<?php
session_set_cookie_params(['httponly'=>true,'samesite'=>'Lax']);session_start();
require_once __DIR__.'/../config/database.php';require_once __DIR__.'/helpers.php';
date_default_timezone_set(cfg()['timezone']);
function csrf(){return $_SESSION['csrf']??=bin2hex(random_bytes(32));}
function csrf_field(){return "<input type='hidden' name='_csrf' value='".csrf()."'>";}
function csrf_check(){if($_SERVER['REQUEST_METHOD']==='POST'&&!hash_equals(csrf(),$_POST['_csrf']??''))die('Invalid CSRF token');}
function login_as($type,$id,$name,$role=''){session_regenerate_id(true);$_SESSION['u']=['type'=>$type,'id'=>(int)$id,'name'=>$name,'role'=>$role];}
function guard($type,$roles=[]){$u=$_SESSION['u']??null;if(!$u||$u['type']!==$type)redirect(cfg()['base_url']."/$type/login.php");if($roles&&$u['role']!=='super_admin'&&!in_array($u['role'],$roles))die('Access denied');return $u;}
if(empty($_SESSION['m2'])){foreach(["ALTER TABLE announcements ADD COLUMN IF NOT EXISTS audience VARCHAR(20) DEFAULT 'employees'","ALTER TABLE announcements ADD COLUMN IF NOT EXISTS is_pinned SMALLINT DEFAULT 0","ALTER TABLE announcements ADD COLUMN IF NOT EXISTS archived SMALLINT DEFAULT 0",
"CREATE TABLE IF NOT EXISTS feedback_tickets(id SERIAL PRIMARY KEY,employee_id INT NULL REFERENCES employees(id) ON DELETE SET NULL,author_hash VARCHAR(64),is_anonymous SMALLINT DEFAULT 0,topic VARCHAR(30),subject VARCHAR(150),message TEXT,status VARCHAR(20) DEFAULT 'Open',created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)",
"CREATE TABLE IF NOT EXISTS feedback_replies(id SERIAL PRIMARY KEY,ticket_id INT REFERENCES feedback_tickets(id) ON DELETE CASCADE,sender VARCHAR(10),message TEXT,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)"] as $q)db()->exec($q);$_SESSION['m2']=1;}
