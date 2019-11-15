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
    header("Location: login");
    exit;
}

if(!$link = mysqli_connect("localhost", "mysql", "mysql", "omima_stal"))
{
	echo "Нет соединения с сервером"; 
	die();
}

if(isset($_POST['submit']))
{
	$QUERY="INSERT INTO employees(
    Surname,
    NAME,
    Sec_name,
    B_date,
    Pass_s_n,
    Pass_n,
    Pass_inf,
    Addr,
    Tel_numb,
    E_mail,
    Emp_date,
    Dep_id,
    M_t_id
)
VALUES(
	'".$_POST['Surname']."',
	'".$_POST['NAME']."',
	'".$_POST['Sec_name']."',
	'".$_POST['B_date']."',
	".$_POST['Pass_s_n'].",
	".$_POST['Pass_n'].",
	'".$_POST['Pass_inf']."',
	'".$_POST['Addr']."',
	'".$_POST['Tel_numb']."',
	'".$_POST['E_mail']."',
	'".$_POST['Emp_date']."',
	".$_POST['Dep_id'].",
	".$_POST['M_t_id'].")";
	//echo $QUERY;
	mysqli_query($link, $QUERY) or die("Ошибка submit".mysqli_error($link));
}
//SELECT manning_table.M_t_id, COUNT(employees.TAB_N) FROM employees RIGHT JOIN manning_table ON employees.M_t_id = manning_table.M_t_id GROUP BY manning_table.M_t_id
?>

<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Сотрудники</title>
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
							<img src="img/space_sb.png" class="img">
						</div>
					</div>
					
					<div class="row-fluid">
						<div class="col text-center nopadding">
							<a href="buhgal_projs"><img src="img/proj_sb.png" class="img"></a>
						</div>
					</div>
					
					<div class="row-fluid">
						<div class="col text-center nopadding">
							<img src="img/buhgal_employ_sb_a.png" class="img" title="Сотрудники"></a>
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
							<p class="sh1 mb-1">Сотрудники</p>
						</div>
					</div>
		  
					<div class="row-fluid ml-3 ">
						<div class="col-md-12 ">
							<ul class="nav nav-tabs fluent-tabs" id="myTab" role="tablist" >
								<li class="nav-item">
									<a class='nav-link active show' id='home-tab' role='tab' aria-selected='true' aria-controls='home' href='#home' data-toggle='tab'><small>Все</small></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="finished-tab" role="tab" aria-selected="false" aria-controls="finished" href="#finished" data-toggle="tab"><small>Новый сотрудник</small></a>
								</li>
							</ul>
							<div class="tab-content" id="myTabContent" >
								<div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab" >

									<div class="row-fluid mr-3">
									
										<div class="col nopadding">
											<div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar pr-3">
												<table class="table table-hover table-striped table-sm" style="overflow: auto">
													<thead>
														<tr>
															<th scope="col"   style="vertical-align: top;"><small>№</small></th>
															<th scope="col"   style="vertical-align: top;"><small>ФИО</small></th>
															<th scope="col"   style="vertical-align: top;"><small>Должность</small></th>
															<th scope="col"   style="vertical-align: top;"><small>Подразделение</small></th>
															<th scope="col"   style="vertical-align: top;"><small>Подробнее</small></th>
														</tr>
													</thead>
													<tbody>
<?php
$QUERY ="SELECT
    employees.TAB_N,
    employees.Surname,
    employees.NAME,
    employees.Sec_name,
    dir_of_positions.Pos_name,
    dir_of_dep.Dep_name
FROM
    dir_of_dep
LEFT JOIN employees ON dir_of_dep.Dep_id = employees.Dep_id
LEFT JOIN manning_table ON employees.M_t_id = manning_table.M_t_id
LEFT JOIN dir_of_positions ON manning_table.Pos_id = dir_of_positions.Pos_id";

