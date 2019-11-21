<?php

namespace App\Errors;

class Error
{
    public $code = 0;
    public $message = 'Unknown error';

    public function __construct(string $value = '')
    {
        if(!empty($value)) {
            $this->setMessage(sprintf($this->getMessage(),$value));
        }
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function toJson() {
        return json_encode([
            "code" => $this->getCode(),
            "message" => $this->getMessage()
        ]);
    }

    public function __toString() {
        return $this->message;
    }
}
