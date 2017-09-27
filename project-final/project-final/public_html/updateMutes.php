<?php
function updateMutes() {
	date_default_timezone_set('America/Los_Angeles');
	$date = date('Y/m/d');
	$cmdstr = "delete from mutes where endtime < TO_DATE('".$date."','YYYY/MM/DD')";
	executeSQL($cmdstr);
}

updateMutes();
?>