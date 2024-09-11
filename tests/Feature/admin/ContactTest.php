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

    // INDEX - DONE
    public function test_admin_can_access_index_page() {
        $response = $this->actingAs($this->admin)->get('/admin/contacts');
        $response->assertStatus(200);
    }

    // SHOW - DONE
    public function test_admin_can_access_show_page() {
        $contact = Contact::factory()->create();

        $response = $this->actingAs($this->admin)->get('/admin/contacts/show/' . $contact->id);
        $response->assertStatus(200);

        $contact->refresh();

        $this->assertNotNull($contact->read_at);
    }

    // SOFT DELETE - DONE
    public function test_admin_can_soft_delete_contact() {
        $contact = Contact::factory()->create();

        $response = $this->actingAs($this->admin)->get('/admin/contacts/soft-delete/' . $contact->id);
        $response->assertRedirect('/admin/contacts');
        $response->assertSessionHas('success');

        $contact->refresh();

        $this->assertSoftDeleted($contact);
    }

    // RESTORE - DONE
    public function test_admin_can_restore_contact() {
        $contact = Contact::factory()->create();
        $contact->delete();

        $response = $this->actingAs($this->admin)->get('/admin/contacts/restore/' . $contact->id);
        $response->assertRedirect('/admin/contacts');
        $response->assertSessionHas('success');

        $contact->refresh();

        $this->assertNull($contact->deleted_at);
    }

    // DELETE - DOING
    public function test_admin_can_delete_contact() {
        $contact = Contact::factory()->create();
        $contact->delete();

        $response = $this->actingAs($this->admin)->get('/admin/contacts/delete/' . $contact->id);
        $response->assertRedirect('/admin/contacts');
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
        $this->assertModelMissing($contact);
    }
}
