<?php

namespace app\parser;


use app\CookiesFile;

class Request
{
    protected $cookieFile;


    public function __construct(CookiesFile $cookieFile)
    {
        $this->cookieFile = $cookieFile;
    }


    public function send($url, array $data = null, bool $isPost = false)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
            'Accept-Encoding: gzip, deflate',
            'Content-type: application/x-www-form-urlencoded'
        ]);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 ");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_REFERER, "http://fantasts.ru/forum/index.php");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieFile->getFilePath());
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieFile->getFilePath());
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
        curl_setopt($ch, CURLOPT_POST, $isPost);

        if ($data) {
            curl_setopt(($ch), CURLOPT_POSTFIELDS, http_build_query($data));
        }

        ob_start();
        curl_exec($ch);

        if (curl_errno($ch)) {
            ob_get_clean();
            throw new \Exception(curl_error($ch));
        }

        curl_close($ch);

        return ob_get_clean();
    }
}