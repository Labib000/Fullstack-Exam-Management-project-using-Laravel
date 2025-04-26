<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\Student;
use App\Models\Moderator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Get the authenticated user
        $user = $request->user();

        // If the user is not authenticated, return a 401 Unauthorized response
        if (!$user) {
            return response()->json(['error' => 'Unauthorized. No token provided.'], 401);
        }

        // Map roles to model types
        $roleModelMap = [
            'admin' => 'App\\Models\\User',
            'moderator' => 'App\\Models\\Moderator',
            'student' => 'App\\Models\\Student',
        ];

        // Ensure the role exists in our map
        if (!isset($roleModelMap[$role])) {
            return response()->json(['error' => 'Invalid role definition.'], 500);
        }

        // Check if the user has the correct model type (i.e., they belong to the correct model)
        if (!$user instanceof $roleModelMap[$role]) {
            return response()->json(['error' => 'Access denied. Insufficient permissions.'], 403);
        }

        $request->attributes->set('role', $role);

        // Allow the request to proceed
        return $next($request);
    }
}