<?php

namespace projects;

use methods\Catalog;
use methods\HtmlDom;


class Motovulkan
{
    const CATALOG_URL = 'https://www.motovulkan.com/%D0%BC%D0%B0%D0%B3%D0%B0%D0%B7%D0%B8%D0%BD';

    private $login;

    public function __construct(string $account, string $password)
    {
        $this->cookies = new \methods\CookiesFile(self::class);
    }


    public function getPostUrls(): array
    {
        $nextUrl = self::CATALOG_URL;

        $result = [];

        $page = 1;

        while (true) {
            $catalog = new Catalog($nextUrl, $this->cookies);

            $items = $catalog->getHtmlDom()->find('[data-hook="product-item-root"] > a');

            if (empty($items)) {
                break;
            }

            foreach ($items as $item) {
                $result[] = $item->getAttribute('href');

                return $result;
            }

            $nextUrl = self::CATALOG_URL . "?page=" . (++$page);
        }

        return $result;
    }


    public function getPostData($url): array
    {
        $dom = (new Catalog($url, $this->cookies))->getHtmlDom();

        $price = HtmlDom::getText($dom, '[data-hook="formatted-primary-price"]', ['clean' => true]);
        
        $result = [
            'url' => $url,
            'title' => HtmlDom::getText($dom, '[data-hook="product-title"]'),
            'art' => HtmlDom::getText($dom, '[data-hook="sku"]', ['clean' => true]),
            'price' => str_replace(',', '.', $price),
            'description' => HtmlDom::getText($dom, '[data-hook="description"]'),
            'options' => [],
            'images' => [],
        ];

        foreach ($dom->find('[data-hook="product-options-inputs"] .cell') as $option) {
            $optionTitle = HtmlDom::getText($option, '[data-hook="options-dropdown-title"]');
            $optionValue = HtmlDom::getText($option, '[data-hook="options-dropdown-title"] + div');

            if (empty($optionTitle) || empty($optionValue)) {
                continue;
            }

            $result['options'][] = [
                'title' => $optionTitle,
                'value' => $optionValue,
            ];
        }

        foreach ($dom->find('.media-wrapper-hook') as $img) {
            if (empty($img)) {
                continue;
            }

            $result['images'][] = $img->getAttribute('href');
        }

        return $result;
    }
}