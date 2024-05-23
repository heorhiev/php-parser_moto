<?php


include(__DIR__ . '/inc/autoload.php');
include(__DIR__ . '/../wp-load.php');

$posts = get_posts([
    'post_type' => 'product',
    'numberposts' => 999,
]);

foreach ($posts as $post) {
    $images = get_post_meta($post->ID, 'images', true);

    if (empty($images)) {
        continue;
    }

    if (is_string($images)) {
        $images = json_encode($images, true);
    }

    $product = new WC_Product_Simple($post->ID);

    $product->set_gallery_image_ids($images);

    $product->save();
}
