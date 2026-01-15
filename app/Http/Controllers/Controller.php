<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

/**
 * Base controller with simple authentication helpers to avoid
 * accidentally exposing sensitive operations.
 */

class Controller extends BaseController
{
    protected function middleware()
    {
        // Placeholder
    }

    /**
     * Ensure a user is logged in.
     */
    protected function requireAuth(): void
    {
        if (!Auth::check()) {
            abort(401, 'Unauthorized');
        }
    }

    /**
     * Ensure the current user has administrator privileges.
     */
    protected function requireAdmin(): void
    {
        $this->requireAuth();
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Forbidden');
        }
    }
}
