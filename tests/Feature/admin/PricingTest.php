<?php

namespace Tests\Feature\admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Pricing;
use App\Models\PricingFeature;
use Illuminate\Support\Facades\Hash;

class PricingTest extends TestCase
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
    public function test_admin_can_access_pricings_index_page() {
        $response = $this->actingAs($this->admin)->get('/admin/pricings');
        $response->assertStatus(200);
    }

    // CREATE - DONE
    public function test_admin_can_access_pricings_create_page() {
        $response = $this->actingAs($this->admin)->get('/admin/pricings/create');
        $response->assertStatus(200);
    }

    // EDIT - DONE
    public function test_admin_can_access_pricings_edit_page() {
        $pricing = Pricing::factory()->create();

        $response = $this->actingAs($this->admin)->get('/admin/pricings/edit/' . $pricing->id);
        $response->assertStatus(200);
    }

    // STORE - DOING
    public function test_admin_can_store_pricing() {
        $pricingData = Pricing::factory()->make()->toArray();
        $pricingData['features'] = ['feature1', 'feature2', 'feature3'];

        $response = $this->actingAs($this->admin)->post('/admin/pricings/store', $pricingData);

        $response->assertRedirect('/admin/pricings');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('pricings', [
            'title' => $pricingData['title'],
        ]);

        foreach ($pricingData['features'] as $feature) {
            $this->assertDatabaseHas('pricing_features', [
                'label' => $feature,
                'pricing_id' => Pricing::latest()->first()->id,
            ]);
        }
    }

    // UPDATE - DOING
    public function test_admin_can_update_pricing() {
        $pricing = Pricing::factory()->create();
        $newPricing = Pricing::factory()->make()->toArray();
        $newPricing['features'] = ['feature1', 'feature2', 'feature3'];


        // Effectuer la requête de mise à jour
        $response = $this->actingAs($this->admin)->post('/admin/pricings/update/' . $pricing->id, $newPricing);

        // Vérifier la redirection et le succès
        $response->assertRedirect('/admin/pricings');
        $response->assertSessionHas('success');

        
        // Vérifier que les données ont été mises à jour dans la base de données
        $this->assertDatabaseHas('pricings', [
            'title' => $newPricing['title'],
            'subtitle' => $newPricing['subtitle'],
            'description' => $newPricing['description'],
            'nbr_sessions' => $newPricing['nbr_sessions'],
            'price' => $newPricing['price'],
            'online' => $newPricing['online'],
        ]);
    }


    // SOFT DELETE - DOING
    public function test_admin_can_soft_delete_pricing() {
        $pricing = pricing::factory()->create();

        $response = $this->actingAs($this->admin)->get('/admin/pricings/soft-delete/' . $pricing->id);
        $response->assertRedirect('/admin/pricings');
        $response->assertSessionHas('success');

        $pricing->refresh();

        $this->assertSoftDeleted($pricing);
    }

    // RESTORE - DOING
    public function test_admin_can_restore_pricing() {
        $pricing = pricing::factory()->create();
        $pricing->delete();

        $response = $this->actingAs($this->admin)->get('/admin/pricings/restore/' . $pricing->id);
        $response->assertRedirect('/admin/pricings');
        $response->assertSessionHas('success');

        $pricing->refresh();

        $this->assertNull($pricing->deleted_at);
    }

    // DELETE - DOING
    public function test_admin_can_delete_pricing() {
        $pricing = pricing::factory()->create();

        $pricing->delete();

        $response = $this->actingAs($this->admin)->get('/admin/pricings/delete/' . $pricing->id);
        $response->assertRedirect('/admin/pricings');
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing($pricing);
        $this->assertModelMissing($pricing);
    }

}
