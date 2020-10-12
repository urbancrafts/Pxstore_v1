<?php

namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;
   
class RegisterController extends BaseController
{
    /**
    * Register api
    *
    * @return \Illuminate\Http\Response
    */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email',
            'dob' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'role' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
            
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $input = $request->all();
        if($input['role'] == 1){
        $input['role'] = 1; // Super Admin role identification
        }else if($input['role'] == 2){
        $input['role'] = 2; // Admin role identification
        }else if($input['role'] == 3){
        $input['role'] = 3; // Merchant role identification
        }
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['user_id'] =  $user->id;
        $success['username'] =  $user->username;
        $success['role'] =  $user->role;
        $success['username'] =  $user->email;

        Storage::makeDirectory('/userassets/' . $user->id);
        Storage::makeDirectory('/userassets/' . $user->id . "/store");
        Storage::makeDirectory('/userassets/' . $user->id . "/profile");
        
        return $this->sendResponse($success, 'User register successfully.');
    }
   
    /**
    * Login api
    *
    * @return \Illuminate\Http\Response
    */
    public function login(Request $request)
    {
        $this->validate($request, ['email' => 'required|email', 'password' => 'required|min:6']);
        
        $credential = ['email' => $request->email, 'password' => $request->password];

        if(Auth::attempt($credential)){ 
            $user = Auth::user(); 
            $status = User::where('email', $user->email)->update(['status' => 1]);
            
            if($user->role == 1 || $user->role == 2 || $user->role == 3){
                $_SESSION['token'] =  $user->createToken('MyApp')-> accessToken;
                $_SESSION['user_id'] =  $user->id;
                $_SESSION['username'] =  $user->username;
                $_SESSION['email'] =  $user->email;
                $_SESSION['role']  =  $user->role;
                $_SESSION['status'] =  $status;

                return $this->sendResponse($_SESSION, 'User login successfully.');
            }

            return $this->sendError('Unauthorised.', ['error'=>'Does not belong here. Ensure you are a registered Admin.']);
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }

    public function logout($request)
    {
        session_start();
        unset($_SESSION['user_id']);
        unset($_SESSION['token']);
        unset($_SESSION['username']);
        unset($_SESSION['email']);
        unset($_SESSION['status']);
        unset($_SESSION['role']);

        if(User::where('id', $request)->update(['status' => 0])){
            $status = 0;
        }
        $success['status'] = $status;

        return $this->sendResponse($success, 'successfully logged out.');
    }

    
}