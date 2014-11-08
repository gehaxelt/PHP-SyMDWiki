<?php

namespace Gehaxelt\SyMDWikiBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Gehaxelt\SyMDWikiBundle\Entity\Log;

/**
 * Log controller.
 *
 * @Route("/log")
 */
class LogController extends Controller
{

    /**
     * Lists all Log entities.
     *
     * @Route("/", name="log")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $curPage = $request->query->get('page');
        if(!isset($curPage) || $curPage <= 0) 
        {
            $curPage = 1;
        }

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('GehaxeltSyMDWikiBundle:Log')
                        ->findBy(array(), array('timestamp' => 'desc'),100, --$curPage * 100);
        $logCount = (int) ($em->getRepository('GehaxeltSyMDWikiBundle:Log')->getLogCount() / 100) + 1;
        
        return array(
            'entities' => $entities,
            'logcount' => $logCount,
            'curPage' => $curPage
        );
    }

    /**
     * Creates a delete form
     * @Route("/delete", name="log_delete_form")
     * @Method("GET")
     * @Template()
    **/
    public function deleteFormAction() {
        return array('delete_form' => $this->createDeleteForm()->createView());
    }

    /**
     * Deletes all logs.
     *
     * @Route("/", name="log_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request)
    {
        $form = $this->createDeleteForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->getRepository('GehaxeltSyMDWikiBundle:Log')->deleteAll();
            $em->flush();

            $this->get('logger')->log(Log::SUCCESS, 'Successfully deleted all logs');

        }

        return $this->redirect($this->generateUrl('log'));
    }

    /**
     * Creates a form to delete all logs.
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm()
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('log_delete'))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * Finds and displays a Log entity.
     *
     * @Route("/{id}", name="log_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GehaxeltSyMDWikiBundle:Log')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Log entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }
}
