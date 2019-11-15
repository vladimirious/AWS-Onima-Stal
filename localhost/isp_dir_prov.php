<?php 
session_start();
$err=0;
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

	$QUERY = "SELECT providers.*, dir_of_works.Work_name  FROM providers LEFT JOIN dir_of_works ON providers.Work_id=dir_of_works.Work_id WHERE Prov_id=".$_GET["prov"];
	$result=mysqli_query($link,$QUERY);
	$prov_info = mysqli_fetch_row($result);
	mysqli_free_result($result);
?>

<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Поставщик</title>
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="./css/bootstrap.min.css">
	<!-- Fluent Design Bootstrap -->
	<link rel="stylesheet" href="./css/fluent.css">
	<!-- Micon icons-->
	<link rel="stylesheet" href="./css/micon.min.css">
	<!--Custom style -->
	<style>
		body {
			background: url('img/bg.png') no-repeat center center fixed;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			background-size: cover;
			-o-background-size: cover;
			overflow: hidden;
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
		.my-custom-scrollbar {
			position: relative;
			height: 450px;
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
							<a href="isp_dir_projs"><img src="img/proj_sb_a.png" class="img"></a>
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
					
					<div class="row-fluid ml-3 ">
						<div class="col">
							<p class="sh1 mb-1">Поставщик №<?echo $_GET["prov"];?></p>
						</div>
					</div>
		  
					<div class="row-fluid ml-3 mt-5 ">
						<div class="col-md-12 ">
						
									<div class="row-fluid mr-3">
										<div class="col">
											<form action="" method="POST">
												<div class="row mt-3 mr-3 align-items-center" style="">
													<div class="col-md-2 pl-0 pr-0 mr-2 text-right" ><small>Поставщик:</small></div>
													<div class="col pl-0 pr-0"  >
														<input disabled class="col" type="text" value="<?echo $prov_info[1];?>" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(0,0,0,.10); font-size: small;">
													</div>
													<div class="col-md-1 pl-0 pr-0 ml-3 mr-2 text-right" ><small>КПП:</small></div>
													<div class="col pl-0 pr-0"  >
														<input disabled required class="col form-control" value="<?echo $prov_info[7];?>" name="kpp" type="number" placeholder="9 цифр" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(0,0,0,.10); font-size: small;">
													</div>
												</div>
												
												<div class="row mt-3 mr-3 align-items-center" style="">
													<div class="col-md-2 pl-0 pr-0 mr-2 text-right" ><small>Тип работ:</small></div>
													<div class="col pl-0 pr-0"  >
														<input disabled class="col" value="<?echo $prov_info[12];?>"  type="text"  style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(0,0,0,.10); font-size: small;">
													</div>
													<div class="col-md-1 pl-0 pr-0 ml-3 mr-2 text-right" ><small>ОГРН:</small></div>
													<div class="col pl-0 pr-0"  >
														<input disabled required class="col form-control" value="<?echo $prov_info[8];?>" name="ogrn" type="number" placeholder="13 цифр" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(0,0,0,.10); font-size: small;">
													</div>
												</div>

												<div class="row mt-3 mr-3 align-items-center" style="">
													<div class="col-md-2 pl-0 pr-0 mr-2 text-right" ><small>Юр. адрес:</small></div>
													<div class="col pl-0 pr-0"  >
														<input disabled required class="col form-control" value="<?echo $prov_info[2];?>" name="address" type="text" placeholder="индекс, страна, город, улица, дом, корпус" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(0,0,0,.10); font-size: small;">
													</div>
													<div class="col-md-1 pl-0 pr-0 ml-3 mr-2 text-right"><small>р/с:</small></div>
													<div class="col pl-0 pr-0">
														<input disabled required class="col form-control" value="<?echo $prov_info[9];?>" name="balance" type="number" placeholder="номер расчетного счета" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(0,0,0,.10); font-size: small;">
													</div>
													
												</div>

												<div class="row mt-3 mr-3 align-items-center" style="">
													<div class="col-md-2 pl-0 pr-0 mr-2 text-right" ><small>Контактное лицо:</small></div>
													<div class="col pl-0 pr-0"  >
														<input disabled required class="col form-control" value="<?echo $prov_info[5];?>" name="cont_name" type="text" placeholder="ФИО" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(0,0,0,.10); font-size: small;">
													</div>
													<div class="col-md-1 pl-0 pr-0 ml-3 mr-2"></div>
													<div class="col pl-0 pr-0"></div>
												</div>

												<div class="row mt-3 mr-3 align-items-center" style="">
													<div class="col-md-2 pl-0 pr-0 mr-2 text-right" ><small>Контактный тел.:</small></div>
													<div class="col pl-0 pr-0">
														<input disabled required class="col form-control" value="<?echo $prov_info[3];?>" name="tel_num" type="text" placeholder="номер телефона" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(0,0,0,.10); font-size: small;">
													</div>
													<div class="col-md-1 pl-0 pr-0 ml-3 mr-2"></div>
													<div class="col pl-0 pr-0"></div>
												</div>

												<div class="row mt-3 mr-3 align-items-center" style="">
													<div class="col-md-2 pl-0 pr-0 mr-2 text-right" ><small>Электронная почта:</small></div>
													<div class="col pl-0 pr-0">
														<input disabled required class="col form-control" value="<?echo $prov_info[6];?>" name="mail" type="email" placeholder="email@domain.com" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(0,0,0,.10); font-size: small;">
													</div>
													<div class="col-md-1 pl-0 pr-0 mr-2 ml-3 text-right" ></div>
													<div class="col pl-0 pr-0"  >
														
													</div>
												</div>

												<div class="row mt-3 mr-3 align-items-center" style="">
													<div class="col-md-2 pl-0 pr-0 mr-2 text-right" ><small>Комментарий:</small></div>
													<div class="col pl-0 pr-0">
														<input disabled required class="col form-control" value="<?echo $prov_info[4];?>" name="comment" type="text" placeholder="комментарий" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(0,0,0,.10); font-size: small;">
													</div>
													<div class="col-md-1 pl-0 pr-0 mr-2 ml-3 text-right" ></div>
													<div class="col pl-0 pr-0"  >
														
													</div>
												</div>

												<div class="row mt-3 mr-3 align-items-center" style="">
													<div class="col-md-2 pl-0 pr-0 mr-2 text-right" ><small>ИНН:</small></div>
													<div class="col pl-0 pr-0"  >
														<input disabled required class="col form-control" value="<?echo $prov_info[10];?>" name="inn" type="number" placeholder="12 цифр" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(0,0,0,.10); font-size: small;">
													</div>
													<div class="col-md-1 pl-0 pr-0 mr-2 ml-3 text-right" ></div>
													<div class="col pl-0 pr-0"  >
														
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
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