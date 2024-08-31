<?php

namespace Tests\Feature\admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class MemberTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $member;

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

        // Créez un utilisateur membre que vous utiliserez dans tous les tests
        $this->member = User::factory()->create([
            'firstname' => 'Jane',
            'lastname' => 'Doe',
            'phone' => '0123456789',
            'address' => '1 rue de la Paix',
            'city' => 'Paris',
            'postal_code' => '75000',
            'address_complement' => 'Appartement 123',
            'country' => 'France',
            'email' => 'member@example.com',
            'password' => Hash::make('password'),
            'role' => 'member',
            'email_verified_at' => now(),
        ]);
    }

    // INDEX
    public function test_admin_can_access_members_index_page()
    {
        $response = $this->actingAs($this->admin)->get('/admin/members');
        $response->assertStatus(200);
    }

    // CREATE
    public function test_admin_can_access_members_create_page()
    {
        $response = $this->actingAs($this->admin)->get('/admin/members/create');
        $response->assertStatus(200);
    }

    // EDIT
    public function test_admin_can_access_members_edit_page()
    {
        $response = $this->actingAs($this->admin)->get('/admin/members/edit/' . $this->member->id);
        $response->assertStatus(200);
    }

    // STORE
    public function test_admin_can_store_member() {
        // Not allowed because email already exists
        $response = $this->actingAs($this->admin)->post('/admin/members/store', [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'member@example.com',
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
        $response = $this->actingAs($this->admin)->post('/admin/members/store', [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'member2@example.com',
            'phone' => '0123456789',
            'address' => '1 rue de la Paix',
            'city' => 'Paris',
            'postal_code' => '75000',
            'address_complement' => 'Appartement 123',
            'country' => 'France',
            'email_verified' => true,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/members');
        $response->assertSessionHas('success');
    }

    // UPDATE
    public function test_admin_can_update_member() {
        

        // Not allowed because email already exists
        $response = $this->actingAs($this->admin)->post('/admin/members/update/' . $this->member->id, [
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

        // Allowed - Same Email
        $response = $this->actingAs($this->admin)->post('/admin/members/update/' . $this->member->id, [
            'firstname' => 'Jane',
            'lastname' => 'Doe',
            'email' => 'member@example.com',
            'phone' => '0123456789',
            'address' => '1 rue de la Paix',
            'city' => 'Paris',
            'postal_code' => '75000',
            'address_complement' => 'Appartement 123',
            'country' => 'France',
            'email_verified' => true,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/members');
        $response->assertSessionHas('success');

        // Allowed - Different Email
        $response = $this->actingAs($this->admin)->post('/admin/members/update/' . $this->member->id, [
            'firstname' => 'Jane',
            'lastname' => 'Doe',
            'email' => 'newmember@email.com',
            'phone' => '0123456789',
            'address' => '1 rue de la Paix',
            'city' => 'Paris',
            'postal_code' => '75000',
            'address_complement' => 'Appartement 123',
            'country' => 'France',
            'email_verified' => true,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/members');
        $response->assertSessionHas('success');
    }

 

    // SOFT DELETE
    public function test_admin_can_soft_delete_member() {
        $response = $this->actingAs($this->admin)->get('/admin/members/soft-delete/' . $this->member->id);
        $response->assertStatus(302);
        $response->assertRedirect('/admin/members');
        $response->assertSessionHas('success');
    }

    // RESTORE
    public function test_admin_can_restore_member() {
        $this->member->softDelete();
        $response = $this->actingAs($this->admin)->get('/admin/members/restore/' . $this->member->id);
        $response->assertStatus(302);
        $response->assertRedirect('/admin/members');
        $response->assertSessionHas('success');
    }


    // DELETE
    public function test_admin_can_delete_admin() {
        $response = $this->actingAs($this->admin)->get('/admin/members/delete/' . $this->member->id);
        $response->assertStatus(302);
        $response->assertRedirect('/admin/members');
        $response->assertSessionHas('success');

        // Member is deleted
        $this->assertNull(User::find($this->member->id));

    }

}
