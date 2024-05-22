<?php

namespace app;

use app\dto\PostDataDto;
use WC_Product_Attribute;
use WC_Product_Simple;


class WPPost
{
    public static function create(PostDataDto $dataDto)
    {
        global $wpdb;

        $results = $wpdb->get_results("SELECT * FROM `{$wpdb->postmeta}` WHERE `meta_value` = '{$dataDto->url}'");

        if ($results) {
            echo "Skip {$dataDto->url}" . PHP_EOL;
            return;
        }

        if (wc_get_product_id_by_sku($dataDto->art)) {
            echo "Exists {$dataDto->art}" . PHP_EOL;
            $dataDto->art = rand(9, 999);
        }

        $product = new WC_Product_Simple();

        $product->set_name($dataDto->title);

        $product->set_sku($dataDto->art);

        $product->set_slug($dataDto->title);

        $product->set_regular_price($dataDto->price);

        $product->set_short_description($dataDto->description);

        $attachments = [];
        foreach ($dataDto->images as $image) {
            echo "download image {$image}" . PHP_EOL;
            $downloadRemoteImage = new WPDownloadRemoteImage($image, [
                'title' => $dataDto->title,
            ]);

            $attachments[] = $downloadRemoteImage->download();
        }


        if (!empty($attachments[0])) {
            $product->set_image_id($attachments[0]);
        }

        $product->set_category_ids([74]);

        $attributes = [];
        foreach ($dataDto->options as $option) {
            $pa = new WC_Product_Attribute();
            $pa->set_name(sanitize_text_field($option['title']));
            $pa->set_options([$option['value']]);
            $pa->set_visible(true);
            $attributes[$option['title']] = $pa;
        }

        if ($attributes) {
            $product->set_attributes($attributes);
        }

        $productId = $product->save();

        if ($attachments) {
            add_post_meta($productId, "images", json_encode($attachments));
        }

        add_post_meta($productId, 'donor_url', $dataDto->url);

        echo "Saved {$productId}: url {$dataDto->url}" . PHP_EOL;
    }
}