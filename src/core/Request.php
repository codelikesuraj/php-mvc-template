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
        return in_array('application/json', $this->request->getAcceptableContentTypes());
    }

    public function getMethod()
    {
        return $this->request->getMethod();
    }

    public function input($key = null)
    {
        $all = $this->request->request->all();
        
        if(is_null($key) || empty(trim($key))) {
            return $all;
        }

        if (array_key_exists($key, $all)) {
            return $all[$key];
        }

        return $all;
    }
}
