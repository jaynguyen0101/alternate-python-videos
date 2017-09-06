<?php
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
	$alreadyexistQ = $conn->prepare("SELECT * from reviews_sample WHERE practice_id = ?");
	$qry = $conn->prepare("INSERT INTO reviews_sample VALUES (?,?,?)");
	if (isset($_POST['practice_id'])) {
		$alreadyexistQ->execute(array($_POST['practice_id']));
		$alreadyexist = $alreadyexistQ->fetch(PDO::FETCH_ASSOC);
		if(isset($alreadyexist['status'])) { //already exists
			print("Sample videos already scheduled!");
		} else {
			$qry->execute(array(NULL, $_POST['practice_id'], "CREATE"));
			print("Sample videos will be made for this practice when the next batch of videos is created.");
		}
	} else {
		print("ERROR: Practice ID not sent correctly!");
	}
	$conn = NULL;
} catch (PDOException $e) {
	print "Conn. failed: " . $e->getMessage();
}


?>