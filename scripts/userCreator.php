<?php

buildMultipleUserQuery();

function buildMultipleUserQuery()
{
    $query = 'INSERT INTO `user` (username, password) VALUES';

    $userCount = 300;
    for ($i = 1; $i <= $userCount; $i++) {
        $username = 'iotuser' . sprintf('%03d', $i);
        $password = sha1($username);

        $query .= "('$username', '$password'), ";
    }

    $query = rtrim($query, ', ');
    $query .= ' ON DUPLICATE KEY UPDATE username = VALUES(username);';

    echo $query;
}
