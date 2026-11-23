<?php // PHP opening tag

namespace App\Policies; // Namespace declaration for policy classes

use App\Models\Tabla; // Import Tabla model class
use App\Models\User; // Import User model class

class TablaPolicy { // Policy governing access to surfboard records
    public function view_any(User $user): bool { // Check permission to list surfboards
        return true; // Any authenticated workshop user can access their own listing
    } // End of view_any method

    public function view(User $user, Tabla $tabla): bool { // Check permission to view a surfboard
        return (int) $user->id === (int) $tabla->User_id; // Allow only the owner workshop user
    } // End of view method

    public function create(User $user): bool { // Check permission to create a surfboard
        return true; // Any authenticated workshop user can create boards
    } // End of create method

    public function update(User $user, Tabla $tabla): bool { // Check permission to edit a surfboard
        return (int) $user->id === (int) $tabla->User_id; // Allow only the owner workshop user
    } // End of update method

    public function delete(User $user, Tabla $tabla): bool { // Check permission to delete a surfboard
        return (int) $user->id === (int) $tabla->User_id; // Allow only the owner workshop user
    } // End of delete method
} // End of TablaPolicy class
