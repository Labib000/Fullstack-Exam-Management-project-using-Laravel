<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    public function index(Request $request) {
        $status = $request->query('status', 'approved');
        $students = Student::where('status', $status)->get();
    
        return response()->json([
            'status' => 200,
            'students' => $students,
        ]);
       
    }
    public function store(Request $request)
    {
       
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|unique:students,email',
            'password'          =>'required|string|max:20',
            'phone'             => 'required|string|max:20',
            'alt_phone'         => 'nullable|string|max:20',
            'whatsapp'          => 'nullable|string|max:20',
            'dob'               => 'nullable|date',
            'birth_place'       => 'nullable|string|max:255',
            'region'            => 'nullable|string|max:255',
            'caste'             => 'nullable|string|max:255',
            'blood_group'       => 'nullable|string|max:3',
            'identity_details'  => 'nullable|string|max:500',
            'current_address'   => 'nullable|string|max:500',
            'permanent_address' => 'nullable|string|max:500',
            'qualification'     => 'nullable|string|max:255',
            'passing_year'      => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
            'percentage'        => 'nullable|numeric|min:0|max:100',
            'institution'       => 'nullable|string|max:255',
        ]);
        

      
     $data = Student::create($request->all());
     $data["password"] = bcrypt($data["password"]);

     $token = $data->createToken("MyApp")->plainTextToken;
              
           if($data){
               
             return response()->json([
                'status' => 200,
                'result' => [
                    'token' => $token,
                    'name' => $data->name,
                    'email' => $data->email
                ],
                'message' => 'Student registered successfully!',
            ], 200);
        }else{
            
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
            ], 500);
        }

       
       
    }

    public function show($id){
        $student = Student::find($id);
        if($student){
            return response()->json([
                'status' => 200,
                'message' => $student,
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No student found',
            ], 404);
        }
}

   public function update(Request $request, $id){
    $validated = $request->validate([
        'name'              => 'required|string|max:255',
        'email'             => 'required|email|max:50',
        'password'          => 'required|string|max:20',
        'phone'             => 'nullable|string|max:20',
        'alt_phone'         => 'nullable|string|max:20',
        'whatsapp'          => 'nullable|string|max:20',
        'dob'               => 'nullable|date',
        'birth_place'       => 'nullable|string|max:255',
        'region'            => 'nullable|string|max:255',
        'caste'             => 'nullable|string|max:255',
        'blood_group'       => 'nullable|string|max:3',
        'identity_details'  => 'nullable|string|max:500',
        'current_address'   => 'nullable|string|max:500',
        'permanent_address' => 'nullable|string|max:500',
        'qualification'     => 'nullable|string|max:255',
        'passing_year'      => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
        'percentage'        => 'nullable|numeric|min:0|max:100',
        'institution'       => 'nullable|string|max:255',
        'status'            =>'nullable|string|max:10'
    ]);

  $data = Student::find($id);

          
       if($data){
        $data->update($request->all());
           
         return response()->json([
            'status' => 200,
            'message' => 'Student updated successfully!',
        ], 200);
    }else{
        
        return response()->json([
            'status' => 404,
            'message' => 'No such student found',
        ], 404);
    }
   }

   public function destroy($id){
     $student =   Student::find($id);
     if($student){
        $student->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Student Deleted Successfully',
        ], 200);
     }else{
        return response()->json([
            'status' => 404,
            'message' => 'No such student found',
        ], 404);
     }
   }

   public function login(Request $request){
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string'
    ]);

    try {
      

        $user = Student::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['result' => 'User not found', 'success' => false], 401);
        }

        if ($request->password !== $user->password) {
            return response()->json(['result' => 'Invalid password', 'success' => false], 401);
        }
        

        $token = $user->createToken('MyApp')->plainTextToken;
       
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

   public function stdlogout(Request $request)
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
    