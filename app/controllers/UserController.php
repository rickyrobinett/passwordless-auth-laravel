<?php

class UserController extends BaseController {
  function validate()
  {
    $phoneNum = Input::get('phone_num');

    $user = User::where('phone_number', '=', $phoneNum)->firstOrFail();

    if($user)
    {
      Session::put('phoneNum', $phoneNum);
      $user->sendToken();
      return Response::json(array('success' => true));
    } else
    {
      return Response::json(array('success' => false));
    }

  }

  function auth()
  {
    $token = Input::get('token');
    $phoneNum = Session::get('phoneNum');

    $user = User::where('phone_number', '=', $phoneNum)->firstOrFail();
    if($user && $user->validateToken($token)) {
      return Response::json(array('success' => true));
    } else {
      return Response::json(array('success' => false));
    }
  }
}
