<html>
<?php
include("execute.php");

select u1.username from Users u1,Follows f1 where u1.username=f1.followee_username AND f1.follower_username IN (select f2.followee_username from follows f2,Users u2 where u2.username=f2.follower_username AND u2.username='A');

$r=executeSQL($stid);
while ($row = oci_fetch_array($stid, OCI_BOTH)) {
	echo'<a href =profile.php?username='.$row[0].' target="_blank"> '.$row[0].'</a> </br>';
}



?>
</html>