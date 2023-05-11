<?php

require 'Telegram.php';
require 'Db.php';
require 'Weather.php';


$query = 'SELECT * FROM users';

$pdo = new PDO('mysql:host=localhost;dbname=arey103_weatherbot','arey103_weatherbot', 'weatherBOT2023');

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


$a = $pdo->query($query);
$b = $a->fetchAll(PDO::FETCH_ASSOC);





foreach ($b as $user){
    $current = time();

    if(!empty($user['remindTime'])){
        if ($current >= $user['remindTime']){


            $bot = new Telegram ($user['chatId'],'');


            $weather = 'Weather: ' . Weather::getWeather($user['city_id'])['weather'][0]['main'];
            $bot->sendSimpleMsg($user['chatId'], $weather);

            $temperature = 'Temperature: ' . Weather::getWeather($user['city_id'])['main']['temp'] . '^C';
            $bot->sendSimpleMsg($user['chatId'], $temperature);
            
            $querySetNull = 'UPDATE users SET remindTime = :remindTime WHERE chatId = :chat_id';
            $null = 0;
            $stmt = $pdo->prepare($querySetNull);
            $stmt->execute([':remindTime'=>$null, ':chat_id'=>$user['chatId']]);

        }
    }

    if(isset($user['intervalTimeStamp']) && isset($user['intervalTime']) && !empty($user['intervalQuantity'])){
        if($current >= $user['intervalTimeStamp'] + $user['intervalTime']){

            $bot = new Telegram ($user['chatId'],'');

            $weather = 'Weather: ' . Weather::getWeather($user['city_id'])['weather'][0]['main'];
            $bot->sendSimpleMsg($user['chatId'], $weather);

            $temperature = 'Temperature: ' . Weather::getWeather($user['city_id'])['main']['temp'] . '^C';
            $bot->sendSimpleMsg($user['chatId'], $temperature);

            $newCount = $user['intervalQuantity'] - 1;

            $queryDecreaseCounter = "UPDATE users SET intervalQuantity = :intervalQuantity WHERE chatId = :chat_id";
            $stmt = $pdo->prepare($queryDecreaseCounter);
            $stmt->execute([':intervalQuantity'=>$newCount, ':chat_id'=>$user['chatId']]);
        }
    }
}



