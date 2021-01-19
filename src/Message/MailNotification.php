<?php

namespace App\Message;

class MailNotification {
    
    private $id;
    private $description;
    private $from;


    public function __construct (int $id, string $description, string $from) {
        $this->id = $id;
        $this->description = $description;
        $this->from = $from;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
 
    public function getFrom(): string
    {
        return $this->from;
    }


}