<?php // PHP opening tag

namespace Tests\Feature; // Feature tests namespace

use App\Models\Cliente; // Import Cliente model
use App\Models\Reparacion; // Import Reparacion model
use App\Models\Tabla; // Import Tabla model
use App\Models\User; // Import User model
use Illuminate\Foundation\Testing\RefreshDatabase; // Import RefreshDatabase trait
use Tests\TestCase; // Import base TestCase

class SprintFiveSubscriptionAndMonetizationTest extends TestCase // Test class for Subscription and Monetization features
{ // Open class declaration
    use RefreshDatabase; // Use refreshed in-memory database

    public function test_workshop_user_can_view_subscription_page(): void // Test subscription view
    { // Open test function
        $user_owner = User::factory()->create(['plan' => 'free']); // Create free tier user
        $response = $this->actingAs($user_owner)->get(route('suscripcion.index')); // Request subscription screen
        $response->assertStatus(200); // Assert HTTP 200 OK
        $response->assertSee('Shaper Local (Gratis)'); // Assert free tier title
        $response->assertSee('Actualizar a Taller Pro (29€/mes)'); // Assert upgrade CTA button
    } // Close test function

    public function test_checkout_upgrades_user_to_pro_plan(): void // Test checkout activation
    { // Open test function
        $user_owner = User::factory()->create(['plan' => 'free']); // Create free user
        $response = $this->actingAs($user_owner)->post(route('suscripcion.checkout'), ['plan' => 'pro']); // Post to checkout endpoint
        $response->assertRedirect(route('suscripcion.index')); // Assert redirect back
        $user_owner->refresh(); // Refresh model from database
        $this->assertTrue($user_owner->is_pro()); // Assert user is now pro
        $this->assertEquals('pro', $user_owner->plan); // Assert plan column is pro
        $this->assertEquals('active', $user_owner->subscription_status); // Assert active status
    } // Close test function

    public function test_free_user_is_blocked_after_reaching_5_monthly_repairs_limit(): void // Test limit enforcement
    { // Open test function
        $user_owner = User::factory()->create(['plan' => 'free']); // Create free user
        $client_record = Cliente::factory()->create(['User_id' => $user_owner->id]); // Create client
        $board_record = Tabla::factory()->create(['User_id' => $user_owner->id]); // Create board

        for ($counter = 1; $counter <= 5; $counter++) { // Create 5 existing repairs for current month
            Reparacion::create([ // Persist repair
                'User_id' => $user_owner->id, // User owner ID
                'Cliente_id' => $client_record->id, // Client ID
                'Tabla_id' => $board_record->id, // Board ID
                'Reparacion' => "Reparacion {$counter}", // Damage text
                'Fecha_llegada' => now()->format('Y-m-d'), // Arrival date
                'created_at' => now(), // Current month timestamp
            ]); // Close repair creation
        } // Close for loop

        $this->assertEquals(5, $user_owner->monthly_repairs_count()); // Verify user has 5 repairs
        $this->assertTrue($user_owner->has_reached_monthly_limit()); // Verify quota limit reached

        $response = $this->actingAs($user_owner)->post(route('reparaciones.store'), [ // Attempt 6th repair
            'Cliente_id' => $client_record->id, // Client ID
            'Tabla_id' => $board_record->id, // Board ID
            'Reparacion' => 'Reparacion 6 no permitida', // Damage text
            'Fecha_llegada' => now()->format('Y-m-d'), // Arrival date
        ]); // Close post request

        $response->assertSessionHasErrors('plan'); // Assert validation error on plan attribute
    } // Close test function

    public function test_pro_user_can_create_more_than_5_repairs_without_limits(): void // Test unlimited repairs for pro user
    { // Open test function
        $user_pro = User::factory()->create(['plan' => 'pro', 'subscription_status' => 'active']); // Create pro user
        $client_record = Cliente::factory()->create(['User_id' => $user_pro->id]); // Create client
        $board_record = Tabla::factory()->create(['User_id' => $user_pro->id]); // Create board

        for ($counter = 1; $counter <= 5; $counter++) { // Create 5 existing repairs
            Reparacion::create([ // Persist repair
                'User_id' => $user_pro->id, // User ID
                'Cliente_id' => $client_record->id, // Client ID
                'Tabla_id' => $board_record->id, // Board ID
                'Reparacion' => "Reparacion {$counter}", // Damage text
                'Fecha_llegada' => now()->format('Y-m-d'), // Arrival date
            ]); // Close creation
        } // Close loop

        $this->assertFalse($user_pro->has_reached_monthly_limit()); // Pro user does not reach limit

        $response = $this->actingAs($user_pro)->post(route('reparaciones.store'), [ // Attempt 6th repair
            'Cliente_id' => $client_record->id, // Client ID
            'Tabla_id' => $board_record->id, // Board ID
            'Reparacion' => 'Reparacion 6 permitida en Pro', // Damage text
            'Fecha_llegada' => now()->format('Y-m-d'), // Arrival date
        ]); // Close post request

        $response->assertRedirect(route('reparaciones.kanban')); // Assert successfully created and redirected
        $this->assertDatabaseHas('reparacions', ['Reparacion' => 'Reparacion 6 permitida en Pro']); // Assert persisted
    } // Close test function

    public function test_user_can_cancel_subscription(): void // Test subscription cancellation
    { // Open test function
        $user_owner = User::factory()->create(['plan' => 'pro', 'subscription_status' => 'active']); // Create active pro user
        $response = $this->actingAs($user_owner)->post(route('suscripcion.cancel')); // Post to cancel endpoint
        $response->assertRedirect(route('suscripcion.index')); // Assert redirect back
        $user_owner->refresh(); // Refresh user model
        $this->assertEquals('free', $user_owner->plan); // Assert downgraded to free
        $this->assertEquals('cancelled', $user_owner->subscription_status); // Assert cancelled status
    } // Close test function
} // Close class declaration
