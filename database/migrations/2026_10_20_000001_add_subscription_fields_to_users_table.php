<?php // PHP opening tag

use Illuminate\Database\Migrations\Migration; // Import Migration base class
use Illuminate\Database\Schema\Blueprint; // Import Blueprint schema builder class
use Illuminate\Support\Facades\Schema; // Import Schema facade

return new class extends Migration { // Return anonymous migration class
    public function up(): void { // Execute database schema migrations
        Schema::table('users', function (Blueprint $table) { // Alter users table structure
            $table->string('plan')->default('free')->after('email'); // Active subscription tier (free, pro, enterprise)
            $table->string('subscription_status')->default('active')->after('plan'); // Status: active, past_due, cancelled
            $table->string('stripe_customer_id')->nullable()->after('subscription_status'); // Stripe customer external ID
            $table->string('stripe_subscription_id')->nullable()->after('stripe_customer_id'); // Stripe subscription external ID
            $table->timestamp('subscription_ends_at')->nullable()->after('stripe_subscription_id'); // Expiration or renewal timestamp
        }); // Close table alteration closure
    } // End of up method

    public function down(): void { // Revert database schema migrations
        Schema::table('users', function (Blueprint $table) { // Alter users table structure
            $table->dropColumn(['plan', 'subscription_status', 'stripe_customer_id', 'stripe_subscription_id', 'subscription_ends_at']); // Drop subscription columns
        }); // Close table alteration closure
    } // End of down method
}; // Close migration anonymous class
