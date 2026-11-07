<?php require '../includes/auth.php';require '../includes/header.php';$u=guard('admin');
$nav=['Dashboard'=>['dashboard.php','speedometer2'],'Employees'=>['employees.php','people']];
$n=fn($sql)=>(int)db()->query($sql)->fetchColumn();
$k=['Active Employees'=>$n("SELECT COUNT(*) FROM employees WHERE status='Active'"),'On Leave Today'=>$n("SELECT COUNT(*) FROM attendance_records WHERE att_date=CURRENT_DATE AND status IN('Paid Leave','Unpaid Leave')"),'Active Candidates'=>$n("SELECT COUNT(*) FROM candidates WHERE is_active=1"),'Avg Evaluation %'=>round((float)db()->query("SELECT AVG(score_percent) FROM employee_assessments WHERE is_published=1")->fetchColumn(),1)];
$cat=db()->query("SELECT c.name,ROUND(AVG(a.score_percent),1) s FROM evaluation_categories c LEFT JOIN employee_assessments a ON a.category_id=c.id GROUP BY c.id")->fetchAll();
page_head('Admin Dashboard',$nav,$u);?>
<div class="row g-3 mb-4"><?php foreach($k as $l=>$v){?><div class="col-6 col-lg-3"><div class="card p-3"><div class="text-muted small"><?=e($l)?></div><div class="kpi"><?=e($v)?></div></div></div><?php }?></div>
<div class="card p-3"><h6>Category-wise Average Evaluation Score</h6><canvas id="c" height="90"></canvas></div>
<script>window.addEventListener('load',()=>new Chart(c,{type:'bar',data:{labels:<?=json_encode(array_column($cat,'name'))?>,datasets:[{label:'Avg %',data:<?=json_encode(array_map('floatval',array_column($cat,'s')))?>,backgroundColor:'#2563EB'}]},options:{scales:{y:{max:100,beginAtZero:true}}}}))</script>
<?php page_foot();
