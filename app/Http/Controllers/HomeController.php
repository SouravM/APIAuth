<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use League\Flysystem\Exception;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\User;
use Dingo\Api\Contract\Http\Request;


class HomeController extends Controller
{
    //

    public function create(array $data)
    {

            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'dob' => $data['dob'],
                'fb_profile_link' => $data['fb_profile_link'],
                'password' => bcrypt($data['password']),
            ]);


    }

    public function register(Request $request)
    {


        try{

            $user = DB::table('users')->where('email',$request->input('email'))->value('id');
            if($user === null) {


                $name = $request->input('name');
                $email = $request->input('email');
                $phone = $request->input('phone');
                $dob = $request->input('dob');
                $fb_profile_link = $request->input('fb_profile_link');
                $password = $request->input('password');
                $input = array(
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'dob' => $dob,
                    'fb_profile_link' => $fb_profile_link,
                    'password' => $password
                );

                HomeController::create($input);
                $id = DB::table('users')->where('email', $email)->value('id');
                $full_name = DB::table('users')->where('email', $email)->value('name');
                return response()->json([
                    'status' => 'User registered successfully',
                    'id' => $id,
                    'full_name' => $full_name
                ]);
            }
            else
            {
                return response()->json([
                    'status' => 'Email already exists',

                ]);
            }

            }
            catch(Exception $ex)
            {
                return response()->json([
                    'status' => $ex
                ]);
            }
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $name = DB::table('users')->where('email', $email)->value('name');

        if($name === null){
            return response()->json([
                'status' => 'User does not exist!'
            ]);
        }
        else
        {
            $password_ext = DB::table('users')->where('email',$email)->value('password');
            if(Hash::check($password, $password_ext))
            {
                return response()->json([
                    'status' => 'Logged in successfully',
                    'full name' => $name
                ]);
            }
            else
            {
                return response()->json([
                    'status' => 'Password mismatch.',
                ]);
            }

        }

    }


}
