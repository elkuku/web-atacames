<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class UserAccessTest extends WebTestCase
{
    public function testUserCanLogin(): void
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, '/en');

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('#site-title', 'Atacames');

        /**
         * @var UserRepository $userRepository
         */
        $userRepository = static::getContainer()->get(UserRepository::class);

        /**
         * @var \Symfony\Component\Security\Core\User\UserInterface $user
         */
        $user = $userRepository->findOneBy(['identifier' => 'user']);

        $client->loginUser($user);

        $client->request(Request::METHOD_GET, '/en');

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h4', 'Welcome user');
    }
}
