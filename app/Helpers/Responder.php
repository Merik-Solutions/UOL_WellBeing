<?php

namespace App\Helpers;

use App\Pipelines\ArrayHandler;
use App\Pipelines\PaginatorHandler;
use App\Pipelines\ResourceHandler;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Fluent;

class Responder extends Fluent implements Responsable, Arrayable
{
    protected $status;
    protected $msg;
    protected $data;
    protected $errors;

    protected $pipelines = [
        ArrayHandler::class,
        ResourceHandler::class,
        PaginatorHandler::class,
    ];
    public function __construct(
        $data = null,
        $msg = null,
        $status = 200,
        $errors = [],
    ) {
        $this->status = $status;
        $this->msg = $msg;
        $this->data = $data;
        $this->errors = $errors;
    }
    public static function make($data = null, $msg = null, $status = 200)
    {
        return new static($data, $msg, $status);
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
    public function setMessage($message)
    {
        $this->msg = $message;
        return $this;
    }
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function setErrors($errors)
    {
        $this->errors = $errors;
        return $this;
    }
    public function getData()
    {
        return app(Pipeline::class)
            ->send($this->data)
            ->through($this->pipelines)
            ->thenReturn();
    }

    public function getStatus()
    {
        return in_array($this->status, [200, 201]);
    }
    public function toResponse($request)
    {
        return response()->json($this->toArray());
    }

    public function toArray()
    {
        return [
            'status' => $this->getStatus(),
            'message' => $this->msg,
            'data' => $this->getData(),
            'errors' => $this->errors,
        ];
    }
}
