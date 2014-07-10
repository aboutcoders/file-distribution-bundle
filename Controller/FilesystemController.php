<?php

namespace Abc\Bundle\FileDistributionBundle\Controller;

use Abc\Bundle\FileDistributionBundle\Doctrine\FilesystemManager;
use Abc\Bundle\FileDistributionBundle\Model\FilesystemManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Abc\Bundle\FileDistributionBundle\Entity\Filesystem;
use Abc\Bundle\FileDistributionBundle\Form\FilesystemType;

/**
 * Filesystem controller.
 *
 * @Route("/filesystem")
 */
class FilesystemController extends Controller
{
    /**
     * Lists all Filesystem entities.
     *
     * @Route("/", name="filesystem")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $manager  = $this->getFilesystemManager();
        $entities = $manager->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Filesystem entity.
     *
     * @Route("/", name="filesystem_create")
     * @Method("POST")
     * @Template("AbcFileDistributionBundle:Filesystem:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $manager = $this->getFilesystemManager();
        $entity  = $manager->create();
        $form    = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if($form->isValid() && !$request->isXmlHttpRequest())
        {
            $manager->update($entity);

            return $this->redirect($this->generateUrl('filesystem_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Filesystem entity.
     *
     * @param Filesystem $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Filesystem $entity)
    {
        $form = $this->createForm(
            new FilesystemType(),
            $entity,
            array(
                'action' => $this->generateUrl('filesystem_create'),
                'method' => 'POST',
            )
        );

        return $form;
    }

    /**
     * Displays a form to create a new Filesystem entity.
     *
     * @Route("/new", name="filesystem_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $manager = $this->getFilesystemManager();
        $entity  = $manager->create();
        $form    = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Filesystem entity.
     *
     * @Route("/{id}", name="filesystem_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $manager = $this->getFilesystemManager();
        $entity  = $manager->findBy(array('id' => $id));

        if(!$entity)
        {
            throw $this->createNotFoundException('Unable to find Filesystem entity.');
        }

        return array(
            'entity' => $entity
        );
    }

    /**
     * Displays a form to edit an existing Filesystem entity.
     *
     * @Route("/{id}/edit", name="filesystem_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $manager = $this->getFilesystemManager();
        $entity  = $manager->findBy(array('id' => $id));

        if(!$entity)
        {
            throw $this->createNotFoundException('Unable to find Filesystem entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView()
        );
    }

    /**
     * Creates a form to edit a Filesystem entity.
     *
     * @param Filesystem $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Filesystem $entity)
    {
        $form = $this->createForm(
            new FilesystemType(),
            $entity,
            array(
                'action' => $this->generateUrl('filesystem_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            )
        );

        return $form;
    }

    /**
     * Edits an existing Filesystem entity.
     *
     * @Route("/{id}", name="filesystem_update")
     * @Method("PUT")
     * @Template("AbcFileDistributionBundle:Filesystem:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $manager = $this->getFilesystemManager();
        $entity  = $manager->findBy(array('id' => $id));

        if(!$entity)
        {
            throw $this->createNotFoundException('Unable to find Filesystem entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if($editForm->isValid())
        {
            $manager->update($entity);

            return $this->redirect($this->generateUrl('filesystem_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView()
        );
    }

    /**
     * @return FilesystemManagerInterface
     */
    protected function getFilesystemManager()
    {
        return $this->container->get('abc.file_distribution.filesystem_manager');
    }
}