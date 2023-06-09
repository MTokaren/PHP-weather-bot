<?php

require 'Telegram.php';
require 'Weather.php';
require 'Db.php';


$primal = json_decode(file_get_contents('php://input'), JSON_OBJECT_AS_ARRAY);

if($primal['message'])
{
	$fname = $primal['message']['from']['first_name'];
	$chat_id = $primal['message']['chat']['id'];
	$msg = $primal['message']['text'];

	$bot = new Telegram($chat_id, $fname);
	$db = new Db($chat_id);

	switch($msg)
	{
		case '/start':
			$text = 'Hello, ' . $fname . '! Please pick a location to get the weather';
			$bot->sendKeyboard($text, Keyboards::STARTER);
			$db->saveChatId();
			break;
		case (preg_match('(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})', $msg) ? true : false) :
			$db->saveRemindTime($msg);
			$text = 'Reminder time was succesfully set';
			$bot->sendKeyboard($text, Keyboards::REMINDER);
			break;
		default:
			$bot->sendMessage('Unknown command. Try again');
			break;
	}

} 
else if($primal['callback_query'])
{
	$fname = $primal['callback_query']['from']['first_name'];
	$chat_id = $primal['callback_query']['from']['id'];
	$callback_data = $primal['callback_query']['data'];


	$bot = new Telegram($chat_id, $fname);
	$db = new Db($chat_id);

	$selected_city = 'FILLABLE';

	switch ($callback_data)
	{

//Select location
		case '1':
			$text = 'There are only these two cities for now. There will be more in future updates if there will be future updates :)';
			$bot->sendKeyboard($text, Keyboards::LOCATIONS);
			break;

//Bila Tserkva
		case 'city_a':
			$db->setLocation(Weather::BILA);
			$bot->sendMessage('You have chosen Bila Tserkva');
			$replyMsg = 'Cool! Now you can get the weather for your location';
			$bot->sendKeyboard($replyMsg, Keyboards::STARTER);
			break;

//Kyiv
		case 'city_b':
			$db->setLocation(Weather::KYIV);
			$bot->sendMessage('You have chosen Kyiv');
			$replyMsg = 'Cool! Now you can get the weather for your location';
			$bot->sendKeyboard($replyMsg, Keyboards::STARTER);
			break;


//Get weather
		case '2':
			if($db->locationWasSet()[0] == NULL)
			{
				$replyMsg = 'You have to choose location firstly, dummy';
				$bot->sendKeyboard($replyMsg, Keyboards::STARTER);
			} else 
			{
				$weather = 'Weather: ' . Weather::getWeather($db->locationWasSet()[0])['weather'][0]['main'];
				$bot->Message($weather);
				
				$temperature = 'Temperature: ' . Weather::getWeather($db->locationWasSet()[0])['main']['temp'] . ' ^C';
				$bot->sendMessage($temperature);
				
				$replyMsg = 'Yay! EVERYTHING WORKS! :D';
				$bot->sendKeyboard($replyMsg, Keyboards::STARTER);

			}
			break;

//Set reminder
		case '3':
			if($db->locationWasSet()[0] == NULL)
			{
				$replyMsg = 'You have to choose location firstly, dummy';
				$bot->sendKeyboard($replyMsg, Keyboards::STARTER);
			} else 
			{
			$replyMsg = '1) Set time: set exact time when you would like to get the update' . "\n" . '2) Set interval: set time interval to get updates' . "\n" . '3) Set quantity: set how many reminders with set interval you would like to receive' . "\n" . '4) Delete all setups: Well, this one is kinda obvious, isnt it?';
			$bot->sendKeyboard($replyMsg, Keyboards::REMINDER);
			
			}
		break;

//Set time
		case '4':
			$instructions = 'Please send a message of following format:' . "\n" . '0000-00-00 00:00:00' . "\n" . 'Example: 2023-06-05 13:23:45' . "\n" . 'It means, that notification will be sent on 5th of June 2023 at 1:23:45 PM';
			$bot->sendMessage($instructions);
		break;

//Set interval
		case '5':
			$bot->sendKeyboard('Select when would you like to get the next update', Keyboards::REMINDER_INTERVAL);
		break;

//Set quantity
		case '6':
			$bot->sendKeyboard('How many times you would like to get updates with the set interval?', Keyboards::REMINDER_INTERVAL_QUANT);
		break;

//Delete all
		case '7':

			break;

//RETURN
		case '8':
			$bot->sendKeyboard('Yep, this button seems to work nicely', Keyboards::STARTER);
		break;

//Set minutes
		case '9':
			$bot->sendKeyboard('How many?', Keyboards::REMINDER_INTERVAL_MINUTES);
		break;

//Set hours
		case '10':
			$bot->sendKeyboard('How many?', Keyboards::REMINDER_INTERVAL_HOURS);
		break;

//Set days
		case '11':
			$bot->sendKeyboard('How many?', Keyboards::REMINDER_INTERVAL_DAYS);
		break;

//RETURN
		case '12':
			$bot->sendKeyboard('Yep, this button seems to work nicely', Keyboards::REMINDER);
		break;

//SET TIME OR QUANT
		default:
			if(preg_match('/^q.*/', $callback_data))
			{
				$db->saveIntervalQuantity($callback_data);
				$bot->sendKeyboard('Interval quantity was set', Keyboards::REMINDER);
			break;
			}else
			{
				$db->saveIntervalTime($callback_data);
				$bot->sendKeyboard('Interval was set', Keyboards::REMINDER);
			break;
			}
	}
}


?>