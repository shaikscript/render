<?php
function e($s){return htmlspecialchars((string)$s,ENT_QUOTES,'UTF-8');}
function redirect($u){header("Location: $u");exit;}
function flash($m=null,$t='success'){if($m){$_SESSION['f']=[$m,$t];return;}if(!empty($_SESSION['f'])){[$m,$t]=$_SESSION['f'];unset($_SESSION['f']);return "<div class='alert alert-$t'>".e($m)."</div>";}}
function rating_for($s){$r=db()->prepare("SELECT label,color FROM rating_scales WHERE ? BETWEEN min_score AND max_score LIMIT 1");$r->execute([$s]);return $r->fetch()?:['label'=>'N/A','color'=>'secondary'];}
function audit($who,$act){db()->prepare("INSERT INTO admin_audit_logs(admin_id,action,ip) VALUES(?,?,?)")->execute([$who,$act,$_SERVER['REMOTE_ADDR']??'']);}
