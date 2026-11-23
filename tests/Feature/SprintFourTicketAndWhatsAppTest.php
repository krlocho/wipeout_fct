<?php // PHP opening tag

namespace Tests\Feature; // Feature tests namespace

use App\Models\Cliente; // Import Cliente model
use App\Models\Reparacion; // Import Reparacion model
use App\Models\Tabla; // Import Tabla model
use App\Models\User; // Import User model
use Illuminate\Foundation\Testing\RefreshDatabase; // Import RefreshDatabase trait
use Tests\TestCase; // Import base TestCase

class SprintFourTicketAndWhatsAppTest extends TestCase // Test class for Sprint 4 Ticket and WhatsApp features
{ // Open class declaration
    use RefreshDatabase; // Use refreshed in-memory database

    public function test_workshop_user_can_view_printable_ticket(): void // Test printable ticket view
    { // Open test function
        $user_owner = User::factory()->create(['name' => 'Taller Zarautz Surf']); // Create owner user
        $client_record = Cliente::factory()->create(['User_id' => $user_owner->id, 'Nombre' => 'Unai', 'Telefono' => '+34 678 123 456']); // Create client
        $board_record = Tabla::factory()->create(['User_id' => $user_owner->id, 'Modelo' => 'Pukas Dark', 'Marca' => 'Pukas']); // Create board

        $repair_record = Reparacion::create([ // Create repair order
            'User_id' => $user_owner->id, // Assign user owner
            'Cliente_id' => $client_record->id, // Assign client
            'Tabla_id' => $board_record->id, // Assign board
            'Reparacion' => 'Toque en quilla central con rotura de fibra', // Damage description
            'Fecha_llegada' => now()->format('Y-m-d'), // Arrival date
            'Estado' => 'Sin Empezar', // Status
            'Precio' => 45.00, // Price
        ]); // Close create call

        $response = $this->actingAs($user_owner)->get(route('reparaciones.ticket', $repair_record->id)); // Request ticket route
        $response->assertStatus(200); // Assert HTTP 200 OK
        $response->assertSee('Taller Zarautz Surf'); // Assert workshop name in ticket
        $response->assertSee($repair_record->tracking_code); // Assert tracking code in ticket
        $response->assertSee('Pukas Dark'); // Assert surfboard model in ticket
        $response->assertSee('Unai'); // Assert client name in ticket
        $response->assertSee('Etiqueta de Taller'); // Assert workshop label section
        $response->assertSee('Resguardo para el Surfista'); // Assert customer claim stub section
        $response->assertSee('api.qrserver.com', false); // Assert QR code generator image source
    } // Close test function

    public function test_user_cannot_view_ticket_of_foreign_workshop(): void // Test IDOR protection on ticket endpoint
    { // Open test function
        $user_owner = User::factory()->create(); // Create owner
        $user_attacker = User::factory()->create(); // Create unauthorized user
        $client_record = Cliente::factory()->create(['User_id' => $user_owner->id]); // Create client
        $board_record = Tabla::factory()->create(['User_id' => $user_owner->id]); // Create board

        $repair_record = Reparacion::create([ // Create repair for owner
            'User_id' => $user_owner->id, // Assign user owner
            'Cliente_id' => $client_record->id, // Assign client
            'Tabla_id' => $board_record->id, // Assign board
            'Reparacion' => 'Reparacion secreta', // Description
            'Fecha_llegada' => now()->format('Y-m-d'), // Arrival date
            'Estado' => 'Sin Empezar', // Status
        ]); // Close create call

        $response = $this->actingAs($user_attacker)->get(route('reparaciones.ticket', $repair_record->id)); // Attacker requests ticket
        $response->assertStatus(404); // Assert 404 Not Found (tenant scoped isolation)
    } // Close test function

    public function test_whatsapp_notification_link_is_rendered_on_repair_show(): void // Test WhatsApp link rendering
    { // Open test function
        $user_owner = User::factory()->create(); // Create owner
        $client_record = Cliente::factory()->create(['User_id' => $user_owner->id, 'Nombre' => 'Iker', 'Telefono' => '+34 600 999 888']); // Create client
        $board_record = Tabla::factory()->create(['User_id' => $user_owner->id, 'Modelo' => 'Channel Islands Neckbeard']); // Create board

        $repair_record = Reparacion::create([ // Create repair order
            'User_id' => $user_owner->id, // Assign user owner
            'Cliente_id' => $client_record->id, // Assign client
            'Tabla_id' => $board_record->id, // Assign board
            'Reparacion' => 'Fisura en nose', // Description
            'Fecha_llegada' => now()->format('Y-m-d'), // Arrival date
            'Estado' => 'Terminado', // Finished status
        ]); // Close create call

        $response = $this->actingAs($user_owner)->get(route('reparaciones.show', $repair_record->id)); // Request show view
        $response->assertStatus(200); // Assert HTTP 200 OK
        $response->assertSee('Avisar por WhatsApp'); // Assert WhatsApp button present
        $response->assertSee('wa.me/34600999888', false); // Assert cleaned international phone number in link
        $response->assertSee($repair_record->tracking_code); // Assert tracking code in view
    } // Close test function
} // Close class declaration
