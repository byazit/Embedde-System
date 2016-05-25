<!DOCTYPE html>
<html>
<head>
<title>PiHome</title>
</head>

<body>

<div style="text-align:center">
    <h1>Raspberry Pi GPIO</h1>
<!--
<form action="index.php" method="post">
	<input type="image" src="forward.jpg" name="forward"  value="forward">
<br>
	<input type="image" src="left.jpg" name="left"  value="left">
	<input type="image" src="right.jpg" name="right"  value="right">

<br>
		<input type="image" src="backward.jpg" name="backward"  value="backward">
<br>
		<input type="image" src="stop.jpg" name="stop"  value="stop">
		<input type="submit" name="button"  value="GPIO">
    </div>
</form>
<a href="index.php?action=setPassword">Change Password</a></p>
-->
</body>
</html>
<?php

	include('db.php');
	$action = $_GET['action'];
	If ($action == "turnOn"){
		$pin = mysql_real_escape_string($_GET['pin']);
		db($pin,"0");
	}else If($_GET['action'] == "turnOff"){
		$pin = mysql_real_escape_string($_GET['pin']);
		db($pin,"1");		
		}
	echo picture();
function picture(){
	include('db.php');
	$query = mysql_query("SELECT pin,status FROM pinMap;");
	$totalGPIOCount = mysql_num_rows($query);
	echo "<table border='1'><tr><th>physical pin</th><th>pin status</th><th>view</th><th>switch</th></tr>";
	for($i=0;$i<$totalGPIOCount;$i++){
	echo "<tr>";
	$pinRow = mysql_fetch_assoc($query);
	$pinNumber=$pinRow['pin'];
	$pinStatus=$pinRow['status'];	
	echo "<th>".$pinNumber."</th><th>";
	echo $pinStatus."</th>";
	if($pinStatus!=0){
		$buttonValue = "Turn Off";
		$action = "turnOn";
		$image = "images/on.png";
		echo "<th><img src='".$image."' alt='Smiley face' height='42' width='42'></th>";
	}
	else{
		$buttonValue = "Turn On";
		$action = "turnOff";
		$image = "images/off.png";
		echo "<th><img src='".$image."' alt='Smiley face' height='42' width='42'></th>";
	}
	echo '<th><form name="pin' . $pinNumber . 'edit" action="index.php" method="get"><input type="hidden" name="action" value="' . $action . '"><input type="hidden" name="pin" value="' . $pinNumber . '"><input type="submit" value="' . $buttonValue . '"></form></th></tr>';
	}
	echo "</table><table border='1'><tr><th width='275px'><form action='index.php' method='post'><input type='image' src='stop.jpg' name='stop'  value='stop'></form></form></th></tr></table>";
	mysql_close();
}
function fileRead($num){
	$myFile = "example.txt";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = "$num\n";
	fwrite($fh, $stringData);
	fclose($fh);
}
function db($pin,$setting){
	include('db.php');
	//$setting = "1";
	//$pin=4;
	mysql_query("UPDATE pinMap SET status='$setting' WHERE pin='$pin';");
	mysql_close();
	header('Location: index.php');
}
function resetPinZero($id,$setting){
	include('db.php');
	//$setting = "1";
	//$pin=4;
	mysql_query("UPDATE pinMap SET status='$setting' WHERE id='$id';");
	mysql_close();
	header('Location: index.php');
}

if (isset($_POST['forward']) && ($_POST['forward'] == 'forward')) {
    echo "forward";
		fileRead("1");
		db("8","0");
		db("7","1");
/*		sleep(1);
		fileRead("0");
		header("Location: fileOne.php");*/
}
else if (isset($_POST['backward']) && ($_POST['backward'] == 'backward')) {
    echo "backward";
		db("7","0");
		db("8","1");
		fileRead("2");
}

else if (isset($_POST['left']) && ($_POST['left'] == 'left')) {
    echo "left";
		db("23","0");
		db("24","1");
		fileRead("2");
}
else if (isset($_POST['right']) && ($_POST['right'] == 'right')) {
    echo "right";
		db("24","0");
		db("23","1");
		fileRead("3");
}
else if (isset($_POST['stop']) && ($_POST['stop'] == 'stop')) {
		for($i=0;$i<=17;$i++)
			resetPinZero($i,0);
}
else if (isset($_POST['button']) && ($_POST['button'] == 'GPIO')) {
		echo picture();
}

?>
