<?php function page_head($title,$nav=[],$user=null){$b=cfg()["base_url"];$nav=nav_for($_SESSION["u"]["type"]??"")?:$nav;?>
<!doctype html><html lang="en" data-bs-theme="light"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?=e($title)?> · AI SQUARE HUB</title><link rel="icon" href="<?=$b?>/assets/img/logo.svg">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="<?=$b?>/assets/css/app.css" rel="stylesheet"><script>document.documentElement.dataset.bsTheme=localStorage.getItem('theme')||'light'</script></head><body>
<div class="d-flex"><aside class="sidebar p-3"><img src="<?=$b?>/assets/img/logo.svg" width="40"> <b>AI SQUARE HUB</b><hr><?php foreach($nav as $l=>[$u,$i]){?><a href="<?=$u?>"><i class="bi bi-<?=$i?>"></i> <?=e($l)?></a><?php }?><hr><a href="<?=$b?>/logout.php"><i class="bi bi-box-arrow-left"></i> Logout</a></aside><main class="flex-grow-1 p-4">
<div class="d-flex justify-content-between mb-3"><h4><?=e($title)?></h4><div><span class="me-3"><?=e($user['name']??'')?></span><button class="btn btn-sm btn-outline-secondary" id="themeBtn"><i class="bi bi-moon"></i></button></div></div><?=flash()?>
<?php }function page_foot(){?></main></div><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script><script src="<?=cfg()['base_url']?>/assets/js/app.js"></script></body></html><?php }
