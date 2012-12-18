<?php

namespace ZendeskTicketManager;

use Buzz\Browser;
use ZendeskTicketManager\Exception;

class TicketManager implements TicketManagerInterface
{

    const TICKET_LIST = '/api/v2/tickets.json';
    const TICKET_CREATE = '/api/v2/tickets.json';
    const TICKET_WEB_URL = '/agent/#/tickets/%id%';

    /**
     * @var Browser
     */
    protected $browser;
    protected $url;

    public function __construct($browser)
    {
        if (!$this->_isCurlInstalled()) {
            throw new Exception\MissingCurlException();
        }
        
        $this->browser = $browser;
    }
    
    public function setUrl($url)
    {
        $this->url = $url;
    }
    
    public function setUsernamePassword($userPass)
    {
        $this->browser->getClient()->setOption(CURLOPT_USERPWD, $userPass);
    }

    public function generateWebUrlForTicket(TicketInterface $ticket)
    {
        return $this->url.str_replace('%id%', $ticket->getId(), self::TICKET_WEB_URL);
    }
    
    public function getTickets()
    {
        $this->browser->get($this->url . self::TICKET_LIST);
        $ticketsData = $this->getResponse()->tickets;
        $tickets = array_map(function($value)
                {
                    return new Ticket($value);
                }, $ticketsData);

        return $tickets;
    }

    public function createTicket(TicketInterface $ticket)
    {
        $this->browser->post(
                $this->url . self::TICKET_CREATE, array('Content-Type: application/json'), $ticket->convertToJson()
        );

        return new Ticket($this->getResponse()->ticket);
    }

    protected function getResponse()
    {
        $content = $this->browser->getLastResponse()->getContent();
        $response = json_decode($this->browser->getLastResponse()->getContent());

        if (isset($response->error)) {
            if ($response->error == 'RecordInvalid') {
                throw new Exception\RecordInvalidException($content);
            } else {
                throw new Exception\UnexpectedResponseException($content);
            }
        } elseif ($this->getResponseStatus() >= 300) {
            throw new Exception\UnexpectedResponseException($content);
        }

        return $response;
    }

    protected function getResponseStatus()
    {
        $headers = $this->browser->getLastResponse()->getHeaders();
        foreach ($headers as $header) {
            if (substr($header, 0, 6) == 'Status') {
                return (int) substr($header, 8, 3);
            }
        }
    }

    protected function _isCurlInstalled()
    {
        if (in_array('curl', get_loaded_extensions())) {
            return true;
        } else {
            return false;
        }
    }

}