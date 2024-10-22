<?php

namespace Tests\Feature\admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Workout;
use App\Models\RestPeriod;
use App\Models\Setting;

class CalendarTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void {
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
    public function test_admin_can_access_calendar_page() {
        $response = $this->actingAs($this->admin)->get('/admin/calendar');
        $response->assertStatus(200);
    }

    // ADD REST PERIOD - DONE
    public function test_admin_can_add_rest_period() {
        $restPeriod = RestPeriod::factory()->make();

        // Allowed
        $response = $this->actingAs($this->admin)->post('/admin/calendar/rest-periods/add', [
            'start_date' => $restPeriod->start_date->format('Y-m-d H:i:s'),
            'end_date' => $restPeriod->end_date->format('Y-m-d H:i:s'),
        ]);

        $this->assertDatabaseHas('rest_periods', $restPeriod->toArray());

        // Not allowed because overlapping
        $restPeriodOverlapping = RestPeriod::factory()->make([
            'start_date' => Carbon::parse($restPeriod->start_date)->subHours(1),
            'end_date' => Carbon::parse($restPeriod->end_date)->addHours(1),
        ]);

        $response = $this->actingAs($this->admin)->post('/admin/calendar/rest-periods/add', [
            'start_date' => $restPeriodOverlapping->start_date->format('Y-m-d H:i:s'),
            'end_date' => $restPeriodOverlapping->end_date->format('Y-m-d H:i:s'),
        ]);

        $this->assertDatabaseMissing('rest_periods', $restPeriodOverlapping->toArray());
    }

    // UPDATE REST PERIOD - DONE
    public function test_admin_can_update_rest_period() {
        $restPeriod = RestPeriod::factory()->create();
        $newRestPeriod = RestPeriod::factory()->make();
    
        // Allowed
        $response = $this->actingAs($this->admin)->post('/admin/calendar/rest-periods/update', [
            'rest_period' => $restPeriod->id,
            'start_date' => $newRestPeriod->start_date->format('Y-m-d H:i:s'),
            'end_date' => $newRestPeriod->end_date->format('Y-m-d H:i:s'),
        ]);
    
        $restPeriod->refresh();
    
        $this->assertDatabaseHas('rest_periods', [
            'id' => $restPeriod->id,
            'start_date' => $newRestPeriod->start_date->format('Y-m-d H:i:s'),
            'end_date' => $newRestPeriod->end_date->format('Y-m-d H:i:s'),
        ]);
    }
    

    // DELETE REST PERIOD - DONE
    public function test_admin_can_delete_rest_period() {
        $restPeriod = RestPeriod::factory()->create();

        $response = $this->actingAs($this->admin)->post('/admin/calendar/rest-periods/delete', [
            'rest_period' => $restPeriod->id,
        ]);

        $this->assertDatabaseMissing('rest_periods', $restPeriod->toArray());
    }

    // STORE WORKOUT - DONE
    public function test_admin_can_store_workout() {

        $member = User::factory()->create();
        $nbr_sessions = 3;

        // Allowed
        $response = $this->actingAs($this->admin)->post('/admin/calendar/workouts/store', [
            'nbr_sessions' => $nbr_sessions,
            'user' => $member->id,
        ]);

        $this->assertEquals($nbr_sessions, Workout::where('user_id', $member->id)->count());
    }

    // UPDATE WORKOUT - DONE
    public function test_admin_can_update_workout() {
        $workout = Workout::factory()->create();
        $newWorkout = Workout::factory()->make()->toArray();
        $newWorkout['user_id'] = $workout->user_id;

        // Allowed
        $response = $this->actingAs($this->admin)->post('/admin/calendar/workouts/update', [
            'userId' => $workout->user_id,
            'workoutId' => $workout->id,
            'date' => Carbon::parse($newWorkout['date'])->format('Y-m-d H:i:s'),
        ]);

        $workout->refresh();

        $this->assertDatabaseHas('workouts', $newWorkout);

        // Not allowed because overlapping on a workout
        $workoutOverlapping = Workout::factory()->create();

        $response = $this->actingAs($this->admin)->post('/admin/calendar/workouts/update', [
            'userId' => $workoutOverlapping->user_id,
            'workoutId' => $workoutOverlapping->id,
            'date' => Carbon::parse($workout->date)->format('Y-m-d H:i:s'),
        ]);

        $workoutOverlapping->refresh();

        $this->assertDatabaseHas('workouts', [
            'id' => $workoutOverlapping->id,
            'date' => $workoutOverlapping->date,
        ]);

        // Not allowed because overlapping on a rest period
        $restPeriod = RestPeriod::factory()->create();

        $response = $this->actingAs($this->admin)->post('/admin/calendar/workouts/update', [
            'userId' => $workoutOverlapping->user_id,
            'workoutId' => $workoutOverlapping->id,
            'date' => Carbon::parse($restPeriod->start_date)->format('Y-m-d H:i:s'),
        ]);

        $workoutOverlapping->refresh();

        $this->assertDatabaseHas('workouts', [
            'id' => $workoutOverlapping->id,
            'date' => $workoutOverlapping->date,
        ]);

    }

    // SOFT DELETE WORKOUT - DONE
    public function test_admin_can_soft_delete_workout() {
        $workout = Workout::factory()->create();
    
        $response = $this->actingAs($this->admin)->get('/admin/calendar/workouts/soft-delete/' . $workout->user->id . '/' . $workout->id);
    
        $workout->refresh();
    
        $this->assertSoftDeleted('workouts', [
            'id' => $workout->id,
        ]);
    }

    // RESTORE WORKOUT - DONE
    public function test_admin_can_restore_workout() {
        $workout = Workout::factory()->create();
        $workout->delete();
    
        $response = $this->actingAs($this->admin)->get('/admin/calendar/workouts/restore/' . $workout->id);
    
        $workout->refresh();
    
        $this->assertNull($workout->deleted_at);
    }

    // DELETE WORKOUT - DONE
    public function test_admin_can_delete_workout() {
        $workout = Workout::factory()->create();
        $workout->delete();
    
        $response = $this->actingAs($this->admin)->get('/admin/calendar/workouts/delete/' . $workout->id);
    
        $this->assertDatabaseMissing('workouts', [
            'id' => $workout->id,
        ]);
    }

    // NOTIFY - DONE
    public function test_admin_can_access_notify_page() {
        $response = $this->actingAs($this->admin)->get('/admin/calendar/notify');
        $response->assertStatus(200);
    }

    // SEND NOTIFICATION - DONE
    public function test_admin_can_notify() {
        $workout = Workout::factory()->create();

        $response = $this->actingAs($this->admin)->post('/admin/calendar/notify', [
            'workouts' => [$workout->id],
        ]);

        $workout->refresh();

        $this->assertEquals(true, $workout->notified);
    }
    
}
