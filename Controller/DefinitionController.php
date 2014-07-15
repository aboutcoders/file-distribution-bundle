<?php

namespace Abc\Bundle\FileDistributionBundle\Controller;

use Abc\Bundle\FileDistributionBundle\Doctrine\DefinitionManager;
use Abc\Bundle\FileDistributionBundle\Model\DefinitionManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Abc\Bundle\FileDistributionBundle\Entity\Definition;
use Abc\Bundle\FileDistributionBundle\Form\DefinitionType;

/**
 * Definition controller.
 *
 * @Route("/filesystem")
 */
class DefinitionController extends Controller
{
    /**
     * Lists all entities.
     *
     * @Route("/", name="filesystem")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $manager  = $this->getDefinitionManager();
        $entities = $manager->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new entity.
     *
     * @Route("/", name="filesystem_create")
     * @Method("POST")
     * @Template("AbcFileDistributionBundle:Definition:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $manager = $this->getDefinitionManager();
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
     * Creates a form to create a entity.
     *
     * @param Definition $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Definition $entity)
    {
        $form = $this->createForm(
            new DefinitionType(),
            $entity,
            array(
                'action' => $this->generateUrl('filesystem_create'),
                'method' => 'POST',
            )
        );

        return $form;
    }

    /**
     * Displays a form to create a new entity.
     *
     * @Route("/new", name="filesystem_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $manager = $this->getDefinitionManager();
        $entity  = $manager->create();
        $form    = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a entity.
     *
     * @Route("/{id}", name="filesystem_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $manager = $this->getDefinitionManager();
        $entity  = $manager->findBy(array('id' => $id));

        if(!$entity)
        {
            throw $this->createNotFoundException('Unable to find entity.');
        }

        return array(
            'entity' => $entity
        );
    }

    /**
     * Displays a form to edit an existing entity.
     *
     * @Route("/{id}/edit", name="filesystem_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $manager = $this->getDefinitionManager();
        $entity  = $manager->findBy(array('id' => $id));

        if(!$entity)
        {
            throw $this->createNotFoundException('Unable to find entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView()
        );
    }

    /**
     * Creates a form to edit a entity.
     *
     * @param Definition $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Definition $entity)
    {
        $form = $this->createForm(
            new DefinitionType(),
            $entity,
            array(
                'action' => $this->generateUrl('filesystem_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            )
        );

        return $form;
    }

    /**
     * Edits an existing entity.
     *
     * @Route("/{id}", name="filesystem_update")
     * @Method("PUT")
     * @Template("AbcFileDistributionBundle:Definition:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $manager = $this->getDefinitionManager();
        $entity  = $manager->findBy(array('id' => $id));

        if(!$entity)
        {
            throw $this->createNotFoundException('Unable to find entity.');
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
     * @return DefinitionManagerInterface
     */
    protected function getDefinitionManager()
    {
        return $this->container->get('abc.file_distribution.definition_manager');
    }
}