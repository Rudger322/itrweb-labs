<?php

namespace classes;

class FeedbackForm
{
    protected $name;
    protected $email;
    protected $message;

    public function __construct($name, $email, $message)
    {
        $this->name = $name;
        $this->email = $email;
        $this->message = $message;
    }

    public function send()
    {
        echo 'Сообщение отправлено';
    }
}
