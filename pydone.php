<?php
if(isset($_POST['secret'])) { if($_POST['secret'] == md5('what is this')) {
	ini_set('include_path','/hsphere/local/home/webrehab/pear');
$GLOBALS['cfg']=parse_ini_file("/hsphere/local/home/webrehab/cfg/gen_cfg.ini",true);

	$user = $GLOBALS['cfg']['databaseSettings']['user'];
	$pass = $GLOBALS['cfg']['databaseSettings']['password'];
	$host = $GLOBALS['cfg']['databaseSettings']['host'];
	$dbname = $GLOBALS['cfg']['databaseSettings']['dbname'];

	$opt = [
	    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	    PDO::ATTR_EMULATE_PREPARES   => false,
	];

	try {
		$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", "$user", "$pass", $opt);
		if($_POST['sample'] == "yes") {
			$qry = $conn->prepare("UPDATE reviews_sample SET status=? WHERE id=?");
			if (isset($_POST['id']) && isset($_POST['status'])) {
				$qry->execute([$_POST['status'], $_POST['id']]);
				print("OK");
			} else {
				print("Sanity check failed! ID/status not set.");
			}
		} else {
			$cdate = date("Y-m-d H:i:s");
			$qry = $conn->prepare("UPDATE reviews SET video_process_status=?, video_process_date=? WHERE id=?");
			if (isset($_POST['id']) && isset($_POST['status'])) {
				$qry->execute([$_POST['status'], $cdate, $_POST['id']]);
				print("OK");
			} else {
				print("Sanity check failed! ID/status not set.");
			}
		}
		$conn = NULL;
	} catch (PDOException $e) {
		print "Conn. failed: " . $e->getMessage();
	}
} else {
	print("pls");
}} else {
	print("stop");
}

?>