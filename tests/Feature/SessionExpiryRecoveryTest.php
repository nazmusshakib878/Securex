<?php

namespace Tests\Feature;

use App\Http\Middleware\RedirectIpToLocalhost;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Tests\TestCase;

class SessionExpiryRecoveryTest extends TestCase
{
    public function test_local_ip_requests_are_redirected_to_the_configured_localhost_origin(): void
    {
        config(['app.url' => 'http://localhost:8000']);

        $request = Request::create(
            'http://127.0.0.1:8000/forgot-password?from=test',
            'GET'
        );

        $response = app(RedirectIpToLocalhost::class)->handle(
            $request,
            fn () => response('next')
        );

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertSame(
            'http://localhost:8000/forgot-password?from=test',
            $response->getTargetUrl()
        );
    }

    public function test_an_expired_csrf_token_redirects_to_login_instead_of_rendering_the_419_page(): void
    {
        $request = Request::create('/login', 'POST');
        $response = app(ExceptionHandler::class)->render(
            $request,
            new TokenMismatchException()
        );

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertSame(route('login'), $response->getTargetUrl());
        $this->assertTrue(session()->has('csrf_error'));
    }
}