<?php 
session_start();
$err=0;
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

function form_control($string){
	$string=str_replace('"', "", $string);
	$string=str_replace("'", "", $string);
	return $string;
}

if(!$link = mysqli_connect("localhost", "mysql", "mysql", "omima_stal"))
{
	echo "Нет соединения с сервером"; 
	die();
}

if(isset($_POST['submit']))
{
	$result = mysqli_query($link,"SELECT Prov_name FROM providers WHERE Prov_name = '".$_POST['cust_name']."'");
	$result = mysqli_num_rows($result);
	if($result){
		$err=1;
		//echo "Заказчик с таким именем уже существует";
	}
	else
	{
	
		if(($_POST['work_id']=="no")&&($_POST['new_type_of_work']!="")){
			mysqli_query($link, 'INSERT INTO dir_of_works (Work_id, Work_name) VALUES (default, "'.$_POST['new_type_of_work'].'")') or die("Ошибка 1 ".mysqli_error($link));
			$result = mysqli_query($link, 'SELECT Work_id FROM dir_of_works WHERE Work_name="'.$_POST['new_type_of_work'].'"') or die("Ошибка 2 ".mysqli_error($link));
			$work_id = mysqli_fetch_row($result);
			$work_id = $work_id[0];
			mysqli_free_result($result);
			
			$QUERY = 'INSERT INTO 
				providers (
					Prov_name,
					Work_id,
					Prov_tel,
					Cont_prov_name,
					E_mail,
					Kpp,
					OGRN,
					Check_acc,
					ITN,
					Addr ,
					Comments 
				) 
				VALUES (
					"'.form_control($_POST['prov_name']).'",
					'.$work_id.',
					"'.$_POST['tel_num'].'",
					"'.$_POST['cont_name'].'",
					"'.$_POST['mail'].'",
					'.$_POST['kpp'].',
					'.$_POST['ogrn'].',
					'.$_POST['balance'].',
					'.$_POST['inn'].',
					"'.form_control($_POST['address']).'",
					"'.$_POST['comment'].'"
				)';
			//echo $QUERY;
			mysqli_query($link, $QUERY) or die("Ошибка submit".mysqli_error($link));
			header("Location: otdel_zakupok_new_purchase?n=".$_GET["n"]);
			//exit;
			
		} else if (($_POST['work_id']!="no")&&($_POST['new_type_of_work']=="")){
			$QUERY = 'INSERT INTO 
				providers (
					Prov_name,
					Work_id,
					Prov_tel,
					Cont_prov_name,
					E_mail,
					Kpp,
					OGRN,
					Check_acc,
					ITN,
					Addr,
					Comments 
				) 
				VALUES (
					"'.form_control($_POST['prov_name']).'",
					'.$_POST['work_id'].',
					"'.$_POST['tel_num'].'",
					"'.$_POST['cont_name'].'",
					"'.$_POST['mail'].'",
					'.$_POST['kpp'].',
					'.$_POST['ogrn'].',
					'.$_POST['balance'].',
					'.$_POST['inn'].',
					"'.form_control($_POST['address']).'",
					"'.$_POST['comment'].'"
				)';
			//echo $QUERY;
			mysqli_query($link, $QUERY) or die("Ошибка submit".mysqli_error($link));
			header("Location: otdel_zakupok_new_purchase?n=".$_GET["n"]);
			//exit;
		}
		else $err=2;
		
		
	}
}
//SELECT manning_table.M_t_id, COUNT(employees.TAB_N) FROM employees RIGHT JOIN manning_table ON employees.M_t_id = manning_table.M_t_id GROUP BY manning_table.M_t_id
?>

<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Новый поставщик</title>
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
							<a href="otdel_zakupok_proj?n=<?echo $_GET['n']?>"><img src="img/back.png" class="img" title="К этапам проекта"></a>
						</div>
					</div>
					
					<div class="row-fluid">
						<div class="col text-center nopadding">
							<a href="otdel_zakupok_projs"><img src="img/proj_sb_a.png" class="img"></a>
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
							<p class="sh1 mb-1">Новый поставщик</p>
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
														<input required class="col form-control" <?if($err==1)echo "title='Поставщик с таким именем уже зарегестрирован в системе';";?> name="prov_name" type="text" placeholder="наименование поставщика" style="border: 1px solid <?if($err==1)echo "rgba(255,0,0,.40);"; else echo "rgba(0,0,0,.40);";?> background-color: rgba(255,255,255,.20); font-size: small;">
													</div>
													<div class="col-md-1 pl-0 pr-0 ml-3 mr-2 text-right" ><small>ИНН:</small></div>
													<div class="col pl-0 pr-0"  >
														<input required class="col form-control" name="inn" type="number" placeholder="12 цифр" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;">
													</div>
												</div>
												
												<div class="row mt-3 mr-3 align-items-center" style="">
													<div class="col-md-2 pl-0 pr-0 mr-2 text-right" ><small>Тип работ:</small></div>
													<div class="col pl-0 pr-0"  >

													<select class="col text-left" name="work_id" id="work_id" style="height:35px; border: 1px solid <?if($err==2)echo "rgba(255,0,0,.40);"; else echo "rgba(0,0,0,.40);";?>  background: rgba(255,255,255,.20); font-size: small; padding-left: 10px;">