$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
if($result)
{
	$rows = mysqli_num_rows($result);
	if ($rows==0) echo "<td  colspan='5'><small>Должностей не найдено</small></td>";
	else {
		for ($i = 0 ; $i < $rows ; ++$i)
		{
			echo "<tr>";
			$row = mysqli_fetch_row($result);
			echo "<td><small>".$row[0]."</small></td>";
			echo "<td><small>".$row[1]." ".$row[2]." ".$row[3]."</small></td>";
			echo "<td><small>".$row[4]."</small></td>";
			echo "<td><small>".$row[5]."</small></td>";
			echo "<td><a href='buhgal_info_employ?n=".$row[0]."'><small>Смотреть</small></td>";
			echo "</tr>";
		}
		mysqli_free_result($result);
	}
}
?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								
								<div class="tab-pane fade" id="finished" role="tabpanel" aria-labelledby="finished-tab">
								
									<div class="row-fluid mr-3">
										<div class="col">
											<form action="" method="POST">
												<div class="row mt-3 mr-0 align-items-center" style="">
													<div class="col-md-2 pl-0 pr-0 mr-2 text-right" style="background-color: ;"><small>Фамилия:</small></div>
													<div class="col pl-0 pr-0" style="background-color: ;" >
														<input required class="col form-control" name="Surname" type="text" placeholder="Фамилия" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;">
													</div>
													<div class="col-md-2 pl-0 pr-0 ml-3 mr-2 text-right" style="background-color: ;"><small>Имя:</small></div>
													<div class="col pl-0 pr-0" style="background-color: ;" >
														<input required class="col form-control" name="NAME" type="text" placeholder="Имя" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;">
													</div>
												</div>
												
												<div class="row mt-3 mr-0 align-items-center" style="">
													<div class="col-md-2 pl-0 pr-0 mr-2 text-right" style="background-color: ;"><small>Отчество:</small></div>
													<div class="col pl-0 pr-0" style="background-color: ;" >
														<input required class="col form-control" name="Sec_name" type="text" placeholder="отчество" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;">
													</div>
													<div class="col-md-2 pl-0 pr-0 ml-3 mr-2 text-right" style="background-color: ;"><small>Дата рождения:</small></div>
													<div class="col pl-0 pr-0" style="background-color: ;" >
														<input required class="col form-control" name="B_date" type="date" max="<?echo (idate('Y')-18)."-".date("m-d");?>" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;">
													</div>
												</div>

												<div class="row mt-3 mr-0 align-items-center" style="">
													<div class="col-md-2 pl-0 pr-0 mr-2 text-right" style="background-color: ;"><small>Серия паспорта:</small></div>
													<div class="col pl-0 pr-0" style="background-color: ;" >
														<input required class="col form-control" name="Pass_s_n" type="text" placeholder="Серия" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;">
													</div>
													<div class="col-md-2 pl-0 pr-0 ml-3 mr-2 text-right" style="background-color: ;"><small>Номер паспорта:</small></div>
													<div class="col pl-0 pr-0" style="background-color: ;" >
														<input required class="col form-control" name="Pass_n" type="text" placeholder="Номер" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;">
													</div>
													
												</div>

												<div class="row mt-3 mr-0 align-items-center" style="">
													<div class="col-md-2 pl-0 pr-0 mr-2 text-right" style="background-color: ;"><small>Когда и кем выдан:</small></div>
													<div class="col pl-0 pr-0" style="background-color: ;" >
														<input required class="col form-control" name="Pass_inf" type="text" placeholder="Кем выдан, когда выдан" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;">
													</div>
													<div class="col-md-2 pl-0 pr-0 ml-3 mr-2 text-right" style="background-color: ;"><small>Адрес:</small></div>
													<div class="col pl-0 pr-0" style="background-color: ;" >
														<input required class="col form-control" name="Addr" type="text" placeholder="Индекс, Страна, город, улица, .." style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;">
													</div>
												</div>

												<div class="row mt-3 mr-0 align-items-center" style="">
													<div class="col-md-2 pl-0 pr-0 mr-2 text-right" style="background-color: ;"><small>Номер телефона:</small></div>
													<div class="col pl-0 pr-0" style="background-color: ;" >
														<input required class="col form-control" name="Tel_numb" type="tel" placeholder="Номер телефона" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;">
													</div>
													<div class="col-md-2 pl-0 pr-0 ml-3 mr-2 text-right" style="background-color: ;"><small>e-mail:</small></div>
													<div class="col pl-0 pr-0" style="background-color: ;" >
														<input required class="col form-control" name="E_mail" type="email" placeholder="e-mail" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;">
													</div>
												</div>

												<div class="row mt-3 mr-0 align-items-center" style="">
													<div class="col-md-2 pl-0 pr-0 mr-2 text-right" style="background-color: ;"><small>Дата трудоустройства:</small></div>
													<div class="col pl-0 pr-0">
														<input required class="col form-control" name="Emp_date" type="date" max="<?echo date("Y-m-d");?>" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;">
													</div>
													<div class="col-md-2 pl-0 pr-0 mr-2 ml-3 text-right" style="background-color: ;"></div>
													<div class="col pl-0 pr-0" style="background-color: ;" >
														
													</div>
												</div>

												<div class="row mt-3 mr-0 align-items-center" style="">
													<div class="col-md-2 pl-0 pr-0 mr-2 text-right" style="background-color: ;"><small>Подразделение:</small></div>
													<div class="col pl-0 pr-0">
														<select required class="pl-2 pr-2" name="Dep_id" id="Dep_id" style="height:35px; width: 285px; border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20);font-size: small;">
															<option value="" style="color: rgba(0,0,0,0.3);">Не выбрано</option>
