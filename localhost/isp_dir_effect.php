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
    header("Location: login");
    exit;
}	


if(!$link = mysqli_connect("localhost", "mysql", "mysql", "omima_stal"))
{
	echo "Нет соединения с сервером"; 
	die();
}

/*КОЛЛИЧЕСТВО ЗАКАЗОВ В СУММЕ*/
$project_quantity = 100;
$QUERY = "SELECT COUNT(Proj_id) FROM projects WHERE Stat_1<>0";
$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
if($result){
	$row = mysqli_fetch_row($result);
	$project_quantity = $row[0];
	mysqli_free_result($result);
}


/*КОЛЛИЧЕСТВО ПРОСРОЧЕК ОТДЕЛА РАСЧЕТОВ И БУХГАЛТЕРИИ SM*/
$SM_delay = 100;
$QUERY ="SELECT COUNT(projects.Proj_id) FROM projects LEFT JOIN project_stages ON projects.Proj_id=project_stages.Proj_id WHERE project_stages.Stat_1<>0 AND project_stages.P_date_SM < project_stages.F_date_SM";
$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
if($result)
{
	$row = mysqli_fetch_row($result);
	$SM_delay = $row[0];
	mysqli_free_result($result);
}


/*КОЛЛИЧЕСТВО ПРОСРОЧЕК ОТДЕЛА ЗАКУПОК ZM*/
$ZM_delay = 100;
$QUERY ="SELECT COUNT(projects.Proj_id) FROM projects LEFT JOIN project_stages ON projects.Proj_id=project_stages.Proj_id WHERE project_stages.Stat_1<>0 AND project_stages.P_date_ZM < project_stages.F_date_ZM";
$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
if($result)
{
	$row = mysqli_fetch_row($result);
	$ZM_delay = $row[0];
	mysqli_free_result($result);
}


/*КОЛЛИЧЕСТВО ПРОСРОЧЕК КОНСТРУКТОР-ТЕХНОЛОГА KTR*/
$KTR_delay = 100;
$QUERY ="SELECT COUNT(projects.Proj_id) FROM projects LEFT JOIN project_stages ON projects.Proj_id=project_stages.Proj_id WHERE project_stages.Stat_1<>0 AND project_stages.P_date_KTR < project_stages.F_date_KTR";
$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
if($result)
{
	$row = mysqli_fetch_row($result);
	$KTR_delay = $row[0];
	mysqli_free_result($result);
}


/*КОЛЛИЧЕСТВО ПРОСРОЧЕК ПРОИЗВОДСТВА PR*/
$PR_delay = 100;
$QUERY ="SELECT COUNT(projects.Proj_id) FROM projects LEFT JOIN project_stages ON projects.Proj_id=project_stages.Proj_id WHERE project_stages.Stat_1<>0 AND project_stages.P_date_PR < project_stages.F_date_PR";
$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
if($result)
{
	$row = mysqli_fetch_row($result);
	$PR_delay = $row[0];
	mysqli_free_result($result);
}


/*КОЛЛИЧЕСТВО ПРОСРОЧЕК СКЛАДА OZ*/
$OZ_delay = 100;
$QUERY ="SELECT COUNT(projects.Proj_id) FROM projects LEFT JOIN project_stages ON projects.Proj_id=project_stages.Proj_id WHERE project_stages.Stat_1<>0 AND project_stages.P_date_OZ < project_stages.F_date_OZ";
$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
if($result)
{
	$row = mysqli_fetch_row($result);
	$OZ_delay = $row[0];
	mysqli_free_result($result);
}


