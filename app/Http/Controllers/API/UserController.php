<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $this->authorize('isAdmin');
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            return User::latest()->paginate(10);
            
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $this->validate($request,[
           'name' => 'required|string|max:191',
           'email' => 'required|string|email|max:191|unique:users',
           'password' => 'required|string|min:6'

       ]);
        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'type' => $request['type'],
            'bio' => $request['bio'],
            'photo' => $request['photo'],
            'password' => Hash::make($request['password']),
        ]);
    }

    
    public function updateProfile(Request $request)
    {
        
        $user = auth('api')->user();

        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|required|min:6'
 
        ]);

        $currentPhoto = $user->photo;
       if($request->photo != $currentPhoto){
           $name = time().'.' .explode('/', explode(':', substr($request->photo, 0, strpos
           ($request->photo, ';')))[1])[1];

           \Image::make($request->photo)->save(public_path('img/profile/').$name);
           $request->merge(['photo' => $name]);

           //Condition for deleting old image if user update to new ones
           $userPhoto = public_path('img/profile/').$currentPhoto;
           if(file_exists($userPhoto)){
                @unlink($userPhoto);
           }
       }
       
           //To avoid error of bcrypt algorithm
           if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }

       //Request all will take the default image from the database and display
       $user->update($request->all());
       return ['message' => "Success"];
    }



    public function profile()
    {
        //return Auth::user(); without api
        return auth('api')->user();
        
    }
    


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|min:6'
 
        ]);

        $user->update($request->all());
        return ['message' => 'Update the user info'];

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');
       $user = User::findOrFail($id);
       //Delete user
       $user->delete();
       return ['message' => 'User Deleted'];
    }

    public function search(){
        if ($search = \Request::get('q')){
            $users = User::where(function($query) use ($search){
                $query->where('name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%")
                ->orWhere('type', 'LIKE', "%$search%")
                ->orWhere('created_at', 'LIKE', "%$search%");
            })->paginate(10);
        }else{
            return $user = User::latest()->paginate(10);
        }
        return $users;
    }
}
