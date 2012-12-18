<?php

namespace ZendeskTicketManager\Exception;

class MissingCurlException extends \RuntimeException {
     
    public function __construct()
    {
        parent::__construct('The curl extension is not installed! You should install it before using this service.');
    }
}