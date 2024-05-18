<?php

namespace app;


class CookiesFile
{
    protected $cookieFilePath;


    public function __construct($name)
    {
        $name = preg_replace("/[^a-zA-Zs]/", '', $name);
        $this->cookieFilePath = rtrim(COOKIES_DIR, '/') . "/cookies.{$name}.txt";
    }


    public function getFilePath(): string
    {
        return $this->cookieFilePath;
    }
}