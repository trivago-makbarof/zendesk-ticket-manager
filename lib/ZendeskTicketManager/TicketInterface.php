<?php

namespace ZendeskTicketManager;

interface TicketInterface {
    
    public function convertToJson();
    
    public function getId();
}