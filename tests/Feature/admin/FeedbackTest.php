<?php

namespace Tests\Feature\admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Feedback;

use Illuminate\Support\Facades\Hash;

class FeedbackTest extends TestCase
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
    public function test_admin_can_access_feedbacks_index_page()
    {
        $response = $this->actingAs($this->admin)->get('/admin/feedbacks');
        $response->assertStatus(200);
    }

    // CREATE
    public function test_admin_can_access_feedbacks_create_page()
    {
        $response = $this->actingAs($this->admin)->get('/admin/feedbacks/create');
        $response->assertStatus(200);
    }

    // EDIT
    public function test_admin_can_access_feedbacks_edit_page()
    {
        $feedback = Feedback::factory()->create();

        $response = $this->actingAs($this->admin)->get('/admin/feedbacks/edit/' . $feedback->id);
        $response->assertStatus(200);
    }

    // STORE
    public function test_admin_can_store_feedback()
    {
        $feedback = Feedback::factory()->make()->toArray();

        $response = $this->actingAs($this->admin)->post('/admin/feedbacks/store', $feedback);
        $response->assertRedirect('/admin/feedbacks');
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('feedback', $feedback);
    }

    // UPDATE
    public function test_admin_can_update_feedback()
    {
        $feedback = Feedback::factory()->create();
        $feedback->name = 'Jane Doe';

        $updatedData = $feedback->toArray();
        $updatedData['online'] = (int) $feedback->online;

        // Exclure les champs de temps de l'assertion
        unset($updatedData['created_at'], $updatedData['updated_at']);

        $response = $this->actingAs($this->admin)->post('/admin/feedbacks/update/' . $feedback->id, $updatedData);
        $response->assertRedirect('/admin/feedbacks');
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('feedback', $updatedData);
    }

    // SOFT DELETE
    public function test_admin_can_soft_delete_feedback()
    {
        $feedback = Feedback::factory()->create();

        $response = $this->actingAs($this->admin)->get('/admin/feedbacks/soft-delete/' . $feedback->id);
        $response->assertRedirect('/admin/feedbacks');
        $response->assertSessionHas('success');

        $expectedData = $feedback->only(['id', 'name', 'job', 'message', 'online']);
        $this->assertSoftDeleted('feedback', $expectedData);
    }

    // RESTORE
    public function test_admin_can_restore_feedback()
    {
        $feedback = Feedback::factory()->create();
        $feedback->softDelete();

        $response = $this->actingAs($this->admin)->get('/admin/feedbacks/restore/' . $feedback->id);
        $response->assertRedirect('/admin/feedbacks');
        $response->assertSessionHas('success');

        $expectedData = $feedback->only(['id', 'name', 'job', 'message', 'online']);
        $this->assertDatabaseHas('feedback', $expectedData);
    }

    // DELETE
    public function test_admin_can_delete_feedback()
    {
        $feedback = Feedback::factory()->create();

        $response = $this->actingAs($this->admin)->get('/admin/feedbacks/delete/' . $feedback->id);
        $response->assertRedirect('/admin/feedbacks');
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('feedback', ['id' => $feedback->id]);
    }

}