<?						
	$QUERY ="SELECT
		Work_id,
		Work_name
	FROM
		dir_of_works";
	
	$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
	echo "<option selected value ='no'>Не выбран</option>";
	if($result)
	{
		$rows = mysqli_num_rows($result);
		if ($rows){
			
			for ($i = 0 ; $i < $rows ; ++$i)
			{
				$row = mysqli_fetch_row($result);
				//print_r($result);
				echo "<option value = ".$row[0].">".$row[1]."</option>";
			}
			mysqli_free_result($result);
		}
	}
?>			
													</select>

													</div>
													<div class="col-md-1 pl-0 pr-0 ml-3 mr-2 text-right" ><small>КПП:</small></div>
													<div class="col pl-0 pr-0"  >
														<input required class="col form-control" name="kpp" type="number" placeholder="9 цифр" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;">
													</div>
												</div>

												<div class="row mt-3 mr-3 align-items-center" style="">
													<div class="col-md-2 pl-0 pr-0 mr-2 text-right" ></div>
													<div class="col pl-0 pr-0"  >
														<input class="col form-control" id="username" name="new_type_of_work" type="text" placeholder="новый тип работ" style="border: 1px solid <?if($err==2)echo "rgba(255,0,0,.40);"; else echo "rgba(0,0,0,.40);";?> background-color: rgba(255,255,255,.20); font-size: small;">
													</div>
													<div class="col-md-1 pl-0 pr-0 ml-3 mr-2 text-right" ><small>ОГРН:</small></div>
													<div class="col pl-0 pr-0"  >
														<input required class="col form-control" name="ogrn" type="number" placeholder="13 цифр" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;">
													</div>
													
												</div>

												<div class="row mt-3 mr-3 align-items-center" style="">
													<div class="col-md-2 pl-0 pr-0 mr-2 text-right" ><small>Юр. адрес:</small></div>
													<div class="col pl-0 pr-0"  >
														<input required class="col form-control" name="address" type="text" placeholder="индекс, страна, город, улица, дом, корпус" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;">
													</div>
													<div class="col-md-1 pl-0 pr-0 ml-3 mr-2 text-right"><small>р/с:</small></div>
													<div class="col pl-0 pr-0">
														<input required class="col form-control" name="balance" type="number" placeholder="номер расчетного счета" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;">
													</div>
												</div>

												<div class="row mt-3 mr-3 align-items-center" style="">
													<div class="col-md-2 pl-0 pr-0 mr-2 text-right" ><small>Контактное лицо:</small></div>
													<div class="col pl-0 pr-0"  >
														<input required class="col form-control" name="cont_name" type="text" placeholder="ФИО" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;">
													</div>
													<div class="col-md-1 pl-0 pr-0 ml-3 mr-2"></div>
													<div class="col pl-0 pr-0"></div>
												</div>

												<div class="row mt-3 mr-3 align-items-center" style="">
													<div class="col-md-2 pl-0 pr-0 mr-2 text-right" ><small>Контактный тел.:</small></div>
													<div class="col pl-0 pr-0">
														<input required class="col form-control" name="tel_num" type="text" placeholder="номер телефона" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;">
													</div>
													<div class="col-md-1 pl-0 pr-0 mr-2 ml-3 text-right" ></div>
													<div class="col pl-0 pr-0"  >
														
													</div>
												</div>

												<div class="row mt-3 mr-3 align-items-center" style="">
													<div class="col-md-2 pl-0 pr-0 mr-2 text-right" ><small>Электронная почта:</small></div>
													<div class="col pl-0 pr-0">
														<input required class="col form-control" name="mail" type="email" placeholder="email@domain.com" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;">
													</div>
													<div class="col-md-1 pl-0 pr-0 mr-2 ml-3 text-right" ></div>
													<div class="col pl-0 pr-0"  >
														
													</div>
												</div>

												<div class="row mt-3 mr-3 align-items-center" style="">
													<div class="col-md-2 pl-0 pr-0 mr-2 text-right" ><small>Комментарий:</small></div>
													<div class="col pl-0 pr-0">
														<input required class="col form-control" name="comment" type="text" placeholder="комментарий" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;">
													</div>
													<div class="col-md-1 pl-0 pr-0 mr-2 ml-3 text-right" ></div>
													<div class="col pl-0 pr-0"  >
														
													</div>
												</div>

												<div class="row align-items-center ml-2" style="padding-top: 3rem;">
													<div class="col-md-2 pl-0 pr-0"  >
														<button class="btn btn-primary btn-sm  btn-block ml-0" type="submit" name="submit"><small>Добавить</small></button>
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