<?php
function connect()
{
	$con =mysqli_connect('us-cdbr-iron-east-05.cleardb.net','b9fbb465685cfb','2cbe13c4','heroku_50a0b95082611ce');
	if($con)
	{
		mysqli_set_charset($con,'utf8');
		return $con;
	}
	else
	{
		die('connect fail');exit();
	}
}

?>