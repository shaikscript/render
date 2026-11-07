<?php
function cfg(){static $c;return $c??=['base_url'=>rtrim(getenv('BASE_URL')?:'','/'),'timezone'=>getenv('APP_TZ')?:'Asia/Kolkata'];}
function db(): PDO{static $p;if(!$p){$u=parse_url(getenv('DATABASE_URL')?:die('DATABASE_URL not set'));
$dsn=sprintf('pgsql:host=%s;port=%d;dbname=%s',$u['host'],$u['port']??5432,ltrim($u['path'],'/'));
$p=new PDO($dsn,urldecode($u['user']),urldecode($u['pass']),[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>false]);}return $p;}
