<?php

namespace Abc\FileDistributionBundle\Controller;

use Abc\FileDistributionBundle\Doctrine\LocationManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Abc\FileDistributionBundle\Entity\Location;
use Abc\FileDistributionBundle\Form\LocationType;

/**
 * Location controller.
 *
 * @Route("/location")
 */
class LocationController extends Controller
{

    /**
     * Lists all Location entities.
     *
     * @Route("/", name="location")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $locationManager = $this->getLocationManager();
        $entities        = $locationManager->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Location entity.
     *
     * @Route("/", name="location_create")
     * @Method("POST")
     * @Template("AbcFileDistributionBundle:Location:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $locationManager = $this->getLocationManager();
        $entity          = $locationManager->create();
        $form            = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid() && !$request->isXmlHttpRequest()) {

            $locationManager->update($entity);

            return $this->redirect($this->generateUrl('location_show', array('id' => $entity->getId())));
        }
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Location entity.
     *
     * @param Location $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Location $entity)
    {
        $form = $this->createForm(new LocationType(), $entity, array(
            'action' => $this->generateUrl('location_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Location entity.
     *
     * @Route("/new", name="location_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $locationManager = $this->getLocationManager();
        $entity          = $locationManager->create();
        $form            = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Location entity.
     *
     * @Route("/{id}", name="location_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $locationManager = $this->getLocationManager();
        $entity          = $locationManager->findBy(array('id' => $id));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Location entity.');
        }

        return array(
            'entity' => $entity
        );
    }

    /**
     * Displays a form to edit an existing Location entity.
     *
     * @Route("/{id}/edit", name="location_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $locationManager = $this->getLocationManager();
        $entity          = $locationManager->findBy(array('id' => $id));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Location entity.');
        }

        $editForm = $this->createEditForm($entity);
        return array(
            'entity'    => $entity,
            'edit_form' => $editForm->createView()
        );
    }

    /**
     * Creates a form to edit a Location entity.
     *
     * @param Location $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Location $entity)
    {
        $form = $this->createForm(new LocationType(), $entity, array(
            'action' => $this->generateUrl('location_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing Location entity.
     *
     * @Route("/{id}", name="location_update")
     * @Method("PUT")
     * @Template("AbcFileDistributionBundle:Location:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $locationManager = $this->getLocationManager();
        $entity          = $locationManager->findBy(array('id' => $id));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Location entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $locationManager->update($entity);

            return $this->redirect($this->generateUrl('location_edit', array('id' => $id)));
        }

        return array(
            'entity'    => $entity,
            'edit_form' => $editForm->createView()
        );
    }

    /**
     * @return LocationManager
     */
    protected function getLocationManager()
    {
        return $this->container->get('abc_file_distribution.location_manager');
    }
}
