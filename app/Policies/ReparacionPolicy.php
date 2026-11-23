<?php // PHP opening tag

namespace App\Policies; // Namespace declaration for policy classes

use App\Models\Reparacion; // Import Reparacion model class
use App\Models\User; // Import User model class

class ReparacionPolicy { // Policy governing access to repair records
    public function view_any(User $user): bool { // Check permission to list repairs
        return true; // Any authenticated workshop user can access their own listing
    } // End of view_any method

    public function view(User $user, Reparacion $reparacion): bool { // Check permission to view a repair
        return (int) $user->id === (int) $reparacion->User_id; // Allow only the owner workshop user
    } // End of view method

    public function create(User $user): bool { // Check permission to create a new repair
        return true; // Any authenticated workshop user can create repairs
    } // End of create method

    public function update(User $user, Reparacion $reparacion): bool { // Check permission to edit a repair
        return (int) $user->id === (int) $reparacion->User_id; // Allow only the owner workshop user
    } // End of update method

    public function delete(User $user, Reparacion $reparacion): bool { // Check permission to delete a repair
        return (int) $user->id === (int) $reparacion->User_id; // Allow only the owner workshop user
    } // End of delete method
} // End of ReparacionPolicy class
