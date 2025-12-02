<?php

namespace App\Policies;

use App\Models\RFQ;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RFQPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Suppliers can view RFQs sent to them, clients can view their RFQs, admins can view all
        return $user->isSupplier() || $user->isClient() || $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, RFQ $rFQ): bool
    {
        // Admins can view all
        if ($user->isAdmin()) {
            return true;
        }
        
        // Suppliers can view RFQs sent to them
        if ($user->isSupplier() && $user->supplier) {
            return $rFQ->supplier_id === $user->supplier->id;
        }
        
        // Clients can view their own RFQs
        if ($user->isClient()) {
            return $rFQ->client_id === $user->id;
        }
        
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only clients can create RFQs
        return $user->isClient() || $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, RFQ $rFQ): bool
    {
        // Only admins can update RFQs directly
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RFQ $rFQ): bool
    {
        // Clients can delete their own RFQs, admins can delete all
        if ($user->isAdmin()) {
            return true;
        }
        
        if ($user->isClient()) {
            return $rFQ->client_id === $user->id;
        }
        
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, RFQ $rFQ): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, RFQ $rFQ): bool
    {
        return false;
    }
}
