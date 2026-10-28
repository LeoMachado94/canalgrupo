<?php

namespace Tests\Feature\Golden;

use App\Models\Client;
use App\Models\User;
use App\Notifications\ClientResetPasswordNotification;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;

class AuthTest extends GoldenTestCase
{
    public function test_login_flows(): void
    {
        $results = [];

        $response = $this->post('/login', ['email' => 'admin@golden.test', 'password' => 'password']);
        $results['admin'] = $this->loginOutcome($response);
        $this->post('/logout');
        Auth::guard('web')->logout();
        Auth::guard('client')->logout();
        $this->flushSession();

        $response = $this->post('/login', ['email' => 'alfa@golden.test', 'password' => 'password']);
        $results['client'] = $this->loginOutcome($response);
        Auth::guard('web')->logout();
        Auth::guard('client')->logout();
        $this->flushSession();

        $response = $this->from('/login')->post('/login', ['email' => 'alfa@golden.test', 'password' => 'errada']);
        $results['wrong_password'] = $this->loginOutcome($response);
        $this->flushSession();

        $response = $this->from('/login')->post('/login', ['email' => '', 'password' => '']);
        $results['empty'] = $this->loginOutcome($response);

        $this->assertGoldenJson('auth/login', $results);
    }

    public function test_logout(): void
    {
        $this->actingAs($this->admin(), 'web');
        $response = $this->post('/logout');

        $this->assertGoldenJson('auth/logout', [
            'status' => $response->getStatusCode(),
            'location' => $response->headers->get('Location'),
            'web' => Auth::guard('web')->check(),
        ]);
    }

    public function test_password_reset_requests(): void
    {
        Notification::fake();

        $results = [
            'admin_request' => $this->outcome($this->from('/password/reset')->post('/password/email', ['email' => 'admin@golden.test'])),
            'admin_unknown' => $this->outcome($this->from('/password/reset')->post('/password/email', ['email' => 'nao@golden.test'])),
            'client_request' => $this->outcome($this->from('/client/password/reset')->post('/client/password/email', ['email' => 'alfa@golden.test'])),
        ];

        Notification::assertSentTo(User::find(1), ResetPassword::class);
        $mail = null;
        Notification::assertSentTo(Client::find(1), ClientResetPasswordNotification::class, function ($notification) use (&$mail) {
            $mail = $notification->toMail(Client::find(1));

            return true;
        });

        $results['client_mail'] = [
            'subject' => $mail->subject,
            'intro' => $mail->introLines,
            'outro' => $mail->outroLines,
            'action' => $mail->actionText,
            'url' => preg_replace('/reset\/[^?]+/', 'reset/TOKEN', $mail->actionUrl),
        ];
        $results['tables'] = [
            'password_resets' => DB::table('password_resets')->pluck('email')->all(),
            'client_password_resets' => DB::table('client_password_resets')->pluck('email')->all(),
        ];

        $this->assertGoldenJson('auth/password_requests', $results);
    }

    public function test_password_resets(): void
    {
        $adminToken = Password::broker('users')->createToken(User::find(1));
        $clientToken = Password::broker('clients')->createToken(Client::find(1));

        $results = [
            'admin_reset' => $this->outcome($this->post('/password/reset', [
                'token' => $adminToken, 'email' => 'admin@golden.test',
                'password' => 'novasenha123', 'password_confirmation' => 'novasenha123',
            ])),
            'client_reset_bad_token' => $this->outcome($this->from('/client/password/reset/x')->post('/client/password/reset', [
                'token' => 'invalido', 'email' => 'alfa@golden.test',
                'password' => 'novasenha123', 'password_confirmation' => 'novasenha123',
            ])),
        ];
        Auth::guard('web')->logout();
        $this->flushSession();

        $results['client_reset'] = $this->outcome($this->post('/client/password/reset', [
            'token' => $clientToken, 'email' => 'alfa@golden.test',
            'password' => 'novasenha123', 'password_confirmation' => 'novasenha123',
        ]));
        $results['client_guard'] = Auth::guard('client')->check();
        $results['admin_password_changed'] = password_verify('novasenha123', User::find(1)->password);
        $results['client_password_changed'] = password_verify('novasenha123', Client::find(1)->password);

        $this->assertGoldenJson('auth/password_resets', $results);
    }

    private function loginOutcome($response): array
    {
        return $this->outcome($response) + [
            'web' => Auth::guard('web')->check(),
            'client' => Auth::guard('client')->check(),
        ];
    }

    private function outcome($response): array
    {
        $session = app('session.store');
        $errors = $session ? $session->get('errors') : null;

        return [
            'status' => $response->getStatusCode(),
            'location' => $response->headers->get('Location'),
            'status_flash' => $session ? $session->get('status') : null,
            'errors' => $errors ? $errors->getBag('default')->toArray() : [],
            'old' => $session ? Arr::except($session->get('_old_input', []), ['_token']) : [],
        ];
    }
}
