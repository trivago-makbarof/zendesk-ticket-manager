<?php

namespace ZendeskTicketManager\Exception;

class UnexpectedResponseException extends \RuntimeException {
     
    public function __construct($message = null, $code = 0)
    {
         parent::__construct('The response status is unexpected. You can find the error description in JSON response: '.$message, $code);
    }
}