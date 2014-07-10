<?php
namespace Abc\Bundle\FileDistributionBundle\Form;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class FieldValueChangeSubscriber implements EventSubscriberInterface
{
    /**
     * @var array
     */
    protected $providers;

    /**
     * @param array $providers Available providers.
     */
    public function __construct(array $providers)
    {
        $this->providers = $providers;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT   => 'preBind',
        );
    }

    /**
     * This method handles initial structure.
     *
     * @param FormEvent $event Form event.
     */
    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        // note that form data is now our entity object
        $this->buildTypeSettingsForm($form, $data->getType());
    }

    /**
     * This method handles changing structure after form submit.
     *
     * @param FormEvent $event Form event.
     */
    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        // first remove old structure
        $form->remove('properties');
        // this time data is just a plain array as parsed from request
        $this->buildTypeSettingsForm($form, $data['type']);
    }

    /**
     * @param Form   $form         Main form.
     * @param string $providerName Provider.
     */
    protected function buildTypeSettingsForm(Form $form, $providerName)
    {
        // create sub-form wrapper
        $subForm = $form->getConfig()->getFormFactory()->createNamed(
            'properties',
            'form',
            null,
            array('label' => false, 'auto_initialize' => false)
        );

        //Add provider form
        if ($providerName && isset($this->providers[$providerName])) {
            $provider = $this->providers[$providerName];
            // delegate form structure building for specific provider
            $provider->buildForm($subForm);
        }

        $form->add($subForm);
    }
}