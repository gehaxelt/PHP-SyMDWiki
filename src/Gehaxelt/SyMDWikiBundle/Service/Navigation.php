<?php

namespace Gehaxelt\SyMDWikiBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Config\Definition\Exception\Exception;
use Gehaxelt\SyMDWikiBundle\Entity\Log;


class Navigation {

    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
        return $this;
    }

    public function getLastModified() {
      $result = $this->em->getRepository('GehaxeltSyMDWikiBundle:Entry')->getLastModified(20);

      return $result;
    }

}