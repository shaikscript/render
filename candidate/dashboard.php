<?php require '../includes/auth.php';require '../includes/header.php';$u=guard('candidate');
$s=db()->prepare("SELECT t.title,t.duration_minutes,a.deadline,a.status,a.result_published FROM candidate_test_assignments a JOIN tests t ON t.id=a.test_id WHERE a.candidate_id=?");$s->execute([$u['id']]);$rows=$s->fetchAll();
page_head('Assigned Assessments',['Assessments'=>['dashboard.php','journal-check']],$u);?>
<div class="card table-responsive"><table class="table mb-0"><tr><th>Test</th><th>Duration</th><th>Deadline</th><th>Status</th></tr>
<?php foreach($rows as $r){?><tr><td><?=e($r['title'])?></td><td><?=$r['duration_minutes']?> min</td><td><?=e($r['deadline']?:'—')?></td><td><?=e($r['result_published']?'Result Published':$r['status'])?></td></tr><?php }if(!$rows)echo'<tr><td colspan=4 class="text-center text-muted p-4">No tests assigned yet</td></tr>';?></table></div>
<?php page_foot();
