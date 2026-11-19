<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Elkuku\SymfonyUtils\Test\ControllerBaseTest;

class ControllerAccessTest extends ControllerBaseTest
{
    #[\Override]
    protected string $controllerRoot = __DIR__.'/../../src/Controller';

    /**
     * @var array<int, string>
     */
    #[\Override]
    protected array $ignoredFiles
        = [
            '.gitignore',
            'BaseController.php',
            'Security/GoogleController.php',
            'Security/GitHubController.php',
            'Security/GitLabController.php',
        ];

    /**
     * @var array<string, array<string, array<string, int|string>>>
     */
    #[\Override]
    protected array $exceptions
        = [
            // Redirects to the home page in the browser's language.
            'app_default' => [
                'statusCodes' => ['GET' => 302],
            ],
            'app_home' => [
                'statusCodes' => ['GET' => 200],
                'params' => ['{_locale}' => 'en'],
            ],
            'app_login' => [
                'statusCodes' => ['GET' => 200],
            ],
            // Logout requires a CSRF token, see LogoutTest.
            'app_logout' => [
                'statusCodes' => ['GET' => 403],
            ],
        ];

    public function testAllRoutesAreProtected(): void
    {
        $this->runTests(static::createClient());
    }
}
