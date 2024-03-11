<?php declare(strict_types=1);

namespace tennis_tournament\util\infrastructure;

final class HttpResponse
{
    public ?int $statusCode;
    public ?string $header;
    public $body;
    
    public function __construct()
    {
        $this->statusCode = 200;
        $this->header = null;
        $this->body = null;
    }

    public function send(): void
    {   
        if ($this->header) {
            header($this->header);
        }
        if ($this->statusCode) {
            http_response_code($this->statusCode);
        }
        if ($this->body) {
            echo json_encode($this->body);
        }
    }

}
