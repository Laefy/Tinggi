<?php

class Session{
	
	private $user;
	private $key;
	
    public function __construct() {
        $this->user = null;
		$this->key = $_SERVER['HTTP_USER_AGENT'].$_SERVER['SERVER_ADDR'].$_SERVER['SERVER_ADMIN'];
		
    }
	
	public function connection(){
	
			if($_SERVER['key'] == $_SERVER['HTTP_USER_AGENT'].$_SERVER['SERVER_ADDR'].$_SERVER['SERVER_ADMIN']){
			
				return true;
			
			}
			
			return false;
			
	}


	public function getUser($user){
	
		$_SESSION['pseudo']=$this->pseudo;
		$_SESSION['mail']=$this->mail;
		$_SESSION['img']=$this->img;
	}
	
	

	
	public public function encrypt($pwd){

		$before="&a|n#a$9¤n!5*";
		$after="#[m=&ào?:ué|";

		$beforeKey=sha1($before);
		$afterKey=sha1($after);
	
		return md5($beforeKey.sha1($pwd).$afterKey);
		
	}
	
	public function comparisonKey($pwd,$key){
	
		if(strcmp(encrypt($pwd),$key==1)){
			return true;
		}
		return false;
	}

	
	$session = new Session;
	$session -> comparisonKey($pwd,$key);


}



	var_dump($_SERVER);



?>