<?php
session_set_cookie_params(['httponly'=>true,'samesite'=>'Lax']);session_start();
require_once __DIR__.'/../config/database.php';require_once __DIR__.'/helpers.php';
date_default_timezone_set(cfg()['timezone']);
function csrf(){return $_SESSION['csrf']??=bin2hex(random_bytes(32));}
function csrf_field(){return "<input type='hidden' name='_csrf' value='".csrf()."'>";}
function csrf_check(){if($_SERVER['REQUEST_METHOD']==='POST'&&!hash_equals(csrf(),$_POST['_csrf']??''))die('Invalid CSRF token');}
function login_as($type,$id,$name,$role=''){session_regenerate_id(true);$_SESSION['u']=['type'=>$type,'id'=>(int)$id,'name'=>$name,'role'=>$role];}
function guard($type,$roles=[]){$u=$_SESSION['u']??null;if(!$u||$u['type']!==$type)redirect(cfg()['base_url']."/$type/login.php");if($roles&&$u['role']!=='super_admin'&&!in_array($u['role'],$roles))die('Access denied');return $u;}
