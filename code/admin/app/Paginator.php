<?php 

namespace App;

class Paginator
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getPrev()
    {
        $prev = $this->data['links']['prev'];
        return '/admin' . substr($prev, strpos($prev, "?"));
    }

    public function getNext()
    {
        $next = $this->data['links']['next'];
        return '/admin' . substr($next, strpos($next, "?"));        
    }
}