<?php

interface LoginInterface
{
	public function authenticate();
}

abstract class LoginAdapter implements LoginInterface
{
    protected $credential;
    protected $identity;
	
	public function setCredential($credential) {
		$this->credential = $credential;
	}

	public function getCredential() {
		return $this->credential;
	}

	public function setIdentity($identity) {
		$this->identity = $identity;
	}

	public function getIdentity() {
		return $this->identity;
	}

	//abstract public function authenticate();
}


class EmailLogin extends LoginAdapter
{
	private $options = [];

	public function __construct($credential, $identity, $options = []) {
		if (null !== $credential) {
			$this->setCredential($credential);
		}
		
		if (null !== $identity) {
			$this->setIdentity($identity);
		}

		if (null != $options) {
			$this->options = $options;
		}
	}
	 
	/**
	 * process authenticate by email
	 */
	public function authenticate() {
		$email 		= $this->credential;
		$password 	= $this->identity;
		$options	= $this->options; 
		// do something..
	}
}

class PhoneLogin extends LoginAdapter
{
	/**
	 * process authenticate by phone
	 */
	public function authenticate() {
		// do something..
	}
}

// class Authenticate {
	
// 	public function main() {
		
// 		$auth = new EmailLogin($email, $password);

// 		$auth->authenticate();
// 	}
// }


// $a = new LoginAdapter();

interface LoginInterface
{
	public function authenticate();
}

class PhoneLogin implements LoginInterface
{
	/**
	 * process authenticate by phone
	 */
	public function authenticate() {
		// do something..
	}
}


class EmailLogin implements LoginInterface
{
	/**
	 * process authenticate by email
	 */
	public function authenticate() {

	}
}