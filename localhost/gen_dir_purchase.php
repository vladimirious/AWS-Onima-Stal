<?php 
session_start();
$err = 0;
if (!isset($_SESSION['hash'])) 
{
	header("Location: login");
	exit;
}
if ($_SESSION['Interface']!='isp_dir')
{
	header("Location: login");
	exit;
}

if (isset($_POST['logout']))
{
	unset($_SESSION['User_id']);
	unset($_SESSION['hash']);
	unset($_SESSION['Interface']);
    session_destroy();
    header("Location: login");
    exit;
}	


if(!$link = mysqli_connect("localhost", "mysql", "mysql", "omima_stal"))
{
	echo "Нет соединения с сервером"; 
	die();
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Закупки</title>
    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="./css/bootstrap.min.css">
    <!-- Fluent Design Bootstrap -->
	<link rel="stylesheet" href="./css/fluent.css">
    <!-- Micon icons-->
	<link rel="stylesheet" href="./css/micon.min.css">
    <!--Custom style -->
	<style>
		body{
			background: url('img/bg.png') no-repeat center center fixed;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			background-size: cover;
			-o-background-size: 
			cover; overflow:hidden;
			min-height: 700px
		}
		/* Delete it if you don't want to have black/white colors and forced font-weight */ 
		.form-control::-webkit-input-placeholder { color: rgba(0,0,0,0.3); }  /* WebKit, Blink, Edge */
		.form-control:-moz-placeholder { color: rgba(0,0,0,0.3); }  /* Mozilla Firefox 4 to 18 */
		.form-control::-moz-placeholder { color: rgba(0,0,0,0.3); }  /* Mozilla Firefox 19+ */
		.form-control:-ms-input-placeholder { color: rgba(0,0,0,0.3); }  /* Internet Explorer 10-11 */
		.form-control::-ms-input-placeholder { color: rgba(0,0,0,0.3); }  /* Microsoft Edge */

		.side-bar {
			-webkit-backdrop-filter: blur(20px) saturate(125%);
			backdrop-filter: blur(20px) saturate(125%);
			background-color: rgba(0,0,0,.3);
		}
		.main-w {
			-webkit-backdrop-filter: blur(20px) saturate(125%);
			backdrop-filter: blur(20px) saturate(125%);
			background-color: rgba(255,255,255,.4);
		}
		@supports not ((-webkit-backdrop-filter: blur(20px)) or (backdrop-filter: blur(20px))){
			.side-bar {
			background-color: rgba(0,0,0,.7);
			}
			.main-w {
				background-color: rgba(255,255,255,.9);
			}
		}
		.nopadding {
			padding: 0 !important;
			margin: 0 !important;
		}
		.my-custom-scrollbar {
		  position: relative;
		  height: 415px;
		  overflow: auto;
		}
		.table-wrapper-scroll-y {
		  display: block;
		}
		.exit {background-color: rgba(255,255,255,.0);}
		.exit:hover { background-color: rgba(232,17,35,.90)}
  </style>

</head>

<body>
<!-- Start your project here-->
<div style="height: 100%; width: 100%; left: 0; top: 0; position: fixed; display: flex; align-items: center; align-content: center; justify-content: center;">
<!--  <div class="main-w" style="width: 1200px; height:735px;">Max-height 100%</div>-->
	<div class="container">
		<div class="row justify-content-md-center" style="width:1080px;">
			<div class="col-fluid" >
				<div class="side-bar" style="width: 100px; height:661px;">
	
					<div class="row-fluid">
						<div class="col text-center nopadding">
							<a href="isp_dir_proj?n=<?echo $_GET['n']?>"><img src="img/back.png" class="img" title="К этапам проекта"></a>
						</div>
					</div>
					<div class="row-fluid">
						<div class="col text-center nopadding">
							<a href="isp_dir_projs"><img src="img/proj_sb_a.png" class="img" title="Проекты"></a>
						</div>
					</div>
					<div class="row-fluid">
						<div class="col text-center nopadding">
						  <a href="isp_dir_effect"><img src="img/effect_sb.png" class="img" title="Эффективность"></a>
						</div>
					</div>
				</div>
			</div>
			
			
			<div class="col-fluid">
				<div class="main-w" style="width: 980px; height:661px;">
					<div class="row-fluid">
						<div class="col text-right nopadding" >
							<button class="exit" type="button" data-target="#exampleModal2" data-toggle="modal" style="border: none;">
								<img src="img/exit-b.png" class="img">
							</button>
						</div>
					</div>
					<div class="row-fluid ml-3">
						<div class="col">
							<p class="sh1">Закупки</p>
						</div>
					</div>
					<div class="row-fluid ml-3 mr-3">
						<div class="col">
							
<?
$QUERY= "SELECT supplies.Supp_id, providers.Prov_name, supplies.Numb, supplies.Comments, supplies.Stat_2, supplies.Stat_3, supplies.Stat_1, supplies.Link FROM supplies LEFT JOIN providers ON supplies.Prov_id=supplies.Prov_id WHERE Proj_id=".$_GET["n"]." AND Stat_4=0";
$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
if($result)
{
	$rows = mysqli_num_rows($result); // количество полученных строк
//	echo $rows;
		if($rows==0) echo '<div style="color: black; opacity: 0.3">Закупки не найдены</div>';
		for ($i = 0 ; $i < $rows ; ++$i)
		{
			echo '<div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar pr-3">
					<table class="table table-hover table-striped table-sm" style="overflow: auto">
						<thead>
							<tr>
								<th scope="col" class="">№</th>
								<th scope="col" class="">Поставщик</th>
								<th scope="col" class="">Количество</th>
								<th scope="col" class="">Комментарий</th>
								<th scope="col" class="">Статус</th>
								<th scope="col" class="">Согласовано</th>
								<th scope="col" class="">Загрузка</th>
							</tr>
						</thead>
						<tbody>
							<tr>';
			$row = mysqli_fetch_row($result);
				//print_r($result);
			echo "<td>".$row[0]."</td>";
			echo "<td>".$row[1]."</td>";
			echo "<td>".$row[2]."</td>";
			echo "<td>".$row[3]."</td>";
			if($row[6]=="") echo "<td>На согласовании</td>";
			else if (($row[6]==1)&&($row[4]==0)) echo "<td>Оформление</td>";
			else if (($row[6]==1)&&($row[4]==1)&&($row[5]==0)) echo "<td>Доставляется</td>";
			else if (($row[6]==1)&&($row[4]==1)&&($row[5]==1)) echo "<td>Получено</td>";

				
			if($row[6]=="") echo "<td class='text-center'><a href='isp_dir_edit_purchase?n=".$_GET["n"]."&doc=".$row[0]."' style='color:#FF8C00' title='Нажмите, чтобы перейти к редактирванию закупки.'>Ожидается</a></td>";			
			else if ($row[6]==0) echo "<td class='text-center' style='color:#DA3B01'>Нет</td>";
			else if ($row[6]==1) echo "<td class='text-center' style='color:#107C10'>Да</td>";
			echo "<td class='text-center'><a href='".$row[7]."' target='_blank'>Скачать</a></td>";
			echo "</tr>						
						</tbody>
						</table>
					</div>";
		}
		mysqli_free_result($result);
}

?>




						</div>
					</div>
				</div>
			</div>





        </div>
	</div>
</div>
<div tabindex="-1" class="modal fade" id="exampleModal2" role="dialog" aria-hidden="true" aria-labelledby="exampleModalLabel2" style="display: none;">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel2">Выход из системы</h5>
					<button class="close" aria-label="Close" type="button" data-dismiss="modal">
						<span aria-hidden="true">×</span>
					</button>
			</div>
			<div class="modal-body">Вы хотите завершить работу?</div>
			<div class="modal-footer">
				<button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Отмена</button>
				<form action="" method="POST"><button class="btn btn-danger btn-sm" name="logout" value="logout" type="submit">Выйти</button></form>
			</div>
		</div>
	</div>
</div>
	<!-- Scripts -->
	<!-- JQuery -->
  <script type="text/javascript" src="./js/jquery-3.3.1.min.js"></script>
    <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="./js/popper.min.js"></script>
  	<!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="./js/bootstrap.min.js"></script>
</body>

</html>