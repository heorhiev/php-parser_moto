<?php

namespace app;


class Catalog
{
    public $url;
    private $cookies;

    public function __construct(string $url, $cookies)
    {
        $this->url = $url;
        $this->cookies = $cookies;
    }


    public function getHtmlDom(array $data = null): \simple_html_dom
    {
        $content = (new Request($this->cookies))->send($this->url, $data);

        $html = new \simple_html_dom();

        $html->load($content);

        return $html;
    }


    public function is200(): bool
    {
        $headers = get_headers($this->url, 1);
        return stripos($headers[0], '200 OK');
    }
}