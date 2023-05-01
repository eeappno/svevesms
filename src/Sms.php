<?php

namespace Eeappdev\SveveSms;

use GuzzleHttp\Client;

class Sms
{
    protected $client;
    protected $user;
    protected $password;
    protected $url;
    protected $recipient;
    protected $message;
    protected $test = false;
    protected $response;
    protected $from;

    public function __construct()
    {
        $this->client = new Client();

        $this->user = config('sveve.user');
        $this->password = config('sveve.password');
        $this->url = config('sveve.url');
        $this->from = config('sveve.from');
    }

    public function to(string $recipient): self
    {
        $this->recipient = $recipient;
        return $this;
    }

    public function from(string $from): self
    {
        $this->from = $from;
        return $this;
    }

    public function message($message): self
    {
        $this->message = $message;
        return $this;
    }

    public function send()
    {
        $response = $this->client->post($this->url . 'SendMessage', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ],
            'json' => [
                'user' => $this->user,
                'passwd' => $this->password,
                'to' => $this->recipient,
                'msg' => $this->message,
                'from' => $this->from,
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
