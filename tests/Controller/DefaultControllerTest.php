<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class DefaultControllerTest extends WebTestCase
{
    public function testHomePageShowsAtacamesAndWebcamPlaceholder(): void
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, '/');

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('#site-title', 'Atacames');
        self::assertSelectorExists('#webcam [data-testid="webcam-placeholder"]');
        self::assertSelectorNotExists('[data-testid="webcam-image"]');
    }
}
