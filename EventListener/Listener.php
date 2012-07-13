<?php

namespace FSC\P3PBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Response;

use FSC\P3PBundle\ResponseDecorator;

/**
 * Listener
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 */
class Listener
{
    protected $responseDecorator;

    public function __construct($responseDecorator)
    {
        $this->responseDecorator = $responseDecorator;
    }

    /**
     * Add the P3P Header to the response if none is set.
     *
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        $this->responseDecorator->decorate($event->getResponse());
    }
}
