<?php

$token = '1111802874:AAHadNlDhTa99n81I61QAHuxt7pInpJP-UE';

function bot($method,$datas=[]) {
global $token;
$url = "https://api.telegram.org/bot".$token."/".$method;
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
$res = curl_exec($ch);
if (curl_error($ch)) {
var_dump(curl_error($ch));
} else {
return json_decode($res);
}
}

$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$text = $message->text;
$message_id = $message->message_id;
$chat_id = $message->chat->id;
$user_id = $message->from->id;
$message_id = $message->message_id;
$name = $message->from->first_name;

if ($text == "/start") {
bot('sendMessage',[
'chat_id'=> $chat_id,
'text'=> "*Join Hider 2 Bot*

Bot to remove messages about user joined or left chatroom.

Add it to your group for bot operation, then assign it as an administrator.",
'parse_mode'=> 'markdown',
]);
}

if ($message->new_chat_member) {
bot('deletemessage',[
'chat_id'=> $chat_id,
'message_id'=> $message_id,
]);
}
if ($message->left_chat_member) {
bot('deletemessage',[
'chat_id'=> $chat_id,
'message_id'=> $message_id,
]);
}
