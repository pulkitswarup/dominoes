<?php

if (! function_exists('array_shuffle_assoc')) {
    function array_shuffle_assoc (array $arr) : array
    {
        $keys = array_keys($arr);
        shuffle($keys);
        $result = array();
        foreach ($keys as $key) {
            $result[$key] = $arr[$key];
        }
        return $result;
    }
}

if (! function_exists('message')) {
    function message(string $message)
    {
        if (
            !isset($_ENV['APP_ENV'])
            || (
                isset($_ENV['APP_ENV'])
                && $_ENV['APP_ENV'] !== 'testing'
            )
        ) {
            echo $message . PHP_EOL;
        }
    }
}

if (! function_exists('error')) {
    function error(string $error)
    {
        if (!isset($_ENV['APP_ENV'])
            || (isset($_ENV['APP_ENV'])
            && $_ENV['APP_ENV'] !== 'testing')) {
            echo sprintf("!!! %s", $error) . PHP_EOL;
        }
    }
}