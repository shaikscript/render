<?php // One-time setup: /setup.php?key=<SETUP_KEY env var>. Creates tables + demo accounts.
require 'config/database.php';$k=getenv('SETUP_KEY');if(!$k||!hash_equals($k,$_GET['key']??''))die('Forbidden');
$d=db();if($d->query("SELECT to_regclass('public.admins')")->fetchColumn()===null){foreach(array_filter(array_map('trim',explode(";\n",file_get_contents('sql/schema.sql')))) as $q)$d->exec($q);}
if($d->query("SELECT COUNT(*) FROM admins")->fetchColumn())die('Already set up.');
$h=fn($p)=>password_hash($p,PASSWORD_BCRYPT);
$d->prepare("INSERT INTO admins(username,email,full_name,password_hash,role) VALUES('admin','admin@aisquare.local','Super Admin',?,'super_admin')")->execute([$h('Admin@123')]);
$d->prepare("INSERT INTO employees(employee_code,full_name,email,joining_date,password_hash) VALUES('AISQ-001','Sample Employee','emp@aisquare.local',CURRENT_DATE,?)")->execute([$h('Emp@12345')]);
$d->prepare("INSERT INTO candidates(candidate_code,full_name,email,position,password_hash) VALUES('AISQ-CAND-001','Sample Candidate','cand@aisquare.local','AI Evaluator',?)")->execute([$h('Cand@12345')]);
echo 'Done. Logins: admin/Admin@123, AISQ-001/Emp@12345, AISQ-CAND-001/Cand@12345. Change passwords, then remove SETUP_KEY env var.';
