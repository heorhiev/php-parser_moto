<?php

const COOKIES_DIR = __DIR__ . '/data';

include(__DIR__ . '/inc/autoload.php');
include(__DIR__ . '/inc/simplehtmldom/simple_html_dom.php');


$moto = new \projects\Motovulkan('58126', 'JUPNB');

foreach ($moto->getPostUrls() as $postUrl) {
    $data = $moto->getPostData($postUrl);
    print_r($data);
    exit;
}


foreach ($moto->getCatalogUrls() as $item) {
    echo $item->getAttribute('href');
    echo PHP_EOL;
}

exit;