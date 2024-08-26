<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected $member;
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Créez un utilisateur que vous utiliserez dans tous les tests
        $this->member = User::factory()->create([
            'email' => 'johndoe@example.com',
            'password' => Hash::make('password'),
        ]);

        // Créez un utilisateur administrateur que vous utiliserez dans tous les tests
        $this->admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
    }

    // LOGIN
    public function test_user_can_access_login_page()
    {
        $response = $this->get('/auth/login');
        $response->assertStatus(200);
    }

    public function test_member_can_login()
    {
        // Un utilisateur non vérifié ne peut pas se connecter
        $this->member->email_verified_at = null;
        $this->member->save();

        $response = $this->post('/auth/login', [
            'email' => $this->member->email,
            'password' => 'password',
        ]);

        $this->member->refresh();

        $response->assertStatus(302);
        $response->assertRedirect('/auth/email-verification/' . $this->member->user_token);

        // Un utilisateur vérifié peut se connecter
        $this->member->verifyEmail();
        $this->member->save();
        $response = $this->post('/auth/login', [
            'email' => $this->member->email,
            'password' => 'password',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/auth/login');
    }

    public function test_admin_can_login()
    {
        $response = $this->post('/auth/login', [
            'email' => $this->admin->email,
            'password' => 'password',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/auth/login');
    }


    // REGISTER
    public function test_user_can_access_register_page()
    {
        $response = $this->get('/auth/register');
        $response->assertStatus(200);
    }

    public function test_member_can_register()
    {
        $response = $this->post('/auth/register', [
            'email' => 'johndoe2@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'address' => '123 rue de la rue',
            'city' => 'Paris',
            'postal_code' => '75000',
            'country' => 'France',
            'lastname' => 'Doe',
            'firstname' => 'John',
            'phone' => '0123456789',
            'address_complement' => null,
        ]);

        $user = User::where('email', 'johndoe2@example.com')->first();
        $user->refresh();

        $response->assertStatus(302);
        $response->assertRedirect('/auth/email-verification/' . User::where('email', 'johndoe2@example.com')->first()->user_token);
    }

    // EMAIL VERIFICATION
    public function test_user_can_verify_email()
    {
        $this->member->email_verified_at = null;
        $this->member->generateUserToken();

        $response = $this->get('/auth/email-verification/' . $this->member->user_token);
        $response->assertStatus(200);

        $this->member->generateEmailToken();

        $response = $this->post('/auth/email-verification', [
            'email_token' => $this->member->email_token,
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/auth/login');

        $this->assertNotNull($this->member->fresh()->email_verified_at);
    }


    // LOGOUT
    public function test_user_can_logout()
    {
        $response = $this->actingAs($this->member)->get('/auth/logout');
        $response->assertStatus(302);
        $response->assertRedirect('/auth/login');
    }


    // PASSWORD
    public function test_user_can_access_password_forget_page()
    {
        $response = $this->get('/auth/password/forget');
        $response->assertStatus(200);
    }
        
    public function test_member_can_receive_reset_password_token()
    {
        $response = $this->post('/auth/password/forget', [
            'email' => $this->member->email,
        ]);
        $response->assertStatus(302);

        $this->assertNotNull($this->member->fresh()->password_token);
        $this->assertNotNull($this->member->fresh()->password_token_expires_at);
    }

    public function test_member_can_access_reset_password_page()
    {
        $this->member->generatePasswordToken();

        $response = $this->get('/auth/password/reset/' . $this->member->password_token);
        $response->assertStatus(200);
    }

    public function test_member_can_reset_password()
    {
        $this->member->generatePasswordToken();

        $response = $this->post('/auth/password/reset/', [
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
            'password_token' => $this->member->password_token,
        ]);
        $response->assertStatus(302);

        $this->assertTrue(Hash::check('newpassword', $this->member->fresh()->password));
    }

    public function test_user_can_access_password_change_page()
    {
        $this->member->password_expires_at = now()->addDay();
        $this->member->save();
        $response = $this->actingAs($this->member)->get('/auth/password/change');
        $response->assertRedirect('/auth/login');

        $this->member->password_expires_at = now()->subDay();
        $this->member->save();
        $response = $this->actingAs($this->member)->get('/auth/password/change');
        $response->assertStatus(200);
    }

    public function test_user_can_change_password()
    {
        $this->member->password_expires_at = now()->subDay();
        $this->member->save();

        $response = $this->actingAs($this->member)->post('/auth/password/change', [
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);
        $response->assertStatus(302);

        $this->assertTrue(Hash::check('newpassword', $this->member->fresh()->password));
    }
}
