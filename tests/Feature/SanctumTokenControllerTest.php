<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\SanctumTokenController
 */
class SanctumTokenControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function email_is_required_for_issuing_tokens()
    {
        $response = $this->postJson('/api/sanctum/token',[
            'password' => 'password',
            'device_name' => "Pepe's device",
        ]);

        $response->assertStatus(422);
        $jsonResponse = json_decode($response->getContent());
        $this->assertEquals("The email field is required.",$jsonResponse->message);
        $this->assertEquals("The email field is required.",$jsonResponse->errors->email[0]);

    }

    /** @test */
    public function email_is_valid_for_issuing_tokens()
    {
        $response = $this->postJson('/api/sanctum/token',[
            'email' => 'notvalid',
            'password' => 'password',
            'device_name' => "Pepe's device",
        ]);

        $response->assertStatus(422);


        $jsonResponse = json_decode($response->getContent());
        $this->assertEquals("The email must be a valid email address.",$jsonResponse->message);
        $this->assertEquals("The email must be a valid email address.",$jsonResponse->errors->email[0]);
    }

    /** @test */
    public function password_is_required_for_issuing_tokens()
    {
        $response = $this->postJson('/api/sanctum/token',[
            'email' => 'abrusca@gmail.com',
            'device_name' => "Pepe's device",
        ]);

        $response->assertStatus(422);
        $jsonResponse = json_decode($response->getContent());
        $this->assertEquals("The password field is required.",$jsonResponse->message);
        $this->assertEquals("The password field is required.",$jsonResponse->errors->password[0]);
    }

    /** @test */
    public function device_name_is_required_for_issuing_tokens()
    {
        $response = $this->postJson('/api/sanctum/token',[
            'email' => 'abrusca@gmail.com',
            'password' => 'password',
        ]);

        $response->assertStatus(422);
        $jsonResponse = json_decode($response->getContent());
        $this->assertEquals("The device name field is required.",$jsonResponse->message);
        $this->assertEquals("The device name field is required.",$jsonResponse->errors->device_name[0]);
    }

    /** @test */
    public function invalid_password_gives_incorrect_credentials_error()
    {
        $user = User::create([
            'name' => 'Pepe Pardo Jeans',
            'email' => 'pepe@pardojeans.com',
            'password' => 'password'
        ]);

        $response = $this->postJson('/api/sanctum/token',[
            'email' => $user->email,
            'password' => 'INCORRECT_PASSWORD',
            'device_name' => $user->name . "'s device",
        ]);

        $response->assertStatus(422);
        $jsonResponse = json_decode($response->getContent());
        $this->assertEquals("The provided credentials are incorrect.",$jsonResponse->message);
        $this->assertEquals("The provided credentials are incorrect.",$jsonResponse->errors->email[0]);
    }

    /** @test */
    public function invalid_email_gives_incorrect_credentials_error()
    {
        $user = User::create([
            'name' => 'Pepe Pardo Jeans',
            'email' => 'pepe@pardojeans.com',
            'password' => 'password'
        ]);

        $response = $this->postJson('/api/sanctum/token',[
            'email' => 'another_email@gmail.com',
            'password' => $user->password,
            'device_name' => $user->name . "'s device",
        ]);

        $response->assertStatus(422);
        $jsonResponse = json_decode($response->getContent());
        $this->assertEquals("The provided credentials are incorrect.",$jsonResponse->message);
        $this->assertEquals("The provided credentials are incorrect.",$jsonResponse->errors->email[0]);
    }

    /**
     * @test
     */
    public function email_with_valid_credentials_can_issue_a_token()
    {
        $user = User::create([
            'name' => 'Pepe Pardo Jeans',
            'email' => 'pepe@pardojeans.com',
            'password' => Hash::make('password')
        ]);

        $this->assertCount(0,$user->tokens);

        $response = $this->postJson('/api/sanctum/token', [
            'email' => $user->email,
            'password' => "password",
            'device_name' => $user->name . "'s device",
        ]);

        $response->assertStatus(200);
        $this->assertNotNull($response->getContent());
        $this->assertCount(1,$user->fresh()->tokens);


    }
}
