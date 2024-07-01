<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\KernelInterface;

class FileCleaner
{
    private $photoDirectory;
    private $kernel;
    private $requestStack;

    public function __construct(string $photoDirectory, KernelInterface $kernel, RequestStack $requestStack)
    {
        $this->photoDirectory = $photoDirectory;
        $this->kernel = $kernel;
        $this->requestStack = $requestStack;
    }

    public function cleanFinalImages()
    {
        $currentRequest = $this->requestStack->getCurrentRequest();
        $session = $currentRequest ? $currentRequest->getSession() : null;
        $finalFilenameToKeep = $session ? $session->get('final_filename') : null;

        $finalImagePattern = $this->photoDirectory . '/final_*';
        $finalImageFiles = glob($finalImagePattern);

        foreach ($finalImageFiles as $finalImageFile) {
            $filename = basename($finalImageFile);
            if ($filename !== $finalFilenameToKeep && $currentRequest && $currentRequest->get('_route') !== 'photo_download') {
                unlink($finalImageFile);
            }
        }

        if ($session && $finalFilenameToKeep) {
            $session->remove('final_filename');
        }

        // *****************************************

        // $currentRequest = $this->requestStack->getCurrentRequest();
        // $session = $currentRequest ? $currentRequest->getSession() : null;
        // $finalFilenameToKeep = $session ? $session->get('final_filename') : null;

        // $finalImagePattern = $this->photoDirectory . '/final_*';
        // $finalImageFiles = glob($finalImagePattern);

        // foreach ($finalImageFiles as $finalImageFile) {
        //     $filename = basename($finalImageFile);
        //     if ($filename !== $finalFilenameToKeep) {
        //         unlink($finalImageFile);
        //     }
        // }

        // if ($session && $finalFilenameToKeep) {
        //     $session->remove('final_filename');
        // }
    }
}