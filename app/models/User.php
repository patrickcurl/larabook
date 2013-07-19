<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

//class User extends Eloquent implements UserInterface, RemindableInterface {
class User extends VerifyUser {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

//Verify	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
//Verify	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
//Verify	public function getAuthIdentifier()
//Verify	{
//Verify		return $this->getKey();
//Verify	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
//Verify	public function getAuthPassword()
//Verify	{
//Verify		return $this->password;
//Verify	}

/*	public static function validate($input){

		$rules = array(
							#validation rules.

							"email" => "Required|Between:3,255|Email|unique:users,email,{Auth::user()->id}",
							"password" => "Required|Between:5,25|Confirmed",
							"password_confirmation" => "Required|Between:5,25"
			);

		return Validator::make($input, $rules);

	}
*/
	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
//Verify	public function getReminderEmail()
//Verify	{
//Verify		return $this->email;
//Verify	}

}