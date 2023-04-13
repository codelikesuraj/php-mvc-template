<?php

namespace Core;

use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class Response
{
    public $response;
    public $message;
    public $statusCode;

    public function __construct($message = null, $statusCode = null)
    {
        $this->message = $message;
        $this->statusCode = $statusCode;
        $this->response = new HttpFoundationResponse();
        return $this;
    }

    public function json($data = [])
    {
        $this->response->headers->set('Content-Type', 'application/json');
        echo json_encode($data);
        return $this;
    }

    public function send()
    {
        if ($this->statusCode) {
            $this->response->setStatusCode($this->statusCode);
        }

        $this->response->send();
    }

    public function setStatusCode($code)
    {
        $this->statusCode = $code;
        return $this;
    }
}
