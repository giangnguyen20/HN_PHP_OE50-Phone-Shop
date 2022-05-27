<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    const ROLE_ADMIN = 1;
    const EMAIL = 'admin@gmail.com';
    const WRONG_EMAIL = 'abcgmail.com';
    const PASSWORD = '12345678';
    const WRONG_PASSWORD = 'abcdefgh';
    const INVALID_PASSWORD = 'abcd';

    public function testLoginView()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertSee(__('Login'))
                ->assertSee(__('Email Address'))
                ->assertInputPresent('email')
                ->assertSee(__('Password'))
                ->assertInputPresent('password')
                ->assertSee(__('Forgot Your Password?'))
                ->assertSee(__('Remember Me'))
                ->assertInputPresent('remember')
                ->assertSeeIn('button[type="submit"]', __('Login'));
        });
    }

    public function testClickHome()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->click('div .navbar-brand')
                ->assertRouteIs('home');
        });
    }

    public function testClickForgotPassword()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->click('div .forget-password')
                ->waitForLocation(route('password.request'))
                ->assertRouteIs('password.request');
        });
    }

    public function testClickSignUp()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('login')
                ->click('div .btn-register')
                ->waitForLocation(route('register'))
                ->assertRouteIs('register');
        });
    }

    public function testRequiredValidate()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('login')
                ->type('email', '')
                ->type('password', '')
                ->click('button[type="submit"]')
                ->assertRouteIs('login')
                ->assertSee(__('email.required'))
                ->assertSee(__('password.required'));
        });
    }

    public function testEmailValidate()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('login')
                ->type('email', static::WRONG_EMAIL)
                ->type('password', static::WRONG_PASSWORD)
                ->click('button[type="submit"]')
                ->assertRouteIs('login')
                ->assertSee(__('email.email'));
        });
    }

    public function testPasswordValidate()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('login')
                ->type('email', static::WRONG_EMAIL)
                ->type('password', static::INVALID_PASSWORD)
                ->click('button[type="submit"]')
                ->assertRouteIs('login')
                ->assertSee(__('password.min'));
        });
    }

    public function testLoginFail()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('login')
                ->type('email', static::EMAIL)
                ->type('password', static::WRONG_PASSWORD)
                ->clickAndWaitForReload('button[type="submit"]')
                ->assertRouteIs('login')
                ->assertSee(__('login_fail'));
        });
    }

    public function testLoginSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('login')
                ->type('email', static::EMAIL)
                ->type('password', static::PASSWORD)
                ->click('button[type="submit"]')
                ->assertRouteIs('admin.');
        });
    }
}
