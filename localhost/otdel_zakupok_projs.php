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
?>

<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Проекты</title>
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
		.form-control::-webkit-input-placeholder { color: #a9a9a9; }  /* WebKit, Blink, Edge */
		.form-control:-moz-placeholder { color: #a9a9a9; }  /* Mozilla Firefox 4 to 18 */
		.form-control::-moz-placeholder { color: #a9a9a9; }  /* Mozilla Firefox 19+ */
		.form-control:-ms-input-placeholder { color: #a9a9a9; }  /* Internet Explorer 10-11 */
		.form-control::-ms-input-placeholder { color: #a9a9a9; }  /* Microsoft Edge */

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
			height: 500px;
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
							<img src="img/proj_sb_a.png" class="img">
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
							<p class="sh1 mb-1">Проекты</p>
						</div>
					</div>
		  
					<div class="row-fluid ml-3 ">
						<div class="col-md-12 ">
							<ul class="nav nav-tabs fluent-tabs" id="myTab" role="tablist" >
								<li class="nav-item">
									<a class='nav-link active show' id='home-tab' role='tab' aria-selected='true' aria-controls='home' href='#home' data-toggle='tab'><small>Текущие</small></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="finished-tab" role="tab" aria-selected="false" aria-controls="finished" href="#finished" data-toggle="tab"><small>Завершенные</small></a>
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
															<th scope="col"   style="vertical-align: top;">Номер заказа</th>
															<th scope="col"   style="vertical-align: top;">Заказчик</th>
															<th scope="col"   style="vertical-align: top;">Тип работ</th>
															<th scope="col"   style="vertical-align: top;">Дата начала</th>
														</tr>
													</thead>
													<tbody>
<?php
if(!$link = mysqli_connect("localhost", "mysql", "mysql", "omima_stal"))
{
	echo "Нет соединения с сервером"; 
	die();
}
$QUERY ="SELECT
    projects.Proj_id,
    customers.Cust_name,
    dir_of_works.Work_name,
    projects.Start_date,
	customers.Cust_id
FROM
    projects
LEFT JOIN dir_of_works ON projects.Work_id = Dir_of_works.Work_id
LEFT JOIN customers ON projects.Cust_id = customers.Cust_id
WHERE
	Stat_1='0';";

$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
if($result)
{
	$rows = mysqli_num_rows($result);
	if ($rows==0) echo "<td  colspan='4'>Текущих проектов не найдено.</td>";
	else {
		for ($i = 0 ; $i < $rows ; ++$i)
		{
			echo "<tr>";
			$row = mysqli_fetch_row($result);
			echo "<td><a href='otdel_zakupok_proj?n=".$row[0]."'>".$row[0]."</td>";
			echo "<td><a href='otdel_zakupok_cust?n=".$row[4]."'>".$row[1]."</td>";
			echo "<td>".$row[2]."</td>";
			echo "<td>".date("d.m.Y",strtotime($row[3]))."</td>";
			
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
										<div class="col nopadding">
											<div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar pr-3">
												<table class="table table-hover table-striped table-sm" style="overflow: auto">
													<thead>
														<tr>
															<th scope="col"   style="vertical-align: top;">Номер заказа</th>
															<th scope="col"   style="vertical-align: top;">Заказчик</th>
															<th scope="col"   style="vertical-align: top;">Тип работ</th>
															<th scope="col"   style="vertical-align: top;">Дата начала</th>
															<th scope="col"   style="vertical-align: top;">Дата окончания</th>
														</tr>
													</thead>
													<tbody>
<?php
$QUERY ="SELECT
    projects.Proj_id,
    customers.Cust_name,
    dir_of_works.Work_name,
    projects.Start_date,
	projects.End_date,
	customers.Cust_id
FROM
    projects
LEFT JOIN dir_of_works ON projects.Work_id = Dir_of_works.Work_id
LEFT JOIN customers ON projects.Cust_id = customers.Cust_id
WHERE
	Stat_1 <> '0';";

$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
if($result)
{
	$rows = mysqli_num_rows($result);
	if ($rows==0) echo "<td  colspan='5'>Завершенных проектов не найдено.</td>";
	else {
		for ($i = 0 ; $i < $rows ; ++$i)
		{
			echo "<tr>";
			$row = mysqli_fetch_row($result);
			echo "<td><a href='otdel_zakupok_proj?n=".$row[0]."'>".$row[0]."</td>";
			echo "<td><a href='otdel_zakupok_cust?n=".$row[5]."'>".$row[1]."</td>";
			echo "<td>".$row[2]."</td>";
			echo "<td>".date("d.m.Y",strtotime($row[3]))."</td>";
			echo "<td>".date("d.m.Y",strtotime($row[4]))."</td>";
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