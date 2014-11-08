<?php

namespace Gehaxelt\SyMDWikiBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Config\Definition\Exception\Exception;
use Gehaxelt\SyMDWikiBundle\Entity\Log;


class Logger {

    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
        return $this;
    }

    /**
      * Creates a new log entry with a given severity and message. 
      * @param: String $severity - Usually Log::WARN, Log::INFO, Log::ERROR, Log::SUCCESS
      * @param: String $message - The log's message
    **/
    public function log($severity, $message) {
      $logEntry = new Log();
      $logEntry->setSeverity($severity);
      $logEntry->setMessage($message);
      $this->em->persist($logEntry);
      $this->em->flush($logEntry);
    }

}