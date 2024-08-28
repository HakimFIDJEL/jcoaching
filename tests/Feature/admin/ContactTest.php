<?php

namespace Tests\Feature\admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Contact;

use Illuminate\Support\Facades\Hash;

class ContactTest extends TestCase
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
    public function test_admin_can_access_index_page()
    {
        $response = $this->actingAs($this->admin)->get('/admin/contacts');
        $response->assertStatus(200);
    }

    // SHOW
    public function test_admin_can_access_show_page()
    {
        $contact = Contact::factory()->create();

        $response = $this->actingAs($this->admin)->get('/admin/contacts/show/' . $contact->id);
        $response->assertStatus(200);

        $contact->refresh();

        $this->assertNotNull($contact->read_at);
    }

    // SOFT DELETE
    public function test_admin_can_soft_delete_contact()
    {
        $contact = Contact::factory()->create();

        $response = $this->actingAs($this->admin)->get('/admin/contacts/soft-delete/' . $contact->id);
        $response->assertRedirect('/admin/contacts');
        $response->assertSessionHas('success');

        $expectedData =  $contact->only(['id', 'lastname', 'firstname', 'subject', 'email', 'phone', 'message']);
        $this->assertSoftDeleted('contacts', $expectedData);
    }

    // RESTORE
    public function test_admin_can_restore_contact()
    {
        $contact = Contact::factory()->create();
        $contact->softDelete();

        $response = $this->actingAs($this->admin)->get('/admin/contacts/restore/' . $contact->id);
        $response->assertRedirect('/admin/contacts');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contacts', $contact->only(['id', 'lastname', 'firstname', 'subject', 'email', 'phone', 'message']));
    }

    // DELETE
    public function test_admin_can_delete_contact()
    {
        $contact = Contact::factory()->create();

        $response = $this->actingAs($this->admin)->get('/admin/contacts/delete/' . $contact->id);
        $response->assertRedirect('/admin/contacts');
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
    }
}
