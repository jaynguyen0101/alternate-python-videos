<?php
ini_set('include_path','/hsphere/local/home/webrehab/pear');
$GLOBALS['cfg']=parse_ini_file("/hsphere/local/home/webrehab/cfg/gen_cfg.ini",true);
include_once $GLOBALS['cfg']['files']['root'].'/sys/core/makeORM.php';
header('Content-Type: application/json');

$truther=array();

$time=date("Y-m-d H:i:s",(strtotime($_REQUEST['date'])));
if(file_exists($GLOBALS['cfg']['files']['root'] . '/practice/' . $_REQUEST['pid'] . "/videosdefault.serialized")) {
	$defs = unserialize(file_get_contents($GLOBALS['cfg']['files']['root'] . '/practice/' . $_REQUEST['pid'] . "/videosdefault.serialized"));
	$truther[] = ORM::for_table('reviews')->where(array('id'=>$_REQUEST['rid']))->find_one()->set(array('video_release_date'=>$_REQUEST['date']))->save();
	$truther[] = ORM::for_table('reviews_parameters')->create()->set(array('review_id'=>$_REQUEST['rid'],'param'=>'spokespersonmov','val'=>$defs['spokespersonmov']))->save();
	$truther[] = ORM::for_table('reviews_parameters')->create()->set(array('review_id'=>$_REQUEST['rid'],'param'=>'bgmfile','val'=>$defs['bgmfile']))->save();
	$truther[] = ORM::for_table('reviews_parameters')->create()->set(array('review_id'=>$_REQUEST['rid'],'param'=>'ltfontcolor','val'=>$defs['ltfontcolor']))->save();
	$truther[] = ORM::for_table('reviews_parameters')->create()->set(array('review_id'=>$_REQUEST['rid'],'param'=>'ltfontcolor2','val'=>$defs['ltfontcolor2']))->save();
	$truther[] = ORM::for_table('reviews_parameters')->create()->set(array('review_id'=>$_REQUEST['rid'],'param'=>'lowerthirdmov','val'=>$defs['lowerthirdmov']))->save();
	$truther[] = ORM::for_table('reviews_parameters')->create()->set(array('review_id'=>$_REQUEST['rid'],'param'=>'resolution','val'=>$defs['resolution']))->save();
} else {
	$truther[] = ORM::for_table('reviews')->where(array('id'=>$_REQUEST['rid']))->find_one()->set(array('video_release_date'=>$_REQUEST['date']))->save();
	$truther[] = ORM::for_table('reviews_parameters')->create()->set(array('review_id'=>$_REQUEST['rid'],'param'=>'spokespersonmov','val'=>'random.mov'))->save();
	$truther[] = ORM::for_table('reviews_parameters')->create()->set(array('review_id'=>$_REQUEST['rid'],'param'=>'bgmfile','val'=>'random.mp3'))->save();
	$truther[] = ORM::for_table('reviews_parameters')->create()->set(array('review_id'=>$_REQUEST['rid'],'param'=>'ltfontcolor','val'=>'white'))->save();
	$truther[] = ORM::for_table('reviews_parameters')->create()->set(array('review_id'=>$_REQUEST['rid'],'param'=>'ltfontcolor2','val'=>'lightgrey'))->save();
	$truther[] = ORM::for_table('reviews_parameters')->create()->set(array('review_id'=>$_REQUEST['rid'],'param'=>'lowerthirdmov','val'=>'multibar_white.png'))->save();
	$truther[] = ORM::for_table('reviews_parameters')->create()->set(array('review_id'=>$_REQUEST['rid'],'param'=>'resolution','val'=>'360p'))->save();
}
print_r(json_encode(array('success'=>$truther,'rid'=>$_REQUEST['rid'],'date'=>$_REQUEST['date'],'time'=>$time)));