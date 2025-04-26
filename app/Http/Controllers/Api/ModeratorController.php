<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Moderator;
use Illuminate\Support\Facades\Hash;
use Exception;

class ModeratorController extends Controller
{
    public function index()
{
    try {
        $moderators = Moderator::all();

        if ($moderators->isEmpty()) {
            return response()->json(['message' => 'No moderators found'], 404);
        }

        return response()->json(['moderators' => $moderators]);
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
    public function store(Request $request)
{
    try {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:moderators,email',
            'password' => 'required|min:6',
            'phone' => 'nullable|string',
            'designation' => 'nullable|string',
        ]);

        $moderator = Moderator::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'designation' => $request->designation,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Moderator created successfully',
            'moderator' => $moderator
        ], 201);

    } catch (Exception $e) {
        return response()->json([
            'error' => $e->getMessage()
        ], 500);
    }
}

public function login(Request $request)
{
    try {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $moderator = Moderator::where('email', $request->email)->first();

        if (!$moderator) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Check if the password is correct
        if (!Hash::check($request->password, $moderator->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $token = $moderator->createToken('moderator_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'token' => $token,
            'moderator' => $moderator
        ]);
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
public function logout(Request $request)
{
    try {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
public function show($id)
{
    try {
        $moderator = Moderator::find($id);

        if (!$moderator) {
            return response()->json(['error' => 'Moderator not found'], 404);
        }

        return response()->json(['moderator' => $moderator]);
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function update(Request $request, $id)
{
    try {
        $request->validate([
            'name' => 'string|nullable',
            'phone' => 'string|nullable',
            'designation' => 'string|nullable',
            // 'role' => 'string|nullable',
            'password' => 'nullable|min:6' // allow optional password change
        ]);

        $moderator = Moderator::find($id);

        if (!$moderator) {
            return response()->json(['error' => 'Moderator not found'], 404);
        }

        // Update basic fields
        $moderator->fill($request->only('name', 'phone', 'designation'));

        // Update password if provided
        if ($request->filled('password')) {
            $moderator->password = Hash::make($request->password);
        }

        $moderator->save();

        return response()->json([
            'message' => 'Moderator updated successfully',
            'moderator' => $moderator
        ]);
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
public function destroy($id)
{
    try {
        $moderator = Moderator::find($id);

        if (!$moderator) {
            return response()->json(['error' => 'Moderator not found'], 404);
        }

        $moderator->delete();

        return response()->json(['message' => 'Moderator deleted successfully'], 200);
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


}
