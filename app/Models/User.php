<?php // PHP opening tag

namespace App\Models; // Models namespace

use Carbon\Carbon; // Import Carbon for date handling
use Illuminate\Database\Eloquent\Factories\HasFactory; // Import HasFactory trait
use Illuminate\Foundation\Auth\User as Authenticatable; // Import base Authenticatable User class
use Illuminate\Notifications\Notifiable; // Import Notifiable trait

class User extends Authenticatable // User workshop account model
{ // Open class declaration
    use HasFactory, Notifiable; // Include model traits

    protected $fillable = [ // Declare mass-assignable attributes list
        'name', // Workshop or user full name
        'phone', // Contact phone number
        'email', // Login email address
        'password', // Hashed account password
        'latitud', // Geographical latitude for map directory
        'longitud', // Geographical longitude for map directory
        'google_id', // OAuth provider external identifier
        'plan', // Subscription tier (free, pro, enterprise)
        'subscription_status', // Status (active, cancelled, past_due)
        'stripe_customer_id', // Stripe customer identifier
        'stripe_subscription_id', // Stripe recurring subscription identifier
        'subscription_ends_at', // Subscription expiration date
    ]; // Close fillable attributes array

    protected $hidden = [ // Attributes excluded from array and JSON serialization
        'password', // Sensitive password hash
        'remember_token', // Persistent authentication token
    ]; // Close hidden attributes array

    protected function casts(): array // Attribute cast definitions
    { // Open casts method
        return [ // Return type casts mapping
            'email_verified_at' => 'datetime', // Cast timestamp to Carbon datetime
            'password' => 'hashed', // Auto-hash plaintext password strings
            'subscription_ends_at' => 'datetime', // Cast subscription expiration timestamp
        ]; // Close casts mapping
    } // Close casts method

    public function reparaciones() // Relationship linking to repair records
    { // Open reparaciones method
        return $this->hasMany(Reparacion::class, 'User_id', 'id'); // Link using User_id foreign key
    } // Close reparaciones method

    public function is_pro(): bool // Check if workshop user has an active Pro or Enterprise plan
    { // Open is_pro method
        return in_array($this->plan, ['pro', 'enterprise'], true) && $this->subscription_status === 'active'; // Evaluate plan tier and active state
    } // Close is_pro method

    public function monthly_repairs_count(): int // Calculate number of repairs created in the current month
    { // Open monthly_repairs_count method
        return $this->reparaciones() // Query owned repairs
            ->whereYear('created_at', Carbon::now()->year) // Filter current year
            ->whereMonth('created_at', Carbon::now()->month) // Filter current month
            ->count(); // Return count of repairs
    } // Close monthly_repairs_count method

    public function has_reached_monthly_limit(): bool // Check whether free tier monthly quota of 5 boards has been reached
    { // Open has_reached_monthly_limit method
        if ($this->is_pro()) { // Pro and Enterprise users have unlimited repairs
            return false; // Unlimited access
        } // Close pro check
        return $this->monthly_repairs_count() >= 5; // Enforce maximum 5 repairs per month for free plan
    } // Close has_reached_monthly_limit method
} // Close User class declaration
