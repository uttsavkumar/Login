<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $req)
    {
        if ($req->method() == "POST") {

            $req->validate([
                'name' => 'required',
                'email' => 'email|required',
                'password' => 'min:8|required'
            ]);
            $email = User::where('email', $req->email)->first();
            if ($email) {
         
            return response([
                'message' => 'Email already exist',
            ],404);

            } else {
                $user = new User();
                $user->name = $req->name;
                $user->email = $req->email;
                $user->password = Hash::make($req->password);
                $new = $user->save();
      

                if($new){
                    // return response([
                    //     'message' => 'User Create Succesfully',
                    //     'name' => $req->name,
                        
                    // ],200);
                    return redirect()->route('login')->with(
                        'email',
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close float-end"  data-bs-dismiss="alert" aria-label="Close"></button>
                        User registered <strong>Successfully!</strong>
                    </div>'
                    );
                }
                else{
                    return response([
                        'message' => 'Something Went wrong',
                    
                    ],404);
                }
            }
        }
        return view('Auth.register');
    }

    public function login(Request $req)
    {
        if ($req->method() == "POST") {
            $user = User::where('email', $req->email)->first();
            if ($user) {
                $check = Hash::check($req->password, $user->password);
                if ($check) {
                  
                    // $token = $user->createToken('helloatg')->plainTextToken;
                    // return response([
                    //     'user' => $user,
                    //     'token' => $token
                    // ],200);
                    $req->session()->put('user',$user);
                    return redirect()->route('dashboard');
                } else {
                    return response([
                        'message' => 'Incorrect Password',   
                    ],404);
                }
            } 
            else {
                return response([
                    'message' => 'User Doesn"t exists',
                    'name' => $req->email,       
                ],404);
            }
        }
        return view('Auth.login');
    }
    public function dashboard(Request $req){
        return view('Auth.darshboard');
    }

    public function getData(Request $req){
        $id = $req->session()->get('user')->id;
         $t = Task::where('user_id',$id)->get();
        return response()->json([
            'tasks' => $t,
        ]);
    }
    
    public function logout(Request $req){
        $req->session()->forget('user');
        return redirect()->route('login');
    }
}
