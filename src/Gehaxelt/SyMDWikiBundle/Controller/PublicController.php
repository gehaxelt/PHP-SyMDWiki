<?php

namespace Gehaxelt\SyMDWikiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Gehaxelt\SyMDWikiBundle\Entity\Entry;
use Gehaxelt\SyMDWikiBundle\Form\EntryType;
use Gehaxelt\SyMDWikiBundle\Entity\Log;

/**
 * Public controller.
 *
 * @Route("/public")
 */
class PublicController extends Controller
{

    /**
     * Lists all public Entry entities.
     *
     * @Route("/", name="public")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('GehaxeltSyMDWikiBundle:Entry')->findBy(array('public' => true), array('sortid' => 'desc'));

        return array(
            'entities' => $entities,
        );
    }
    
    /**
     * Finds and displays a public Entry entity.
     *
     * @Route("/{id}", name="public_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GehaxeltSyMDWikiBundle:Entry')->findOneBy(array('id' => $id, 'public' => true));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entry entity.');
        }

        return array(
            'entity'      => $entity
        );
    }
}
