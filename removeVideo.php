<?php
ini_set('include_path','/hsphere/local/home/webrehab/pear');
$GLOBALS['cfg']=parse_ini_file("/hsphere/local/home/webrehab/cfg/gen_cfg.ini",true);
include_once $GLOBALS['cfg']['files']['root'].'/sys/core/makeORM.php';
header('Content-Type: application/json');

$truther=array();

$time=date("Y-m-d H:i:s",(strtotime($_REQUEST['date'])));
	$truther[] = ORM::for_table('reviews')->where(array('id'=>$_REQUEST['rid']))->find_one()->set(array('video_release_date'=> NULL, 'video_process_status'=>NULL, 'video_process_date'=>NULL))->save();
	$truther[] = ORM::for_table('reviews_parameters')->where_equal('review_id', $_REQUEST['rid'])->delete_many();
print_r(json_encode(array('success'=>$truther,'rid'=>$_REQUEST['rid'],'date'=>$_REQUEST['date'],'time'=>$time)));
?>