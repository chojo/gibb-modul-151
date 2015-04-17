<?php

namespace Controller;

class userController implements IController {
	public function __construct() {
	}
	public function index($param, $data, $session) {
		$this->listusers ();
	}
	public function detail($param) {
		$user = \BO\BOUser::find ( $param );
		if ($user && ! $user->isNew ()) {
			
			(new \View\View ( 'user.detail', array (
					'user' => $user 
			) ))->display ();
		} else {
			$this->listusers ();
		}
	}
	public function listusers() {
		$users = \BO\BOUser::findAll ();
		
		$this->innerView = new \View\View ( 'user.list', array (
				'users' => $users 
		) );
		$this->create ();
	}
	public function register($param, $data, $session) {
		$errorMessage = "";
		$error = false;
		$backurl = "/";
		if (isset ( $data ['backurl'] ))
			$backurl = $data ['backurl'];
			// Do the register logic and validation
		if (isset ( $data ['username'] ) && isset ( $data ['password'] ) && isset ( $data ['password2'] ) && isset ( $data ['email'] ) && isset ( $data ['fullname'] )) {
			
			$password = $data ['password'];
			$password2 = $data ['password'];
			
			$user = new \BE\BEUser ();
			$user->Username = $data ['username'];
			$user->Email = $data ['email'];
			$user->FullName = $data ['fullname'];
			// add user
			
			try {
				$user = \BO\BOUser::register ( $user, $password, $password2 );
				
				if ($user->Id > 0) {
					
					$_SESSION ['userId'] = $user->Id;
					$_SESSION ['FullName'] = $user->FullName;
					// Logged In
					\Redirector::redirect ( $backurl );
					return;
				} else
					$errorMessage .= "<li>Unknown error!</li>";
			} catch ( \Exception $ex ) {
				$errorMessage .= $ex->getMessage ();
			}
		} else
			$errorMessage .= "<li>Please fill in all fields!</li>";
			
			// Display Login Page
		$this->innerView = new \View\View ( 'user.registrieren', array (
				'errorMessage' => $errorMessage,
				'backurl' => $backurl 
		) );
		$this->create ();
	}
	
	public function logout() {
		session_destroy ();
		\Redirector::redirect ( "/" );
	}
	
	public function login($param, $data, $session) {
		$errorMessage = "";
		$backurl = "/";
		if (isset ( $data ['backurl'] ))
			$backurl = $data ['backurl'];
		
		if (isset ( $data ['email'] ) && isset ( $data ['password'] )) {
			try {
				$user = \BO\BOUser::login ( $data ['email'], $data ['password'] );
				if ($user->Id > 0) {
					
					$_SESSION ['userId'] = $user->Id;
					$_SESSION ['FullName'] = $user->FullName;
					// Logged In
					\Redirector::redirect ( $backurl );
					return;
				} else
					$errorMessage = "Incorrect credentials!";
			} catch ( \Exception $ex ) {
				// Show error
				$errorMessage .= "<li>" . $ex->getMessage () . "</li>";
			}
		} else
			$errorMessage = "Please enter credentials!";
			
			// Display Login Page
		$this->innerView = new \View\View ( 'user.login', array (
				'errorMessage' => $errorMessage,
				'backurl' => $backurl 
		) );
		$this->create ();
	}
	
	public function create() {
		$this->innerView = (new \View\View ( 'mainpage', array (
				'title' => 'Login',
				'innercontent' => $this->innerView 
		) ))->display ();
	}
	public function __destruct() {
	}
}
