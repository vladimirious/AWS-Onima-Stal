<?php 
session_start();
$back = 0;
if (!isset($_SESSION['hash'])) 
{
	header("Location: login");
	exit;
}
if ($_SESSION['Interface']!='konstr_tech')
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
$QUERY = "SELECT Contr_N, DATE, Link, Comments, Stat_1, Stat_2, Stat_3 FROM contracts WHERE Proj_id=".$_GET["n"];
$result = mysqli_query($link, $QUERY) or die("Ошибка 1 ".mysqli_error($link));
$contract = mysqli_fetch_row($result);

if (isset($_GET['to_equip']))
{
	if ($_GET['to_equip']==1)
	$back = 1;
}

if (isset($_POST['submit1']))
{	
	if ($_POST['stage1']!=""){
		$QUERY="UPDATE supplies SET Stat_2=1 WHERE Supp_id=".$_POST['stage1']." AND Proj_id=".$_GET["n"];
		mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
		//print_r ($_POST['submit']);
		//exit;
	}
}
if (isset($_POST['submit2']))
{	
	if ($_POST['stage2']!=""){
		$QUERY="UPDATE supplies SET Stat_3=1 WHERE Supp_id=".$_POST['stage2']." AND Proj_id=".$_GET["n"];
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
	<title>КТП</title>
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
		.my-custom-scrollbar {
		  position: relative;
		  height: 435px;
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
							<a href="konstr_tech_proj?n=<?echo $_GET['n']?>"><img src="img/back.png" class="img" title="К этапам проекта"></a>
						</div>
					</div>
					
					<div class="row-fluid">
						<div class="col text-center nopadding">
							<a href="konstr_tech_projs"><img src="img/proj_sb_a.png" class="img" title="Проекты"></a>
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
							<p class="sh1 mb-1">Конструкторско-технологическое проектирование</p>
						</div>
					</div>
		  
					<div class="row-fluid ml-3 ">	
						<div class="col-md-12 ">
							<ul class="nav nav-tabs fluent-tabs" id="myTab" role="tablist" >
								<li class="nav-item">
									<a class='nav-link <?if(!$back) echo "active show";?>' id='order-tab' role='tab' aria-selected='<?if(!$back) echo "true"; else echo "false";?>' aria-controls='order' href='#order' data-toggle='tab'><small>Заказы</small></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="konst_docs-tab" role="tab" aria-selected="false" aria-controls="konst_docs" href="#konst_docs" data-toggle="tab"><small>Конструкторские док.</small></a>
								</li>
								<li class="nav-item">
									<a class='nav-link ' id='techn_docs-tab' role='tab' aria-selected='false' aria-controls='techn_docs' href='#techn_docs' data-toggle='tab'><small>Технологические док.</small></a>
								</li>			
								<li class="nav-item">
									<a class='nav-link ' id='spec-tab' role='tab' aria-selected='false' aria-controls='spec' href='#spec' data-toggle='tab'><small>Спецификация</small></a>
								</li>	
								<li class="nav-item">
									<a class='nav-link <?if($back) echo "active show";?>' id='pr_equip-tab' role='tab' aria-selected='<?if($back) echo "true"; else echo "false";?>' aria-controls='pr_equip' href='#pr_equip' data-toggle='tab'><small>Оборудование на проект</small></a>
								</li>									
							</ul>
							
							<div class="tab-content " id="myTabContent" >
								<div class="tab-pane fade <?if(!$back) echo "active show";?>" id="order" role="tabpanel" aria-labelledby="order-tab" >
									<div class="row-fluid mt-4 mr-3">
										<div class="col nopadding">
											
<?
				$QUERY= "SELECT 
						supplies.Supp_id,
						providers.Prov_name,
						supplies.Numb,
						supplies.Comments,
						supplies.Stat_2,
						supplies.Stat_3,
						supplies.Stat_1,
						supplies.Link,
						supplies.Prov_id
					FROM 
						supplies 
					LEFT JOIN 
						providers 
					ON 
						supplies.Prov_id=providers.Prov_id 
					WHERE 
						Proj_id=".$_GET["n"]." AND Stat_4=1";
				$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
				if($result)
				{
					$rows = mysqli_num_rows($result); // количество полученных строк
				//	echo $rows;
						if($rows==0) echo '<button class="col-md-2 btn btn-primary btn-block btn-sm ml-0" style="margin-top: 50px;" onClick=\'location.href="konstr_tech_new_purchase?n='.$_GET["n"].'"\' ><small>Добавить</small></button>';
						else{
							echo '<div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar pr-3">
										<table class="table table-hover table-striped table-sm" style="overflow: auto">
											<thead>
												<tr>
													<th scope="col" class="">№</th>
													<th scope="col" class="">Поставщик</th>
													<th scope="col" class="">Количество</th>
													<th scope="col" class="">Комментарий</th>
													<th scope="col" style="padding-left:8px;">Статус</th>
													<th scope="col" class="">Согласовано</th>
													<th scope="col" class="">Загрузка</th>
												</tr>
											</thead>
											<tbody>';
							for ($i = 0 ; $i < $rows ; ++$i)
							{
								$row = mysqli_fetch_row($result);
								//print_r($result);
								echo "<tr><td>".$row[0]."</td>";
								echo "<td><a href='konstr_tech_prov?n=".$_GET["n"]."&prov=".$row[8]."'>".$row[1]."</a></td>";
								echo "<td>".$row[2]."</td>";
								echo "<td>".$row[3]."</td>";
								if($row[6]==0) echo "<td>На согласовании</td>";
								else if (($row[6]==1)&&($row[4]==0)) echo "<td>
								<form method='POST' action=''>
									<select id='stage1' name='stage1' style='border: 0px; background-color: rgba(0,0,0,0);'>
										<option selected value=''>Оформление</option>
										<option value=".$row[0].">Исполняется</option>
									</select>
								<input type='submit' name='submit1' value='Submit' style='display:none;'/>
								</form>
								</td>";
								else if (($row[6]==1)&&($row[4]==1)&&($row[5]==0)) echo "<td>
								<form method='POST' action=''>
									<select id='stage2' name='stage2' style='border: 0px; background-color: rgba(0,0,0,0);'>
										<option selected value=''>Исполняется</option>
										<option value=".$row[0].">Завершен</option>
									</select>
								<input type='submit' name='submit2' value='Submit' style='display:none;'/>
								</form>
								</td>";
								else if (($row[6]==1)&&($row[4]==1)&&($row[5]==1)) echo "<td style='padding-left:8px;'>Завершен</td>";

								
								if($row[6]=="") echo "<td class='text-center' style='color:#FF8C00'>Ожидается</td>";
								else if ($row[6]==0) echo "<td class='text-center'><a href='konstr_tech_edit_purchase?n=".$_GET["n"]."&doc=".$row[0]."' style='color:#DA3B01' title='Нажмите, чтобы перейти к редактированию закупки.'>Нет</a></td>";
								else if ($row[6]==1) echo "<td class='text-center' style='color:#107C10'>Да</td>";
								echo "<td class='text-center'><a href='".$row[7]."' target='_blank'>Скачать</a></td>";
								echo "</tr>";
							}
							echo "			</tbody>
										</table>
									</div>";
							mysqli_free_result($result);
							echo '<button class="col-md-2 btn btn-primary btn-block btn-sm ml-0" onClick=\'location.href="konstr_tech_new_purchase?n='.$_GET["n"].'"\' ><small>Добавить</small></button>';
						}
				}
?>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="konst_docs" role="tabpanel" aria-labelledby="konst_docs-tab">
									<div class="row-fluid mt-4 mr-3">
										<div class="col nopadding">
<?
				$QUERY= "SELECT 
						konstr_doc.Konstr_doc_id,
						providers.Prov_name,
						konstr_doc.Comments,
						konstr_doc.Link,
						providers.Prov_id
					FROM 
						konstr_doc 
					LEFT JOIN 
						providers 
					ON 
						konstr_doc.Prov_id=providers.Prov_id 
					WHERE 
						Proj_id=".$_GET["n"];
						
				$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
				if($result)
				{
					$rows = mysqli_num_rows($result); // количество полученных строк
				//	echo $rows;
						if($rows==0) echo '<button class="col-md-2 btn btn-primary btn-block btn-sm ml-0" style="margin-top: 50px;" onClick=\'location.href="konstr_tech_new_konst_doc?n='.$_GET["n"].'"\' ><small>Добавить</small></button>';
						else{
							echo '<div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar pr-3">
										<table class="table table-hover table-striped table-sm" style="overflow: auto">
											<thead>
												<tr>
													<th scope="col" class="">№</th>
													<th scope="col" class="">Поставщик</th>
													<th scope="col" class="">Комментарий</th>
													<th scope="col" class="">Загрузка</th>
												</tr>
											</thead>
											<tbody>';
							for ($i = 0 ; $i < $rows ; ++$i)
							{
								$row = mysqli_fetch_row($result);
								//print_r($result);
								echo "<tr><td>".$row[0]."</td>";
								echo "<td><a href='konstr_tech_prov?n=".$_GET["n"]."&prov=".$row[4]."'>".$row[1]."</a></td>";
								echo "<td>".$row[2]."</td>";
								echo "<td ><a href='".$row[3]."' target='_blank'>Скачать</a></td></tr>";
							}
							echo "			</tbody>
										</table>
									</div>";
							mysqli_free_result($result);
							echo '<button class="col-md-2 btn btn-primary btn-block btn-sm ml-0" onClick=\'location.href="konstr_tech_new_konst_doc?n='.$_GET["n"].'"\' ><small>Добавить</small></button>';
						}
				}
				?>
										</div>
									</div>
								</div>

								<div class="tab-pane fade" id="techn_docs" role="tabpanel" aria-labelledby="techn_docs-tab">
									<div class="row-fluid mt-4 mr-3">
										<div class="col nopadding">
<?
				$QUERY= "SELECT 
						Techn_doc_id,
						Comments,
						Link
					FROM
						techn_doc 
					WHERE 
						Proj_id=".$_GET["n"];
						
				$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
				if($result)
				{//Techn_doc_id Link Comments Proj_id 
					$rows = mysqli_num_rows($result); // количество полученных строк
				//	echo $rows;
						if($rows==0) echo '<button class="col-md-2 btn btn-primary btn-block btn-sm ml-0" style="margin-top: 50px;" onClick=\'location.href="konstr_tech_new_techn_doc?n='.$_GET["n"].'"\' ><small>Добавить</small></button>';
						else{
							echo '<div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar pr-3">
										<table class="table table-hover table-striped table-sm" style="overflow: auto">
											<thead>
												<tr>
													<th scope="col" class="">№</th>
													<th scope="col" class="">Комментарий</th>
													<th scope="col" class="">Загрузка</th>
													<th scope="col" class="">Ред.</th>
												</tr>
											</thead>
											<tbody>';
							for ($i = 0 ; $i < $rows ; ++$i)
							{
								$row = mysqli_fetch_row($result);
								//print_r($result);
								echo "<tr><td>".$row[0]."</td>";
								echo "<td>".$row[1]."</td>";
								echo "<td ><a href='".$row[2]."' target='_blank'>Скачать</a></td>";
								echo "<td ><a href='konstr_tech_edit_techn_docs?n=".$_GET["n"]."&doc=".$row[0]."'>Ред.</a></td></tr>";
							}
							echo "			</tbody>
										</table>
									</div>";
							mysqli_free_result($result);
							echo '<button class="col-md-2 btn btn-primary btn-block btn-sm ml-0" onClick=\'location.href="konstr_tech_new_techn_doc?n='.$_GET["n"].'"\' ><small>Добавить</small></button>';
						}
				}
?>
										</div>
									</div>
								</div>
								
								<div class="tab-pane fade" id="spec" role="tabpanel" aria-labelledby="spec-tab">
									<div class="row-fluid mt-4 mr-3">
										<div class="col nopadding">
<?
				$QUERY= "SELECT 
						Spec_id,
						Spec_date,
						Comments,
						Link
					FROM
						specifications 
					WHERE 
						Proj_id=".$_GET["n"];
						
				$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
				if($result)
				{//Techn_doc_id Link Comments Proj_id 
					$rows = mysqli_num_rows($result); // количество полученных строк
				//	echo $rows;
						if($rows==0) 
							echo '<button class="col-md-2 btn btn-primary btn-block btn-sm ml-0" style="margin-top: 50px;" onClick=\'location.href="konstr_tech_new_spec?n='.$_GET["n"].'"\' ><small>Добавить</small></button>';
						else{
							$row = mysqli_fetch_row($result);
							echo '<div class="row mt-3 mr-5 align-items-center" style="">
												<div class="col-md-3 text-right" style="">
													Спецификация:
												</div>
												<div class="col">№'.$row[0].'</div>
												<div class="col-md-3 ml-4">	</div>

											</div>
											
											<div class="row mt-3 mr-5 align-items-center" style="">
												<div class="col-md-3 text-right" style="">
													Документ:
												</div>
												<div class="col"><a href="'.$row[3].'" target="_blank">Скачать</a></div>
												<div class="col-md-3 ml-4"></div>
											</div>

											<div class="row mt-3 mr-5 align-items-center" style="">
												<div class="col-md-3 text-right" style="">
													Комментарий:
												</div>
												<div class="col">'.$row[2].'</div>
												<div class="col-md-3 ml-4"></div>
											</div>
											
											<div class="row mt-3 mr-5 align-items-center" style="">
												<div class="col-md-3 text-right" style="">
													Дата загрузки:
												</div>
												<div class="col">'.$row[1].'</div>
												<div class="col-md-3 ml-4"></div>
											</div>
											<div class="row mt-4 mr-5 align-items-center" style="">
												<div class="col-md-3 text-right" style=""></div>
												
													<button class="col-md-2 btn btn-secondary btn-sm btn-block m-0" onclick=\'location.href="konstr_tech_edit_spec?n='.$_GET["n"].'"\'><small>Изменить</small></button>
												
											</div>';
							mysqli_free_result($result);

						}
				}
?>
										</div>
									</div>
								</div>	
								
								<div class="tab-pane fade <?if($back) echo "active show";?>" id="pr_equip" role="tabpanel" aria-labelledby="pr_equip-tab">
									<div class="row-fluid mt-4 mr-3">
									
										<div class="col p-0">
											
<?php
$QUERY ="SELECT
	equip_for_proj.Eq_proj_id,
	equipment.Equip_name,
	equipment.Serial_N,
	equipment.Location,
	equip_for_proj.Comments,
	equip_for_proj.Equip_id
FROM
   equip_for_proj
LEFT JOIN
	equipment
ON
	equip_for_proj.Equip_id=equipment.Equip_id;";

$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
if($result)
{

	$rows = mysqli_num_rows($result); // количество полученных строк
//	echo $rows;
	if($rows==0) 
		echo '<button class="col-md-2 btn btn-primary btn-block btn-sm ml-0" onClick=\'location.href="konstr_tech_equip?n='.$_GET["n"].'"\'><small>Добавить</small></button>';
	else
	{	echo '<div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar pr-3">
												<table class="table table-hover table-striped table-sm" style="overflow: auto">
													<thead>
														<tr>
															<th scope="col" style="vertical-align: top;">№</th>
															<th scope="col" style="vertical-align: top;">Наименование</th>
															<th scope="col" style="vertical-align: top;">Серийный номер</th>
															<th scope="col" style="vertical-align: top;">Местонахождение</th>
															<th scope="col" style="vertical-align: top;">Комментарий</th>
															<th scope="col" style="vertical-align: top;"><div hidden class="deleting_th">Удалить</div></th>
														</tr>
													</thead>
													<tbody>';
		for ($i = 0 ; $i < $rows ; ++$i)
		{
			echo "<tr>";
			$row = mysqli_fetch_row($result);
				for ($j = 0 ; $j < 5; ++$j) echo "<td>".$row[$j]."</td>";
			echo "<td><a hidden class='deleting_td' href='konstr_tech_del_equip?n=".$_GET["n"]."&eq=".$row[5]."' style='color: #DA3B01;'>Удалить</a></td>";
			echo "</tr>";
		}
		mysqli_free_result($result);
		echo '										</tbody>
												</table>
											</div>';
		echo '<button hidden id="eq_add_button" class="col-md-2 btn btn-primary btn-block btn-sm ml-0" onClick=\'location.href="konstr_tech_equip?n='.$_GET["n"].'"\'><small>Добавить</small></button>';
		echo '<button id="eq_ed_button" class="col-md-2 btn btn-secondary btn-block btn-sm ml-0"><small>Изменить</small></button>';	
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
	document.getElementById("eq_ed_button").addEventListener("click", function(event){
		event.preventDefault();
		$("#eq_add_button").removeAttr("hidden");
		$("#eq_ed_button").attr("hidden", "true");	
		$(".deleting_th").removeAttr("hidden");
		$(".deleting_td").removeAttr("hidden");
	});
	</script>
	<!-- JQuery -->
	<script type="text/javascript" src="./js/jquery-3.3.1.min.js"></script>
    <!-- Bootstrap tooltips -->
	<script type="text/javascript" src="./js/popper.min.js"></script>
  	<!-- Bootstrap core JavaScript -->
	<script type="text/javascript" src="./js/bootstrap.min.js"></script>
	<script>
	$(document).ready(function() {
		$('#stage1').on('change', function() {
			var $form = $(this).closest('form');
			$form.find('input[type=submit]').click();
		});
		$('#stage2').on('change', function() {
			var $form = $(this).closest('form');
			$form.find('input[type=submit]').click();
		});
	});
	</script>
</body>

</html>