<?php 

namespace App\Controller;

use App\Form\PhotoType;
use Intervention\Image\ImageManagerStatic as Image;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PhotoController extends AbstractController
{

    #[Route('/', name: 'photo')]
    public function uploadmoyenne(Request $request): Response
    {
        $session = $request->getSession();
        $session->remove('photo_uploaded');

        $form = $this->createForm(PhotoType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $photoFile */
            $photoFile = $form->get('photo')->getData();

        if ($photoFile) {
            $uploadDir = $this->getParameter('photos_directory');
                $existingFiles = glob($uploadDir.'/*');
    
                $existingFilename = null;
                foreach ($existingFiles as $existingFile) {
                    if (filesize($existingFile) === $photoFile->getSize() && 
                        md5_file($existingFile) === md5_file($photoFile->getPathname())) {
                        $existingFilename = basename($existingFile);
                        break;
                    }
                }
    
                if ($existingFilename === null) {
                    $newFilename = uniqid().'.'.$photoFile->guessExtension();
                    try {
                        $photoFile->move(
                            $uploadDir,
                            $newFilename
                        );
                    } 
                    catch (FileException $e) {
                        // handle exception if something happens during file upload
                    }
                } else {
                    $newFilename = $existingFilename;
                }

                // Chemin du cadre préconstruit
                $framePath = $this->getParameter('frames_directory').'/frame1.png';

                // Charger l'image de l'utilisateur et le cadre
                $userImage = Image::make($this->getParameter('photos_directory').'/'.$newFilename);
                $frameImage = Image::make($framePath);

                // Redimensionner l'image de l'utilisateur pour qu'elle s'intègre dans le cadre
                $userImage->fit(630, 630, null, 'center'); 

                // Créer une nouvelle image ayant les dimensions du cadre
                $canvas = Image::canvas($frameImage->width(), $frameImage->height());

                // Intégrer l'image de l'utilisateur dans le canvas
                $canvas->insert($userImage, 'center');

                // Intégrer le cadre sur l'image de l'utilisateur
                $canvas->insert($frameImage, 'top-left');

            $finalImagePath = $this->getParameter('photos_directory').'/final_'.$newFilename;
            $canvas->save($finalImagePath);
            unlink($uploadDir . '/' . $newFilename);

            $session = $request->getSession();
            $session->set('final_filename', 'final_'.$newFilename);

            return $this->redirectToRoute('photo_result', ['filename' => 'final_'.$newFilename]);
        }
    }


        return $this->render('photo/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/upload/grande', name: 'photo_upload_grande')]
    public function uploadbig(Request $request): Response
    {
        $session = $request->getSession();
        $session->remove('photo_uploaded');

        $form = $this->createForm(PhotoType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $photoFile */
            $photoFile = $form->get('photo')->getData();

        if ($photoFile) {
            $uploadDir = $this->getParameter('photos_directory');
                $existingFiles = glob($uploadDir.'/*');
    
                $existingFilename = null;
                foreach ($existingFiles as $existingFile) {
                    if (filesize($existingFile) === $photoFile->getSize() && 
                        md5_file($existingFile) === md5_file($photoFile->getPathname())) {
                        $existingFilename = basename($existingFile);
                        break;
                    }
                }
    
                if ($existingFilename === null) {
                    $newFilename = uniqid().'.'.$photoFile->guessExtension();
                    try {
                        $photoFile->move(
                            $uploadDir,
                            $newFilename
                        );
                    } 
                    catch (FileException $e) {
                        // handle exception if something happens during file upload
                    }
                } else {
                    $newFilename = $existingFilename;
                }
                
                // Chemin du cadre préconstruit
                $framePath = $this->getParameter('frames_directory').'/frame.png';

                // Charger l'image de l'utilisateur et le cadre
                $userImage = Image::make($this->getParameter('photos_directory').'/'.$newFilename);
                $frameImage = Image::make($framePath);

                // Redimensionner l'image de l'utilisateur pour qu'elle s'intègre dans le cadre
                $userImage->fit(800, 800, null, 'center'); 

                // Créer une nouvelle image ayant les dimensions du cadre
                $canvas = Image::canvas($frameImage->width(), $frameImage->height());

                // Intégrer l'image de l'utilisateur dans le canvas
                $canvas->insert($userImage, 'center');

                // Intégrer le cadre sur l'image de l'utilisateur
                $canvas->insert($frameImage, 'top-left');

            $finalImagePath = $this->getParameter('photos_directory').'/final_'.$newFilename;
            $canvas->save($finalImagePath);
            unlink($uploadDir . '/' . $newFilename);

            $session = $request->getSession();
            $session->set('final_filename', 'final_'.$newFilename);

            return $this->redirectToRoute('photo_result', ['filename' => 'final_'.$newFilename]);
        }
    }


    return $this->render('photo/index.html.twig', [
        'form' => $form->createView(),
        ]);
    }
    #[Route('/upload/petite', name: 'photo_upload_petite')]
    public function uploadPetite(Request $request): Response
    {
        $session = $request->getSession();
        $session->remove('photo_uploaded');

        $form = $this->createForm(PhotoType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $photoFile */
            $photoFile = $form->get('photo')->getData();

        if ($photoFile) {
            $uploadDir = $this->getParameter('photos_directory');
                $existingFiles = glob($uploadDir.'/*');
    
                $existingFilename = null;
                foreach ($existingFiles as $existingFile) {
                    if (filesize($existingFile) === $photoFile->getSize() && 
                        md5_file($existingFile) === md5_file($photoFile->getPathname())) {
                        $existingFilename = basename($existingFile);
                        break;
                    }
                }
    
                if ($existingFilename === null) {
                    $newFilename = uniqid().'.'.$photoFile->guessExtension();
                    try {
                        $photoFile->move(
                            $uploadDir,
                            $newFilename
                        );
                    } 
                    catch (FileException $e) {
                        // handle exception if something happens during file upload
                    }
                } else {
                    $newFilename = $existingFilename;
                }

                // Chemin du cadre préconstruit
                $framePath = $this->getParameter('frames_directory').'/frame2.png';

                // Charger l'image de l'utilisateur et le cadre
                $userImage = Image::make($this->getParameter('photos_directory').'/'.$newFilename);
                $frameImage = Image::make($framePath);

                // Redimensionner l'image de l'utilisateur pour qu'elle s'intègre dans le cadre
                $userImage->fit(400, 400, null, 'center'); 

                // Créer une nouvelle image ayant les dimensions du cadre
                $canvas = Image::canvas($frameImage->width(), $frameImage->height());

                // Intégrer l'image de l'utilisateur dans le canvas
                $canvas->insert($userImage, 'center');

                // Intégrer le cadre sur l'image de l'utilisateur
                $canvas->insert($frameImage, 'top-left');

            $finalImagePath = $this->getParameter('photos_directory').'/final_'.$newFilename;
            $canvas->save($finalImagePath);
            unlink($uploadDir . '/' . $newFilename);

            $session = $request->getSession();
            $session->set('final_filename', 'final_'.$newFilename);

            return $this->redirectToRoute('photo_result', ['filename' => 'final_'.$newFilename]);
        }
    }


        return $this->render('photo/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/result/{filename}', name: 'photo_result')]
    public function result(string $filename, Request $request): Response
    {
        $session = $request->getSession();
        $session->remove('photo_uploaded');

        return $this->render('photo/result.html.twig', [
        'filename' => $filename,
    ]);
    }

    #[Route('/download/{filename}', name: 'photo_download')]
    public function download(string $filename, Request $request): BinaryFileResponse
    {
        $session = $request->getSession();
        $session->remove('photo_uploaded');

        $filePath = $this->getParameter('photos_directory').'/'.$filename;
        return new BinaryFileResponse($filePath);
    }
}

