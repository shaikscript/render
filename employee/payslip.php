<?php require '../includes/auth.php';require '../includes/header.php';$u=guard('employee');
$s=db()->prepare("SELECT * FROM payslips WHERE id=? AND employee_id=? AND status='Published'");$s->execute([(int)$_GET['id'],$u['id']]);$s=$s->fetch()?:die('Not found');page_head('Payslip',[],$u);echo slip_html($s);page_foot();
