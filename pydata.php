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
		//find ids that have sample also
		$findsamples = $conn->query("SELECT * FROM reviews_sample WHERE status = \"CREATE\"")->fetch(PDO::FETCH_ASSOC);
		$samplecreate = false;
		if(isset($findsamples['id'])) {
			$samplecreate = true;
		}
		//normal reviews that need video
		$qdate = date("Y-m-d H:i:s", strtotime('+1 week', strtotime(date("r"))));
		if($samplecreate) {
			$row = array('video_release_date' => 'sample',
				'id' => $findsamples['id'],
				'practice_id' => $findsamples['practice_id']);
			$practiceqry = "SELECT Name, website, signature_phone from practice WHERE ID = {$row['practice_id']}"; #get practice info
			$row['ptinfo'] = $conn->query($practiceqry)->fetch(PDO::FETCH_ASSOC);
			$conn->exec("UPDATE reviews_sample SET status = 'IN_PROGRESS' WHERE ID = $findsamples[id]");
			print(serialize($row));
		} else {
			$qry = "SELECT video_script_ver, video_process_status, video_process_date, video_release_date, id, practice_id, location_id, edited_review, signature FROM reviews WHERE video_release_date < '$qdate' AND video_release_date IS NOT NULL AND video_process_status IS NULL GROUP BY video_release_date";
			$row = $conn->query($qry)->fetch(PDO::FETCH_ASSOC); #grab 1 row regardless of how many there are
			if(isset($row['video_release_date'])) { #sanity check and make sure there any any left
				$paramqry = "SELECT param, val from reviews_parameters WHERE review_id = {$row['id']}"; #get video parameters
				$paramset = $conn->query($paramqry)->fetchAll(PDO::FETCH_ASSOC);
				$parameters = array();
				foreach ($paramset as $paramrow) { #iterate through them
					$parameters[$paramrow["param"]] = $paramrow["val"];
				}
				$row['video_parameters'] = $parameters;
				$practiceqry = "SELECT Name, website, signature_phone from practice WHERE ID = {$row['practice_id']}"; #get practice info
				$row['ptinfo'] = $conn->query($practiceqry)->fetch(PDO::FETCH_ASSOC);
				if(!is_null($row['location_id'])) {
					$row['phone'] = $conn->query("SELECT phone FROM clinic WHERE ID = {$row['location_id']}")->fetch(PDO::FETCH_ASSOC)['phone'];
				} else {
					if(!is_null($row['ptinfo']['signature_phone']) && ($row['ptinfo']['signature_phone'] != "")) {
						$row['phone'] = $row['ptinfo']['signature_phone'];
					}
				}
				$qry2 = "UPDATE reviews SET video_process_status = 'IN_PROGRESS', video_process_date = '" . date("Y-m-d H:i:s") . "' WHERE id = " . $row['id'];
				$conn->exec($qry2);
				print(serialize($row));
			} else {
			print("NO VIDEOS TO PROCESS");
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