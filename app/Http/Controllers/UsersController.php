<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:users,email',
            'name' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'role' => 'string|max:255'
        ]);

        if ($request->has('role')) {
            $role = $request->role;
        } else {
            $role = 'user';
        }

        if ($validator->passes()) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $role,
                'email_verified_at' => Carbon::now()
            ]);
            return redirect()->route('home')->with(['message' => 'usuario creado correctamente']);
        } else {
            return back()->withErrors(['message' => $validator->errors()->first()])->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'name' => 'string|max:255',
            'password' => 'string|max:255',
            'role' => 'string|max:255',
        ]);

        if ($validator->passes()) {
            if ($request->has('password')) {
                if($request->password != $user->password){
                    $request->merge([
                        'password' => Hash::make($request->password),
                    ]);
                }
            }

            if ($request->has('email_verified_at')) {
                $request->merge([
                    'email_verified_at' => Carbon::now(),
                ]);
            }

            if ($request->email != $user->email) {
                if (!is_null($user->email_verified_at)) {
                    $user->email_verified_at = null;
                }
            }


            $result = $user->update($request->all());
            if($result == true){
                return redirect()->route('home')->with(['message' => 'The user has been updated properly']);
            }else{
                return back()->withErrors(['message' => 'The user coudnt be updated'])->withInput();
            }
        } else {
            return back()->withErrors(['message' => $validator->errors()->first()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('home')->with(['message' => 'usuario eliminado correctamente']);
    }
}
