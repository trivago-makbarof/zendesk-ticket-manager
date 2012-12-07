<?php

namespace ZendeskTicketManager;

interface TicketManagerInterface {
    
    public function createTicket(TicketInterface $ticket);
    
    public function getTickets();
}