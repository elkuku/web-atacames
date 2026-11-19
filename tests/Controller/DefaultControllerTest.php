<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class DefaultControllerTest extends WebTestCase
{
    /**
     * @return iterable<string, array{string, string}>
     */
    public static function acceptLanguageProvider(): iterable
    {
        yield 'German browser' => ['de-DE,de;q=0.9,en;q=0.8', '/de'];
        yield 'Spanish browser' => ['es-EC,es;q=0.9', '/es'];
        yield 'English browser' => ['en-US,en;q=0.9', '/en'];
        yield 'Other language' => ['fr-FR,fr;q=0.9', '/en'];
    }

    #[DataProvider('acceptLanguageProvider')]
    public function testRootRedirectsToTheBrowserLanguage(string $acceptLanguage, string $expected): void
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, '/', server: ['HTTP_ACCEPT_LANGUAGE' => $acceptLanguage]);

        self::assertResponseRedirects($expected);
    }

    /**
     * @return iterable<string, array{string, string, string}>
     */
    public static function localeProvider(): iterable
    {
        yield 'English' => ['en', 'Live webcam', 'Discover Atacames'];
        yield 'German' => ['de', 'Live-Webcam', 'Atacames entdecken'];
        yield 'Spanish' => ['es', 'Cámara web en vivo', 'Descubre Atacames'];
    }

    #[DataProvider('localeProvider')]
    public function testHomePageIsTranslated(string $locale, string $webcamTitle, string $discoverTitle): void
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, '/'.$locale);

        self::assertResponseIsSuccessful();
        self::assertSelectorExists(\sprintf('html[lang="%s"]', $locale));
        self::assertSelectorTextContains('#site-title', 'Atacames');
        self::assertSelectorTextContains('#webcam-title', $webcamTitle);
        self::assertSelectorTextContains('#discover-title', $discoverTitle);
        self::assertSelectorExists(\sprintf('.language-switcher a.active[hreflang="%s"]', $locale));
    }

    public function testLanguageSwitcherLinksToTheSamePageInEachLanguage(): void
    {
        $client = static::createClient();

        $crawler = $client->request(Request::METHOD_GET, '/de');

        $links = $crawler->filter('.language-switcher a')->each(
            static fn ($link): string => (string) $link->attr('href'),
        );
        self::assertSame(['/en', '/de', '/es'], $links);
    }

    public function testUnknownLanguageIsNotFound(): void
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, '/fr');

        self::assertResponseStatusCodeSame(404);
    }

    public function testWebcamShowsTheBundledImageByDefault(): void
    {
        $client = static::createClient();

        $crawler = $client->request(Request::METHOD_GET, '/en');

        $src = (string) $crawler->filter('#webcam [data-testid="webcam-image"]')->attr('src');
        self::assertMatchesRegularExpression('#^/assets/images/webcam-[\w-]+\.jpg$#', $src);
    }
}
