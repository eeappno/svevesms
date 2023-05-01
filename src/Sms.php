<?php

namespace Eeappdev\SveveSms;

use GuzzleHttp\Client;

class Sms
{
    protected $client;
    protected $user;
    protected $password;
    protected $url;
    protected $from;

    protected $recipients = [];
    protected $messages = [];
    protected $response;

    protected $test = false;

    public function __construct()
    {
        $this->client = new Client();

        $this->user = config('sveve.user');
        $this->password = config('sveve.password');
        $this->url = config('sveve.url');
        $this->from = config('sveve.from');
    }

    public function to(string|array $recipients): self
    {
        if (is_array($recipients)) {
            $this->recipients = $recipients;
        } else {
            $this->recipients[] = $recipients;
        }

        return $this;
    }

    public function from(string $from): self
    {
        $this->from = $from;
        return $this;
    }

    public function message(string|array $messages): self
    {
        if (is_array($messages)) {
            $this->messages = $messages;
        } else {
            $this->messages[] = $messages;
        }

        return $this;
    }

    public function send()
    {
        $messages = [];

        foreach ($this->recipients as $index => $recipient) {
            $message = isset($this->messages[$index]) ? $this->messages[$index] : $this->messages[0];

            $messages[] = [
                'to' => $recipient,
                'msg' => $message,
                'from' => $this->from,
            ];
        }

        $response = $this->client->post($this->url . 'SendMessage', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ],
            'json' => [
                'user' => $this->user,
                'passwd' => $this->password,
                'messages' => $messages,
                'f' => 'json',
                'test' => $this->test ?? false,
            ],
        ]);

        return $this->response = json_decode($response->getBody(), true);
    }

    public function remainingSms()
    {
        $response = $this->client->get($this->url . 'AccountAdm?cmd=sms_count&user=' . $this->user . '&passwd=' . $this->password);
        return json_decode($response->getBody(), true);
    }

    public function test(bool $test): self
    {
        $this->test = $test;
        return $this;
    }

}
