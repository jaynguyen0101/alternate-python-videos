<?php
$out = array('spokespersonmov' => $_POST['spokespersonmov'],
	'bgmfile' => $_POST['bgmfile'],
	'lowerthirdmov' => $_POST['lowerthirdmov'],
	'ltfontcolor' => $_POST['ltfontcolor'],
	'ltfontcolor2' => $_POST['ltfontcolor2'],
	'resolution' => $_POST['resolution']);
file_put_contents("/hsphere/local/home/webrehab/ptclinic.com/practice/" . $_POST['pid'] . "/videosdefault.serialized", serialize($out));
?>