<?php

namespace Zendesk\TicketManager;

interface TicketManagerInterface {
    
    public function createTicket(TicketInterface $ticket);
    
    public function getTickets();
}