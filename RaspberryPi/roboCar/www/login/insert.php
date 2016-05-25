<?php
	$host='localhost';
	$uname='root';
	$pwd='#razib3417#';
	$db="northpole";

	$con = mysql_connect($host,$uname,$pwd) or die("connection failed");
	mysql_select_db($db,$con) or die("db selection failed");
	 
	$date = date('Y-m-d');
	$time = date('H:i:s');
	
	$LongOne=$_REQUEST['long'];
	$short=$_REQUEST['short'];
	echo $id;
	//$name=$_REQUEST['name'];

	$flag['code']=0;

	if($r=mysql_query("insert into insulin (short,LongOne,date,time) values('$short','$LongOne','$date','$time') ",$con))
	{
		$flag['code']=1;
		//echo"hi";
	}

	print(json_encode($flag));
	mysql_close($con);
?>
