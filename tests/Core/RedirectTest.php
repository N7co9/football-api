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
        $redirect->to('');
        self::assertSame('http://localhost:8079/', $headerSender->capturedHeaders[0]);
    }
}
