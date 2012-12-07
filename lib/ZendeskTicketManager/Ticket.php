<?php

namespace ZendeskTicketManager;

class Ticket implements TicketInterface {
    
    protected $id;
    protected $externalId;
    protected $url;
    protected $createdAt;
    protected $updatedAt;
    protected $type = 'task';
    protected $subject;
    protected $description;
    protected $priority;
    protected $status;
    protected $recipient;
    protected $requesterId;
    protected $submitterId;
    protected $assigneeId;
    protected $organizationId;
    protected $groupId;
    protected $collaboratorIds;
    protected $forumTopicId;
    protected $problemId;
    protected $hasIncidents;
    protected $dueAt;
    protected $tags = array();
    protected $via;
    protected $customFields = array();
    protected $satisfactionRating;
    protected $sharingAgreementIds;
    
    protected static $writableProperties = array(
        'externalId',
        'type',
        'subject',
        'description',
        'priority',
        'status',
        'dueAt',
        'tags',
    );
    
    protected static $dateTimeProperties = array(
        'createdAt',
        'updatedAt',
        'dueAt'
    );
    
    public static function camelize($id)
    {
        return preg_replace_callback('/(^|_|\.)+(.)/', function ($match) { return ('.' === $match[1] ? '_' : '').strtoupper($match[2]); }, $id);
    }
    
    public static function underscore($id)
    {
        return strtolower(preg_replace(array('/([A-Z]+)([A-Z][a-z])/', '/([a-z\d])([A-Z])/'), array('\\1_\\2', '\\1_\\2'), strtr($id, '_', '.')));
    }
    
    public function __construct($data = array())
    {
        foreach($data as $property => $value) {
            $property = self::camelize($property);
            if ($value && in_array($property, self::$dateTimeProperties)) {
                $value = new \DateTime($value, new \DateTimeZone('UTC'));
            }
            $this->$property = $value;
        }
    }
    
    public function convertToJson() {
        $parameters = new \stdClass;
        $parameters->ticket = new \stdClass;
        
        foreach (self::$writableProperties as $property) {
            if (isset($this->$property)) {
                if ($this->$property instanceof \DateTime) {
                    $dateTime = new \DateTime($this->$property->format('Y-m-d'), new \DateTimeZone('UTC'));
                    $value = $dateTime->format('c');
                } else {
                    $value = $this->$property;
                }

                $property = self::underscore($property);

                $parameters->ticket->$property = $value;
            }
        }
        
        return json_encode($parameters);
    }
    
    public function setExternalId($externalId)
    {
        $this->externalId = $externalId;
        
        return $this;
    }

    public function setType($type)
    {
        $this->type = $type;
        
        return $this;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
        
        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setPriority($priority)
    {
        $this->priority = $priority;
        
        return $this;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        
        return $this;
    }

    public function setDueAt($dueAt)
    {
        $this->dueAt = $dueAt;
        
        return $this;
    }

    public function setTags($tags)
    {
        $this->tags = $tags;
    }
    
    public function addTag($tag) {
        $this->tags[] = $tag;
        
        return $this;
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getExternalId()
    {
        return $this->externalId;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getRecipient()
    {
        return $this->recipient;
    }

    public function getRequesterId()
    {
        return $this->requesterId;
    }

    public function getSubmitterId()
    {
        return $this->submitterId;
    }

    public function getAssigneeId()
    {
        return $this->assigneeId;
    }

    public function getOrganizationId()
    {
        return $this->organizationId;
    }

    public function getGroupId()
    {
        return $this->groupId;
    }

    public function getCollaboratorIds()
    {
        return $this->collaboratorIds;
    }

    public function getForumTopicId()
    {
        return $this->forumTopicId;
    }

    public function getProblemId()
    {
        return $this->problemId;
    }

    public function getHasIncidents()
    {
        return $this->hasIncidents;
    }

    public function getDueAt()
    {
        return $this->dueAt;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function getVia()
    {
        return $this->via;
    }

    public function getCustomFields()
    {
        return $this->customFields;
    }

    public function getSatisfactionRating()
    {
        return $this->satisfactionRating;
    }

    public function getSharingAgreementIds()
    {
        return $this->sharingAgreementIds;
    }


}