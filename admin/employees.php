<?php require '../includes/auth.php';require '../includes/header.php';$u=guard('admin',['hr_manager']);csrf_check();
if(($_POST['_action']??'')==='add'){$s=db()->prepare("INSERT INTO employees(employee_code,full_name,email,mobile,joining_date,password_hash) VALUES(?,?,?,?,?,?)");
 try{$s->execute([trim($_POST['code']),trim($_POST['name']),trim($_POST['email']),trim($_POST['mobile']),$_POST['joining'],password_hash($_POST['password'],PASSWORD_BCRYPT)]);audit($u['id'],'Added employee '.$_POST['code']);flash('Employee added');}catch(PDOException $x){flash('Employee ID or email already exists','danger');}redirect('employees.php');}
if(($_POST['_action']??'')==='toggle'){db()->prepare("UPDATE employees SET login_active=1-login_active WHERE id=?")->execute([(int)$_POST['id']]);audit($u['id'],'Toggled login #'.(int)$_POST['id']);redirect('employees.php');}
$rows=db()->query("SELECT * FROM employees ORDER BY id DESC")->fetchAll();
page_head('Employees',['Dashboard'=>['dashboard.php','speedometer2'],'Employees'=>['employees.php','people']],$u);?>
<form method="post" class="card p-3 mb-4 row g-2 flex-row"><?=csrf_field()?><input type="hidden" name="_action" value="add">
<div class="col-md-2"><input class="form-control" name="code" placeholder="AISQ-002" required></div><div class="col-md-3"><input class="form-control" name="name" placeholder="Full name" required></div>
<div class="col-md-3"><input class="form-control" type="email" name="email" placeholder="Email" required></div><div class="col-md-2"><input class="form-control" name="mobile" placeholder="Mobile"></div>
<div class="col-md-2"><input class="form-control" type="date" name="joining" required></div><div class="col-md-3"><input class="form-control" name="password" placeholder="Temp password" required minlength="8"></div><div class="col-md-2"><button class="btn btn-primary">Add</button></div></form>
<div class="table-responsive card"><table class="table mb-0"><tr><th>ID</th><th>Name</th><th>Email</th><th>Status</th><th>Login</th><th></th></tr>
<?php foreach($rows as $r){?><tr><td><?=e($r['employee_code'])?></td><td><?=e($r['full_name'])?></td><td><?=e($r['email'])?></td><td><span class="badge text-bg-success"><?=e($r['status'])?></span></td><td><?=$r['login_active']?'Enabled':'Disabled'?></td>
<td><form method="post"><?=csrf_field()?><input type="hidden" name="_action" value="toggle"><input type="hidden" name="id" value="<?=$r['id']?>"><button class="btn btn-sm btn-outline-secondary">Toggle login</button></form></td></tr><?php }?></table></div>
<?php page_foot();
