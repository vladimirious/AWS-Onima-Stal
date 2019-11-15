<?php 
session_start();
if (!isset($_SESSION['hash'])) 
{
		header("Location: login");
		exit;
}
if(!$link = mysqli_connect("localhost", "mysql", "mysql", "omima_stal"))
{
	echo "Нет соединения с сервером"; 
	die();
}

switch($_GET["stage"]){

	case "ZM":
		if($_GET["des"]=='true')
		{
			$QUERY = "UPDATE project_stages SET F_date_ZM='".date("Y-m-d")."' WHERE Proj_id=".$_GET["n"];

			mysqli_query($link, $QUERY) or die("Ошибка 1a ".mysqli_error($link));
		}
		else if($_GET["des"]=='false')
		{
			$QUERY = "UPDATE project_stages SET Stat_1=0 WHERE Proj_id=".$_GET["n"];

			mysqli_query($link, $QUERY) or die("Ошибка 1d ".mysqli_error($link));
		}
		break;
		
	case "KTR":
		if($_GET["des"]=='true')
		{
			$QUERY = "UPDATE project_stages SET F_date_KTR='".date("Y-m-d")."' WHERE Proj_id=".$_GET["n"];

			mysqli_query($link, $QUERY) or die("Ошибка 2a ".mysqli_error($link));
		}
		else if($_GET["des"]=='false')
		{
			$QUERY = "UPDATE project_stages SET Stat_2=0 WHERE Proj_id=".$_GET["n"];

			mysqli_query($link, $QUERY) or die("Ошибка 2d ".mysqli_error($link));
		}
		break;
		
	case "PR":
		if($_GET["des"]=='true')
		{
			$QUERY = "UPDATE project_stages SET F_date_PR='".date("Y-m-d")."' WHERE Proj_id=".$_GET["n"];

			mysqli_query($link, $QUERY) or die("Ошибка 3a ".mysqli_error($link));
		}
		else if($_GET["des"]=='false')
		{
			$QUERY = "UPDATE project_stages SET Stat_3=0 WHERE Proj_id=".$_GET["n"];

			mysqli_query($link, $QUERY) or die("Ошибка 3d ".mysqli_error($link));
		}
		break;		

	case "OZ":
		if($_GET["des"]=='true')
		{
			$QUERY = "UPDATE project_stages SET F_date_OZ='".date("Y-m-d")."' WHERE Proj_id=".$_GET["n"];

			mysqli_query($link, $QUERY) or die("Ошибка 4a ".mysqli_error($link));
		}
		else if($_GET["des"]=='false')
		{
			$QUERY = "UPDATE project_stages SET Stat_4=0 WHERE Proj_id=".$_GET["n"];

			mysqli_query($link, $QUERY) or die("Ошибка 4d ".mysqli_error($link));
		}
		break;
}

header("Location: isp_dir_proj?n=".$_GET["n"]."");