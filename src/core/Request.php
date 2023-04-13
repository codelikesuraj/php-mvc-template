<?php

namespace Core;

use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

class Request
{
    public $request;

    public function __construct()
    {
        $this->request = (new HttpFoundationRequest())::createFromGlobals();
        return $this;
    }

    public function isJson()
    {
        $content_type = strtolower($this->request->headers->get('Content-Type') ?? '');

        return strpos($content_type, 'application/json') !== false;
    }
}