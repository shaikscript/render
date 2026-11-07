<?php require '../includes/auth.php';require '../includes/header.php';$u=guard('admin',['payroll_manager']);
$s=db()->prepare("SELECT * FROM payslips WHERE id=?");$s->execute([(int)$_GET['id']]);$s=$s->fetch()?:die('Not found');page_head('Payslip',[],$u);echo slip_html($s);page_foot();
