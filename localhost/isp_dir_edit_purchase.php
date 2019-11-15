<?php 
session_start();
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
    
    exit;
}

if(!$link = mysqli_connect("localhost", "mysql", "mysql", "omima_stal"))
{
	echo "Нет соединения с сервером"; 
	die();
}

$QUERY= "SELECT supplies.Prov_id, Numb, supplies.Comments, providers.Prov_name, supplies.Link, supplies.Stat_4 FROM supplies LEFT JOIN providers ON supplies.prov_id=providers.prov_id WHERE Supp_id=".$_GET["doc"];
$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
$row = mysqli_fetch_row($result);	

mysqli_free_result($result);



if(isset($_POST['submit']))
{
	if($_POST['agreed']==0)
		$QUERY = "UPDATE supplies SET Stat_1=0, Comments='".$_POST['comment']."' WHERE Supp_id=".$_GET["doc"]." AND Proj_id=".$_GET["n"];
	else if ($_POST['agreed']==1)
		$QUERY = "UPDATE supplies SET Stat_1=1, Comments='".$_POST['comment']."' WHERE Supp_id=".$_GET["doc"]." AND Proj_id=".$_GET["n"];

	mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
	if ($row[5]==0) header("Location: isp_dir_purchase?n=".$_GET["n"]);
	else header("Location: isp_dir_ktp?n=".$_GET["n"]);
	exit;
}	

	
?>
<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Редактирование закупки</title>
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
				background-color: rgba(255,255,255,.8);
			}
		}
		
		.nopadding {
			padding: 0 !important;
			margin: 0 !important;
		}
		.exit {background-color: rgba(255,255,255,.0);}
		.exit:hover { background-color: rgba(232,17,35,.90)}
		
		label {
		   cursor: pointer;
		   /* Style as you please, it will become the visible UI component. */
		}

		#upload-file {
		   opacity: 0;
		   position: absolute;
		   z-index: -1;
		}
		
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
							<a href="isp_dirr_proj?n=<?echo $_GET['n']?>"><img src="img/back.png" class="img" title="К этапам проекта"></a>
						</div>
					</div>
					<div class="row-fluid">
						<div class="col text-center nopadding">
							<a href="isp_dirr_projs"><img src="img/proj_sb_a.png" class="img" title="Проекты"></a>
						</div>
					</div>
					<div class="row-fluid">
						<div class="col text-center nopadding">
						  <a href="isp_dirr_effect"><img src="img/effect_sb.png" class="img" title="Эффективность"></a>
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
					<div class="row-fluid ml-3 ">
						<div class="col">
							<p class="sh1 mb-1">Редактирование закупки №<?echo $_GET["doc"]?></p>
						</div>
					</div>
<!--############################################################################# -->
					
					<div class="row mt-5 mr-5 ml-3 align-items-center" style="">
						<div class="col-md-2 text-right" style="">
							Заказчик:
						</div>
							<input disabled class="col form-control" value="<?echo $row[3];?>" type="text" placeholder="" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(0,0,0,.10); font-size: small;" >
						
						<div class="col-md-3 ml-4"></div>
						
						
					</div>
					
					
					<div class="row mt-4 mr-5 ml-3 align-items-center" >
						<div class="col-md-2 text-right" style="">
							<?if($row[5]==0) echo "Количество:"; else echo "Доп. инф.:"?>
						</div>
						<input disabled class="col form-control" value="<?echo $row[1];?>" type="text" placeholder="количество" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(0,0,0,.10); font-size: small;" >
						<div class="col-md-3 ml-4">
						</div>
					</div>
					
					
					<div class="row mt-4 mr-5 ml-3 align-items-center" style="">
						<div class="col-md-2 text-right" style="">
							Загрузка:
						</div>
						<a href="<? echo $row[4];?>" target='_blank' style="padding-left: 11px;">Скачать</a>
						<div class="col-md-3 ml-4"></div>
					</div>
					
					<form class="" action="" method="POST">
					<div class="row mt-5 mr-5 ml-3 align-items-center" style="">
						<div class="col-md-2 text-right">
							Комментарий:
						</div>
						<input required class="col form-control" id="username" value="<?echo $row[2];?>" name="comment" type="text" placeholder="комментарий" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;" >
						<div class="col-md-3 ml-4" style=""></div>
					</div>
					
					<div class="row mt-4 mr-5 ml-3 align-items-center" style="">
						<div class="col-md-2 text-right">
							Согласовано:
						</div>
						<div class="col-md-2 p-0">
							<select required class="text-left pl-2 pr-2" name="agreed" style="height:35px; width:138px; border: 1px solid rgba(0,0,0,.40); background: rgba(255,255,255,.20);font-size: small;">
								<option selected value="">Не выбрано</option>
								<option value="1">Да</option>
								<option value="0">Нет</option>
							</select>
						</div>
						<div class="col" style=""></div>
					</div>
					
					<div class="row mt-4 mr-5 ml-3 align-items-center" style="">
						<div class="col-md-2 text-right"></div>
						<div class="col-md-2 pl-0">
							<button class="btn btn-primary btn-sm btn-block ml-0" type="submit" name="submit">Сохранить</button>
						</div>
						<div class="col">
						</div>
					</div>
	
					</form>
<!--############################################################################# -->
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