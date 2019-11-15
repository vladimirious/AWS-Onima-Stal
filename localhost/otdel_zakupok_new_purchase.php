<?php 
session_start();
if (!isset($_SESSION['hash'])) 
{
	header("Location: login");
	exit;
}
if ($_SESSION['Interface']!='otdel_zakupok')
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

if(isset($_POST['submit'])){
	$QUERY = "INSERT INTO supplies (Prov_id, Numb, Comments, Stat_4, Proj_id) VALUES (".$_POST['prov_id'].", '".$_POST['number']."', '".$_POST['comment']."', 0, ".$_GET["n"].")";
	mysqli_query($link, $QUERY) or die("Ошибка 1 ".mysqli_error($link));
	
	$QUERY = "SELECT MAX(Supp_id) FROM supplies WHERE Stat_4=0 AND Proj_id=".$_GET["n"];
	$result = mysqli_query($link, $QUERY) or die("Ошибка 2".mysqli_error($link));
	$supp_id = mysqli_fetch_row($result);
	$supp_id = $supp_id[0];
	mysqli_free_result($result);
	
	$uploaddir = 'files/purchase_docs/';
	$my_string=$_FILES['userfile']['name'];
	//echo $my_string."<BR>";
	$point_place = strrpos($my_string, '.');
	$my_string_len=strlen($my_string);
	$type_len = $my_string_len - $point_place;
	$_FILES['userfile']['name'] = "purchase_n".$supp_id.substr($my_string, $point_place, $type_len);
	$uploadfile = $uploaddir.basename($_FILES['userfile']['name']);
	//echo $uploadfile;
	move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
	
	$QUERY = "UPDATE supplies SET Link='".$uploadfile."' WHERE Supp_id=".$supp_id;
	mysqli_query($link, $QUERY) or die("Ошибка 3 ".mysqli_error($link));
	
	header("Location: otdel_zakupok_purchase?n=".$_GET["n"]);
	exit;
}	
?>
<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Новая закупка</title>
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
							<a href="otdel_zakupok_proj?n=<?echo $_GET['n']?>"><img src="img/back.png" class="img" title="К этапам проекта"></a>
						</div>
					</div>
					
					<div class="row-fluid">
						<div class="col text-center nopadding">
							<a href="otdel_zakupok_projs"><img src="img/proj_sb_a.png" class="img" title="Проекты"></a>
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
							<p class="sh1 mb-1">Новая закупка</p>
						</div>
					</div>
<!--############################################################################# -->
					<form class="ml-4 mt-5" action="" method="POST" enctype="multipart/form-data">
					<div class="row mt-4 mr-5 align-items-center" style="">
						<div class="col-md-2 text-right" style="">
							Поставщик:
						</div>
							<select required class="col text-left pr-3" name="prov_id" style="height:35px; border: 1px solid rgba(0,0,0,.40); background: rgba(255,255,255,.20);font-size: small;">
							<option value ="">Не выбран</option>
							
<?php
	$QUERY ="SELECT
		Prov_id,
		Prov_name
	FROM
		providers";

	$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
	if($result)
	{
		$rows = mysqli_num_rows($result);
		if ($rows){
			for ($i = 0 ; $i < $rows ; ++$i)
			{
				$row = mysqli_fetch_row($result);
				//print_r($result);
				if($i==0)echo "<option value =".$row[0].">".$row[1]."</option>";
				else echo "<option value = ".$row[0].">".$row[1]."</option>";
			}
			mysqli_free_result($result);
		}
	}
?>

						</select>
						
						<button class="col-md-3 btn btn-secondary btn-sm ml-4 mr-0" onClick='location.href="otdel_zakupok_new_prov?n=<?echo $_GET["n"];?>"' type="button" style="text-transform:none">Добавить нового поставщика</button>
						
						
					</div>
					
					
					<div class="row mt-4 mr-5 align-items-center" >
						<div class="col-md-2 text-right" style="">
							Количество:
						</div>
						<input required class="col form-control" id="username" name="number" type="text" placeholder="количество" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;" >
						<div class="col-md-3 ml-4">
						</div>
					</div>
					
					
					<div class="row mt-4 mr-5 align-items-center" style="">
						<div class="col-md-2 text-right" style="">
							Загрузка:
						</div>
						<input type="hidden" name="MAX_FILE_SIZE" value="25000000"/>
						<label class="col" for="upload-file" id="upload-file-label" style="height:35px; border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small; padding-left: 1rem; padding-top:0.33rem;">Обзор...</label>
						<input required  name="userfile" id="upload-file" type="file" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, application/pdf, .docx">
						<div class="col-md-3 ml-4"></div>
					</div>
					
					<div class="row mt-4 mr-5 align-items-center" style="">
						<div class="col-md-2 text-right">
							Комментарий:
						</div>
						<input required class="col form-control" id="username" name="comment" type="text" placeholder="комментарий" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;" >
						<div class="col-md-3 ml-4" style=""></div>
					</div>
					
					<div class="row mt-4 mr-5 align-items-center" style="">
						<div class="col-md-2 text-right">
							
						</div>
						<div class="col-md-2 pl-0">
							<button class="btn btn-primary btn-sm btn-block ml-0" type="submit" name="submit"><small>Сохранить</small></button>
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
	<script>
		window.onload=function(){
			function control(){
				var current = document.getElementById("upload-file").value
				if(upload_file != current){
					upload_file_label.innerHTML = current;
					clearInterval(timerId);
				}
			}
			upload_file_label = document.getElementById("upload-file-label");
			const upload_file = document.getElementById("upload-file").value;

			upload_file_label.addEventListener("click", function() {
				control();
				timerId = setInterval(control, 100);
				
			});
		}
	
	</script>
	<!-- JQuery -->
	<script type="text/javascript" src="./js/jquery-3.3.1.min.js"></script>
    <!-- Bootstrap tooltips -->
	<script type="text/javascript" src="./js/popper.min.js"></script>
  	<!-- Bootstrap core JavaScript -->
	<script type="text/javascript" src="./js/bootstrap.min.js"></script>
</body>

</html>