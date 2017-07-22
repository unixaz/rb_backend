<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class RestController extends Controller
{
    public function postUser(Request $request)
    {
        $json_data = $request->json()->all();
        $error_arr = array();

        if (empty($json_data['name']))
        {
            $error_arr['messages'][] = 'Username can\'t be empty';
            $error_arr['respStatus'] = 'error';
        }
        if (empty($json_data['password']))
        {
            $error_arr['messages'][] = 'Password can\'t be empty';
            $error_arr['respStatus'] = 'error';
        }
        if (empty($json_data['repeatPassword']))
        {
            $error_arr['messages'][] = 'Repeat password can\'t be empty';
            $error_arr['respStatus'] = 'error';
        }
        if ($json_data['password'] != $json_data['repeatPassword'])
        {
            $error_arr['messages'][] = 'Passwords doesn\'t match';
            $error_arr['respStatus'] = 'error';
        }
        if (empty($error_arr))
        {
            $user = new User;

            $user->name = $json_data['name'];
            $user->email = str_random(20);
            $user->password = $json_data['password'];
            $user->remember_token = '';
            $user->save();

            $error_arr['messages'][] = 'User created';
            $error_arr['respStatus'] = 'ok';

        }

        return response()->json($error_arr);
    }

    public function getAllUsers()
    {
        return User::all();
    }
}
