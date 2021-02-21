<?php

$token = '1466689222:AAHDHaMYkocO0csl2ynw2F6IgFqCsgdnLg4';
$users = file_get_contents("http://izzatbekk00.000webhostapp.com/pic/users.txt");
    $user = explode("\n", $users);
                foreach ($user as $u) {
				    if (empty($u)) continue;
				    $data = [
						'chat_id'=> $u,
						'text'=> "You can transfer money to +998913238252 qiwi wallet to support us"
				    ];
				        $response = file_get_contents("https://api.telegram.org/bot" . $token . "/sendmessage?" . http_build_query($data) );
				}