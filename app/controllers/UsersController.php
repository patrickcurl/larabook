<?php
class UsersController extends BaseController {
	protected $layout = 'layouts.master';


	public function getShow($id)
	{
		if (Sentry::check()){
			try
			{
			  //Get the current user's id.
				Sentry::check();
				$currentUser = Sentry::getUser();

			   	//Do they have admin access?

				if ( $currentUser->hasAccess('admin') || $currentUser->getId() == $id)
				{
					//Either they are an admin, or:
					//They are not an admin, but they are viewing their own profile.
					$data['user'] = Sentry::getUserProvider()->findById($id);
					$data['myGroups'] = $data['user']->getGroups();
					return View::make('users.show')->with($data);
				} else {
					Session::flash('error', 'You don\'t have access to that user.');
					return Redirect::to("/users/show/{$currentUser->getId()}");
					//return View::make('users.login');
				}
			}
			catch (Cartalyst\Sentry\UserNotFoundException $e)
			{
			    Session::flash('error', 'There was a problem accessing your account.');
				// return Redirect::to('/');
					return View::make('users.login');
			}
		} else {
			Session::flash('error', 'User not logged in, please login and try again.');

					return View::make('users.login');
		}

	}

	public function postLogin(){
		$email = Input::get('email');
		$password = Input::get('password');
		$input = array('email' => $email, 'password' => $password);
		$rules = array(
			#validation rules.
			 	"email" => "Required|Between:3,255|Email",
				"password" => "Required|Between:5,25"
				);

		$messages = array();
		 $v = Validator::make($input, $rules, $messages);
		if ($v->fails()){
			return Redirect::to('users/login')->withErrors($v)->withInput();
		} else {

			try {

			$user = Sentry::authenticate($input, false);
			if ($user){
				return Redirect::back()->with('success', 'You have logged in successfully.');
			}
		} catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
{
		return Redirect::to('users/register')->with('message', 'Login field is required.');
    //return 'Login field is required.';
}
catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
{
		return Redirect::to('users/register')->with('error', 'Password field is required.');
    //return 'Password field is required.';
}
catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
{
		return Redirect::to('users/register')->with('error', 'Wrong password, try again.');
    //return 'Wrong password, try again.';
}
catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
{
		return Redirect::to('users/register')->with('error', 'User was not found.');
    //return 'User was not found.';
}
catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
{
		return Redirect::to('users/register')->with('error', 'User is not activated.');
    //return 'User is not activated.';
}

// The following is only required if throttle is enabled
catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
{
		return Redirect::to('users/register')->with('error', 'User is suspended.');
    //return 'User is suspended.';
}
catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
{
		return Redirect::to('users/register')->with('error', 'User is banned.');
    //return 'User is banned.';
}
		}




	}

