<?php

namespace App\Http\Controllers\API;
   
use session;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Validator;  

class BuyerAuthController extends BaseController
{
    protected $guard = "api_buyer";

    public $success;

    public function __construct()
    {
        $this->middleware('auth:api')->except('login', 'logout', 'register');
    }
    public function index()
    {
        $buyers = User::all()->where('role', 4);
        if($buyers->count() > 0){
            return $this->sendResponse($buyers, 'Retrieved successfully.');
        }
        $buyers = 'null';
        return $this->sendResponse($buyers, 'No registered buyer yet.');
    }
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
            'country' => 'required',
            'c_code' => 'required',
            'curr' => 'required',
            'city' => 'required',
            'zip_code' => 'required',
            'address' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $input = $request->all();
        $input['role'] = 4; //Buyer role identification
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['user_id'] =  $user->id;
        $success['username'] =  $user->username;
        $success['role'] =  $user->role;
        $success['username'] =  $user->email;
        
        Storage::makeDirectory('/userassets/' . $user->id);
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

            if($user->role == 4){
                $_SESSION['token'] =  $user->createToken('MyApp')-> accessToken;
                $_SESSION['user_id'] =  $user->id;
                $_SESSION['username'] =  $user->username;
                $_SESSION['email'] =  $user->email;
                $_SESSION['role']  =  $user->role;
                $_SESSION['status'] =  $status;

                return $this->sendResponse($_SESSION, 'User login successfully.');
            }

            return $this->sendError('Unauthorised.', ['error'=>'Does not belong here. Ensure you are a registered buyer.']);
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }

    public function logout($request)
    {
        session_start();
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


    public function update(Request $request, $buyer)
    {
        $result = User::find($buyer);
        $input = $request->all();
        
        //Declared and initialized email_verified_at and role
        $email_verified_at = $result['email_verified_at'];
        $role = $result['role'];

        //Assigned User result to buyer
        $buyer = $result;
        $buyer->username = $input['username'];
        $buyer->fname = $input['fname'];
        $buyer->lname = $input['lname'];
        $buyer->email_verified_at = $email_verified_at;
        $buyer->dob = $input['dob'];
        $buyer->gender = $input['gender'];
        $buyer->phone = $input['phone'];
        $buyer->role = $role;
        $buyer->country = $input['country'];
        $buyer->code = $input['code'];
        $buyer->curr = $input['curr'];
        $buyer->userImg = $input['userImg'];
        $buyer->isActive = $input['isActive'];
        $buyer->status = $input['status'];
        $buyer->email = $input['email'];
        $buyer->password = bcrypt($input['password']);
        $buyer->save();

        return $this->sendResponse($buyer, ['Successful'=>'Your information updated succeccfully.']);
    }

    public function show($buyers)
    {
        $buyer = User::find($buyers);

        return $this->sendResponse($buyer, ['Successful'=>'Retrieved succeccfully.']);

    }

    public function activate($id){

        $buyer=User::find($id);
        $buyer->isActive= 1;
        $buyer->save();
        
        return $this->sendResponse($buyer, ['Successful'=>'Succeccfully activated.']);
     
    }

    public function deactivate($id){

            $buyer=User::find($id);
            $buyer->isActive= 0;
            $buyer->save();

            return $this->sendResponse($buyer, ['Successful'=>'Succeccfully deactivated.']);
        
    }


}