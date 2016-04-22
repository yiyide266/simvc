<?php
namespace app\rbac\module;
/**
 * login module
 * @category   rbac
 * @package  rbac
 * @subpackage  lib.module
 * @author    kimmy
 */
class Login extends \simvc\lib\module\Module{
	/**
	 * declare table name in this module 
	 * @attribute  protected
	 * @type string
	 */
	protected $tab_name = 'sess';
	/**
	 * declare this module name
	 * @param  void
	 * @return string
	 */
	public static function who(){
		return __CLASS__;
	}
	/**
	 * insert
	 * @param  int   $data   u_id
	 * @return string
	 */
	public function addOne( $data ){
		return $this -> add( $data );
	}
	/**
	 * get one
	 * @param  int   $data   u_id
	 * @return string
	 */
	public function getOne( $data ){
		$u_id = intval($data);
		return $this -> where( array( 'u_id' => $u_id ) ) -> find();
	}
	/**
	 * alter one
	 * @param  array   $data   query params
	 * @return string
	 */
	public function alterOne( $data ){
		if( isset($data['u_sess']) ){
			$p['u_sess'] = $data['u_sess'];
		}
		if( isset($data['u_sess_expire']) ){
			$p['u_sess_expire'] = $data['u_sess_expire'];
		}
		return $this -> where( array( 'u_id' => $data['u_id'] ) ) -> update( $p );
	}
	/**
	 * login
	 * @param  array   $data   array[['u_account']['u_pass']]
	 * @return array   [0] => [0]:user not exsist
	 *						  [1]:password invalided
	 *						  [2]:login success
	 */
	public function login( $data ){
		$um = \app\rbac\module\Users::instance();
		$user = $um -> getOne_2( $data['u_account'] );
		//var_dump( $um );
		if( !$user ){ return array(0); }
		//var_dump( $user );
		if( md5($data['u_pass']) != $user['u_pass'] ){ return array(1); }
		$usess = $this -> getOne( $user['u_id'] );
		$p['u_id'] = $user['u_id'];
		$p['u_sess'] = $this -> mkSess( $user['u_id'] );
		$p['u_sess_expire'] = $this -> mkSessExpire();
		if( $usess ){
			$this -> alterOne( $p );
		}else{
			$this -> addOne( $p );
		}
		$this -> setSess( $p['u_id'] );
		$this -> setCookie( $p['u_id'], $p['u_sess'], $p['u_sess_expire'] );
		return array( 2,$p );
	}
	/**
	 * cookie login
	 * @param  void
	 * @return array
	 */
	public function logout(){
		$this -> delSess();
		$this -> delCookie();
	}
	/**
	 * cookie login
	 * @param  void
	 * @return array   [0] => [0]:cookie invalided
	 *						  [1]:session not fount
	 *						  [2]:session invalided
	 *						  [3]:session expire
	 *						  [4]:cookie valid
	 */
	public function cookieLogin(){
		$u_id = cookie_get( 'u_id' );
		$u_sess = cookie_get( 'u_sess' );
		if( !$u_id && !$u_sess ){ return array(0);}
		$usess = $this -> getOne( $u_id );
		if( !$usess ){ return array(1); }
		if( $usess['u_sess'] != $u_sess ){ return array(2);}
		if( $usess['u_sess_expire'] < time() ){return array(3);}
		$this -> setSess( $u_id );
		return array(4);
	}
	/**
	 * make a session string 
	 * @param  string   $data   u_id
	 * @return string
	 */
	public function mkSess( $data ){
		return _crc32('!@#$%^&123'.time().rand(1,999).$data);
	}
	/**
	 * make a session expire time
	 * @param  void
	 * @return string
	 */
	public function mkSessExpire(){
		return time() + conf( 'sys_user_login_expire' );
	}
	/**
	 * set cookie
	 * @param  void
	 * @return string
	 */
	public function setCookie( $uid, $usess, $expire ){
		cookie_set( 'u_id', $uid, $expire );
		cookie_set( 'u_sess', $usess, $expire );
	}
	/**
	 * del cookie
	 * @param  void
	 * @return string
	 */
	public function delCookie(){
		cookie_del(  'u_id'  );
		cookie_del( 'u_sess' );
	}
	/**
	 * set session
	 * @param  void
	 * @return string
	 */
	public function setSess( $uid ){
		sess( 'u_id', $uid );
		$m = \app\rbac\module\CnodeAccess::instance();
		//var_dump( $m -> getUserPermit( $uid ) );exit;
		sess( 'u_permit', $m -> arrTotree( $m -> getUserPermit( $uid ) ) );
	}
	/**
	 * del session
	 * @param  void
	 * @return string
	 */
	public function delSess(){
		sess_del( 'u_id' );
		sess_del( 'u_permit' );
	}



}
