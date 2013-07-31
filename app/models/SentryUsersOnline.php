<?php

Class SentryUsersOnline extends Eloquent {
  /**
  * The table associated with the model.
  *
  * @var string
  */
    protected $table = 'sessions';
  /**
  * Indicates if the model should be timestamped.
  *
  * @var bool
  */
  public $timestamps = false;
  /**
  * Holds all the registered users.
  *
  * @var array
  */
  protected $allUsers = null;
  /**
  * Create a new Eloquent model instance.
  *
  * @param array $attributes
  * @return void
  */
  public function __construct()
  {
    parent::__construct();
    $this->clearTimeouts(300); // 5 Minutes
    $this->register();
    $this->allUsers = $this->allUsers ?: Sentry::getUserProvider()->findAll();
  }
  /**
  * Deletes the old rows from database
  *
  * @param int $timeout
  * @return void
  */
  public function clearTimeouts($timeout)
  {
    return $this->where('id', '!=', Session::getId())->where('last_activity', '<', time() - $timeout)->delete();
  }
  /**
  * Store the necessary user information on the session table.
  *
  * @return mixed
  */
  public function register()
  {
    $user_id = Sentry::check() ? Sentry::getUser()->id : 0;
    return $this->where('id', Session::getId())->update(compact('user_id'));
  }
  /**
  * Return the total of guests online.
  *
  * @return int
  */
  public function getGuestsCount()
  {
    return $this->where('user_id', 0)->count();
  }
  /**
  * Return the total of users online.
  *
  * @return int
  */
  public function getUsersCount()
  {
    return $this->where('user_id', '>', 0)->count();
  }
  /**
  * Return a list of online users.
  *
  * @return array
  */
  public function registeredUsers()
  {
    $users = array_combine(
      array_map(function($user) { return $user->id; }, $this->allUsers),
      array_map(function($user) { return $user; }, $this->allUsers)
    );
    $usersOnline = array();
    foreach ($this->where('user_id', '>', 0)->orderBy('last_activity', 'DESC')->get() as $online)
    {
      $usersOnline[] = $users[$online->user_id];
    }
    return $usersOnline;
  }
}