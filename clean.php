<?php


include(__DIR__ . '/inc/autoload.php');
include(__DIR__ . '/../wp-load.php');

$posts = get_posts([
    'post_type' => 'product',
    'numberposts' => 999,
]);

$i = 0;
foreach ($posts as $post) {
    $sku = get_post_meta($post->ID, '_sku', true);
    $skuClean = ltrim($sku, '0');

    if ("$sku" === "$skuClean" || empty($skuClean)) {
        continue;
    }

    $oldPosts = get_posts([
        'meta_query' => array(
            array(
                'key' => '_sku',
                'value' => $skuClean
            )
        ),
        'post_type' => 'product',
        'posts_per_page' => -1
    ]);

    if (empty($oldPosts)) {
        continue;
    }

    foreach ($oldPosts as $oldPost) {
        $WC_Product = new WC_Product($oldPost->ID);
        $slug = $WC_Product->get_slug();
        $WC_Product->delete(true);

        $product = new WC_Product_Simple($post->ID);
        $product->set_slug($slug);
        $product->save();
    }

    $i++;
}

echo $i;