	public function postRegister(){
		$first_name = Input::get('first_name');
		$last_name = Input::get('last_name');
		$email = Input::get('email');
		$password = Input::get('password');
		$password_confirmation = Input::get('password_confirmation');
		$phone = Input::get('phone');
		$address = Input::get('address');
		$city = Input::get('city');
		$state = Input::get('state');
		$zip = Input::get('zip');
		$payment_method = Input::get('payment_method');
		$paypal_email = Input::get('paypal_email');
		$name_on_cheque = Input::get('name_on_cheque');

		$input = array(
				'first_name' => $first_name,
				'last_name' => $last_name,
				'email' => $email,
				'password' => $password,
				'password_confirmation' => $password_confirmation,
				'phone' => $phone,
				'address' => $address,
				'city' => $city,
				'state' => $state,
				'zip' => $zip,
				'payment_method' => $payment_method,
				'paypal_email' => $paypal_email,
				'name_on_cheque' => $name_on_cheque
			);
		$rules = array(
			#validation rules.
			  "first_name" => "Required",
			  "last_name" => "Required",
				"email" => "Required|Between:3,255|Email|unique:users,email",
				"password" => "Required|Between:5,25|Confirmed",
				"password_confirmation" => "Required|Between:5,25",
				"phone" => "Required|Between:10,20",
				"address" => "Required",
				"city" => "Required",
				"state" => "Required",
				"zip" => "Required"
				);

		$messages = array(
				'first_name.required' => 'First name is required.',
				'last_name.required' => 'Last name is required.',
				'password.between' => 'Password must be 5-25 chars.',
				'password.confirmed' => 'Passwords do not match.',
				'password_confirmation.between' => 'Password must be 5-25 chars.',
				'email.unique' => 'Email taken, try again.',
				'email.between' => 'Email must be 3-255 chars.',
				'phone.between' => 'Phone must be 10-20 chars.',
				'phone.required' => 'Phone is required.',
				'address.required' => 'Address is required.',
				'city.required' => 'City is required.',
				'state.required' => 'State is required.',
				'zip.required' => 'Zip is required.'
				);

		$v = Validator::make($input, $rules, $messages);

			if ($v->fails()){

				return Redirect::to('users/register')->withErrors($v)->withInput();
			} else {
				try {
					$user = Sentry::register(array(
							'first_name' => $first_name,
							'last_name' => $last_name,
							'email' => $email,
							'password' => $password,
							'phone' => $phone,
							'address' => $address,
							'city' => $city,
							'state' => $state,
							'zip' => $zip,
							'payment_method' => $payment_method,
							'paypal_email' => $paypal_email,
							'name_on_cheque' => $name_on_cheque
						), true);
						$customerGroup = Sentry::getGroupProvider()->findByName('customers');
						$user->addGroup($customerGroup);
					$data['email'] = $email;

					// Send Welcome Email

					Mail::send('emails.auth.welcome', $data, function($m) use($data){
						$m->to($data['email'])->subject('Welcome to TopBookPrices.com');

					});

					//Success!

					Session::flash('success', 'Your account has been created.');
					Sentry::loginAndRemember($user);
					return Redirect::to('/');
				}
				catch (Cartalyst\Sentry\Users\LoginRequiredException $e){
					Session::flash('error', 'Email is required.');
					return Redirect::to('/users/register')->withErrors($v)->withInput();
				}
				catch (Cartalyst\Sentry\Users\UserExistsException $e){
					Session::flash('error', 'User already exists.');
					return Redirect::to('users/register')->withErrors($v)->withInput();
				}
			}
	}
	public function getRegister(){
		return View::make('users.login');
	}
	public function getLogin(){
		return View::make('users.login');
	}


