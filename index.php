<?php

include "config.php";

$api = "https://api.telegram.org/bot$bot_token/";

$update = json_decode(file_get_contents("php://input"),true);

$message = $update["message"];
$callback = $update["callback_query"];

$chat_id = $message["chat"]["id"];
$text = $message["text"];

$data = $callback["data"];
$cid = $callback["message"]["chat"]["id"];

function sendMessage($chat,$msg,$keyboard=null){
global $api;

$params=[
"chat_id"=>$chat,
"text"=>$msg
];

if($keyboard){
$params["reply_markup"]=json_encode($keyboard);
}

file_get_contents($api."sendMessage?".http_build_query($params));
}

if($text=="/start"){

file_put_contents("users.txt",$chat_id."\n",FILE_APPEND);

$keyboard=[
"inline_keyboard"=>[
[
["text"=>"💎 Get Premium","callback_data"=>"premium"]
],
[
["text"=>"🎥 Premium Demo","url"=>$demo_channel]
],
[
["text"=>"✅ How To Get Premium","url"=>$how_channel]
]
]
];

sendMessage($chat_id,"Price ₹99\nValidity Lifetime",$keyboard);

}

?>