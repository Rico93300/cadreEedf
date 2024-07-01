<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\TerminateEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FileDeleteListener implements EventSubscriberInterface
{
    private $photoDirectory;

    public function __construct(string $photoDirectory)
    {
        $this->photoDirectory = $photoDirectory;
    }

    public function onTerminate(TerminateEvent $event)
    {
        $request = $event->getRequest();
    $route = $request->get('_route');

        if ($route === 'photo_download') {
        $filename = $request->get('filename');
        $filePath = $this->photoDirectory . '/' . $filename;

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::TERMINATE => 'onTerminate',
        ];
    }
}