<?php


class Db
{
    protected $pdo;
    protected $chatId;

    public function __construct($chatId){
         $this->pdo = new PDO ('mysql:host=localhost;dbname=arey103_weatherbot','arey103_weatherbot', 'weatherBOT2023');
        $this->chatId = $chatId;
    }
    
    public function saveChatId(){

        $queryFind = "SELECT * FROM users WHERE chatId = :chat_id";
        $stmt = $this->pdo->prepare($queryFind);
        $stmt->execute([':chat_id'=>$this->chatId]);
        $res = $stmt->fetchAll();

        if(!$res){
            $queryPut = "INSERT INTO users SET chatId=:chatId";
            $stmt = $this->pdo->prepare($queryPut);
            $stmt->execute([':chatId'=>$this->chatId]);
        } 

    }

    public function setLocation($city_id){
        $queryLocation = "UPDATE users SET city_id = :city_id WHERE chatId = :chat_id";
        $stmt = $this->pdo->prepare($queryLocation);
        $stmt->execute([':city_id'=>$city_id, ':chat_id'=>$this->chatId]);
    }

    public function locationWasSet(){
        $queryLocation = "SELECT city_id FROM users WHERE chatId = :chatId";
        $stmt = $this->pdo->prepare($queryLocation);
        $stmt->execute([':chatId'=>$this->chatId]);
        $res = $stmt->fetch();
        return $res;
    }

    //REMINDER

    public function saveRemindTime($data){
        $unixTime = strtotime($data);
        $queryLocation = "UPDATE users SET remindTime = :remindTime WHERE chatId = :chat_id";
        $stmt = $this->pdo->prepare($queryLocation);
        $stmt->execute([':remindTime'=>$unixTime, ':chat_id'=>$this->chatId]);
    }

    public function saveIntervalTimeStamp(){

        $unixTime = time();
        $query = "UPDATE users SET intervalTimeStamp = :intervalTimeStamp WHERE chatId = :chat_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':intervalTimeStamp'=>$unixTime, ':chat_id'=>$this->chatId]);
    }

    public function saveIntervalQuantity($msg){
        $num = preg_replace('/[^0-9]/', '', $msg);
        $query = "UPDATE users SET intervalQuantity = :intervalQuantity WHERE chatId = :chat_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':intervalQuantity'=>$num, ':chat_id'=>$this->chatId]);
    }

    public function saveIntervalMinutes($msg){
        $this->saveIntervalTimeStamp();
        $this->saveIntervalQuantity(1);
        $amount = preg_replace('/[^0-9]/', '', $msg);
        $time = 60 * $amount;
        $query = "UPDATE users SET intervalTime = :intervalTime WHERE chatId = :chat_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':intervalTime'=>$time, ':chat_id'=>$this->chatId]);
    }

    public function saveIntervalHours($msg){
        $this->saveIntervalTimeStamp();
        $this->saveIntervalQuantity(1);
        $amount = preg_replace('/[^0-9]/', '', $msg);
        $time = 60 * 60 * $amount;
        $query = "UPDATE users SET intervalTime = :intervalTime WHERE chatId = :chat_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':intervalTime'=>$time, ':chat_id'=>$this->chatId]);
    }

    public function saveIntervalDays($msg){
        $this->saveIntervalTimeStamp();
        $this->saveIntervalQuantity(1);
        $amount = preg_replace('/[^0-9]/', '', $msg);
        $time = 60 * 60 * 24 * $amount;
        $query = "UPDATE users SET intervalTime = :intervalTime WHERE chatId = :chat_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':intervalTime'=>$time, ':chat_id'=>$this->chatId]);
    }
    
}