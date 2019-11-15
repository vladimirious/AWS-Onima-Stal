<?php 
session_start();
if (!isset($_SESSION['hash'])) 
{
	header("Location: login");
	exit;
}
if ($_SESSION['Interface']!='buhgal')
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
$QUERY = "SELECT Contr_N, Link, Comments, Stat_1, Stat_2, Stat_3, Cust_id FROM contracts WHERE Proj_id=".$_GET["n"];
$result = mysqli_query($link, $QUERY) or die("Ошибка 1 ".mysqli_error($link));
$contract = mysqli_fetch_row($result);
		



if(isset($_POST['submit'])){

	if ($_FILES['userfile']['name']!=""){
		if($contract[1]!=""){
			unlink($contract[1]);
		}
		$uploaddir = 'files/contracts/';
		$my_string=$_FILES['userfile']['name'];
		$point_place = strrpos($my_string, '.');
		$my_string_len=strlen($my_string);
		$type_len = $my_string_len - $point_place;
		$_FILES['userfile']['name'] = "contract_n".$_GET["n"].substr($my_string, $point_place, $type_len);
		
		$uploadfile = $uploaddir.basename($_FILES['userfile']['name']);
		if(move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
		{
			//case
			if(($_POST['checked']=="")&&($_POST['paid']=="")){
				$QUERY = "UPDATE contracts SET Contr_N=".$_POST['contract_num'].", Comments='".$_POST['comment']."', Link='".$uploadfile."' WHERE Proj_id=".$_GET["n"];
			}
			else if(($_POST['checked']!="")&&($_POST['paid']=="")){
					$QUERY = "UPDATE contracts SET Contr_N=".$_POST['contract_num'].", Comments='".$_POST['comment']."', Link='".$uploadfile."', Stat_1=".$_POST['checked']." WHERE Proj_id=".$_GET["n"];
			}
			else if(($_POST['checked']=="")&&($_POST['paid']!="")){
					$QUERY = "UPDATE contracts SET Contr_N=".$_POST['contract_num'].", Comments='".$_POST['comment']."', Link='".$uploadfile."', Stat_3=".$_POST['paid']." WHERE Proj_id=".$_GET["n"];
					$FINISH_STAGE_QUERY= "UPDATE project_stages SET F_date_SM='".date("Y-m-d")."' WHERE Proj_id=".$_GET["n"];
					mysqli_query($link, $FINISH_STAGE_QUERY) or die("Ошибка ".mysqli_error($link));
			}
			mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
			header("Location: buhgal_cont_prep?n=".$_GET["n"]);
			exit;
		}
		else echo "Ошибка!";
	}
	else{
		if(($_POST['checked']=="")&&($_POST['paid']=="")){
				$QUERY = "UPDATE contracts SET Contr_N=".$_POST['contract_num'].", Comments='".$_POST['comment']."' WHERE Proj_id=".$_GET["n"];
		}
		else if(($_POST['checked']!="")&&($_POST['paid']=="")){
				$QUERY = "UPDATE contracts SET Contr_N=".$_POST['contract_num'].", Comments='".$_POST['comment']."', Stat_1=".$_POST['checked']." WHERE Proj_id=".$_GET["n"];
		}
		else if(($_POST['checked']=="")&&($_POST['paid']!="")){
				$QUERY = "UPDATE contracts SET Contr_N=".$_POST['contract_num'].", Comments='".$_POST['comment']."', Stat_3=".$_POST['paid']." WHERE Proj_id=".$_GET["n"];
				$FINISH_STAGE_QUERY= "UPDATE project_stages SET F_date_SM='".date("Y-m-d")."' WHERE Proj_id=".$_GET["n"];
				mysqli_query($link, $FINISH_STAGE_QUERY) or die("Ошибка ".mysqli_error($link));
		}
		mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
		header("Location: buhgal_cont_prep?n=".$_GET["n"]);
		exit;
	}
}	
?>
<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Редактирование договора</title>
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
		#checked, #paid {border-radius:0px;}
		
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
							<a href="buhgal_proj?n=<?echo $_GET['n']?>"><img src="img/back.png" class="img" title="К этапам проекта"></a>
						</div>
					</div>
					
					<div class="row-fluid">
						<div class="col text-center nopadding">
							<a href="buhgal_projs"><img src="img/proj_sb_a.png" class="img" title="Проекты"></a>
						</div>
					</div>
					
					<div class="row-fluid">
						<div class="col text-center nopadding">
							<a href="buhgal_employ"><img src="img/buhgal_employ_sb.png" class="img" title="Сотрудники"></a>
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
							<p class="sh1 mb-1">Редактирование договора</p>
						</div>
					</div>
<!--############################################################################# -->
						<form action="" method="POST" enctype="multipart/form-data">
							<div class="row mt-5 mr-5 align-items-center" style="">
								<div class="col-md-3 text-right" style="">
									Номер договора:
								</div>
								<input  <?if($contract[4]==1)echo "readonly".' title="Договор подписан"';?> required class="col form-control" name="contract_num" type="number" value="<?echo $contract[0];?>"placeholder="введите номер договора" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;">
								<div class="col-md-3 ml-4">	</div>

							</div>
							
							<div class="row mt-3 mr-5 align-items-center" style="">
								<div class="col-md-3 text-right" style="">
									Загрузка:
								</div>
								<input type="hidden" name="MAX_FILE_SIZE" value="15000000"/>
								<label class="col" for="upload-file" id="upload-file-label" style="height:33px; border: 1px solid rgba(0,0,0,.50); background: rgba(255,255,255,.20); font-size: small;padding-left: 1em; padding-top:0.5em;">Заменить</label>
								<input  name="userfile" id="upload-file" type="file" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, application/pdf, .docx">
								<div class="col-md-3 ml-4"></div>
							</div>

							<div class="row mt-3 mr-5 align-items-center" style="">
								<div class="col-md-3 text-right" style="">
									Комментарий:
								</div>
								<input class="col form-control" name="comment" type="text" value="<?echo $contract[2];?>" placeholder="комментарий" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;">
								<div class="col-md-3 ml-4"></div>
							</div>
							
							<div class="row mt-3 mr-5 align-items-center" style="">
								<div class="col-md-3 text-right" style="">
									Проверен:
								</div>
								<select <?if($contract[4]==1)echo "disabled".' title="Уже был проверен"';?> class="col text-left pr-3 form-control"  name="checked" id="checked" style="height:38px; border: 1px solid #707070; background-color: rgba(255,255,255,.20);font-size: small;">
									<option <?if($contract[3]==0) echo "selected";?> value ="0" >Нет</option>";
									<option <?if($contract[3]==1) echo "selected";?> value ="1" >Да</option>";
								</select>
								<div class="col-md-3 ml-4"></div>
							</div>
							
							<div class="row mt-3 mr-5 align-items-center" style="">
								<div class="col-md-3 text-right" style="">
									Подписан:
								</div>
								<div class="col text-left pr-3" style="height:35px; border: 1px solid #707070; background-color: rgba(0,0,0,.1);font-size: small; padding-top: 0.33rem;">
									<?if($contract[4]==0) echo "Нет"; else echo "Да";?>
								</div>
								<div class="col-md-3 ml-4"></div>
							</div>

							<div class="row mt-3 mr-5 align-items-center" style="">
								<div class="col-md-3 text-right" style="">
									Оплачен:
								</div>
								<select <?if(($contract[3]==0)||($contract[4]==0)||($contract[5]==1))echo "disabled".' title="Доступно после проверки и подписания или договор уже оплачен"';?> class="col text-left pr-3 form-control"  name="paid" id="paid" style="height:38px; border: 1px solid #707070; background-color: rgba(255,255,255,.20);font-size: small;">
									<option <?if($contract[5]==0) echo "selected";?> value ="0" >Нет</option>";
									<option <?if($contract[5]==1) echo "selected";?> value ="1" >Да</option>";
								</select>
								<div class="col-md-3 ml-4"></div>
							</div>
							
							<div class="row mt-3 mr-5 align-items-center" style="">
								<div class="col-md-3 text-right" style=""></div>
								<div class="col-md-2 p-0" name="cust_id">
									<button class="btn btn-primary btn-sm btn-block m-0" type="submit" name="submit"><small>Сохранить</small></button>
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