<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class authController extends Controller
{
    public function adminIndex()
{
    try {
        $admins = User::all();

        if ($admins->isEmpty()) {
            return response()->json(['message' => 'No admins found'], 404);
        }

        return response()->json(['admins' => $admins]);
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string'
    ]);

    try {
      

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['result' => 'User not found', 'success' => false], 401);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['result' => 'Invalid password', 'success' => false], 401);
        }

        $token = $user->createToken("MyApp")->plainTextToken;
        

        return response()->json([
            'success' => true,
            'result' => [
                'token' => $token,
                'name' => $user->name,
                'email' => $user->email
            ],
            'msg' => 'User login successfully'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'msg' => 'Login error',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function signUp(Request $request)
    {
        try {
            $input = $request->all();
            $input["password"] = bcrypt($input["password"]);
            $user = User::create($input);
    
            $token = $user->createToken("MyApp")->plainTextToken;
    
            return response()->json([
                'success' => true,
                'result' => [
                    'token' => $token,
                    'name' => $user->name,
                    'email' => $user->email
                ],
                'msg' => 'User registered successfully'
            ]);
    
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => 'Signup error', 'error' => $e->getMessage()], 500);
        }
    }
    public function signOut(Request $request)
    {
        // Log::info('Api hit');
        try {
            $token = $request->user()->currentAccessToken();
            // Log::info('Examiner login process started.',$token);
            if (!$token) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token not found. Are you sending the Bearer token?',
                ], 401);
            }
    
            $token->delete();

            
    
            return response()->json([
                'success' => true,
                'msg' => 'Token deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Exception occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    }

