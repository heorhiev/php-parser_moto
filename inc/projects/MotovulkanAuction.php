<?php

namespace projects;

use methods\Catalog;


class MotovulkanAuction
{
    const LOGIN_URL = 'https://bdsc.jupiter.ac/NJP10/NJP10100?ReturnUrl=%2FNJP20%2FNJP20202';
    const CATALOG_URL = 'https://bdsc.jupiter.ac/NJP20/NJP20202';

    private $login;

    public function __construct(string $account, string $password)
    {
        $this->login = new \methods\Login(static::class, self::LOGIN_URL, [
            'member' => $account,
            'pas' => $password,
        ]);
    }


    public function getCatalog($selector)
    {
        $catalog = new Catalog(self::CATALOG_URL, $this->login->cookies);

        return $catalog->getItems($selector);
    }
}