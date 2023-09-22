<?php

namespace Core;

use App\Core\RedirectSpy;
use App\Core\Redirect;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertStringContainsString;

class RedirectTest extends TestCase
{
    public function testRedirectTo(): void
    {
        $headerSender = new RedirectSpy();
        $redirect = new Redirect($headerSender);
        $redirect->to('index.php?page=favorites&action=manage');
        self::assertSame('http://localhost:8079/index.php?page=favorites&action=manage', $headerSender->capturedHeaders[0]);
    }
}
