<?php

namespace app;

use app\dto\PostDataDto;
use WC_Product_Simple;


class WPPost
{
    public static function create(PostDataDto $dataDto)
    {
        $product = new WC_Product_Simple();

        $product->set_name($dataDto->title);

        $product->set_sku($dataDto->art);

        $product->set_slug($dataDto->title);

        $product->set_regular_price($dataDto->price);

        $product->set_short_description($dataDto->description);

        foreach ($dataDto->images as $image) {
            $downloadRemoteImage = new WPDownloadRemoteImage($image);
            $attachmentId = $downloadRemoteImage->download();

            if ($attachmentId) {
                $product->set_image_id($attachmentId);
            }
        }

//        $product->set_category_ids( array( 19 ) );

        $productId = $product->save();

        foreach ($dataDto->options as $key => $option) {
            add_post_meta($productId, $option['title'], $option['value']);
        }

        add_post_meta($productId, 'donor_url', $dataDto->url);
    }
}