<?php // PHP opening tag

namespace App\Policies; // Namespace declaration for policy classes

use App\Models\Cliente; // Import Cliente model class
use App\Models\User; // Import User model class

class ClientePolicy { // Policy governing access to customer records
    public function view_any(User $user): bool { // Check permission to list customers
        return true; // Any authenticated workshop user can access their own listing
    } // End of view_any method

    public function view(User $user, Cliente $cliente): bool { // Check permission to view a customer
        return (int) $user->id === (int) $cliente->User_id; // Allow only the owner workshop user
    } // End of view method

    public function create(User $user): bool { // Check permission to create a customer
        return true; // Any authenticated workshop user can create clients
    } // End of create method

    public function update(User $user, Cliente $cliente): bool { // Check permission to edit a customer
        return (int) $user->id === (int) $cliente->User_id; // Allow only the owner workshop user
    } // End of update method

    public function delete(User $user, Cliente $cliente): bool { // Check permission to delete a customer
        return (int) $user->id === (int) $cliente->User_id; // Allow only the owner workshop user
    } // End of delete method
} // End of ClientePolicy class
