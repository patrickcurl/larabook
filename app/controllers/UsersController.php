<?php
class UsersController extends BaseController {
	protected $layout = 'layouts.master';

	public function postLogin(){
		$email = Input::get('email');
		$password = Input::get('password');
		$user = User::where('email','=',$email)->first();

			if(Auth::attempt(array('email' => $email, 'password' => $password))){
				return Redirect::intended('view_orders')->with('success', 'You have logged in successfully.');
			}

		 else {

					if($user){ return Redirect::back()->with('warning', 'Wrong password, please try again.');} else{
						return Redirect::back()->with('message', 'User does not exist, please register.');
					}
				}

//			return View::make('checkout', array('states' => $state_list, 'cart' => $cart));
		//return Redirect::to('checkout')

	}

	public function postRegister(){
		$v = User::validate(Input::all());

		if ($v->passes()){
				$user = new User;
				$user->first_name = Input::get('first_name');
				$user->last_name = Input::get('last_name');
				$user->email = Input::get('email');
				$user->password = Hash::make(Input::get('password'));
				$user->phone = Input::get('phone');
				$user->address = Input::get('address');
				$user->city = Input::get('city');
				$user->state = Input::get('state');
				$user->zip = Input::get('zip');
				$user->payment_method = Input::get('payment_method');
				$user->paypal_email = Input::get('paypal_email');
				$user->save();
				if($user){
					Auth::login($user);
					return Redirect::to('profile')->with('message', 'Registration successful. You are now logged in!');
				} else {
					return Redirect::to('login')->with('message', 'Registration successful. Please login.');
				}

		} else {
			$errors = $v->messages();
			return Redirect::to('login')->withErrors($v);
			//return $v->messages->first('email');
		}

	}

	public function getLogin(){
		return View::make('user.login');
	}

	public function getLogout(){
		Auth::logout();
		return Redirect::back()->with('message', 'Successfully Logged Out');
	}

		public function getEditProfile(){
			//$password = Crypt::decrypt(Auth::user()->password);
			if (Auth::check()){
				return View::make('user.edit_profile');
			}
			else
				{ return Redirect::to('login');}

	}

		public function postUpdateProfile(){
			$id = Auth::user()->id;
			$rules = array(
								#validation rules.

								"email" => "Required|Between:3,255|Email|unique:users,email,{$id}",
								"password" => "Between:5,25|Confirmed",
								"password_confirmation" => "Between:5,25"
				);
			$messages = array(
				'password.between' => 'Password must be 5-25 chars.',
				'password.confirmed' => 'Passwords do not match.',
				'password_confirmation.between' => 'Password must be 5-25 chars.',
				'email.unique' => 'Email taken, try again.'
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
	}

	public function getProfile(){

	}

	public function getForgotPassword(){
		return View::make('user.forgot_password');
	}

	public function postForgotPassword(){
		$cred = array('email' => Input::get('email'));
		return Password::remind($cred)->with('success', 'A password reset e-mail has been sent. ');
	}

	public function getPasswordReset(){
		return View::make('user.password_reset');
	}

	public function postPasswordReset(){
		$cred = array('email' => Input::get('email'));
		return Password::reset($cred, function($user, $password){
			$user->password = Hash::make($password);
			$user->save();
			return Redirect::to('login');
		});

	}



}