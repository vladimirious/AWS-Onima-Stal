<?php 
session_start();
$err = 0;
if (!isset($_SESSION['hash'])) 
{
	header("Location: login");
	exit;
}
if ($_SESSION['Interface']!='nach_sklada')
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

if (isset($_POST['submit']))
{	


	if ($_POST['stage']!=""){
		$QUERY="UPDATE supplies SET Stat_2=1 WHERE Supp_id=".$_POST['stage']." AND Proj_id=".$_GET["n"];
		mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
		//print_r ($_POST['submit']);
		//exit;
	}
	
}	
?>

<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Материалы на проект</title>
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
			-o-background-size: cover; 
			overflow:hidden;
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
		  height: 475px;
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
							<a href="nach_sklada_proj?n=<?echo $_GET['n']?>"><img src="img/back.png" class="img" title="К этапам проекта"></a>
						</div>
					</div>
					<div class="row-fluid">
						<div class="col text-center nopadding">
							<a href="nach_sklada_projs"><img src="img/proj_sb_a.png" class="img" title="Проекты"></a>
						</div>
					</div>
					<div class="row-fluid">
						<div class="col text-center nopadding">
							<a href="nach_sklada_equip"><img src="img/equip_sb.png" class="img"></a>
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
							<p class="sh1">Материалы на проект №<?echo $_GET["n"];?></p>
						</div>
					</div>
					<div class="row-fluid ml-3 mr-3">
						<div class="col ">
							
<?
$QUERY= "SELECT 
			Mat_proj_id, 
			Numb, 
			Comments, 
			S_section, 
			Arr_date, 
			Del_date,
			Name
		FROM 
			mater_for_proj 
		WHERE 
			Proj_id=".$_GET["n"];
$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
if($result)
{
	$rows = mysqli_num_rows($result); // количество полученных строк
//	echo $rows;
		if($rows==0) echo '<div style="color: black; opacity: 0.3">Материалов на проект не найдено. Проверьте этап закупок или подождите.</div>';
		else{
			echo '<div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar pr-3">
					<table class="table table-hover table-striped table-sm" style="overflow: auto">
						<thead>
							<tr>
									<th scope="col" class=""><small>№</small></th>
									<th scope="col" class=""><small>Наименование</small></th>
									<th scope="col" class=""><small>Количество</small></th>
									<th scope="col" class=""><small>Комментарий</small></th>
									<th scope="col" class=""><small>Хранение</small></th>
									<th scope="col" class=""><small>Дата поступления</small></th>
									<th scope="col" class=""><small>Дата последней выдачи</small></th>
									<th scope="col" class=""><small>Ред.</small></th>
							</tr>
						</thead>
					<tbody>';
			for ($i = 0 ; $i < $rows ; ++$i)
			{
				$row = mysqli_fetch_row($result);
				//print_r($result);
				echo "<tr>";
				echo "<td><small>".$row[0]."</small></td>";
				if($row[6]=="") echo "<td style='color: #DA3B01;'><small>Не назначено</small></td>";
				else echo "<td><small>".$row[6]."</small></td>";
				echo "<td><small>".$row[1]."</small></td>";
				echo "<td><small>".$row[2]."</small></td>";
				if($row[3]=="") echo "<td style='color: #DA3B01;'><small>Принимается</small></td>";
				else echo "<td><small>".$row[3]."</small></td>";
				echo "<td><small>".$row[4]."</small></td>";	
				if($row[5]=="") echo "<td><small>Не выдавалось</small></td>";
				else echo "<td><small>".$row[5]."</small></td>";
				echo "<td><a href='nach_sklada_edit_mat_for_pr?n=".$_GET["n"]."&mat=".$row[0]."'><small>Ред.</small></a></td></tr>";
			}
			echo '</tbody>
							</table>
						</div>';
			mysqli_free_result($result);
		}
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
	<script>

$(document).ready(function() {
  $('#stage').on('change', function() {
    var $form = $(this).closest('form');
    $form.find('input[type=submit]').click();
  });
});

	</script>
</body>

</html>