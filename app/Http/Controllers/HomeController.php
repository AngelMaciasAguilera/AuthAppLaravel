<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role == 'admin' || $user->role == 'superadmin') {
            $enumValues = DB::select("SHOW COLUMNS FROM users WHERE Field = 'role'");
            $typeEnumValues = $enumValues[0]->Type;
            preg_match_all("/'([^']+)'/", $typeEnumValues, $matches);
            $enumValuesArray = $matches[1];
            if($user->role == 'superadmin'){
                $users = User::where('id', '!=', 1) -> orderBy('created_at','desc') -> get() ;
            }else{
                $users = User::where('id', '!=', 1) -> where('role','!=', 'admin') -> orderBy('created_at','desc') ->get();
            }
            return view('admin.adminPanel', ['actualuser' => $user,'users' => $users, 'roles' => $enumValuesArray]);
        } else {
            return view('home', ['user' => $user]);
        }
    }
}
