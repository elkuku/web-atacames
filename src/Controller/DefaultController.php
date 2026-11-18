<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'app_default', methods: ['GET'])]
class DefaultController extends BaseController
{
    public function __invoke(
        #[Autowire('%env(WEBCAM_IMAGE_URL)%')] string $webcamImageUrl,
    ): Response {
        return $this->render('default/index.html.twig', [
            'webcam_image_url' => $webcamImageUrl,
        ]);
    }
}
