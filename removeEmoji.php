<?php
ini_set('include_path','/hsphere/local/home/webrehab/pear');
$GLOBALS['cfg']=parse_ini_file("/hsphere/local/home/webrehab/cfg/gen_cfg.ini",true);
include_once $GLOBALS['cfg']['files']['root'].'/sys/core/makeORM.php';
include_once $GLOBALS['cfg']['files']['root']."/ca/includes/bs_formsV2.php";
// header('Content-Type: application/json');
// $form_values = ORM::for_table('reviews')->select('edited_review')->select('id')->find_array();
// $holder='';
// foreach ($form_values as $key => $value) {
// 	$holder = preg_replace('/([0-9|#][\x{20E3}])|[\x{00ae}|\x{00a9}|\x{203C}|\x{2047}|\x{2048}|\x{2049}|\x{3030}|\x{303D}|\x{2139}|\x{2122}|\x{3297}|\x{3299}][\x{FE00}-\x{FEFF}]?|[\x{2190}-\x{21FF}][\x{FE00}-\x{FEFF}]?|[\x{2300}-\x{23FF}][\x{FE00}-\x{FEFF}]?|[\x{2460}-\x{24FF}][\x{FE00}-\x{FEFF}]?|[\x{25A0}-\x{25FF}][\x{FE00}-\x{FEFF}]?|[\x{2600}-\x{27BF}][\x{FE00}-\x{FEFF}]?|[\x{2900}-\x{297F}][\x{FE00}-\x{FEFF}]?|[\x{2B00}-\x{2BF0}][\x{FE00}-\x{FEFF}]?|[\x{1F000}-\x{1F6FF}][\x{FE00}-\x{FEFF}]?/u', '', $value['edited_review']);
// 	$truther[] = ORM::for_table('reviews')->where(array('id'=>$value['id']))->find_one()->set(array('edited_review'=>$holder))->save();
	
// }
// print_r(json_encode($truther));
