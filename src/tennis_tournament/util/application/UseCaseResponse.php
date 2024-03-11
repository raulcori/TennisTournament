<?php declare(strict_types=1);

namespace tennis_tournament\util\application;

final class UseCaseResponse
{
    public readonly bool $success;
    public readonly ?string $message;
    public $data;

    private function __construct(bool $success, ?string $message, $data)
    {
        $this->success = $success;
        $this->message = $message;
        $this->data = $data;
    }

    public static function success($data, string $message=null): self
    {
        return new self(true, $message, $data);
    }

    public static function error(string $message='', $data=null): self
    {
        return new self(false, $message, $data);
    }


}


