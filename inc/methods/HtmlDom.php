<?php

namespace methods;


class HtmlDom
{
    /**
     * @param \simple_html_dom|\simple_html_dom_node $dom
     */
    public static function getText($dom, $selector, array $options = []): string
    {
        try {
            $text = $dom->find($selector, 0)->text();

            if (!empty($options['clean'])) {
                $text = preg_replace("/[^,.0-9]/", '', $text);
            }
            return $text;

        } catch (\Throwable $throwable) {
            return '';
        }
    }
}