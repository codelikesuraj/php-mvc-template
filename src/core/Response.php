<?php

namespace Core;

use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class Response
{
    public $response;
    public $statusCode;
    public $statusMessage;

    public function __construct($message = null, $statusCode = null)
    {
        $this->statusMessage = $message;
        $this->statusCode = $statusCode;
        $this->response = new HttpFoundationResponse();
        return $this;
    }

    public function json($data = [])
    {
        $this->response->headers->set('Content-Type', 'application/json');
        $data = $this->statusMessage ? array_merge([$this->statusMessage], $data) : $data;
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

    public function setStatusMessage($message)
    {
        $this->statusMessage = $message;
        return $this;
    }
}
