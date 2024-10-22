<?php

namespace Tests\Feature\admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Setting;
use App\Models\Reduction;

use Illuminate\Support\Facades\Hash;

class ReductionTest extends TestCase
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
        
        $this->setting = Setting::factory()->create();
    }

    // INDEX - DONE
    public function test_admin_can_access_reductions_index_page() {
        $response = $this->actingAs($this->admin)->get('/admin/reductions');
        $response->assertStatus(200);
    }

    // CREATE - DONE
    public function test_admin_can_access_reductions_create_page() {
        $response = $this->actingAs($this->admin)->get('/admin/reductions/create');
        $response->assertStatus(200);
    }

    // EDIT - DONE
    public function test_admin_can_access_reductions_edit_page() {
        $reduction = Reduction::factory()->create();

        $response = $this->actingAs($this->admin)->get('/admin/reductions/edit/' . $reduction->id);
        $response->assertStatus(200);
    }

    // STORE - DONE
    public function test_admin_can_store_reduction() {
        $reduction = Reduction::factory()->make()->toArray();

        $response = $this->actingAs($this->admin)->post('/admin/reductions/store', $reduction);
        $response->assertRedirect('/admin/reductions');
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('reductions', $reduction);
    }

    
    // UPDATE - DONE
    public function test_admin_can_update_reduction() {
        $reduction = Reduction::factory()->create();
        $newReduction = Reduction::factory()->make()->toArray();

        $response = $this->actingAs($this->admin)->post('/admin/reductions/update/' . $reduction->id, $newReduction);
        $response->assertRedirect('/admin/reductions');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('reductions', $newReduction);
    }

    // SOFT DELETE - DONE
    public function test_admin_can_soft_delete_reduction() {
        $reduction = Reduction::factory()->create();

        $response = $this->actingAs($this->admin)->get('/admin/reductions/soft-delete/' . $reduction->id);
        $response->assertRedirect('/admin/reductions');
        $response->assertSessionHas('success');

        $reduction->refresh();

        $this->assertSoftDeleted($reduction);
    }

    // RESTORE - DONE
    public function test_admin_can_restore_reduction() {
        $reduction = Reduction::factory()->create();
        $reduction->delete();

        $response = $this->actingAs($this->admin)->get('/admin/reductions/restore/' . $reduction->id);
        // $response->assertRedirect('/admin/reductions');
        $response->assertSessionHas('success');

        $reduction->refresh();

        $this->assertNull($reduction->deleted_at);
    }

    // DELETE - DONE
    public function test_admin_can_delete_reduction() {
        $reduction = Reduction::factory()->create();
        $reduction->delete();

        $response = $this->actingAs($this->admin)->get('/admin/reductions/delete/' . $reduction->id);
        // $response->assertRedirect('/admin/reductions');
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('reductions', ['id' => $reduction->id]);
        $this->assertModelMissing($reduction);
    }

}