	public function getLogout(){
		Sentry::logout();
		return Redirect::to('/')->with('message', 'Successfully Logged Out');
	}

public function getEdit($id=0){
	if($id==0){
		$currentUser = Sentry::getUser();
		if ($currentUser){
			return Redirect::to("/users/edit/{$currentUser->getId()}");
		} else {
			Session::flash('error', 'You must be logged in to access this area.');
			return Redirect::to('users/login');
		}
	} else {
		if (Sentry::check())
		{
			try
			{
			    //Get the current user's id.

				$currentUser = Sentry::getUser();

			   	//Do they have admin access?
				if ( $currentUser->hasAccess('admin'))
				{
					$data['user'] = Sentry::getUserProvider()->findById($id);
					$data['userGroups'] = $data['user']->getGroups();
					$data['allGroups'] = Sentry::getGroupProvider()->findAll();
					return View::make('users.edit')->with($data);
				}
				elseif ($currentUser->getId() == $id)
				{
					//They are not an admin, but they are viewing their own profile.
					$data['user'] = Sentry::getUserProvider()->findById($id);
					$data['userGroups'] = $data['user']->getGroups();
					return View::make('users.edit')->with($data);
				} else {
					Session::flash('error', 'You don\'t have access to that user.');
					return Redirect::to("/users/edit/{$currentUser->getId()}");
				}

			}
			catch (Cartalyst\Sentry\UserNotFoundException $e)
			{
			    Session::flash('error', 'There was a problem accessing your account.');
				return Redirect::to('/');
			}
		}	else {
				Session::flash('error', 'You must be logged in to access this area.');
			return Redirect::to('users/login');
		}
	}
	}

public function postEdit($id, $type="profile") {
		// Gather Sanitized Input
		$input = array(
				'first_name' => Input::get('first_name'),
				'last_name' => Input::get('last_name'),
				'email' => Input::get('email'),
				'phone' => Input::get('phone'),
				'address' => Input::get('address'),
				'city' => Input::get('city'),
				'state' => Input::get('state'),
				'zip' => Input::get('zip'),
				'payment_method' => Input::get('payment_method'),
				'paypal_email' => Input::get('paypal_email'),
				'name_on_cheque' => Input::get('name_on_cheque'),
				'oldPassword' => Input::get('oldPassword'),
				'password' => Input::get('password'),
				'password_confirmation' => Input::get('password_confirmation')
				);


		if($type=="profile"){


			// Set Validation Rules
			$rules = array (
				"first_name" => "alpha",
				"last_name" => "alpha",
				"email" => "Required|Between:3,255|Email|unique:users,email,{$id}",

				);

			//Run input validation
			$v = Validator::make($input, $rules);

			if ($v->fails())
			{
				// Validation has failed
				return Redirect::to('users/edit/' . $id)->withErrors($v)->withInput();
			}
			else
			{
				try
				{
					//Get the current user's id.
					Sentry::check();
					$currentUser = Sentry::getUser();

				   	//Do they have admin access?
					if ( $currentUser->hasAccess('admin')  || $currentUser->getId() == $id)
					{
						// Either they are an admin, or they are changing their own password.
						// Find the user using the user id
						$user = Sentry::getUserProvider()->findById($id);

					    // Update the user details
					    $user->first_name = $input['first_name'];
					    $user->last_name = $input['last_name'];

					    // Update the user
					    if ($user->save())
					    {
					        // User information was updated
					        Session::flash('success', 'Profile updated.');
							return Redirect::to('users/show/'. $id);
					    }
					    else
					    {
					        // User information was not updated
					        Session::flash('error', 'Profile could not be updated.');
							return Redirect::to('users/edit/' . $id);
					    }

					} else {
						Session::flash('error', 'You don\'t have access to that user.');
						return Redirect::to('/');
					}
				}
				catch (Cartalyst\Sentry\Users\UserExistsException $e)
				{
				    Session::flash('error', 'User already exists.');
					return Redirect::to('users/edit/' . $id);
				}
				catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
				{
				    Session::flash('error', 'User was not found.');
					return Redirect::to('users/edit/' . $id);
				}
			}
		}

		if($type == "payment"){
			try
				{
					//Get the current user's id.
					Sentry::check();
					$currentUser = Sentry::getUser();

				   	//Do they have admin access?
					if ( $currentUser->hasAccess('admin')  || $currentUser->getId() == $id)
					{
						// Either they are an admin, or they are changing their own password.
						// Find the user using the user id
						$user = Sentry::getUserProvider()->findById($id);

					    // Update the user details
					    $user->payment_method = $input['payment_method'];
					    $user->paypal_email = $input['paypal_email'];
					    $user->name_on_cheque = $input['name_on_cheque'];

					    // Update the user
					    if ($user->save())
					    {
					        // User information was updated
					        Session::flash('success', 'Profile updated.');
							return Redirect::to('users/show/'. $id);
					    }
					    else
					    {
					        // User information was not updated
					        Session::flash('error', 'Profile could not be updated.');
							return Redirect::to('users/edit/' . $id);
					    }

					} else {
						Session::flash('error', 'You don\'t have access to that user.');
						return Redirect::to('/');
					}
				}
				catch (Cartalyst\Sentry\Users\UserExistsException $e)
				{
				    Session::flash('error', 'User already exists.');
					return Redirect::to('users/edit/' . $id);
				}
				catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
				{
				    Session::flash('error', 'User was not found.');
					return Redirect::to('users/edit/' . $id);
				}

		}

				if($type=="password"){
					$rules = array (
						'password' => 'different:oldPassword,confirmed'
					);

					//Run input validation
					$v = Validator::make($input, $rules);

					if ($v->fails())
					{
						// Validation has failed
						return Redirect::to('users/edit/' . $id)->withErrors($v)->withInput();
					}		else
					{
						try
							{
								//Get the current user's id.
								Sentry::check();
								$currentUser = Sentry::getUser();

								//Do they have admin access?
								if ( $currentUser->hasAccess('admin')  || $currentUser->getId() == $id)
								{
									// Either they are an admin, or they are changing their own password.
									// Find the user using the user id
									$user = Sentry::getUserProvider()->findById($id);
									// Update the user details
										if($user->checkPassword($input['oldPassword'])){
											if($input['password'] == $input['password_confirmation']){
												$user->password = $input['password'];
												if ($user->save())
												{
													// User information was updated
													Session::flash('success', 'Profile updated.');
													return Redirect::to('users/show/'. $id);
												}
												else
												{
													// User information was not updated
													Session::flash('error', 'Profile could not be updated.');
													return Redirect::to('users/edit/' . $id);
												}
											} else {
												Session::flash('error', "Password and Password confirmation do not match!");
												return Redirect::to('users/edit/' . $id);
											}
										} else {
											Session::flash('error', "Old password does not match current password.");
											return Redirect::to('users/edit/' . $id);
										}
											// Update the user


									} else {
										Session::flash('error', 'You don\'t have access to that user.');
										return Redirect::to('/');
									}
								}
							catch (Cartalyst\Sentry\Users\UserExistsException $e)
							{
							    Session::flash('error', 'User already exists.');
								return Redirect::to('users/edit/' . $id);
							}
							catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
							{
							    Session::flash('error', 'User was not found.');
								return Redirect::to('users/edit/' . $id);
							}
				}

				// Set Validation Rules
		}

	}

