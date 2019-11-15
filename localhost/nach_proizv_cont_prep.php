<?php 
session_start();
$err = 0;
if (!isset($_SESSION['hash'])) 
{
	header("Location: login");
	exit;
}
if ($_SESSION['Interface']!='nach_proizv')
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

$QUERY = "SELECT Link, Comments, Type_doc FROM tech_doc WHERE Proj_id=".$_GET["n"];
$result = mysqli_query($link, $QUERY) or die("Ошибка 1 ".mysqli_error($link));
$tech_doc = mysqli_fetch_row($result);

$QUERY = "SELECT Pr_doc_date, Comments, Link, Pr_doc_id FROM pr_contract_docs WHERE TYPE='smeta' AND Proj_id=".$_GET["n"];
$result = mysqli_query($link, $QUERY) or die("Ошибка 2 ".mysqli_error($link));
$smeta = mysqli_fetch_row($result);

$QUERY = "SELECT Pr_doc_date, Comments, Link, Pr_doc_id FROM pr_contract_docs WHERE TYPE='plan' AND Proj_id=".$_GET["n"];
$result = mysqli_query($link, $QUERY) or die("Ошибка 2 ".mysqli_error($link));
$plan = mysqli_fetch_row($result);
?>

<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Подготовка договора</title>
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
		  height: 415px;
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
							<a href="nach_proizv_proj?n=<?echo $_GET['n']?>"><img src="img/back.png" class="img" title="К этапам проекта"></a>
						</div>
					</div>
					<div class="row-fluid">
						<div class="col text-center nopadding">
							<a href="nach_proizv_projs"><img src="img/proj_sb_a.png" class="img" title="Проекты"></a>
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
							<p class="sh1 mb-1">Подготовка договора</p>
						</div>
					</div>
		  
					<div class="row-fluid ml-3 ">	
						<div class="col-md-12 ">
							<ul class="nav nav-tabs fluent-tabs" id="myTab" role="tablist" >
								<li class="nav-item">
									<a class='nav-link active show' id='contract-tab' role='tab' aria-selected='true' aria-controls='contract' href='#contract' data-toggle='tab'><small>Договор</small></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="tech_docs-tab" role="tab" aria-selected="false" aria-controls="tech_docs" href="#tech_docs" data-toggle="tab"><small>Технические док.</small></a>
								</li>
								<li class="nav-item">
									<a class='nav-link ' id='plan-tab' role='tab' aria-selected='false' aria-controls='plan' href='#plan' data-toggle='tab'><small>План</small></a>
								</li>
								<li class="nav-item">
									<a class='nav-link ' id='smeta-tab' role='tab' aria-selected='false' aria-controls='smeta' href='#smeta' data-toggle='tab'><small>Смета</small></a>
								</li>								
							</ul>
							
							<div class="tab-content" id="myTabContent" >
								<div class="tab-pane fade active show" id="contract" role="tabpanel" aria-labelledby="contract-tab" >
									<div class="row-fluid mt-4 mr-3">
										<div class="col nopadding">
											<?if (!$contract){
												echo '<button class="btn btn-primary btn-sm ml-0" onClick=\'location.href="gen_dir_new_contract?n='.$_GET["n"].'"\'>Добавить договор</button>';
											}
											else{
												
											$checked="Нет";
											if($contract[4]==1) $checked = "Да";
											
											$signed_up="Нет";
											if($contract[5]==1) $signed_up = $contract[1];

											$paid="Нет";
											if($contract[6]==1) $paid = "Да";											
											
											echo '<div class="row mt-3 mr-5 align-items-center" style="">
												<div class="col-md-3 text-right" style="">
													Номер договора:
												</div>
												<div class="col">№'.$contract[0].'</div>
												<div class="col-md-3 ml-4">	</div>

											</div>
											
											<div class="row mt-3 mr-5 align-items-center" style="">
												<div class="col-md-3 text-right" style="">
													Документ:
												</div>
												<div class="col"><a href="'.$contract[2].'" target="_blank">Скачать</a></div>
												<div class="col-md-3 ml-4"></div>
											</div>

											<div class="row mt-3 mr-5 align-items-center" style="">
												<div class="col-md-3 text-right" style="">
													Комментарий:
												</div>
												<div class="col">'.$contract[3].'</div>
												<div class="col-md-3 ml-4"></div>
											</div>
											
											<div class="row mt-3 mr-5 align-items-center" style="">
												<div class="col-md-3 text-right" style="">
													Проверен:
												</div>
												<div class="col">'.$checked.'</div>
												<div class="col-md-3 ml-4"></div>
											</div>
											
											<div class="row mt-3 mr-5 align-items-center" style="">
												<div class="col-md-3 text-right" style="">
													Подписан:
												</div>
												<div class="col">'.$signed_up.'</div>
												<div class="col-md-3 ml-4"></div>
											</div>
											
											<div class="row mt-3 mr-5 align-items-center" style="">
												<div class="col-md-3 text-right" style="">
													Оплачен:
												</div>
												<div class="col">'.$paid.'</div>
												<div class="col-md-3 ml-4"></div>
											</div>';
											}?>

										</div>
									</div>
								</div>
				  
								<div class="tab-pane fade" id="tech_docs" role="tabpanel" aria-labelledby="tech_docs-tab">
									<div class="row-fluid mt-4 mr-3">
										<div class="col nopadding">
