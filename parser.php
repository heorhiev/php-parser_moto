<?php

const COOKIES_DIR = __DIR__ . '/data';

include(__DIR__ . '/inc/autoload.php');
include(__DIR__ . '/inc/simplehtmldom/simple_html_dom.php');
include(__DIR__ . '/../wp-load.php');

$moto = new \projects\Motovulkan('58126', 'JUPNB');

$i = 0;
foreach ($moto->getPostUrls() as $postUrl) {
    $postData = $moto->getPostData($postUrl);

    if ($postData) {
        \app\WPPost::create($postData);
        $i++;
    }
}

echo "count: {$i}" . PHP_EOL;

//print_r($rows);

//$path = __DIR__ . 'data/export.csv';
//$fp = fopen($path, 'w'); // open in write only mode (write at the start of the file)
//foreach ($rows as $row) {
//    fputcsv($fp, $row);
//}
//fclose($fp);
//
//exit;