<?php

$HTTP_API = '1111802874:AAEoK8Xqp1dP3DqjBEMIqVuPyGjFCcL43M4';

function bot($method, $datas = []) {
global $HTTP_API;
$url = 'https://api.telegram.org/bot' . $HTTP_API . '/'. $method;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
$result = curl_exec($ch);
if (curl_error($ch)) {
var_dump(curl_error($ch));
} else {
return json_decode($result);
}
}

$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$text = $message->text;
$message_id = $message->message_id;
$chat_id = $message->chat->id;

$dbhost = "mysql-izzatbek.alwaysdata.net";
$dbuser = "izzatbek";
$dbpass = "@izzatbek00";
$dbname = "izzatbek_db";
$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if ($text == '/start' or $text == '/start@Joinhider2_bot' or $text == '/start@Joinhider2_bot start') {
bot('sendMessage',[
'chat_id' => $chat_id,
'text' => "*Joinhider2_bot* version: `2.0`

Bot to remove messages about user joined or left chatroom. Add to your group for bot operation, then assign as administrator.",
'parse_mode' => 'markdown',
'reply_markup' => json_encode([
'inline_keyboard' => [
[['text' => '➕ Add to group ➕', 'url' => 'https://t.me/joinhider2_bot?startgroup=start']]
]
])
]);
$chat = mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM joinhider WHERE chat_id = '$chat_id' LIMIT 1"));
if ($chat['chat_id'] != true){
$connect->query("INSERT INTO joinhider (chat_id)
VALUES ('$chat_id')");
}
}

if ($message->new_chat_member) {
bot('deleteMessage',[
'chat_id' => $chat_id,
'message_id' => $message_id
]);
}
if ($message->left_chat_member) {
bot('deleteMessage',[
'chat_id' => $chat_id,
'message_id' => $message_id
]);
}

if ($text == "/stat" and $chat_id == 708888699) {
$chats = mysqli_num_rows(mysqli_query($connect,"SELECT chat_id FROM joinhider"));
bot('sendmessage',[
'chat_id'=> $chat_id,
'text'=> "Bot statistikasi bilan tanishing:

Foydalanuvchilar soni: <b>$chats</b>",
'parse_mode'=> 'html'
]);
}