<?php

namespace app\parser;


class Login
{
    public $cookies;
    private $url;
    private $data;

    public function __construct(string $class, string $url, array $data)
    {
        $this->url = $url;
        $this->data = $data;
        $this->cookies = new \methods\CookiesFile($class);

        (new Request($this->cookies))->send($url, $data, true);
    }
}