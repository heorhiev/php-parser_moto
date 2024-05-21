<?php

namespace app\dto;


class PostDataDto
{
    public $url;
    public $title;
    public $art;
    public $price;
    public $description;
    public $images;

    /** @var array[array{title: string, value: string}] */
    public $options;
}