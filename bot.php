<?php

$token = '1111802874:AAEoK8Xqp1dP3DqjBEMIqVuPyGjFCcL43M4';

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
$type = $message->chat->type;
$message_id = $message->message_id;
$chat_id = $message->chat->id;
$user_id = $message->from->id;
$message_id = $message->message_id;
$name = $message->from->first_name;

if (isset($text)) {
$users = file_get_contents("users.txt");
$groups = file_get_contents("groups.txt");
if ($type == "private") {
if (strpos($users, "$chat_id") !== false) {
} else {
file_put_contents("users.txt", "$users\n$chat_id");
}
} 
if ($type == "group" or $type == "supergroup") {
if (strpos($groups, "$chat_id") !== false) {
} else {
file_put_contents("groups.txt", "$groups\n$chat_id");
}
} 
}

if ($text == "/stat" and $user_id == "708888699") {
$users = file_get_contents("users.txt");
$groups = file_get_contents("groups.txt");
$count_users = substr_count($users, "\n");
$count_groups = substr_count($groups, "\n");
$count_all = $count_users + $count_groups;
bot('sendmessage',[
'chat_id'=> $chat_id,
'text'=> "👤 Users: <b>$count_users</b>
👥 Groups: <b>$count_groups</b>
📊 All: <b>$count_all</b>",
'parse_mode'=> 'html'
]);
}

if ($text == "/start" or $text == "/start@Joinhider2_bot" or $text == "/start@Joinhider2_bot start") {
bot('sendMessage',[
'chat_id'=> $chat_id,
'text'=> "*Joinhider2_bot* version: `1.1`

Bot to remove messages about user joined or left chatroom.

Add it to your group for bot operation, then assign it as an administrator.",
'parse_mode'=> 'markdown',
'reply_markup'=> json_encode([
'inline_keyboard'=> [
[['text'=> "➕ Add to group ➕", 'url'=> "https://t.me/joinhider2_bot?startgroup=start"]]
]
])
]);
}

if ($message->new_chat_member) {
bot('deletemessage',[
'chat_id'=> $chat_id,
'message_id'=> $message_id
]);
}
if ($message->left_chat_member) {
bot('deletemessage',[
'chat_id'=> $chat_id,
'message_id'=> $message_id
]);
}