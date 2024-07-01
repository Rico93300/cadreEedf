<?php

namespace App\EventSubscriber;

use App\Service\FileCleaner;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class FileCleanerSubscriber implements EventSubscriberInterface
{
    private $fileCleaner;

    public function __construct(FileCleaner $fileCleaner)
    {
        $this->fileCleaner = $fileCleaner;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $this->fileCleaner->cleanFinalImages();
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}