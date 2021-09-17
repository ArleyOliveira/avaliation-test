<?php

namespace AppBundle\Event\EventListener;

use AppBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class InitializeControllerEventListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return array(
            KernelEvents::CONTROLLER => array(
                array('onKernelController')
            )
        );
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = (isset($event->getController()[0])) ? $event->getController()[0] : null;

        if ($controller instanceof AbstractController) {
            $controller->initialize();
        }

    }
}