if ($roject_quantity!=0){
	$SM_delay=(($project_quantity-$SM_delay)/$project_quantity)*100;
	$ZM_delay=(($project_quantity-$ZM_delay)/$project_quantity)*100;
	$KTR_delay=(($project_quantity-$KTR_delay)/$project_quantity)*100;
	$PR_delay=(($project_quantity-$PR_delay)/$project_quantity)*100;
	$OZ_delay=(($project_quantity-$OZ_delay)/$project_quantity)*100;
}
else{
	$SM_delay = 100;
	$ZM_delay = 100;
	$KTR_delay = 100;
	$PR_delay = 100;
	$OZ_delay = 100;
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Эффективность</title>
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
	
	#blocks {background-color: rgba(255,255,255,0.4);}
	#blocks:hover { background-color: rgba(255,255,255,0.9)}
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
				<a href="isp_dir_projs"><img src="img/proj_sb.png" class="img" title="Проекты"></a>
            </div>
          </div>
          <div class="row-fluid">
            <div class="col text-center nopadding">
              <img src="img/effect_sb_a.png" class="img">
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
          <div class="row-fluid ml-3 mb-5">
            <div class="col">
              <p class="sh1">Эффективность</p>
            </div>
          </div>

			<div class="row shadow-lg mt-4 ml-5 mr-5 pt-2 pb-2 " id="blocks" style="width:350px;">
				<div class="col ml-3" style=""><h5 class="h5 mb-0 mt-0" >Отдел расчетов</h5></div>
				<div class="col-md-3" style=""><h5 class="h5 mb-0 mt-0"><span class="badge badge-<?if($SM_delay>=85) echo "success"; 
else if(($SM_delay<85)&&($SM_delay>55)) echo "warning";
else echo "danger";?>"><?echo $SM_delay;?>%</span></h5></div>
            </div>	
			
			<div class="row shadow-lg mt-4 ml-5 mr-5 pt-2 pb-2 " id="blocks" style="width:350px; ">
				<div class="col ml-3" style=""><h5 class="h5 mb-0 mt-0" >Бухгалтерия</h5></div>
				<div class="col-md-3" style=""><h5 class="h5 mb-0 mt-0"><span class="badge badge-<?if($SM_delay>=85) echo "success"; 
else if(($SM_delay<85)&&($SM_delay>55)) echo "warning";
else echo "danger";?>"><?echo $SM_delay;?>%</span></h5></div>
            </div>	
			
			<div class="row shadow-lg mt-4 ml-5 mr-5 pt-2 pb-2 " id="blocks" style="width:350px;">
				<div class="col ml-3" style=""><h5 class="h5 mb-0 mt-0" >Отдел снабжения</div>
				<div class="col-md-3" style=""><h5 class="h5 mb-0 mt-0"><span class="badge badge-<?if($ZM_delay>=85) echo "success"; 
else if(($ZM_delay<85)&&($ZM_delay>55)) echo "warning";
else echo "danger";?>"><?echo $ZM_delay;?>%</span></h5></div>
            </div>	

			<div class="row shadow-lg mt-4 ml-5 mr-5 pt-2 pb-2 " id="blocks" style="width:350px;">
				<div class="col ml-3" style=""><h5 class="h5 mb-0 mt-0" >Конструктор-технолог</h5></div>
				<div class="col-md-3" style=""><h5 class="h5 mb-0 mt-0"><span class="badge badge-<?if($KTR_delay>=85) echo "success"; 
else if(($KTR_delay<85)&&($KTR_delay>55)) echo "warning";
else echo "danger";?>"><?echo $KTR_delay;?>%</span></h5></div>
            </div>	

			<div class="row shadow-lg mt-4 ml-5 mr-5 pt-2 pb-2 " id="blocks" style="width:350px;">
				<div class="col ml-3" style=""><h5 class="h5 mb-0 mt-0" >Отдел производства</h5></div>
				<div class="col-md-3" style=""><h5 class="h5 mb-0 mt-0"><span class="badge badge-<?if($PR_delay>=85) echo "success"; 
else if(($PR_delay<85)&&($PR_delay>55)) echo "warning";
else echo "danger";?>"><?echo $PR_delay;?>%</span></h5></div>
            </div>

			<div class="row shadow-lg mt-4 ml-5 mr-5 pt-2 pb-2 " id="blocks" style="width:350px;">
				<div class="col ml-3" style=""><h5 class="h5 mb-0 mt-0" >Склад</h5></div>
				<div class="col-md-3" style=""><h5 class="h5 mb-0 mt-0"><span class="badge badge-<?if($OZ_delay>=85) echo "success"; 
else if(($OZ_delay<85)&&($OZ_delay>55)) echo "warning";
else echo "danger";?>"><?echo $OZ_delay;?>%</span></h5></div>
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