<?php
namespace Iot\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator as Valid;
use \Exception;

class AuthController extends BaseController
{
    public function getLogIn(Request $request, Response $response)
    {
        return $this->view->render($response, 'login.twig');
    }

    public function postLogIn(Request $request, Response $response)
    {
        $validation = $this->validator->validate($request, [
            'username' => Valid::noWhitespace()->notEmpty(),
            'password' => Valid::noWhitespace()->notEmpty(),
        ]);
        if ($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('login'));
        }

        $auth = $this->authenticator->checkUserByUsername(
            $request->getParam('username'),
            $request->getParam('password')
        );

        if (!$auth) {
            $this->flash->addMessage('error', 'Invalid username/password.');
            return $response->withRedirect($this->router->pathFor('login'));
        }

        $redirect = $this->router->pathFor('home');

        /*if(isset($_SESSION['redirect_uri'])){
            $redirect = $_SESSION['redirect_uri'];
        }*/

        /*if ($this->authenticator->getUserRole() === 'administrator') {
            $redirect = $this->router->pathFor('admin.dashboard');
        }*/

        return $response->withRedirect($redirect);
    }

    public function getLogout(Request $request, Response $response)
    {
        $this->authenticator->logout();
        return $response->withRedirect($this->router->pathFor('login'));
    }

    public function getSignup(Request $request, Response $response)
    {
        return $this->view->render($response, 'signup.twig');
    }

    public function postSignup(Request $request, Response $response)
    {
        $validation = $this->validator->validate($request, [
            'name' => Valid::notEmpty()->alpha(),
            'password' => Valid::noWhitespace()->notEmpty(),
            'mobile' => Valid::phone(),
            'email' => Valid::email(),
        ]);
        if ($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('signup'));
        }

        $formData = $request->getParams();
        $userExist = $this->authRepository->checkUserExist(
            $formData['email'],
            $formData['mobile']
        );
        if ($userExist) {
            $this->flash->addMessage(
                'error',
                "User's Email/Mobile number already exist!"
            );
            return $response->withRedirect($this->router->pathFor('signup'));
        }

        $userCreated = $this->authRepository->addUser($formData);
        $this->signupMail($response, $formData['name'], $formData['email']);
        if ($userCreated) {
            $this->flash->addMessage(
                'success',
                'Account Created. Please Login.!'
            );

            return $response->withRedirect($this->router->pathFor('login'));
        }

        return $response->withRedirect($this->router->pathFor('signup'));
    }

    private function signupMail($response, $username, $email)
    {
        $data['username'] = $username;
        $subject = 'Welcome to ' . $this->config->getAppName();
        $message = $this->view->fetch('email/signup.twig', $data);
        $status = $this->mailer->sendMail($email, $subject, $message);
    }

    public function getForgotPassword(Request $request, Response $response)
    {
        return $this->view->render($response, 'forgot_password.twig');
    }

    public function postForgotPassword(Request $request, Response $response)
    {
        $validation = $this->validator->validate($request, [
            'email' => Valid::email(),
        ]);
        if ($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('forgotPwd'));
        }

        try {
            $email = $request->getParam('email');
            $userName = $this->authRepository->getUserName($email);

            if (empty($userName) === true) {
                throw new Exception(
                    'Given email is not associated with any account.'
                );
            }

            $uniqId = $this->authenticator->getRandomString(32);
            $isUpdate = $this->authRepository->updateForgotToken(
                $uniqId,
                $email
            );
            if ($isUpdate === false) {
                throw new Exception('Some problem occurred, please try again.');
            }

            $mailResponse = $this->passwordResetMail(
                $response,
                $email,
                $userName,
                $uniqId
            );
            if ($mailResponse['type'] === false) {
                $this->logger->log(
                    'Email Response: ' . json_encode($mailResponse)
                );
                throw new Exception('Some problem occurred, please try again.');
            }

            $alertMessage =
                'Please check your e-mail, we have sent a password reset link to your registered email.';
            $this->flash->addMessage('success', $alertMessage);
            return $response->withRedirect($this->router->pathFor('forgotPwd'));
        } catch (Exception $e) {
            $this->flash->addMessage('error', $e->getMessage());
            return $response->withRedirect($this->router->pathFor('forgotPwd'));
        }
    }

    public function displayChangePassword(Request $request, Response $response)
    {
        return $this->view->render($response, 'user/change_password.twig');
    }

    public function updateUserPassword(Request $request, Response $response)
    {
        $validation = $this->validator->validate($request, [
            'password' => Valid::noWhitespace()->notEmpty(),
            'newPassword' => Valid::noWhitespace()->notEmpty(),
            'confirmPassword' => Valid::noWhitespace()->notEmpty(),
        ]);
        if ($validation->failed()) {
            return $response->withRedirect(
                $this->router->pathFor('user.changePwd')
            );
        }

        $password = $request->getParam('password');
        $newPassword = $request->getParam('newPassword');
        $confirmPassword = $request->getParam('confirmPassword');

        if ($newPassword !== $confirmPassword) {
            $this->flash->addMessage(
                'error',
                'New Password & confirm password should be same'
            );
            return $response->withRedirect(
                $this->router->pathFor('user.changePwd')
            );
        }

        $email = $this->authenticator->getUserEmail();
        $auth = $this->authenticator->checkUserByEmail($email, $password);
        if (!$auth) {
            $this->flash->addMessage('error', 'Current Password is Incorrect');
            return $response->withRedirect(
                $this->router->pathFor('user.changePwd')
            );
        }

        $isUpdate = $this->authRepository->updateUserPasswordByEmail(
            $email,
            sha1($newPassword)
        );
        if ($isUpdate === false) {
            $type = 'error';
            $msg = 'Some problem occurred, please try again.';
        } else {
            $type = 'success';
            $msg = 'Password updated successfully.';
        }

        $this->flash->addMessage($type, $msg);

        return $response->withRedirect(
            $this->router->pathFor('user.changePwd')
        );
    }

    private function passwordResetMail($response, $email, $username, $uniqId)
    {
        $resetPassurl = $this->container->get('settings')['resetPasswordUrl'];
        $resetPassLink = sprintf($resetPassurl, $uniqId);

        $data['username'] = $username;
        $data['resetPassLink'] = $resetPassLink;
        $subject = $this->config->getAppName() . ' Password Reset';
        $message = $this->view->fetch('email/password_reset.twig', $data);
        $status = $this->mailer->sendMail($email, $subject, $message);

        return $status;
    }

    public function getResetPassword(
        Request $request,
        Response $response,
        $args
    ) {
        $uniqId = $args['id'];
        $isUniqIdExist = $this->authRepository->checkUserByUniqId($uniqId);
        if ($isUniqIdExist === false) {
            $this->flash->addMessage(
                'error',
                'You does not authorized to reset new password of this account. Please try again.'
            );

            return $response->withRedirect($this->router->pathFor('forgotPwd'));
        }

        return $this->view->render($response, 'reset_password.twig');
    }

    public function postResetPassword(
        Request $request,
        Response $response,
        $args
    ) {
        $uniqId = $args['id'];
        $validation = $this->validator->validate($request, [
            'password' => Valid::noWhitespace()->notEmpty(),
            'confirmPassword' => Valid::noWhitespace()->notEmpty(),
        ]);
        if ($validation->failed()) {
            return $response->withRedirect(
                $this->router->pathFor('resetPwd', ['id' => $uniqId])
            );
        }
        $password = $request->getParam('password');
        $confirmPassword = $request->getParam('confirmPassword');
        if ($password !== $confirmPassword) {
            $this->flash->addMessage('error', 'Passwords should be same.');

            return $response->withRedirect(
                $this->router->pathFor('resetPwd', ['id' => $uniqId])
            );
        }

        $isUniqIdExist = $this->authRepository->checkUserByUniqId($uniqId);
        if ($isUniqIdExist === false) {
            $this->flash->addMessage(
                'error',
                'You does not authorized to reset new password of this account. Please try again.'
            );

            return $response->withRedirect($this->router->pathFor('forgotPwd'));
        }

        $isUpdate = $this->authRepository->updateUserPassword(
            sha1($password),
            $uniqId
        );
        if ($isUpdate === false) {
            $type = 'error';
            $msg = 'Some problem occurred, please try again.';
            $router = $this->router->pathFor('resetPwd', ['id' => $uniqId]);
        } else {
            $type = 'success';
            $msg =
                'Your account password has been reset successfully. Please login with your new password.';
            $router = $this->router->pathFor('login');
        }

        $this->flash->addMessage($type, $msg);

        return $response->withRedirect($router);
    }

    public function refreshSession(Request $request, Response $response)
    {
        if (isset($_SESSION)) {
            $_SESSION['siteUrl'] = $_SESSION['siteUrl'];
            $_SESSION['user_id'] = $_SESSION['user_id'];
            $_SESSION['user'] = $_SESSION['user'];
            $_SESSION['role'] = $_SESSION['role'];
            $_SESSION['email'] = $_SESSION['email'];
            $_SESSION['isUserEnrolled'] = $_SESSION['isUserEnrolled'];
            $_SESSION['token'] = $_SESSION['token'];
            $_SESSION['quizStart'] = $_SESSION['quizStart'];
        }
    }

    public function sendOTP(Request $request, Response $response)
    {
        $data['status'] = false;
        $mobileNumber = $request->getParam('mobileNumber');
        $user = $this->authRepository->getUserByMobileNumber($mobileNumber);
        if (empty($user) === true) {
            $data['msg'] =
                'Given Mobile number is not associated with any account.';
            echo json_encode($data);
            return;
        }

        $otp = $this->authenticator->getOTP();

        $_SESSION['mobile']['number'] = $mobileNumber;
        $_SESSION['mobile']['otp'] = sha1($otp);
        $_SESSION['mobile']['expire'] = time() + 15 * 60;

        $number = [$mobileNumber];
        $message =
            $otp .
            ' is your one time password and it is valid for the next 15mins. Please do not share this OTP with anyone. Thank you';

        $smsResponse = $this->sms->sendSms($number, $message);
        $this->logger->log('SMS Response: ' . json_encode($smsResponse));

        if ($smsResponse['status'] == 'success') {
            $data['msg'] = 'OTP is sent to Your Mobile Number';
            $data['status'] = true;
        } else {
            $data['msg'] = 'Unable to send SMS. Please Try again.';
            $data['status'] = false;
        }

        echo json_encode($data);
        return;
    }

    /*public function verifyOTP(Request $request, Response $response) {
		$data['status'] = false;
		$mobileOtp = $request->getParam('mobileOtp');

		$now = time();

		if (($now > $_SESSION['mobile']['expire']) ||
			($_SESSION['mobile']['otp'] !== sha1($mobileOtp))
		){
			$data['msg'] = "Invalid OTP. Login Failed!";
			$this->resetOTPSession();
			echo json_encode($data);

			return;
		}

		$mobileNumber = $_SESSION['mobile']['number'];
		$user = $this->authRepository->getUserByMobileNumber($mobileNumber);
		$this->authenticator->setUserSessionData($user);
		$this->resetOTPSession();

		$redirect = $this->router->pathFor('home');
        if(isset($_SESSION['redirect_uri'])){
            $redirect = $_SESSION['redirect_uri'];
        }
		if ($this->authenticator->getUserRole() === 'administrator') {
            $redirect = $this->router->pathFor('admin.dashboard');
        }

		$data['status'] = true;
		$data['redirect'] = $redirect;

		echo json_encode($data);
		return;
	}

	private function resetOTPSession() {
		unset($_SESSION['mobile']);
	}*/
}