	public function postEditPassword($id){

	}
/*
		public function postUpdateProfile(){
			$user = Sentry::getUser();
			$id = $user->id;
			$rules = array(
					#validation rules.
					"email" => "Required|Between:3,255|Email|unique:users,email,{$id}",
					"password" => "Between:5,25|Confirmed",
					"password_confirmation" => "Between:5,25",
					"address" => "Required",
					"city" => "Required",
					"state" => "Required",
					"zip" => "Required"

				);
		$messages = array(
				'password.between' => 'Password must be 5-25 chars.',
				'password.confirmed' => 'Passwords do not match.',
				'password_confirmation.between' => 'Password must be 5-25 chars.',
				'email.unique' => 'Email taken, try again.',
				'email.between' => 'Email must be 3-255 chars',
				'address.required' => 'Address is required.',
				'city.required' => 'City is required.',
				'state.required' => 'State is required.',
				'zip.required' => 'Zip is required.'
				);
			$v = Validator::make(Input::all(), $rules, $messages);

		if ($v->passes()){
			$user = User::find(Input::get('id'));
			$user->first_name = Input::get('first_name');
			$user->last_name = Input::get('last_name');
			$user->email = Input::get('email');
			$user->password = Crypt::encrypt(Input::get('password'));
			$user->phone = Input::get('phone');
			$user->address = Input::get('address');
			$user->city = Input::get('city');
			$user->state = Input::get('state');
			$user->zip = Input::get('zip');
			$user->payment_method = Input::get('payment_method');
			$user->paypal_email = Input::get('paypal_email');
			$user->save();
			return Redirect::to('edit_profile');
		} else {
			$errors = $v->messages();
			return Redirect::to('edit_profile')->withErrors($v);
		}
	} */

	public function getOrders($id){
		if (Sentry::check()){
			$currentUser = Sentry::getUser();
				if( $currentUser->hasAccess('admin') || $currentUser->getId()== $id){
					Event::listen('laravel.query', function($sql) {
    dd($sql);});
					$orders = Order::where('user_id','=',$id)->get(); // find all orders from currently logged in user.
					$orderArray = array();
					$i = 0;


					foreach($orders as $order){
						$items = DB::table('items')->join('books', function($join){$join->on('books.id', '=', 'items.book_id');})->where('order_id','=',$order->id)->get();
						$orderArray[$i]['id'] = $order->id;
						$orderArray[$i]['total_amount'] = $order->total_amount;
						$orderArray[$i]['created_at'] = $order->created_at;
						$orderArray[$i]['received_date'] = $order->received_date;
						$orderArray[$i]['paid_date'] = $order->paid_date;
						$orderArray[$i]['comments'] = $order->comments;
						$orderArray[$i]['ups_label'] = $order->ups_label;
						//$orderArray[$i]['ups_label'] = $order->ups_label;
						$j = 0;
							// attach all items to an order
						foreach($items as $item){
							$orderArray[$i]['items'][$j]['qty'] = $item->qty;
							$orderArray[$i]['items'][$j]['price'] = $item->price;
							$orderArray[$i]['items'][$j]['title'] = $item->title;
							$orderArray[$i]['items'][$j]['author'] = $item->author;
							$orderArray[$i]['items'][$j]['edition'] = $item->edition;
							$orderArray[$i]['items'][$j]['image_url'] = $item->image_url;
							$orderArray[$i]['items'][$j]['publisher'] = $item->publisher;
							$orderArray[$i]['items'][$j]['isbn10'] = $item->isbn10;
							$orderArray[$i]['items'][$j]['isbn13'] = $item->isbn13;
							$j++;
						}

						$i++;
					}

					$data['user'] = Sentry::getUserProvider()->findById($id);
					$data['orders'] = $orderArray;

					return View::make('users.orders', array('orders' => $orderArray))->with($data);
					}else {
					Session::flash('error', 'You don\'t have access to that user.');
					return Redirect::to("/users/orders/{$currentUser->getId()}");
				}

			} else {

				Session::flash('error', 'You are currently logged out, please login and try again!');
				return Redirect::to('login');
			}

	}

