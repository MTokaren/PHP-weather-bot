<?php


require_once('Keyboards.php');

class Telegram
{
    const BASE_URL = 'https://api.telegram.org/bot';

    const TOKEN_PROD = '6140959186:AAH9EPi8BFGZt6iklYy-BdlSmpvHheJ0h6I/';
    const TOKEN_TEST = '6003002247:AAHteN0bdN4NiIAvV5MLGuLle02LTjuDNgY/';

    protected array $data = [];
    protected int $chat_id;
    protected string $fname;
    protected array $keyboard;

    public function __construct(int $chat_id, string $fname)
    {
        $this->chat_id = $chat_id;
        $this->fname = $fname;
        $this->keyboard = new Keyboards;
    }

    static public function sendMessage(string $text):void
    {
        $data = ['chat_id'=>$this->chat_id,'text'=>$text];
        $query = http_build_query($data);
        $ch = curl_init(self::BASE_URL . self::TOKEN_PROD . 'sendMessage?' . $query);
        $result = curl_exec($ch);
        curl_close($ch);
    }

    public function sendKeyboard($message, $keyboard):void
    {
        $data = ['chat_id'=>$this->chat_id,'text'=>$message, 'parse_mode'=>'HTML', 'reply_markup'=>json_encode($keyboard)];
        $query = http_build_query($data);
        $ch = curl_init(self::BASE_URL . self::TOKEN_PROD . 'sendMessage?' . $query);
        $result = curl_exec($ch);
        curl_close($ch);
    }
}