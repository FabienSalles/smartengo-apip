<?php

namespace Smartengo\Tests\Functional\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use Smartengo\Domain\Core\Identifier;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ApiTestCase extends \ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase
{
    protected static Client $client;

    protected function tearDown(): void
    {
    }

    public static function setUpBeforeClass(): void
    {
        self::$client = self::createClient();
    }

    public function getUriIdentifier(string $prefix, ResponseInterface $response): string
    {
        $uri = $response->getHeaders(false)['content-location'][0];

        return substr($uri, \strlen('/'.$prefix.'/'));
    }

    public static function assertUriExist(string $prefix, ResponseInterface $response): void
    {
        self::assertArrayHasKey('content-location', $response->getHeaders(false));
        self::assertArrayHasKey(0, $response->getHeaders(false)['content-location']);
        $uri = $response->getHeaders(false)['content-location'][0];
        self::assertStringContainsString($prefix, $uri);
        self::assertRegExp('/'.Identifier::PATTERN.'/', substr($uri, \strlen('/'.$prefix.'/')));
    }
}
