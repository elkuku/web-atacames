<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Sends visitors of "/" to the home page in their browser's language.
 */
#[Route('/', name: 'app_default', methods: ['GET'])]
class DefaultController extends BaseController
{
    /**
     * @param array<int, string> $enabledLocales
     */
    public function __invoke(
        Request $request,
        #[Autowire('%kernel.enabled_locales%')] array $enabledLocales,
        #[Autowire('%kernel.default_locale%')] string $defaultLocale,
    ): RedirectResponse {
        return $this->redirectToRoute('app_home', [
            '_locale' => $request->getPreferredLanguage($enabledLocales) ?? $defaultLocale,
        ]);
    }
}
