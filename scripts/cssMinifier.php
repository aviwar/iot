<?php

$customUI = $_GET['ui'] ?? '';

if (empty($customUI)) {
    exit('Unable to process.!');
}

$cssFiles = [];
$minifiedCSSFile = '';
if ($customUI === 'trios') {
    $cssFiles = [
        '../assets/css/trios/custom.css',
    ];

    $minifiedCSSFile = '../assets/css/trios/custom-style.min.css';
} elseif ($customUI === 'beginner') {
    $cssFiles = [
        '../assets/css/beginner/custom.css',
    ];

    $minifiedCSSFile = '../assets/css/beginner/custom-style.min.css';
}

$cssContent = '';
foreach ($cssFiles as $cssFile) {
    $cssContent .= file_get_contents($cssFile);
}

$url = 'https://cssminifier.com/raw';

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => ["Content-Type: application/x-www-form-urlencoded"],
    CURLOPT_POSTFIELDS => http_build_query(["input" => $cssContent])
]);

$minifiedCSSContent = curl_exec($ch);

curl_close($ch);

file_put_contents($minifiedCSSFile, $minifiedCSSContent);
echo "Minified.!";
