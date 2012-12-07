<?php

namespace ZendeskTicketManager\Exception;

class RecordInvalidException extends \RuntimeException {
     
    public function __construct($message = null, $code = 0)
    {
        parent::__construct('An error occurred. You can find the error description in JSON response: '.$message, $code);
    }
}