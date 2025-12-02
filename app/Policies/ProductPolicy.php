<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Allow suppliers to view their own products
        return $user->isSupplier() || $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Product $product): bool
    {
        // Suppliers can view their own products, admins can view all
        if ($user->isAdmin()) {
            return true;
        }
        
        if ($user->isSupplier() && $user->supplier) {
            return $product->supplier_id === $user->supplier->id;
        }
        
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Suppliers can create products
        return $user->isSupplier() || $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product): bool
    {
        // Suppliers can update their own products, admins can update all
        if ($user->isAdmin()) {
            return true;
        }
        
        if ($user->isSupplier() && $user->supplier) {
            return $product->supplier_id === $user->supplier->id;
        }
        
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): bool
    {
        // Suppliers can delete their own products, admins can delete all
        if ($user->isAdmin()) {
            return true;
        }
        
        if ($user->isSupplier() && $user->supplier) {
            return $product->supplier_id === $user->supplier->id;
        }
        
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Product $product): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Product $product): bool
    {
        return false;
    }
}
