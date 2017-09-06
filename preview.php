<?php
ini_set('include_path','/hsphere/local/home/webrehab/pear');
$GLOBALS['cfg']=parse_ini_file("/hsphere/local/home/webrehab/cfg/gen_cfg.ini",true);
require_once ($GLOBALS['cfg']['files']['root'].'/sys/core/makeORM.php');

$stats = ORM::for_table('practice')->where(array('ID'=>$_REQUEST['pid']))->find_array()[0];
$opacity = 1.0;
if(strpos($_REQUEST['lowerthird'], 'black_to_') !== false) $opacity = 0.8;

if($_REQUEST['spokesperson'] == "random") {
	$choice = rand(0, 8);
	switch ($choice) {
		case 0:
			$_REQUEST['spokesperson'] = "erehab1";
			break;
		
		case 1:
			$_REQUEST['spokesperson'] = "erehab2";
			break;

		case 2:
			$_REQUEST['spokesperson'] = "erehab3";
			break;

		case 3:
			$_REQUEST['spokesperson'] = "erehab_male_1";
			break;

		case 4:
			$_REQUEST['spokesperson'] = "erehab_male_2";
			break;

		case 5:
			$_REQUEST['spokesperson'] = "erehab_male_3";
			break;

		case 6:
			$_REQUEST['spokesperson'] = "erehab_olderfemale_1";
			break;

		case 7:
			$_REQUEST['spokesperson'] = "erehab_olderfemale_2";
			break;

		case 8:
			$_REQUEST['spokesperson'] = "erehab_olderfemale_3";
			break;
	}
		$randchoose = "Random movie chosen: " . $_REQUEST['spokesperson'] . "\n";
}

?><style type="text/css">
#main {
	position: absolute;
	height: 720px;
	width: 1280px;
	top: 50%;
	left: 50%;
	margin: -360px 0 0 -680px;
}

#lt {
	position: absolute;
	left: 0px;
	top: 0px;
	opacity: <?= $opacity ?>;
}

#t1 {
	position: absolute;
	left: 210px;
	top: 580px;
	font-family: Arial;
	font-size: 30px;
	color: <?= $_REQUEST['fontcolor1']; ?>;
}

#t2 {
	position: absolute;
	left: 210px;
	top: 625px;
	font-family: Arial;
	font-size: 25px;
	color: <?= $_REQUEST['fontcolor2']; ?>;
}

#logo {
	position: absolute;
	left: 120px;
	top: 580px;
	height: 75px;
	width: 75px;
}

.base {
	height: 720px;
	width: 1280px;
}
</style>
<div id="main">
<video autoplay class="base" id="previewvideo">
<source src="/ca/page/video_gen/previews/<?= $_REQUEST['spokesperson']; ?>.mp4" type="video/mp4" />
</video>
<img src="/ca/page/video_gen/lowerthird/<?= $_REQUEST['lowerthird']; ?>" id="lt" />\
<img src="http://<?= $stats['website']; ?>/files/mobile/icon-114x114.png" id="logo"/>
<div id="t1"><?= $stats['Name']; ?></div>
<?php 
if($stats['signature_phone']){
	if(isset($randchoose)) {
		$v=	"<div id='t2'>Call: {$stats['signature_phone']} $randchoose</div>";
	} else {
		$v=	"<div id='t2'>Call: {$stats['signature_phone']}</div>";	
	}
} elseif(isset($randchoose)) {
	$v = "<div id='t2'>$randchoose</div>";
}


print_r($v);

?>
</div>