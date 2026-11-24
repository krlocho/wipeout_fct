<?php // PHP opening tag

namespace Tests\Feature; // Feature tests namespace

use App\Models\User; // Import User model
use Illuminate\Foundation\Testing\RefreshDatabase; // Import RefreshDatabase trait
use Tests\TestCase; // Import base TestCase

class SprintThreeLandingAndMonetizationTest extends TestCase // Test class for Sprint 3 Landing and Monetization
{ // Open class declaration
    use RefreshDatabase; // Use refreshed in-memory database

    public function test_commercial_landing_page_renders_successfully(): void // Test landing page rendering
    { // Open test function
        $response = $this->get(route('welcome')); // Fetch home page route
        $response->assertStatus(200); // Assert HTTP status 200 OK
        $response->assertSee('El taller bajo control'); // Assert authentic headline present
        $response->assertSee('De la resina al agua'); // Assert subtitle headline present
        $response->assertSee('Registrar Taller'); // Assert register CTA button present
        $response->assertSee('Alta Rápida (Quick Intake)'); // Assert feature 1 present
        $response->assertSee('Tablero Kanban de Curado'); // Assert feature 2 present
        $response->assertSee('Portal Público sin Contraseñas'); // Assert feature 3 present
        $response->assertSee('Shaper Local'); // Assert free tier present
        $response->assertSee('Taller Pro'); // Assert pro tier present
        $response->assertSee('Escuela & Factory', false); // Assert enterprise tier present without escaping search term
    } // Close test function

    public function test_landing_page_includes_tracking_search(): void // Test tracking search visibility on landing page
    { // Open test function
        $response = $this->get(route('welcome')); // Fetch home page route
        $response->assertStatus(200); // Assert HTTP status 200 OK
        $response->assertSee('Comprobar estado de una tabla'); // Assert tracking heading
        $response->assertSee(route('reparaciones.track'), false); // Assert tracking action URL exists in search form
    } // Close test function
} // Close class declaration
