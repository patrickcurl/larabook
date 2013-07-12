<?php 
class UsersController extends BaseController {
	protected $layout = 'layouts.master';
	
	public function postLogin(){
		$email = Input::get('email');
		$password = Input::get('password');
		//$user = array(
		//	'email' => Input::get('email'),
		//	'password' => Input::get('password')
		// );
			$user = User::where('email','=',$email)->first();
			if($user){
				if ($password == Crypt::decrypt($user->password)){
					Auth::login($user);
					//return Redirect::to('checkout')
					return Redirect::back()
						->with('message', 'You are successfully logged in.');
				} else {
						return Redirect::back()
							->with('message', 'Wrong password, please try again!')
							->withInput();
				}
			} else {
				return Redirect::back()
					->with('message', 'Your email does not match an account, please register.')
					->withInput();
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

		//var_dump(Auth::user()->id);
		$v = User::validate(Input::all(), Auth::user()->id);
		//$v = User::validate(Input::get(all))
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

}