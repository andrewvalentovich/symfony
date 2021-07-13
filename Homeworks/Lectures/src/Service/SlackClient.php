<?php


namespace App\Service;


use Nexy\Slack\Client;

class SlackClient
{
    public function __construct(Client $slack)
    {
        $this->slack = $slack;
    }

    public function send(string $message, string $icon = ':ghost:', string $from = 'Andrew')
    {
        $slackMessage = $this->slack->createMessage();

        $slackMessage
            ->from($from)
            ->withIcon($icon)
            ->setText($message)
        ;

        $this->slack->sendMessage($slackMessage);
    }
}