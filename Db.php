<?php


class Db
{
    protected PDO $pdo;
    protected int $chatId;

    public function setChatId(int $chat_id) :self {$this->chat_id = $chat_id; return $this;}
    public function getChatId():int {return $this->chat_id;}

    public function setPDO(PDO $pdo):self {$this->pdo = $pdo; return $this;}
    public function getPDO():PDO {return $this->pdo;}

    public function __construct(int $chatId)
    {
        $this->pdo = new PDO ('mysql:host=localhost;dbname=arey103_weatherbot','arey103_weatherbot', 'weatherBOT2023');
        $this->chatId = $chatId;
    }
  
    public function saveChatId():void
    {
        $queryFind = "SELECT * FROM users WHERE chatId = :chat_id";
        $stmt = $this->pdo->prepare($queryFind);
        $stmt->execute([':chat_id'=>$this->chatId]);
        $res = $stmt->fetchAll();

        if(!$res)
        {
            $queryPut = "INSERT INTO users SET chatId=:chatId";
            $stmt = $this->pdo->prepare($queryPut);
            $stmt->execute([':chatId'=>$this->chatId]);
        } 
    }

    public function setLocation(int $city_id):void
    {
        $queryLocation = "UPDATE users SET city_id = :city_id WHERE chatId = :chat_id";
        $stmt = $this->pdo->prepare($queryLocation);
        $stmt->execute([':city_id'=>$city_id, ':chat_id'=>$this->chatId]);
    }

    public function locationWasSet():int
    {
        $queryLocation = "SELECT city_id FROM users WHERE chatId = :chatId";
        $stmt = $this->pdo->prepare($queryLocation);
        $stmt->execute([':chatId'=>$this->chatId]);
        $res = $stmt->fetch();
        return $res;
    }

    //REMINDER

    public function saveRemindTime($data):void
    {
        $unixTime = strtotime($data);
        $queryLocation = "UPDATE users SET remindTime = :remindTime WHERE chatId = :chat_id";
        $stmt = $this->pdo->prepare($queryLocation);
        $stmt->execute([':remindTime'=>$unixTime, ':chat_id'=>$this->chatId]);
    }

    public function saveIntervalTimeStamp():void
    {
        $unixTime = time();
        $query = "UPDATE users SET intervalTimeStamp = :intervalTimeStamp WHERE chatId = :chat_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':intervalTimeStamp'=>$unixTime, ':chat_id'=>$this->chatId]);
    }

    public function saveIntervalQuantity(string $keyword):void
    {
        $num = self::TIME_ARRAY[$keyword];
        $query = "UPDATE users SET intervalQuantity = :intervalQuantity WHERE chatId = :chat_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':intervalQuantity'=>$num, ':chat_id'=>$this->chatId]);
    }

    public function saveIntervalTime(string $keyword):void
    {
        $time = self::TIME_ARRAY[$keyword];
        $this->saveIntervalTimeStamp();
        $this->saveIntervalQuantity(1);
        $query = "UPDATE users SET intervalTime = :intervalTime WHERE chatId = :chat_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':intervalTime'=>$time, ':chat_id'=>$this->chatId]);
    }

    const TIME_ARRAY = [
        'min-1'=>60,
        'min-2'=>120,
        'min-5'=>300,
        'min-10'=>600,
        'hr-1'=>3600,
        'hr-2'=>7200,
        'hr-4'=>14400,
        'hr-8'=>28800,
        'd-1'=>86400,
        'd-2'=>172800,
        'd-3'=>259200,
        'd-4'=>345600,
        'q-1'=>1,
        'q-2'=>2,
        'q-3'=>3,
        'q-4'=>4,
        'q-5'=>5
    ];
}