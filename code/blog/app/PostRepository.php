<?php

namespace App;

class PostRepository
{
    private $_apiClient;

    public function __contruct()
    {
        $this->$_apiClient = new GuzzleHttp\Client([
            'base_uri' => ''
        ]);
    }
}