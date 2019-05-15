<?php


namespace App\Tests\Service;


use App\Service\AuthorService;
use PHPUnit\Framework\TestCase;

class AuthorServiceTest extends TestCase
{
    private $authorService;
    private $expectedHash;
    private $ipAddress;

    public function __construct()
    {
        parent::__construct();
        $this->authorService = new AuthorService();
    }

    protected function setUp(): void
    {
        $this->ipAddress = '127.0.0.1';
        $this->expectedHash = \hash('sha512', $this->ipAddress);
    }

    public function testCreateAuthor()
    {
        $author = $this->authorService->createAuthor($this->ipAddress);
        self::assertEquals($this->expectedHash, $author->getIdentifier());
        self::assertFalse($author->isBanned());
    }

    public function testCreateBannedAuthor()
    {
        $author = $this->authorService->createAuthor($this->ipAddress, true);
        self::assertEquals($this->expectedHash, $author->getIdentifier());
        self::assertTrue($author->isBanned());
    }
}
