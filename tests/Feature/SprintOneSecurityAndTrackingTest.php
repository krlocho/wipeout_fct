<?php // PHP opening tag

namespace Tests\Feature; // Test namespace declaration

use App\Models\Cliente; // Import Cliente model
use App\Models\Reparacion; // Import Reparacion model
use App\Models\Tabla; // Import Tabla model
use App\Models\User; // Import User model
use Illuminate\Foundation\Testing\RefreshDatabase; // Import RefreshDatabase trait
use Tests\TestCase; // Import base TestCase

class SprintOneSecurityAndTrackingTest extends TestCase { // Feature test suite for Sprint 1 security and tracking
    use RefreshDatabase; // Reset database between tests

    public function test_repair_automatically_generates_unique_tracking_code(): void { // Test tracking code auto generation
        $user = User::factory()->create(); // Create test workshop owner user
        $tabla = Tabla::create(['Modelo' => 'Fish 5.8', 'Marca' => 'Al Merrick', 'User_id' => $user->id]); // Create board
        $cliente = Cliente::create(['Nombre' => 'Carlos', 'Telefono' => '654987321', 'User_id' => $user->id]); // Create client
        $reparacion = Reparacion::create([ // Create test repair record
            'User_id' => $user->id, // Assign user ownership
            'Tabla_id' => $tabla->id, // Assign board foreign key
            'Cliente_id' => $cliente->id, // Assign client foreign key
            'Reparacion' => 'Toque en quilla central', // Damage description
            'Fecha_llegada' => now()->toDateString(), // Arrival date
            'Estado' => 'Sin Empezar', // Default status
        ]); // End of creation array
        $this->assertNotEmpty($reparacion->tracking_code); // Assert tracking code is not empty
        $this->assertStringStartsWith('WP-', $reparacion->tracking_code); // Assert code has WP- prefix
    } // End of test_repair_automatically_generates_unique_tracking_code method

    public function test_public_user_can_track_board_by_code_without_auth(): void { // Test unauthenticated public tracking
        $user = User::factory()->create(); // Create test workshop user
        $tabla = Tabla::create(['Modelo' => 'Gun 7.2', 'Marca' => 'Pukas', 'User_id' => $user->id]); // Create board
        $cliente = Cliente::create(['Nombre' => 'Laura', 'Telefono' => '611222333', 'User_id' => $user->id]); // Create client
        $reparacion = Reparacion::create([ // Create test repair record
            'User_id' => $user->id, // Assign user ownership
            'Tabla_id' => $tabla->id, // Assign board foreign key
            'Cliente_id' => $cliente->id, // Assign client foreign key
            'Reparacion' => 'Reparación de tail', // Damage description
            'Fecha_llegada' => now()->toDateString(), // Arrival date
            'Estado' => 'En Proceso', // Status value
        ]); // End of creation array
        $response = $this->get('/tracking/' . $reparacion->tracking_code); // Perform unauthenticated GET request
        $response->assertStatus(200); // Assert HTTP OK status
        $response->assertSee($reparacion->tracking_code); // Assert tracking code is visible
        $response->assertSee('Gun 7.2'); // Assert board model is displayed
        $response->assertSee('En Reparación'); // Assert progress stage is rendered
    } // End of test_public_user_can_track_board_by_code_without_auth method

    public function test_user_cannot_view_or_edit_other_users_repairs(): void { // Test multi-tenant isolation on repairs
        $workshop_a = User::factory()->create(); // Create first workshop user
        $workshop_b = User::factory()->create(); // Create second workshop user
        $tabla = Tabla::create(['Modelo' => 'Retro 5.10', 'Marca' => 'Lost', 'User_id' => $workshop_a->id]); // Create board for A
        $cliente = Cliente::create(['Nombre' => 'Marcos', 'Telefono' => '677888999', 'User_id' => $workshop_a->id]); // Create client for A
        $reparacion = Reparacion::create([ // Create repair owned by workshop A
            'User_id' => $workshop_a->id, // Workshop A ownership
            'Tabla_id' => $tabla->id, // Board identifier
            'Cliente_id' => $cliente->id, // Client identifier
            'Reparacion' => 'Fisura en canto', // Work description
            'Fecha_llegada' => now()->toDateString(), // Arrival date
            'Estado' => 'Sin Empezar', // Status value
        ]); // End of creation array
        $response = $this->actingAs($workshop_b)->get('/reparaciones/' . $reparacion->id . '/edit'); // Workshop B attempts to access A's repair
        $response->assertStatus(404); // Assert not found error preventing unauthorized access
    } // End of test_user_cannot_view_or_edit_other_users_repairs method

    public function test_user_cannot_delete_other_users_repairs(): void { // Test multi-tenant delete protection
        $workshop_a = User::factory()->create(); // Create first workshop user
        $workshop_b = User::factory()->create(); // Create second workshop user
        $tabla = Tabla::create(['Modelo' => 'Single Fin 6.6', 'Marca' => 'Town & Country', 'User_id' => $workshop_a->id]); // Create board for A
        $cliente = Cliente::create(['Nombre' => 'Elena', 'Telefono' => '644555666', 'User_id' => $workshop_a->id]); // Create client for A
        $reparacion = Reparacion::create([ // Create repair owned by workshop A
            'User_id' => $workshop_a->id, // Workshop A ownership
            'Tabla_id' => $tabla->id, // Board identifier
            'Cliente_id' => $cliente->id, // Client identifier
            'Reparacion' => 'Laminado de quilla', // Work description
            'Fecha_llegada' => now()->toDateString(), // Arrival date
            'Estado' => 'Sin Empezar', // Status value
        ]); // End of creation array
        $response = $this->actingAs($workshop_b)->delete('/reparaciones/' . $reparacion->id); // Workshop B attempts to delete A's repair
        $response->assertStatus(404); // Assert not found error blocking deletion
        $this->assertDatabaseHas('reparacions', ['id' => $reparacion->id]); // Assert repair still exists safely
    } // End of test_user_cannot_delete_other_users_repairs method

    public function test_dashboard_renders_metrics_properly(): void { // Test workshop dashboard metrics
        $user = User::factory()->create(); // Create test workshop user
        $tabla = Tabla::create(['Modelo' => 'Egg 6.8', 'Marca' => 'Torq', 'User_id' => $user->id]); // Create board
        $cliente = Cliente::create(['Nombre' => 'Sofia', 'Telefono' => '633444555', 'User_id' => $user->id]); // Create client
        Reparacion::create([ // Create completed repair
            'User_id' => $user->id, // Owner ID
            'Tabla_id' => $tabla->id, // Board ID
            'Cliente_id' => $cliente->id, // Client ID
            'Reparacion' => 'Reparación completa', // Description
            'Fecha_llegada' => now()->toDateString(), // Arrival
            'Estado' => 'Terminado', // Completed status
        ]); // End of creation array
        $response = $this->actingAs($user)->get('/dashboard'); // Fetch authenticated dashboard
        $response->assertStatus(200); // Assert successful load
        $response->assertSee('Estado de las Reparaciones'); // Assert metrics card headline
    } // End of test_dashboard_renders_metrics_properly method
} // End of SprintOneSecurityAndTrackingTest class
