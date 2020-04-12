<?php

$token = '1092997171:AAGbkcfOM616c0VI5CamBn8s-zSybvZiVPY';

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
$name = $message->from->first_name;

if ($text == "/start") {
bot('sendMessage',[
'chat_id'=> $chat_id,
'text'=> "Salom <b>$name</b>",
'parse_mode'=> 'HTML',
]);
}

if ($text == "/ping") {
$send = bot('sendMessage',[
'chat_id'=> $chat_id,
'text'=> "Ping:",
'parse_mode'=> 'HTML',
])->result->message_id;
        
$end_time = round(microtime(true) * 1000);
$ping = $end_time - $start_time;
bot('editMessageText',[
'chat_id'=> $chat_id,
'message_id'=> $send,
'text'=> "Ping: " . $ping . " ms",
'parse_mode'=> 'HTML',
]);
}
