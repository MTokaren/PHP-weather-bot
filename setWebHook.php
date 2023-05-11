<?php

const TOKEN_URL = 'https://api.telegram.org/bot6140959186:AAH9EPi8BFGZt6iklYy-BdlSmpvHheJ0h6I/setWebhook?url=';
const URL = 'https://weather.onlydev.com.ua/index.php';

$response = file_get_contents(TOKEN_URL . URL);

var_dump($response);