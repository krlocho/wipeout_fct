<?php // PHP opening tag

namespace Tests\Feature; // Feature tests namespace

use App\Models\Cliente; // Import Cliente model
use App\Models\Reparacion; // Import Reparacion model
use App\Models\Tabla; // Import Tabla model
use App\Models\User; // Import User model
use Illuminate\Foundation\Testing\RefreshDatabase; // Import RefreshDatabase trait
use Illuminate\Http\UploadedFile; // Import UploadedFile test utility
use Illuminate\Support\Facades\Storage; // Import Storage facade
use Tests\TestCase; // Import base TestCase

class SprintTwoQuickIntakeAndKanbanTest extends TestCase // Test class for Sprint 2 features
{ // Open class declaration
    use RefreshDatabase; // Ensure pristine database for each test

    public function test_quick_intake_creates_client_and_board_on_the_fly(): void // Test quick intake creation
    { // Open test function
        $user_owner = User::factory()->create(); // Create user owner

        $response = $this->actingAs($user_owner)->post(route('reparaciones.store'), [ // Post to repair store endpoint
            'nuevo_cliente_nombre' => 'Mikel Echevarria', // New client full name
            'nuevo_cliente_telefono' => '+34600112233', // New client phone number
            'nuevo_cliente_email' => 'mikel@example.com', // New client email address
            'nuevo_tabla_modelo' => 'Sub Driver 2.0', // New board model
            'nuevo_tabla_marca' => 'Lost Surfboards', // New board brand
            'nuevo_tabla_color' => 'Blanco y Amarillo', // New board color
            'Reparacion' => 'Toque en el canto derecho con fisura', // Repair description
            'Observaciones' => 'Listo para el fin de semana por favor', // Additional observations
            'Fecha_llegada' => now()->format('Y-m-d'), // Arrival date
            'Estado' => 'Sin Empezar', // Initial status
        ]); // Close post request

        $response->assertRedirect(route('reparaciones.kanban')); // Assert redirected to kanban board

        $this->assertDatabaseHas('clientes', [ // Verify client was created
            'Nombre' => 'Mikel Echevarria', // Matches input name
            'Telefono' => '+34600112233', // Matches input phone
        ]); // Close client database assertion

        $this->assertDatabaseHas('tablas', [ // Verify board was created
            'Modelo' => 'Sub Driver 2.0', // Matches board model
            'Marca' => 'Lost Surfboards', // Matches board brand
        ]); // Close board database assertion

        $this->assertDatabaseHas('reparacions', [ // Verify repair was created
            'Reparacion' => 'Toque en el canto derecho con fisura', // Matches description
        ]); // Close repair database assertion
    } // Close test function

    public function test_repair_with_damage_photo_upload(): void // Test photo upload functionality
    { // Open test function
        Storage::fake('public'); // Fake public disk
        $user_owner = User::factory()->create(); // Create user owner
        $client_record = Cliente::factory()->create(['User_id' => $user_owner->id]); // Create client record
        $board_record = Tabla::factory()->create(['User_id' => $user_owner->id]); // Create board record

        $uploaded_image = UploadedFile::fake()->image('ding.jpg'); // Generate fake image

        $response = $this->actingAs($user_owner)->post(route('reparaciones.store'), [ // Post to repair store endpoint
            'Cliente_id' => $client_record->id, // Existing client ID
            'Tabla_id' => $board_record->id, // Existing board ID
            'Reparacion' => 'Tail machacado contra las rocas', // Repair description
            'Fecha_llegada' => now()->format('Y-m-d'), // Arrival date
            'Estado' => 'Sin Empezar', // Initial status
            'foto' => $uploaded_image, // Attached image file
        ]); // Close post request

        $response->assertRedirect(route('reparaciones.kanban')); // Assert redirect to kanban

        $repair_record = Reparacion::where('User_id', $user_owner->id)->first(); // Query stored repair
        $this->assertNotNull($repair_record); // Ensure repair exists
        $this->assertNotNull($repair_record->foto_url); // Ensure photo url was set
        $clean_file_path = str_replace('/storage/', '', $repair_record->foto_url); // Extract relative disk path
        Storage::disk('public')->assertExists($clean_file_path); // Verify image exists on disk
    } // Close test function

    public function test_kanban_board_renders_and_allows_status_transition(): void // Test kanban board and status transition
    { // Open test function
        $user_owner = User::factory()->create(); // Create user owner
        $client_record = Cliente::factory()->create(['User_id' => $user_owner->id]); // Create client record
        $board_record = Tabla::factory()->create(['User_id' => $user_owner->id]); // Create board record

        $repair_record = Reparacion::create([ // Create initial repair
            'User_id' => $user_owner->id, // Set user owner
            'Cliente_id' => $client_record->id, // Set client
            'Tabla_id' => $board_record->id, // Set board
            'Reparacion' => 'Quilla arrancada', // Set damage description
            'Fecha_llegada' => now()->format('Y-m-d'), // Set arrival date
            'Estado' => 'Sin Empezar', // Set initial status
        ]); // Close create call

        $kanban_response = $this->actingAs($user_owner)->get(route('reparaciones.kanban')); // Access kanban board route
        $kanban_response->assertStatus(200); // Assert HTTP 200 OK
        $kanban_response->assertSee('Tablero de Taller'); // Assert kanban title
        $kanban_response->assertSee('Quilla arrancada'); // Assert repair present in kanban

        $patch_response = $this->actingAs($user_owner)->patchJson(route('reparaciones.update_estado', $repair_record->id), [ // Send JSON patch
            'estado' => 'Terminado', // Update status to finished
        ]); // Close patch call

        $patch_response->assertStatus(200); // Assert successful JSON status
        $patch_response->assertJson([ // Assert JSON response
            'success' => true, // Expect success flag true
            'estado' => 'Terminado', // Expect updated status
        ]); // Close assertJson

        $this->assertDatabaseHas('reparacions', [ // Verify database update
            'id' => $repair_record->id, // Target repair ID
            'Estado' => 'Terminado', // Status updated
        ]); // Close assertDatabaseHas
    } // Close test function

    public function test_user_cannot_update_kanban_status_of_foreign_repair(): void // Test IDOR protection on kanban update
    { // Open test function
        $user_owner = User::factory()->create(); // Create owner
        $user_attacker = User::factory()->create(); // Create attacker
        $client_record = Cliente::factory()->create(['User_id' => $user_owner->id]); // Create client record
        $board_record = Tabla::factory()->create(['User_id' => $user_owner->id]); // Create board record

        $repair_record = Reparacion::create([ // Create repair for owner
            'User_id' => $user_owner->id, // User owner ID
            'Cliente_id' => $client_record->id, // Client ID
            'Tabla_id' => $board_record->id, // Board ID
            'Reparacion' => 'Reparacion privada', // Repair description
            'Fecha_llegada' => now()->format('Y-m-d'), // Arrival date
            'Estado' => 'Sin Empezar', // Initial status
        ]); // Close create call

        $response = $this->actingAs($user_attacker)->patchJson(route('reparaciones.update_estado', $repair_record->id), [ // Attacker attempts patch
            'estado' => 'Terminado', // Target status
        ]); // Close patch call

        $response->assertStatus(404); // Assert not found HTTP 404 error
    } // Close test function
} // Close class declaration
