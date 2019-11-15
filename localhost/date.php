<?php
//$date =0;
if (isset($_POST["submit"])){
	echo $_POST["date"]."<BR>";
	echo $_POST["name"];
	//$date = $_POST["date"];
}

	echo '<form method="POST"><input name="date" value="" type="date">';
	echo '<button class="" type="submit" name="submit">Отправить</button>';
	echo '<input name="name" value="Hi" type="text"></form>';
		

	//echo "<BR>".(idate('Y')-18)."-".date("m-d");
?>

