<?php 
session_start();
if (!isset($_SESSION['hash'])) 
{
	header("Location: login");
	exit;
}
if ($_SESSION['Interface']!='gen_dir')
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

if(isset($_POST['submit'])){
	
	if(!$link = mysqli_connect("localhost", "mysql", "mysql", "omima_stal"))
	{
		echo "Нет соединения с сервером"; 
		die();
	}
	$QUERY = "INSERT INTO tech_doc (Type_doc, Comments, Proj_id, Link) VALUES ('".$_POST['doc_type']."', '".$_POST['comment']."', ".$_GET["n"].", 0)";
	mysqli_query($link, $QUERY) or die("Ошибка 1 ".mysqli_error($link));
	
	$QUERY = "SELECT MAX(Tech_doc_id) FROM tech_doc WHERE Proj_id=".$_GET["n"];
	$result = mysqli_query($link, $QUERY) or die("Ошибка 2".mysqli_error($link));
	$tech_doc_id = mysqli_fetch_row($result);
	$tech_doc_id = $tech_doc_id[0];
	mysqli_free_result($result);
	
	$uploaddir = 'files/techichic_docs/';
	$my_string=$_FILES['userfile']['name'];
	$point_place = strrpos($my_string, '.');
	$my_string_len=strlen($my_string);
	$type_len = $my_string_len - $point_place;
	$_FILES['userfile']['name'] = "tech_doc_n".$tech_doc_id.substr($my_string, $point_place, $type_len);
	$uploadfile = $uploaddir.basename($_FILES['userfile']['name']);
	
	move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
	
	$QUERY = "UPDATE tech_doc SET Link='".$uploadfile."' WHERE Tech_doc_id=".$tech_doc_id;
	mysqli_query($link, $QUERY) or die("Ошибка 3 ".mysqli_error($link));
	
	header("Location: gen_dir_cont_prep?n=".$_GET["n"]);
	exit;
}	
?>
<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Новый технический документ</title>
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
							<a href="gen_dir_proj?n=<?echo $_GET['n']?>"><img src="img/back.png" class="img" title="К этапам проекта"></a>
						</div>
					</div>
					
					<div class="row-fluid">
						<div class="col text-center nopadding">
							<a href="gen_dir_projs"><img src="img/proj_sb_a.png" class="img" title="Проекты"></a>
						</div>
					</div>
					
					<div class="row-fluid">
						<div class="col text-center nopadding">
							<a href="gen_dir_effect"><img src="img/effect_sb.png" class="img" title="Эффективность"></a>
						</div>
					</div>
					
					<div class="row-fluid">
						<div class="col text-center nopadding">
							<a href="gen_dir_stat"><img src="img/gen_dir_stat_sb.png" class="img" title="Статистика"></a>
						</div>
					</div>
					
					<div class="row-fluid">
						<div class="col text-center nopadding">
							<a href="gen_dir_equip"><img src="img/equip_sb.png" class="img" title="Оборудование"></a>
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
							<p class="sh1 mb-1">Новый технический документ</p>
						</div>
					</div>
<!--############################################################################# -->
						<form action="" method="POST" enctype="multipart/form-data">
							<div class="row mt-5 mr-5 align-items-center" style="">
								<div class="col-md-3 text-right" style="">
									Тип документа:
								</div>
								<input required class="col form-control" name="doc_type" type="text" placeholder="введите тип документа" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;">
								<div class="col-md-3 ml-4">	</div>

							</div>
							
							
							<div class="row mt-3 mr-5 align-items-center" style="">
								<div class="col-md-3 text-right" style="">
									Загрузка:
								</div>
								<input type="hidden" name="MAX_FILE_SIZE" value="25000000"/>
								<label class="col" for="upload-file" id="upload-file-label" style="height:32px; border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small; padding-left: 1em; padding-top:0.5em;">Обзор...</label>
								<input required  name="userfile" id="upload-file" type="file" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, application/pdf, .docx">
								<div class="col-md-3 ml-4"></div>
							</div>

							<div class="row mt-3 mr-5 align-items-center" style="">
								<div class="col-md-3 text-right" style="">
									Комментарий:
								</div>
								<input class="col form-control" name="comment" type="text" placeholder="комментарий" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;">
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