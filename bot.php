<?php

$HTTP_API = 'BOT_TOKEN';

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
$type = $message->chat->type;

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
