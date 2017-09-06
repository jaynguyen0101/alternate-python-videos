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
	$qr = $conn->prepare("SELECT param, val FROM reviews_parameters WHERE review_id = ?");
	$qr->execute(array($_GET['rid']));
	print("<button onclick='window.open(\"\", \"_self\", \"\"); window.close();'>Close</button><br>");
	print("<pre>" . var_export($qr->fetchAll(), true) . "</pre>");
} catch (PDOException $e) {
	print "Conn. failed: " . $e->getMessage();
}
?>