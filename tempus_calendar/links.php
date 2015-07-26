<?php
foreach (scandir('.', 1) as $f)
  if (preg_match('/^ver[0-9]{5}$/', $f)) {
    $cur_dir = $f;
    break;
}

?>
<link rel="stylesheet" type="text/css" href="<?php echo $cur_dir; ?>/scripts/lib/bootstrap-3.1.1-dist/css/bootstrap.min.css" />
i<link rel="stylesheet" type="text/css" href="<?php echo $cur_dir; ?>/scripts/lib/bootstrap-3.1.1-dist/css/slate-theme.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $cur_dir; ?>/css/fonts.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo $cur_dir; ?>/css/main.css" />
	    <!--
	        <link rel="stylesheet" type="text/css" href="<?php echo $cur_dir; ?>/css/black_and_white.css" />-->
		<script type="text/JavaScript"
		src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
		</script>
		<script type="text/JavaScript" src="<?php echo $cur_dir; ?>/scripts/lib/jquery-1.11.2-min.js"></script>
		<script type="text/JavaScript" src="<?php echo $cur_dir; ?>/scripts/lib/jquery-ui.min.js"></script>
		<script type="text/JavaScript" src="<?php echo $cur_dir; ?>/scripts/lib/bootstrap-3.1.1-dist/js/bootstrap.min.js"></script>
		<script type="text/JavaScript" src="<?php echo $cur_dir; ?>/scripts/application.js"></script>
