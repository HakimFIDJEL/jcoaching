<?php

namespace Tests\Feature\admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Créez un utilisateur administrateur que vous utiliserez dans tous les tests
        $this->admin = User::factory()->create([
            'firstname' => 'John',
            'lastname' => 'Doe',
            'phone' => '0123456789',
            'address' => '1 rue de la Paix',
            'city' => 'Paris',
            'postal_code' => '75000',
            'address_complement' => 'Appartement 123',
            'country' => 'France',
            'email' => 'johndoe@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
    }

    // INDEX
    public function test_admin_can_access_admins_index_page()
    {
        $response = $this->actingAs($this->admin)->get('/admin/admins');
        $response->assertStatus(200);
    }

    // CREATE
    public function test_admin_can_access_admins_create_page()
    {
        $response = $this->actingAs($this->admin)->get('/admin/admins/create');
        $response->assertStatus(200);
    }

    // EDIT
    public function test_admin_can_access_admins_edit_page()
    {
        $response = $this->actingAs($this->admin)->get('/admin/admins/edit');
        $response->assertStatus(200);
    }

    // STORE
    public function test_admin_can_store_admin()
    {
        // Not allowed because email already exists
        $response = $this->actingAs($this->admin)->post('/admin/admins/store', [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'johndoe@example.com',
            'phone' => '0123456789',
            'address' => '1 rue de la Paix',
            'city' => 'Paris',
            'postal_code' => '75000',
            'address_complement' => 'Appartement 123',
            'country' => 'France',
            'email_verified' => true,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');

        // Allowed
        $response = $this->actingAs($this->admin)->post('/admin/admins/store', [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'example@example.com',
            'phone' => '0123456789',
            'address' => '1 rue de la Paix',
            'city' => 'Paris',
            'postal_code' => '75000',
            'address_complement' => 'Appartement 123',
            'country' => 'France',
            'email_verified' => true,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/admins');
        $response->assertSessionHas('success');
    }

    // UPDATE
    public function test_admin_can_update_admin()
    {
        // Create an admin
        $temporaryAdmin = User::factory()->create([
            'firstname' => 'Jane',
            'lastname' => 'Doe',
            'phone' => '0123456789',
            'address' => '1 rue de la Paix',
            'city' => 'Paris',
            'postal_code' => '75000',
            'address_complement' => 'Appartement 123',
            'country' => 'France',
            'email' => 'example@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Not allowed because email already exists
        $response = $this->actingAs($this->admin)->post('/admin/admins/update', [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'example@example.com',
            'phone' => '0123456789',
            'address' => '1 rue de la Paix',
            'city' => 'Paris',
            'postal_code' => '75000',
            'address_complement' => 'Appartement 123',
            'country' => 'France',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');

        // Allowed - Same Email
        $response = $this->actingAs($this->admin)->post('/admin/admins/update', [
            'firstname' => 'Jane',
            'lastname' => 'Doe',
            'email' => 'johndoe@example.com',
            'phone' => '0123456789',
            'address' => '1 rue de la Paix',
            'city' => 'Paris',
            'postal_code' => '75000',
            'address_complement' => 'Appartement 123',
            'country' => 'France',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/admins');
        $response->assertSessionHas('success');

        // Allowed - Different Email
        $response = $this->actingAs($this->admin)->post('/admin/admins/update', [
            'firstname' => 'Jane',
            'lastname' => 'Doe',
            'email' => 'new@email.com',
            'phone' => '0123456789',
            'address' => '1 rue de la Paix',
            'city' => 'Paris',
            'postal_code' => '75000',
            'address_complement' => 'Appartement 123',
            'country' => 'France',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/admins');
        $response->assertSessionHas('success');
    }

    // CHANGE PASSWORD
    public function test_admin_can_change_password()
    {   
        // Not Allowed - Wrong Current Password
        $response = $this->actingAs($this->admin)->post('/admin/admins/update-password', [
            'current_password' => 'wrongpassword',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('error');

        // Not allowed - Password and Password Confirmation do not match
        $response = $this->actingAs($this->admin)->post('/admin/admins/update-password', [
            'current_password' => 'password',
            'password' => 'newpassword',
            'password_confirmation' => 'wrongpassword',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('password');

        // Not Allowed - Password is the same as the current password
        $response = $this->actingAs($this->admin)->post('/admin/admins/update-password', [
            'current_password' => 'password',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('error');


        // Allowed
        $response = $this->actingAs($this->admin)->post('/admin/admins/update-password', [
            'current_password' => 'password',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/admins');
        $response->assertSessionHas('success');
    }


    // SOFT DELETE
    public function test_admin_can_soft_delete_admin()
    {
        // Create an admin
        $temporaryAdmin = User::factory()->create([
            'firstname' => 'Jane',
            'lastname' => 'Doe',
            'phone' => '0123456789',
            'address' => '1 rue de la Paix',
            'city' => 'Paris',
            'postal_code' => '75000',
            'address_complement' => 'Appartement 123',
            'country' => 'France',
            'email' => 'example@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Not allowed - Admin is soft deleting himself
        $response = $this->actingAs($this->admin)->get('/admin/admins/soft-delete/' . $this->admin->id);
        $response->assertStatus(302);
        $response->assertSessionHas('error');

        // Allowed
        $response = $this->actingAs($this->admin)->get('/admin/admins/soft-delete/' . $temporaryAdmin->id);
        $response->assertStatus(302);
        $response->assertRedirect('/admin/admins');
        $response->assertSessionHas('success');


    }


    // DELETE
    public function test_admin_can_delete_admin()
    {
        // Create an admin
        $temporaryAdmin = User::factory()->create([
            'firstname' => 'Jane',
            'lastname' => 'Doe',
            'phone' => '0123456789',
            'address' => '1 rue de la Paix',
            'city' => 'Paris',
            'postal_code' => '75000',
            'address_complement' => 'Appartement 123',
            'country' => 'France',
            'email' => 'example@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Not allowed - Admin is deleting himself
        $response = $this->actingAs($this->admin)->get('/admin/admins/delete/' . $this->admin->id);
        $response->assertStatus(302);
        $response->assertSessionHas('error');

        // Allowed
        $response = $this->actingAs($this->admin)->get('/admin/admins/delete/' . $temporaryAdmin->id);
        $response->assertStatus(302);
        $response->assertRedirect('/admin/admins');
        $response->assertSessionHas('success');

        // Admin is deleted
        $this->assertNull(User::find($temporaryAdmin->id));

    }
}