	/**
	* Forgot Password / Reset
	*/

	public function getResetPassword(){
		return View::make('users.login');
	}

	public function postResetPassword(){
		$input = array('email' => Input::get('email'));
		$rules = array('email' => 'required|min:4|max:255|email');

		$v = Validator::make($input, $rules);
		if ($v->fails()){
			return Redirect::back()->withErrors($v)->withInput();
		}
		else {
			try {
					$user = Sentry::getUserProvider()->findByLogin($input['email']);
			    $data['resetCode'] = $user->getResetPasswordCode();
			    $data['userId'] = $user->getId();
			    $data['email'] = $input['email'];

			    // Email the reset code to the user
					Mail::send('emails.auth.reset', $data, function($m) use($data)
					{
						$m->from('patrick@recycleabook.com', 'RecycleABook')->to($data['email'])->subject('Password Reset Confirmation | Laravel4 With Sentry');
						});
					Session::flash('success', 'Check your email for password reset information.');
			    return Redirect::back();

			}
			catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
			{
			    echo 'User does not exist';
			}
		}
	}

		/**
	 * Reset User's password
	 */

	public function getReset($userId, $resetCode) {
		try
		{
		  // Find the user
		  $user = Sentry::getUserProvider()->findById($userId);
		  $newPassword = $this->_generatePassword(8,8);

	    // Attempt to reset the user password
	    if ($user->attemptResetPassword($resetCode, $newPassword))
	    {
	        // Password reset passed
	        //
	        // Email the reset code to the user

		    //Prepare New Password body
		    $data['newPassword'] = $newPassword;
		    $data['email'] = $user->getLogin();

		    Mail::send('emails.auth.newpassword', $data, function($m) use($data)
			{
			    $m->to($data['email'])->subject('New Password Information | Laravel4 With Sentry');
			});

			Session::flash('success', 'Your password has been changed. Check your email for the new password.');
		    return Redirect::to('login');

	    }
	    else
	    {
	        // Password reset failed
	    	Session::flash('error', 'There was a problem.  Please contact the system administrator.');
		    return Redirect::to('login');
	    }
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
		    echo 'User does not exist.';
		}
	}






	/* public function getForgotPassword(){

		return View::make('users.forgot_password');
	}
*/
	public function postForgotPassword(){
		//$cred = array('email' => Input::get('email'));
		Mail::send('emails.welcome', $data, function($message)
{
    $message->to('foo@example.com', 'John Smith')->subject('Welcome!');
});
		//return Password::remind($cred)->with('success', 'A password reset e-mail has been sent. ');
	}

	public function getPasswordReset(){
		$email = Input::get('email');
		Mail::send('emails.auth.reminder', $data, function($message)
		{
    		$message->to($email)->subject('TopBookPrices.com :: Password Reset');
		});

		return View::make('users.password_reset');
	}

	public function postPasswordReset(){
		/* $cred = array('email' => Input::get('email'));
		return Password::reset($cred, function($user, $password){
			$user->password = Hash::make($password);
			$user->save();
			*/
			try {

				return Redirect::to('login')->with('success', 'Password reset successful!');
			} catch (Cartalyst\Sentry\Users\UserNotFoundException $e){

				return Redirect::to('login')->with('warning', 'User not found.');
			}



	}


/**
	 * Generate password - helper function
	 * From http://www.phpscribble.com/i4xzZu/Generate-random-passwords-of-given-length-and-strength
	 *
	 */

	private function _generatePassword($length=9, $strength=4) {
		$vowels = 'aeiouy';
		$consonants = 'bcdfghjklmnpqrstvwxz';
		if ($strength & 1) {
			$consonants .= 'BCDFGHJKLMNPQRSTVWXZ';
		}
		if ($strength & 2) {
			$vowels .= "AEIOUY";
		}
		if ($strength & 4) {
			$consonants .= '23456789';
		}
		if ($strength & 8) {
			$consonants .= '@#$%';
		}

		$password = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$password .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$password .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		return $password;
	}


}