<?if (!$tech_doc){
	echo '<div style="color: black; opacity: 0.3"> Техническая документация не найдена</div>';
}
else 
{
	echo '											
		<div class="row-fluid ml-0 mr-3">
            <div class="col pl-0">
              <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar pr-3">
                  <table class="table table-hover table-striped table-sm" style="overflow: auto">
                    <thead>
                       <tr>
                         <th scope="col" >№</th>
						 <th scope="col">Тип документа</th>
                         <th scope="col" >Комментарий</th>
                         <th scope="col" >Загрузка</th>
                       </tr>
                     </thead>
                     <tbody>';

	$QUERY ="SELECT
		Tech_doc_id,
		Type_doc,
		Comments,
		Link
	FROM
		tech_doc
	WHERE
		Proj_id =".$_GET["n"];

	$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
	if($result)
	{
		$rows = mysqli_num_rows($result); // количество полученных строк
	//	echo $rows;
		for ($i = 0 ; $i < $rows ; ++$i)
		{
			echo "<tr>";
			$row = mysqli_fetch_row($result);
			for ($j = 0 ; $j < 3 ; ++$j) echo "<td>".$row[$j]."</td>";
			echo "<td><a href='".$row[3]."' target='_blank'>Скачать</a></td>";
			echo "</tr>";
		}
		mysqli_free_result($result);
	}

    echo '                 </tbody>
                   </table>
                </div>
              </div>
            </div>
					
										</div>
									</div>	
								</div>';
}
?>

								<div class="tab-pane fade" id="plan" role="tabpanel" aria-labelledby="plan-tab">
									<div class="row-fluid mt-4 mr-3">
										<div class="col nopadding">
											<?if (!$plan)
												echo '<div style="color: black; opacity: 0.3"> План не найден</div>';
											else{									

												if (!$plan[0])
													$approved="Нет";
												else $approved=$plan[0];

												echo '
											
											<div class="row mt-3 mr-5 align-items-center" style="">
												<div class="col-md-3 text-right" style="">
													Документ:
												</div>
												<div class="col"><a href="'.$plan[2].'" target="_blank">Скачать</a></div>
												
											</div>
											<div class="row mt-3 mr-5 align-items-center" style="">
												
												<div class="col-md-3 text-right" style="">
													Комментарий:
												</div>
												<div class="col-md-4">'.$plan[1].'</div>											
											</div>
											
											<div class="row mt-3 mr-5 align-items-center" style="">
												<div class="col-md-3 text-right" style="">
													Согласовано:
												</div>
												<div class="col-md-4">'.$approved.'</div>
											</div>';
											}?>
										</div>
									</div>
								</div>	
								<div class="tab-pane fade" id="smeta" role="tabpanel" aria-labelledby="smeta-tab">
									<div class="row-fluid mt-4 mr-3">
										<div class="col nopadding">
											<?if (!$smeta[0])
												echo '<div style="color: black; opacity: 0.3"> Смета не найдена</div>';
											else{									

												if (!$smeta[0])
													$approved="Нет";
												else $approved=$smeta[0];

												echo '
											
											<div class="row mt-3 mr-5 align-items-center" style="">
												<div class="col-md-3 text-right" style="">
													Документ:
												</div>
												<div class="col"><a href="'.$smeta[2].'" target="_blank">Скачать</a></div>
												
											</div>
											<div class="row mt-3 mr-5 align-items-center" style="">
												
												<div class="col-md-3 text-right" style="">
													Комментарий:
												</div>
												<div class="col-md-4">'.$smeta[1].'</div>											
											</div>
											
											<div class="row mt-3 mr-5 align-items-center" style="">
												<div class="col-md-3 text-right" style="">
													Согласовано:
												</div>
												<div class="col-md-4">'.$approved.'</div>
											</div>';
											}?>
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