<?
$QUERY="SELECT Dep_id, Dep_name FROM Dir_of_dep";
$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
if($result)
{
	$rows = mysqli_num_rows($result);
	for ($i = 0 ; $i < $rows ; ++$i)
	{	$row = mysqli_fetch_row($result);
		echo '<option value="'.$row[0].'" >'.$row[1].'</option>';
	}
	mysqli_free_result($result);
}
?>
														</select>
													</div>
													<div class="col-md-2 pl-0 pr-0 mr-2 ml-3 text-right" style="background-color: ;"></div>
													<div class="col pl-0 pr-0" style="background-color: ;" >
														
													</div>
												</div>

												<div class="row mt-3 mr-0 align-items-center" style="">
													<div class="col-md-2 pl-0 pr-0 mr-2 text-right" style="background-color: ;"><small>Должность:</small></div>
													<div class="col pl-0 pr-0">
														<select required class="pl-2 pr-2" name="M_t_id" id="M_t_id" style="height:35px; width: 285px; border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20);font-size: small;">
															<option value="" style="color: rgba(0,0,0,0.3);">Не выбрана</option>
<?
$QUERY="SELECT
    manning_table.M_t_id,
    dir_of_positions.Pos_name
FROM
    manning_table
LEFT JOIN dir_of_positions ON manning_table.Pos_id = dir_of_positions.Pos_id";

$for_print = mysqli_query($link, $QUERY) or die("Ошибка 1".mysqli_error($link));


$QUERY="SELECT manning_table.M_t_id, T.num, manning_table.Numb_of_b FROM (SELECT M_t_id, COUNT(TAB_N) as num FROM employees WHERE Dism_date IS NULL GROUP BY M_t_id) as T RIGHT JOIN manning_table ON T.M_t_id=manning_table.M_t_id";






$counting = mysqli_query($link, $QUERY) or die("Ошибка 2".mysqli_error($link));

$rows_for_print = mysqli_num_rows($for_print);
for ($i = 0 ; $i < $rows_for_print ; ++$i)
{	$row_for_print = mysqli_fetch_row($for_print);
	$row_for_counting = mysqli_fetch_row($counting);
	if($row_for_counting[1]<$row_for_counting[2]) echo '<option value="'.$row_for_print[0].'" >'.$row_for_print[1].'</option>';
	else continue;
}
mysqli_free_result($for_print);
mysqli_free_result($counting);








?>
														</select>
													</div>
													<div class="col-md-2 pl-0 pr-0 mr-2 ml-3 text-right" style="background-color: ;"></div>
													<div class="col pl-0 pr-0" style="background-color: ;" >
														
													</div>
												</div>

												<div class="row mt-3 mr-0 align-items-center" style="">
													<div class="col-md-2 pl-0 pr-0 mr-2 text-right" style="background-color: ;"></div>
													
													<button class="col-md-2 btn btn-primary btn-sm btn-block ml-0" type="submit" name="submit"><small>Добавить</small></button>
													
													<div class="col-md-2 pl-0 pr-0 mr-2 ml-3 text-right" style="background-color: ;"></div>
													<div class="col pl-0 pr-0" style="background-color: ;" >
														
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