<?php require '../includes/auth.php';require '../includes/header.php';$u=guard('employee');$id=$u['id'];csrf_check();
$t=db()->prepare("SELECT * FROM attendance_records WHERE employee_id=? AND att_date=CURRENT_DATE");$t->execute([$id]);$today=$t->fetch();
$a=$_POST['_action']??'';
if($a==='in'&&!$today){db()->prepare("INSERT INTO attendance_records(employee_id,att_date,status,check_in,source) VALUES(?,CURRENT_DATE,'Present',NOW(),'portal')")->execute([$id]);flash('Checked in');redirect('dashboard.php');}
if($a==='out'&&$today&&!$today['check_out']){db()->prepare("UPDATE attendance_records SET check_out=NOW() WHERE id=? AND employee_id=?")->execute([$today['id'],$id]);flash('Checked out');redirect('dashboard.php');}
$s=db()->prepare("SELECT c.name,ROUND(AVG(a.score_percent),1) s FROM employee_assessments a JOIN evaluation_categories c ON c.id=a.category_id WHERE a.employee_id=? AND a.is_published=1 GROUP BY c.id");$s->execute([$id]);$cat=$s->fetchAll();
$o=db()->prepare("SELECT AVG(score_percent) FROM employee_assessments WHERE employee_id=? AND is_published=1");$o->execute([$id]);$ov=round((float)$o->fetchColumn(),1);$rt=rating_for($ov);
page_head('My Dashboard',['Dashboard'=>['dashboard.php','house']],$u);?>
<div class="row g-3 mb-4"><div class="col-md-6"><div class="card p-3"><div class="text-muted small">Today</div>
<p class="mb-2"><?=$today?'In: '.e($today['check_in']).($today['check_out']?' · Out: '.e($today['check_out']):''):'Not checked in'?></p>
<form method="post"><?=csrf_field()?><?php if(!$today){?><input type="hidden" name="_action" value="in"><button class="btn btn-success">Check In</button><?php }elseif(!$today['check_out']){?><input type="hidden" name="_action" value="out"><button class="btn btn-warning">Check Out</button><?php }else echo'<span class="text-muted">Done for today</span>';?></form></div></div>
<div class="col-md-6"><div class="card p-3"><div class="text-muted small">Overall Evaluation</div><div class="kpi"><?=$ov?>% <span class="badge text-bg-<?=e($rt['color'])?> fs-6"><?=e($rt['label'])?></span></div></div></div></div>
<div class="card p-3"><h6>Category-wise Performance</h6><canvas id="c" height="90"></canvas></div>
<script>window.addEventListener('load',()=>new Chart(c,{type:'bar',data:{labels:<?=json_encode(array_column($cat,'name'))?>,datasets:[{label:'Avg %',data:<?=json_encode(array_map('floatval',array_column($cat,'s')))?>,backgroundColor:'#10B981'}]},options:{scales:{y:{max:100,beginAtZero:true}}}}))</script>
<?php page_foot();
