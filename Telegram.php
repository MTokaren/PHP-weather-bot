<?php


require_once('Keyboards.php');

class Telegram
{
const BASE_URL = 'https://api.telegram.org/bot';

const TOKEN_PROD = '6140959186:AAH9EPi8BFGZt6iklYy-BdlSmpvHheJ0h6I/';
const TOKEN_TEST = '6003002247:AAHteN0bdN4NiIAvV5MLGuLle02LTjuDNgY/';

protected $data = [];
protected $chat_id;
protected $fname;
protected $keyboard;

public function __construct($chat_id, $fname){
    $this->chat_id = $chat_id;
    $this->fname = $fname;
    $this->keyboard = new Keyboards;
}


public function sayUnknown(){
    $this->sendSimpleMsg($this->chat_id, 'Unknown command. Try again');
}

static public function sendSimpleMsg($chat_id, $text){
    $data = ['chat_id'=>$chat_id,'text'=>$text];
    $query = http_build_query($data);
    $ch = curl_init(self::BASE_URL . self::TOKEN_PROD . 'sendMessage?' . $query);
    $result = curl_exec($ch);
    curl_close($ch);
 }

 public function sendKeyboard($message, $keyboard){
    $data = ['chat_id'=>$this->chat_id,'text'=>$message, 'parse_mode'=>'HTML', 'reply_markup'=>json_encode($keyboard)];
    $query = http_build_query($data);
    $ch = curl_init(self::BASE_URL . self::TOKEN_PROD . 'sendMessage?' . $query);
    $result = curl_exec($ch);
    curl_close($ch);
 }
}