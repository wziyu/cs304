<?php
function echoRows($statement) {
	$i=0;
	while($r = oci_fetch_assoc($statement)) {
		echo $r['CONTENT'];
		// $i++;
		// foreach($r as $key=>$val) {
		// 	echo $i." ".$key." ".$val."<br>";
		// }
	}
}
?>