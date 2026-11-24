<?php // PHP opening tag

namespace App\Http\Controllers; // Controllers namespace declaration

use Carbon\Carbon; // Import Carbon datetime library
use Illuminate\Http\RedirectResponse; // Import RedirectResponse class
use Illuminate\Http\Request; // Import Request class
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\View\View; // Import View class

class SubscriptionController extends Controller // Controller managing workshop plans and Stripe billing
{ // Open class declaration
    public function index(): View { // Render subscription management and upgrade page
        $user = Auth::user(); // Retrieve authenticated workshop user
        $monthly_repairs = $user->monthly_repairs_count(); // Count repairs created this calendar month
        $max_free_repairs = 5; // Free plan quota constant
        $is_pro = $user->is_pro(); // Evaluate Pro tier status
        return view('suscripcion.index', compact('user', 'monthly_repairs', 'max_free_repairs', 'is_pro')); // Render subscription blade view
    } // End of index method

    public function checkout(Request $request): RedirectResponse { // Initiate Stripe checkout or activate Pro plan
        $user = Auth::user(); // Retrieve authenticated user
        $target_plan = $request->input('plan', 'pro'); // Default target plan to pro
        $stripe_key = config('services.stripe.secret'); // Retrieve Stripe secret key from config
        if (!empty($stripe_key) && class_exists(\Stripe\Stripe::class)) { // Check if Stripe SDK and API keys are configured
            \Stripe\Stripe::setApiKey($stripe_key); // Set global Stripe API key
            $session = \Stripe\Checkout\Session::create([ // Create hosted Stripe Checkout Session
                'payment_method_types' => ['card'], // Allow card payments
                'line_items' => [[ // Billing line items
                    'price_data' => [ // Dynamic price structure
                        'currency' => 'eur', // European Euro currency
                        'product_data' => ['name' => 'Wipeout Taller Pro (Suscripción Mensual)'], // Product title
                        'unit_amount' => 2900, // 29.00 EUR in cents
                        'recurring' => ['interval' => 'month'], // Monthly billing interval
                    ], // Close price data
                    'quantity' => 1, // Quantity 1 seat
                ]], // Close line items array
                'mode' => 'subscription', // Subscription recurring mode
                'success_url' => route('suscripcion.success') . '?session_id={CHECKOUT_SESSION_ID}', // Redirect on success
                'cancel_url' => route('suscripcion.index'), // Redirect on cancel
                'customer_email' => $user->email, // Prefill user email
            ]); // Close session creation
            return redirect($session->url); // Redirect user to Stripe secure checkout
        } // Close real Stripe check
        $user->update([ // Instant simulated activation for development and testing environments
            'plan' => $target_plan, // Set plan to pro
            'subscription_status' => 'active', // Mark subscription as active
            'subscription_ends_at' => Carbon::now()->addMonth(), // Set renewal date to one month ahead
        ]); // Close update call
        return redirect()->route('suscripcion.index')->with('success', '¡Plan Taller Pro activado con éxito! Ahora tienes reparaciones y fotos ilimitadas.'); // Redirect with confirmation
    } // End of checkout method

    public function success(Request $request): RedirectResponse { // Handle return from Stripe checkout
        $user = Auth::user(); // Retrieve authenticated user
        $user->update([ // Activate Pro subscription
            'plan' => 'pro', // Set plan to pro
            'subscription_status' => 'active', // Set status to active
            'subscription_ends_at' => Carbon::now()->addMonth(), // Add 1 month subscription validity
        ]); // Close update call
        return redirect()->route('suscripcion.index')->with('success', '¡Enhorabuena! Tu taller ha sido actualizado al plan Pro.'); // Redirect with success message
    } // End of success method

    public function cancel(): RedirectResponse { // Cancel recurring subscription and downgrade to free
        $user = Auth::user(); // Retrieve authenticated user
        $user->update([ // Downgrade user record
            'plan' => 'free', // Reset plan to free
            'subscription_status' => 'cancelled', // Mark status as cancelled
        ]); // Close update call
        return redirect()->route('suscripcion.index')->with('info', 'Tu suscripción ha sido cancelada. Tu taller operará bajo el plan Shaper Local (5 tablas/mes).'); // Redirect with notice
    } // End of cancel method
} // Close SubscriptionController class
