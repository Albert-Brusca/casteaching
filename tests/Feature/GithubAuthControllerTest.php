<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\GithubAuthController::class
 */
class GithubAuthControllerTest extends TestCase
{
    use RefreshDatabase, CanLogin;
    /**
     * @test
     */
    public function refirect_to_github()
    {
        $response = $this->get('/auth/redirect');

        $response->assertRedirect();

        $this->assertStringStartsWith('https://github.com/login/oauth/authorize',$response->headers->get('Location'));
    }

    /** @test */
    public function can_process_a_github_callback()
    {
        $this->withoutExceptionHandling();
        $this->assertGuest();

        Socialite::shouldReceive('driver')
            ->once()
            ->with('github')
            ->andReturn($driver = new GithubDriverMock());

        $response = $this->get('/auth/callback');

        $response->assertRedirect('dashboard');
        $this->assertAuthenticated();


        $user = User::where(['email' => GithubDriverMock::EMAIL])->first();

        $this->assertNotNull($user);
        $this->assertEquals($user->name,GithubDriverMock::NAME);
        $this->assertEquals($user->email,GithubDriverMock::EMAIL);
//        $this->assertTrue($user->email_verified_at);
        $this->assertNotNull($user->password);
//        $this->assertNotNull($user->profile_photo_path);
        $this->assertNull($user->superadmin);
        $this->assertEquals($user->github_id,GithubDriverMock::ID);
        $this->assertEquals($user->github_nickname,GithubDriverMock::NICKNAME);
//        $this->assertEquals($user->github_avatar,GithubDriverMock::AVATAR);
        $this->assertEquals($user->github_token,GithubDriverMock::TOKEN);
        $this->assertNull($user->github_refresh_token);

        $this->assertAuthenticatedAs($user);

    }

    /** @test */
    public function can_process_a_github_callback_if_user_with_same_github_id_exists()
    {
        $useralbert = User::create([
            'name' => 'Albert Brusca Manchón',
            'email' => 'abrusca@iesebre.com',
            'password' => Hash::make('password'),
            'github_id' => GithubDriverMock::ID
        ]);

        $this->assertGuest();

        Socialite::shouldReceive('driver')
            ->once()
            ->with('github')
            ->andReturn($driver = new GithubDriverMock());

        $response = $this->get('/auth/callback');

        $response->assertRedirect('dashboard');
        $this->assertAuthenticated();

        $user = User::where(['github_id' => GithubDriverMock::ID])->first();

        $this->assertNotNull($user);
        $this->assertEquals($user->name,GithubDriverMock::NAME);

        $this->assertNotNull($user->password);

        $this->assertNull($user->superadmin);
        $this->assertEquals($user->github_id,GithubDriverMock::ID);
        $this->assertEquals($user->github_nickname,GithubDriverMock::NICKNAME);

        $this->assertEquals($user->github_token,GithubDriverMock::TOKEN);
        $this->assertNull($user->github_refresh_token);

        $this->assertAuthenticatedAs($user);

    }

    /** @test */
    public function can_process_a_github_callback_if_user_with_same_email_id_exists()
    {
        $useralbert = User::create([
            'name' => 'Albert Brusca Manchón',
            'email' => GithubDriverMock::EMAIL,
            'password' => Hash::make('password'),
        ]);

        $this->assertGuest();

        Socialite::shouldReceive('driver')
            ->once()
            ->with('github')
            ->andReturn($driver = new GithubDriverMock());

        $response = $this->get('/auth/callback');

        $response->assertRedirect('dashboard');
        $this->assertAuthenticated();

        $user = User::where(['email' => GithubDriverMock::EMAIL])->first();

        $this->assertNotNull($user);
        $this->assertEquals($user->name,GithubDriverMock::NAME);
        $this->assertEquals($user->email,GithubDriverMock::EMAIL);

        $this->assertNotNull($user->password);

        $this->assertNull($user->superadmin);
        $this->assertEquals($user->github_id,GithubDriverMock::ID);
        $this->assertEquals($user->github_nickname,GithubDriverMock::NICKNAME);

        $this->assertEquals($user->github_token,GithubDriverMock::TOKEN);
        $this->assertNull($user->github_refresh_token);

        $this->assertAuthenticatedAs($user);

    }

    /** @test */
    public function show_error_when_call_to_github_fails()
    {
        $e = new \Exception('Error!');

        Socialite::shouldReceive('driver')
            ->once()
            ->with('github')
            ->andThrow($e);

        $response = $this->get('/auth/callback');

        $response->assertRedirect('login');
        $response->assertSessionHasErrors(['msg' => 'An Error occurred!Error!']);
    }
}
