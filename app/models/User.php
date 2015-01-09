<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

  protected $fillable = array('email', 'phone_number');

  public function sendToken()
  {
    $token = mt_rand(100000, 999999);
    Session::put('token', $token);

    $client = new Services_Twilio($_ENV['TWILIO_ACCOUNT_SID'], $_ENV['TWILIO_AUTH_TOKEN']);

    $sms = $client->account->messages->sendMessage(
      $_ENV['TWILIO_NUMBER'], // the text will be sent from your Twilio number
      $this->phone_number,
      "Your auth token is " . $token
    );
  }

  public function validateToken($token)
  {
    $validToken = Session::get('token');
    if($token == $validToken) {
      Session::forget('token');
      Auth::login($this);
      return true;
    } else {
      return false;
    }
  }
}
