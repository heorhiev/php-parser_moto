<?php

const COOKIES_DIR = __DIR__ . '/data';

include(__DIR__ . '/inc/autoload.php');
include(__DIR__ . '/inc/simplehtmldom/simple_html_dom.php');
include(__DIR__ . '/../wp-load.php');

$moto = new \projects\Motovulkan('58126', 'JUPNB');

foreach ($moto->getPostUrls() as $postUrl) {
    $postData = $moto->getPostData($postUrl);

    \app\WPPost::create($postData);

    break;
}

//print_r($rows);

//$path = __DIR__ . 'data/export.csv';
//$fp = fopen($path, 'w'); // open in write only mode (write at the start of the file)
//foreach ($rows as $row) {
//    fputcsv($fp, $row);
//}
//fclose($fp);
//
//exit;