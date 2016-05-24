<?php
class Session{

	private static $user;
	private static $auth;
	private static $salt;

  public static function init(){
			session_start();
      self::$user = null;
			self::$auth = self::getUserInformation();
			self::$salt = sha1("&a|n#a$9¤n!5*");
			Session::connection();
  }

	public static function signIn($user){
		self::$user = $user;
		$_SERVER['user_id'] = $user->getId();
	}

	private static function getUserInformation(){
		return ($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR']);
	}

	private static function connection(){

			if( (isset($_SERVER['auth'])) && (isset($_SERVER['user_id'])) )
			{
				if(strcmp(encrypt(self::$auth,self::getUserInformation()) == 0)){
					if($_SERVER['user_id'] != 0)
					{
						self::$user = User::getById($_SERVER['user_id']);
					}
					return true;
				}
				else
				{
					session_destroy();
					session_start();
				}
			}
			$_SERVER['auth'] = self::getUserInformation();
			$_SERVER['user_id'] = 0;
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
