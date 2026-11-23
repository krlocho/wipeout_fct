<?php // PHP opening tag

use Illuminate\Database\Migrations\Migration; // Import base migration class
use Illuminate\Database\Schema\Blueprint; // Import blueprint for schema table builder
use Illuminate\Support\Facades\Schema; // Import schema facade for table alterations

return new class extends Migration { // Return anonymous migration instance
    public function up(): void { // Execute migration modifications
        Schema::table('reparacions', function (Blueprint $table) { // Target the reparacions database table
            $table->string('foto_url')->nullable()->after('Observaciones'); // Add optional damage photo path column
        }); // Close table alteration callback
    } // End of up migration method

    public function down(): void { // Revert migration modifications
        Schema::table('reparacions', function (Blueprint $table) { // Target the reparacions database table
            $table->dropColumn('foto_url'); // Drop damage photo column on rollback
        }); // Close table rollback callback
    } // End of down migration method
}; // End of migration class
