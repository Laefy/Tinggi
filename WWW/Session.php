<?php
require "common/recaptchalib.php";

class Session{

	private static $user;
	private static $auth;
	private static $salt;
	private static $g_key = '6Lcw9SATAAAAAM3zdE31DuiI9UNcMWCtK9bFdCL9';
	private static $g_key_secret = '6Lcw9SATAAAAAEssaKP_aT8zoUPvMl8z2Hi-nqis';

  public static function init(){
			ini_set('session.use_cookies', 1);
			ini_set('session.use_only_cookies', 1);
			ini_set('session.use_trans_sid', false);
			session_start();
			self::$user = null;
			self::$auth = self::getUserInformation();
			self::$salt = sha1("&a|n#a$9¤n!5*");
			Session::connection();
  }

	public static function getGoogleKey() {
		return self::$g_key;
	}

	public static function getGoogleSecretKey() {
		return self::$g_key_secret;
	}

	public static function isNotARobot() {
			$reCaptcha = new ReCaptcha(self::$g_key_secret);
			if(isset($_POST["g-recaptcha-response"])) {
				$resp = $reCaptcha->verifyResponse($_SERVER["REMOTE_ADDR"],$_POST["g-recaptcha-response"]);
				return  ($resp != null && $resp->success);
			}
	}

	public static function signIn($user){
		self::$user = $user;
		$_SESSION['user_id'] = $user->getId();
	}

	private static function getUserInformation(){
		return ($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR']);
	}

	private static function connection(){

			if( (isset($_SESSION['auth'])) && (isset($_SESSION['user_id'])) )
			{
				if(strcmp(self::$auth,self::getUserInformation()) == 0){
					if($_SESSION['user_id'] != 0)
					{
						self::$user = \model\User::getById($_SESSION['user_id']);
					}
					return true;
				}
				else
				{
					self::reset();
				}
			}
			$_SESSION['auth'] = self::getUserInformation();
			$_SESSION['user_id'] = 0;
	}

	public static function getUser(){
		return self::$user;
	}

	public static function isLogin(){
		return !is_null(self::$user);
	}

	public static function getVar($name){
		if(isset($_SESSION[$name]))
		{
			return $_SESSION[$name];
		}
		return false;

	}

	public static function saveVar($name,$var){
		$_SESSION[$name] = $var;
	}

	public static function resetVar($name){
		unset($_SESSION[$name]);
	}

	public static function reset(){
		session_unset();
		session_destroy();
		session_start();
		self::connection();
	}

	public static function encrypt($string){
		return md5(self::$salt.$string.self::$salt);
	}

	public static function compareStingHash($string,$key){
		if(strcmp(Session::encrypt($string,$key) == 0)){
			return true;
		}
		return false;
	}
}
?>
