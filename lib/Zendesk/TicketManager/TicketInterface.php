<?php

namespace Zendesk\TicketManager;

interface TicketInterface {
    
    public function convertToJson();
    
    public function getId();
}