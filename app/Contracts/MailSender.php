<?php
namespace App\Contracts;

class MailSender implements NotifyInterface
{
    public function send()
    {
        return "Sending....";
    }
}