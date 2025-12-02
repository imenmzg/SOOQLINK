<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use App\Models\RFQ;

class ReviewPolicy
{
    /**
     * Determine if the user can create a review for a supplier.
     * Only clients who have had an RFQ with the supplier can review.
     */
    public function create(User $user, $supplierId = null): bool
    {
        // For admin panel, allow creation
        if ($user->isAdmin()) {
            return true;
        }

        if (!$user->isClient()) {
            return false;
        }

        // If supplierId is not provided (e.g., from Filament authorization check), allow
        // The actual validation will happen in the form
        if ($supplierId === null) {
            return true;
        }

        // Check if client has at least one RFQ with this supplier that was replied or accepted
        return RFQ::where('client_id', $user->id)
            ->where('supplier_id', $supplierId)
            ->whereIn('status', ['replied', 'accepted'])
            ->exists();
    }

    /**
     * Determine if the user can update the review.
     */
    public function update(User $user, Review $review): bool
    {
        return $user->id === $review->client_id && !$review->is_approved;
    }

    /**
     * Determine if the user can delete the review.
     */
    public function delete(User $user, Review $review): bool
    {
        return $user->id === $review->client_id && !$review->is_approved;
    }
}

