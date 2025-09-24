<?php

namespace App\Services\ResponseService;

use JsonSerializable;

class ResponseService implements JsonSerializable
{
    public bool $success;
    public mixed $data;
    public ?string $message;

    public function __construct(bool $success, mixed $data = null, ?string $message = null)
    {
        $this->success = $success;
        $this->data = $data;
        $this->message = $message;
    }

    public static function success(mixed $data = null, string $message = 'Success'): self
    {
        return new self(true, $data, $message);
    }

    public static function error(string $message = 'Error', mixed $data = null): self
    {
        return new self(false, $data, $message);
    }

    /**
     * Cette méthode permet à json_encode() et response()->json()
     * de convertir l'objet automatiquement en JSON.
     */
    public function jsonSerialize(): mixed
    {
        return [
            'success' => $this->success,
            'data'    => $this->data,
            'message' => $this->message,
        ];
    }
}

