<?php
function e($s){return htmlspecialchars((string)$s,ENT_QUOTES,'UTF-8');}
function redirect($u){header("Location: $u");exit;}
function flash($m=null,$t='success'){if($m){$_SESSION['f']=[$m,$t];return;}if(!empty($_SESSION['f'])){[$m,$t]=$_SESSION['f'];unset($_SESSION['f']);return "<div class='alert alert-$t'>".e($m)."</div>";}}
function rating_for($s){$r=db()->prepare("SELECT label,color FROM rating_scales WHERE ? BETWEEN min_score AND max_score LIMIT 1");$r->execute([$s]);return $r->fetch()?:['label'=>'N/A','color'=>'secondary'];}
function audit($who,$act){db()->prepare("INSERT INTO admin_audit_logs(admin_id,action,ip) VALUES(?,?,?)")->execute([$who,$act,$_SERVER['REMOTE_ADDR']??'']);}
function author_hash($id){return hash('sha256',$id.'|'.(getenv('DATABASE_URL')?:'x'));}
function nav_for($t){return ['admin'=>['Dashboard'=>['dashboard.php','speedometer2'],'Employees'=>['employees.php','people'],'Evaluations'=>['evaluations.php','bar-chart'],'Announcements'=>['announcements.php','megaphone'],'Feedback'=>['feedback.php','chat-dots'],'Password'=>['password.php','key']],
'employee'=>['Dashboard'=>['dashboard.php','house'],'Evaluations'=>['evaluations.php','bar-chart'],'Announcements'=>['announcements.php','megaphone'],'Feedback'=>['feedback.php','chat-dots'],'Password'=>['password.php','key']],
'candidate'=>['Assessments'=>['dashboard.php','journal-check'],'Announcements'=>['announcements.php','megaphone'],'Password'=>['password.php','key']]][$t]??[];}
function badge($p){return ['Urgent'=>'danger','Important'=>'warning','Normal'=>'secondary','Open'=>'danger','In Review'=>'warning','Resolved'=>'success','Closed'=>'secondary'][$p]??'secondary';}
