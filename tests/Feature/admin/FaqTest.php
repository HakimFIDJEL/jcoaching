<?php

namespace Tests\Feature\admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Faq;

use Illuminate\Support\Facades\Hash;


class FaqTest extends TestCase
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
    public function test_admin_can_access_faqs_index_page()
    {
        $response = $this->actingAs($this->admin)->get('/admin/faqs');
        $response->assertStatus(200);
    }

    // CREATE
    public function test_admin_can_access_faqs_create_page()
    {
        $response = $this->actingAs($this->admin)->get('/admin/faqs/create');
        $response->assertStatus(200);
    }

    // EDIT
    public function test_admin_can_access_faqs_edit_page()
    {
        $faq = faq::factory()->create();

        $response = $this->actingAs($this->admin)->get('/admin/faqs/edit/' . $faq->id);
        $response->assertStatus(200);
    }

    // STORE
    public function test_admin_can_store_faq()
    {
        $faq = faq::factory()->make()->toArray();

        $response = $this->actingAs($this->admin)->post('/admin/faqs/store', $faq);
        $response->assertRedirect('/admin/faqs');
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('faqs', $faq);
    }

    // UPDATE
    public function test_admin_can_update_faq()
    {
        $faq = Faq::factory()->create();
        $faq->question = 'Here is my question !!';

        $updatedData = $faq->toArray();
        $updatedData['online'] = (int) $faq->online;

        // Exclure les champs de temps de l'assertion
        unset($updatedData['created_at'], $updatedData['updated_at']);

        $response = $this->actingAs($this->admin)->post('/admin/faqs/update/' . $faq->id, $updatedData);
        $response->assertRedirect('/admin/faqs');
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('faqs', $updatedData);
    }

    // SOFT DELETE
    public function test_admin_can_soft_delete_faq()
    {
        $faq = Faq::factory()->create();

        $response = $this->actingAs($this->admin)->get('/admin/faqs/soft-delete/' . $faq->id);
        $response->assertRedirect('/admin/faqs');
        $response->assertSessionHas('success');

        $expectedData = $faq->only(['id', 'question', 'answer', 'online']);
        $this->assertSoftDeleted('faqs', $expectedData);
    }

    // RESTORE
    public function test_admin_can_restore_faq()
    {
        $faq = Faq::factory()->create();
        $faq->softDelete();

        $response = $this->actingAs($this->admin)->get('/admin/faqs/restore/' . $faq->id);
        $response->assertRedirect('/admin/faqs');
        $response->assertSessionHas('success');

        $expectedData = $faq->only(['id', 'question', 'answer', 'online']);
        $this->assertDatabaseHas('faqs', $expectedData);
    }

    // DELETE
    public function test_admin_can_delete_faq()
    {
        $faq = Faq::factory()->create();

        $response = $this->actingAs($this->admin)->get('/admin/faqs/delete/' . $faq->id);
        $response->assertRedirect('/admin/faqs');
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('faqs', ['id' => $faq->id]);
    }
}
