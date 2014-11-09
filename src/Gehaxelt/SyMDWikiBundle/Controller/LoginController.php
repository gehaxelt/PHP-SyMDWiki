<?php

namespace Gehaxelt\SyMDWikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;

use Gehaxelt\SyMDWikiBundle\Entity\Log;

class LoginController extends Controller
{
    /**
     * @Route("/login")
     * @Template()
     */
    public function loginAction(Request $request)
    {
      $session = $request->getSession();
      $logger = $this->get('logger');

      if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) 
      {
          $error = $request->attributes->get(
              SecurityContext::AUTHENTICATION_ERROR
          );
      }
      else 
      {
          $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
          $session->remove(SecurityContext::AUTHENTICATION_ERROR);
          // $logger->log(Log::WARN,'Failed login');
      }
       
      return array(
              // last username entered by the user
              'last_username' => $session->get(SecurityContext::LAST_USERNAME),
              'error'         => $error,
          );
    }
}
