<?php
class UsersTableSeeder extends Seeder{
	public function run(){
			$users = array(
						array('first_name' => 'Patrick', 'last_name' => 'Curl',	'email' => 'patrickwcurl@gmail.com', 'password' => Hash::make('mypass'), 'phone' => '9372235538', 'address' => '54 Bond St', 'city' => 'Dayton', 'state' => 'OH', 'zip' => '45405', 'payment_method' => 'Paypal', 'paypal_email' => 'test@testmonkey.com'),
			);

			DB::table('users')->delete();
			foreach($users as $user){
				DB::table('users')->insert($user);
			}
	}
}