<?php

namespace app;


class DtoHelper
{
    public static function compose(string $classInstance, $data)
    {
        if (is_string($data)) {
            $data = json_decode($data, true);
        }

        $dot = new $classInstance();

        if ($data) {
            foreach ($data as $key => $datum) {
                $dot->{$key} = $datum;
            }
        }

        return $dot;
    }
}
