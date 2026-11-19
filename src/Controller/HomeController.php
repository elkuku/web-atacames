<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/{_locale}', name: 'app_home', requirements: ['_locale' => '%app.locales%'], methods: ['GET'])]
class HomeController extends BaseController
{
    public function __invoke(
        #[Autowire('%env(WEBCAM_IMAGE_URL)%')] string $webcamImageUrl,
    ): Response {
        return $this->render('default/index.html.twig', [
            'webcam_image_url' => $webcamImageUrl,
        ]);
    }
}
