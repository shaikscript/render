<?php require 'includes/auth.php';
$portal=$portal??($_GET['portal']??'employee');$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){csrf_check();$portal=$_POST['portal'];$id=trim($_POST['id']);$pw=$_POST['password'];
 $q=['employee'=>["SELECT * FROM employees WHERE (employee_code=? OR email=?) AND login_active=1 AND status<>'Inactive'",'employee','full_name'],
     'candidate'=>["SELECT * FROM candidates WHERE (candidate_code=? OR email=?) AND is_active=1",'candidate','full_name'],
     'admin'=>["SELECT * FROM admins WHERE (username=? OR email=?) AND is_active=1",'admin','full_name']][$portal]??null;
 if($q){$s=db()->prepare($q[0]);$s->execute([$id,$id]);$r=$s->fetch();
  if($r&&password_verify($pw,$r['password_hash'])){login_as($q[1],$r['id'],$r[$q[2]],$r['role']??'');if($portal==='admin')audit($r['id'],'Login');redirect(cfg()['base_url']."/$portal/".($portal==='admin'?'dashboard.php':'dashboard.php'));}
  $err='Invalid credentials';}}
?><!doctype html><html data-bs-theme="light"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>AI SQUARE HUB</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link href="assets/css/app.css" rel="stylesheet"><link rel="icon" href="assets/img/logo.svg">
<script>document.documentElement.dataset.bsTheme=localStorage.getItem('theme')||'light'</script></head>
<body class="bg-body-tertiary"><div class="container py-5" style="max-width:440px"><div class="text-center mb-4"><img src="assets/img/logo.svg" width="64"><h3 class="mt-2">AI SQUARE HUB</h3><div class="text-muted">AI SQUARE IT SOLUTIONS<br>Build • Evaluate • Grow Together</div></div>
<div class="card p-4"><ul class="nav nav-pills nav-fill mb-3"><?php foreach(['employee'=>'Employee','candidate'=>'Candidate','admin'=>'Admin'] as $k=>$v){?><li class="nav-item"><a class="nav-link <?=$portal===$k?'active':''?>" href="<?=basename($_SERVER['PHP_SELF'])==='index.php'?'?portal=':'#'?><?=$k?>"><?=$v?></a></li><?php }?></ul>
<?php if($err)echo "<div class='alert alert-danger'>".e($err)."</div>";?>
<form method="post"><?=csrf_field()?><input type="hidden" name="portal" value="<?=e($portal)?>">
<input class="form-control mb-2" name="id" placeholder="<?=['employee'=>'Employee ID or Email','candidate'=>'Candidate ID or Email','admin'=>'Username or Email'][$portal]??'ID'?>" required>
<input class="form-control mb-3" type="password" name="password" placeholder="Password" required><button class="btn btn-primary w-100">Sign in to <?=ucfirst(e($portal))?> Hub</button></form></div>
<div class="text-center mt-3"><button class="btn btn-sm btn-outline-secondary" id="themeBtnG">Toggle theme</button></div></div><script src="assets/js/app.js"></script></body></html>
