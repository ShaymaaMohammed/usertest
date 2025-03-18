<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    use ValidatesRequests;

    //public function __construct()
    //     {$this->middleware('auth:web')->except('list'); }
     
   
    
 public function list(Request $request) {

        $users = User::all();
        $query = User::select("users.*");
        $query->when($request->name, fn($q)=> $q->where("name" , "like", "%$request->name%"));
        $query->when($request->id, fn($q)=> $q->where("id" ,  "$request->id"));
        $users = $query->get();
     
            return view("users.list", compact('users'));
        }

    public function new(Request $request, User $user) {
        $user = $user??new User();
            return view("users.new", compact('user'));
        }

    public function save(Request $request, user $user = null) {
        $user = $user??new User();
        $user->fill($request->all());
        $user->save();
            return redirect()->route('users_list');
        }

    public function delete(Request $request, User $user) {

        
        if (User::findOrFail(Auth::id())->hasPermissionTo('delete_users')) {
            
        }
            $user->delete();
            return redirect()->route('users_list');
        }
      
  

    public function edit(Request $request, User $user) {
           
        if(!auth::check()) 
           return redirect()->route('login');
    
    
        $user = $user??new User(); 
            return view('users.edit', compact('user')); 
        }

    public function update(Request $request, User $user) {
        $user = $user??new User(); 
      
            
        $user->update($request->all());
        
            return redirect()->route('users_list');
        }

        public function register(Request $request) {
            return view('users.register');
        }


        public function doRegister(Request $request) {

            try {
                $this->validate($request, [
                'name' => ['required', 'string', 'min:5'],
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
                ]);
            }
            catch(\Exception $e) {
    
                return redirect()->back()->withInput($request->input())->withErrors('Invalid registration information.');
            }
    
            
            $user =  new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password); 
            $user->save();
    
            return redirect('/');
        }


        public function login(Request $request) {
            return view('users.login');
        }

        public function doLogin(Request $request) {
            
    	
                if(!Auth::attempt(['email' => $request->email, 'password' => $request->password]))
                    return redirect()->back()->withInput($request->input())->withErrors('Invalid login information.');
        
                $user = User::where('email', $request->email)->first();
                Auth::setUser($user);
        
                return redirect('/');
            }
           
        

            public function doLogout(Request $request) {
    	
                Auth::logout();
        
                return redirect('/');
            }

            public function admin_edit(Request $request, User $user = null) {
                $user = $user ?? Auth::user();

                if ($user->id !== Auth::id() && !User::findOrFail(Auth::id())->hasPermissionTo('edit_user')) {
                    abort(401);
                }
                return view('users.admin_edit', compact('user'));
             }

            public function profile() {
                $user = $user ?? Auth::user();

                if ($user->id !== Auth::id() && !User::findOrFail(Auth::id())->hasPermissionTo('edit_user')) {
                    abort(401);
                }

                $permissions = [];
                foreach($user->permissions as $permission) {
                    $permissions[] = $permission;
                }

                $roles = [];
                foreach($user->roles as $role) {
                    $roles[] = $role;
                }
                
                
        
                return view('users.profile', compact('user', 'permissions','roles'));
            }

   
    public function admin_save(Request $request, User $user) {
        
        //dd(Auth::user());
        //dd(Auth::guard('web')->user());
        $user = $user ?? Auth::user();

        if ($user->id !== Auth::id() && !User::findOrFail(Auth::id())->hasPermissionTo('edit_user')) {
            abort(401);
        }

        User::findOrFail(Auth::user()->id)->update([
            'name' =>$request->name,
        ]);

        if (User::findOrFail(Auth::id())->user()->hasPermissionTo('edit_user') && $user->id !== Auth::id()) {

            //$user->syncRoles($request->roles);
            //$user->syncPermissions($request->permissions);
        
            Artisan::call('cache:clear');
        }

        return redirect(route('profile', ['user'=>$user->id]));
    }

    public function updatePassword(Request $request)
    {
        

        $this->validate($request, [
            'current_password' => ['required'],
            'new_password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
            ]);



            $currentPasswordStatus = Hash::check($request->current_password, Auth::user()->password);
            if($currentPasswordStatus){
                
            

                User::where('id', Auth::id())->update([
                    'password' => bcrypt($request->password),
                ]);

                /*$user1=Auth::user();
                $user1->update([
                    'password' =>bcrypt($request->password),
                ]);*/



    
                return redirect()->back()->with('message','Password Updated Successfully');
    
            }else{
    
                return redirect()->back()->with('message','Current Password does not match with Old Password');
            }
        }

        public function personal_information(Request $request, User $user = null) {
            $user = $user ?? Auth::user();

            if ($user->id !== Auth::id() && !User::findOrFail(Auth::id())->hasPermissionTo('personal_information')) {
                abort(401);
            }
            return view('users.personal_information', compact('user'));
         }

         public function information_save(Request $request, user $user = null) {
            $data = $request->only(['name', 'email']);

            $authUser = Auth::user();
        
            //user
            if (($authUser->id === $user->id && $authUser->hasPermissionTo('edit_general_info')) || 
                 $authUser->hasRole('Employee')) {
                 $user->update($data);
                
            } else {
                abort(403, 'Unauthorized');
            }
                return redirect()->route('users_list');
            }
      
    }
    
    
     
   

   
