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
 * Entry controller.
 *
 * @Route("/entry")
 */
class EntryController extends Controller
{

    /**
     * Lists all Entry entities.
     *
     * @Route("/", name="entry")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('GehaxeltSyMDWikiBundle:Entry')->findBy(array(), array('sortid' => 'desc'));

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Entry entity.
     *
     * @Route("/", name="entry_create")
     * @Method("POST")
     * @Template("GehaxeltSyMDWikiBundle:Entry:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Entry();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
            $this->get('logger')->log(Log::SUCCESS, 'Successfully created post: '. $entity->getTitle());

            return $this->redirect($this->generateUrl('entry_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Entry entity.
     *
     * @param Entry $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Entry $entity)
    {
        $form = $this->createForm(new EntryType(), $entity, array(
            'action' => $this->generateUrl('entry_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Entry entity.
     *
     * @Route("/new", name="entry_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Entry();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Entry entity.
     *
     * @Route("/{id}", name="entry_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GehaxeltSyMDWikiBundle:Entry')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entry entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Entry entity.
     *
     * @Route("/{id}/edit", name="entry_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GehaxeltSyMDWikiBundle:Entry')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entry entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Entry entity.
    *
    * @param Entry $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Entry $entity)
    {
        $form = $this->createForm(new EntryType(), $entity, array(
            'action' => $this->generateUrl('entry_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Entry entity.
     *
     * @Route("/{id}", name="entry_update")
     * @Method("PUT")
     * @Template("GehaxeltSyMDWikiBundle:Entry:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GehaxeltSyMDWikiBundle:Entry')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entry entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setLastmodified(new \DateTime());
            $em->flush();

            $this->get('logger')->log(Log::SUCCESS, 'Successfully edited post: '. $entity->getTitle());


            return $this->redirect($this->generateUrl('entry_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates the delete form for an entity
    * 
    * @Route("/{id}/delete", name="entry_delete_form")
    * @Method("GET")
    * @Template()
    **/
    public function deleteFormAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('GehaxeltSyMDWikiBundle:Entry')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entry entity.');
        }

        return array(
            'entity' => $entity,
            'delete_form' => $form->createView()
            );
    }

    /**
     * Deletes a Entry entity.
     *
     * @Route("/{id}", name="entry_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('GehaxeltSyMDWikiBundle:Entry')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Entry entity.');
            }

            $em->remove($entity);
            $em->flush();

            $this->get('logger')->log(Log::SUCCESS, 'Successfully deleted post: '. $entity->getTitle());

        }

        return $this->redirect($this->generateUrl('entry'));
    }

    /**
     * Creates a form to delete a Entry entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('entry_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
