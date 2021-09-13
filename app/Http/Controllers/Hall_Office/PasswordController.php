<?php

namespace App\Http\Controllers\Hall_Office;

use App\Http\Controllers\Controller;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PasswordController extends Controller
{
    public function index()
    {
        return view( "hall_office.change_password" );
    }

    public function update( Request $request )
    {
        $inputs = $request->except( '_token' );
        $rules = [
            'old_password' => 'required',
            'password'     => 'required | confirmed',
        ];

        $validator = Validator::make( $inputs, $rules );

        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        }

        $hashedPassword = Auth::user()->password;
        if ( Hash::check( $request->old_password, $hashedPassword ) ) {
            if ( !Hash::check( $request->password, $hashedPassword ) ) {

                $user = User::find( Auth::id() );
                $user->password = Hash::make( $request->password );
                $user->save();

                Toastr::success( 'Password Successfully Changed!', 'Success' );
                Auth::logout();

                return redirect()->back();

            } else {
                Toastr::error( 'New password cant be same as old password', 'Error' );

                return redirect()->back();
            }

        } else {
            Toastr::error( 'Current Password not Match!', 'Error' );

            return redirect()->back();
        }
    }
}
