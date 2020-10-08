<?php

namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
   
class SellerAuthController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('index','show', 'register', 'login', 'logout');
    }
    public function index()
    {
        $sellers = User::all()->where('role', 2);
        if($sellers->count() > 0){
            return $this->sendResponse($sellers, 'Retrieved successfully.');
        }
        $sellers = 'null';
        return $this->sendResponse($sellers, 'No registered seller yet.');
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
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        
        $input = $request->all();
        $input['role'] = 2; //Seller role identification
        $input['status'] = 1; //set user status to true on success
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['username'] =  $user->username;
        $success['role'] =  $user->role;
        $success['username'] =  $user->email;
   
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

            if($user->role == 2){
                $_SESSION['token'] =  $user->createToken('MyApp')-> accessToken;
                $_SESSION['username'] =  $user->username;
                $_SESSION['email'] =  $user->email;
                $_SESSION['role']  =  $user->role;
                $_SESSION['status'] =  $status;

                return $this->sendResponse($_SESSION, 'User login successfully.');
            }

            return $this->sendError('Unauthorised.', ['error'=>'Does not belong here. Ensure you are a registered Seller.']);
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }

    /**
    * Log the user out of the application.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
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

    public function show($sellers)
    {
        $seller = User::find($sellers);

        return $this->sendResponse($seller, ['Successful'=>'Retrieved succeccfully.']);

    }

    public function update(Request $request, $seller)
    {
        $result = User::find($seller);
        $input = $request->all();
        
        //Declared and initialized email_verified_at and role
        $email_verified_at = $result['email_verified_at'];
        $role = $result['role'];

        //Assigned User result to seller
        $seller = $result;
        $seller->username = $input['username'];
        $seller->fname = $input['fname'];
        $seller->lname = $input['lname'];
        $seller->email_verified_at = $email_verified_at;
        $seller->dob = $input['dob'];
        $seller->gender = $input['gender'];
        $seller->phone = $input['phone'];
        $seller->role = $role;
        $seller->userImg = $input['userImg'];
        $seller->isActive = $input['isActive'];
        $seller->status = $input['status'];
        $seller->email = $input['email'];
        $seller->password = bcrypt($input['password']);
        $seller->save();

        return $this->sendResponse($buyer, ['Successful'=>'Your information updated succeccfully.']);
    }

    public function activate($id)
    {
        $seller=User::find($id);
        $seller->isActive= 1;
        $seller->save();
    
        return $this->sendResponse($seller, ['Successful'=>'Succeccfully activated.']);
    }

    public function deactivate($id)
    {
            $seller=User::find($id);
            $seller->isActive= 0;
            $seller->save();

            return $this->sendResponse($seller, ['Successful'=>'Succeccfully deactivated.']);
    }

    
}