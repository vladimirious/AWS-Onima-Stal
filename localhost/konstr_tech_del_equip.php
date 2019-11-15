<?
session_start();
if (!isset($_SESSION['hash'])) 
{
	header("Location: login");
	exit;
}
if ($_SESSION['Interface']!='konstr_tech')
{
	header("Location: login");
	exit;
}
if(!$link = mysqli_connect("localhost", "mysql", "mysql", "omima_stal"))
{
	echo "Нет соединения с сервером"; 
	die();
}
if (isset($_GET['n']))
{
	if (isset($_GET['eq'])){
		$QUERY="DELETE FROM equip_for_proj WHERE Eq_proj_id =".$_GET['eq']." AND Proj_id=".$_GET["n"]." LIMIT 1";
		mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
		header("Location: konstr_tech_ktp?n=".$_GET["n"]."&to_equip=1");
	}
}	

?>