<?php
function pw_page($type){$u=guard($type);csrf_check();$t=['admin'=>'admins','employee'=>'employees','candidate'=>'candidates'][$type];
if($_SERVER['REQUEST_METHOD']==='POST'){$s=db()->prepare("SELECT password_hash FROM $t WHERE id=?");$s->execute([$u['id']]);$h=$s->fetchColumn();
 if(!password_verify($_POST['cur'],$h))flash('Current password is wrong','danger');elseif(strlen($_POST['new'])<8||$_POST['new']!==$_POST['conf'])flash('New password must be 8+ chars and match','danger');
 else{db()->prepare("UPDATE $t SET password_hash=? WHERE id=?")->execute([password_hash($_POST['new'],PASSWORD_BCRYPT),$u['id']]);flash('Password updated');}redirect('password.php');}
page_head('Change Password',[],$u);?><form method="post" class="card p-3" style="max-width:420px"><?=csrf_field()?>
<input class="form-control mb-2" type="password" name="cur" placeholder="Current password" required><input class="form-control mb-2" type="password" name="new" placeholder="New password" required><input class="form-control mb-3" type="password" name="conf" placeholder="Confirm new password" required><button class="btn btn-primary">Update</button></form><?php page_foot();}
function ann_page($type,$aud){$u=guard($type);$s=db()->prepare("SELECT * FROM announcements WHERE audience IN(?,'all') AND archived=0 ORDER BY is_pinned DESC,id DESC");$s->execute([$aud]);page_head('Announcements',[],$u);
foreach($s as $a){?><div class="card p-3 mb-3"><div class="d-flex justify-content-between"><b><?=$a['is_pinned']?'📌 ':''?><?=e($a['title'])?></b><span class="badge text-bg-<?=badge($a['priority'])?>"><?=e($a['priority'])?></span></div><div class="text-muted small mb-2"><?=e($a['created_at'])?></div><div><?=nl2br(e($a['body']))?></div></div><?php }
if(!$s->rowCount())echo'<div class="text-muted">No announcements.</div>';page_foot();}
