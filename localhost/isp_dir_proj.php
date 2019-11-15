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

if (isset($_POST['submit']))
{
	//"F_date_ZM, P_date_ZM, F_date_KTR, P_date_KTR, F_date_PR, P_date_PR, F_date_OZ, P_date_OZ FROM project_stages WHERE Proj_id =".$_GET["n"].";";
	if($_POST['P_date_ZM']!=""){
		$QUERY = "UPDATE project_stages SET P_date_ZM='".$_POST['P_date_ZM']."' WHERE Proj_id=".$_GET["n"];
		mysqli_query($link, $QUERY) or die("Ошибка".mysqli_error($link));
	}
	if($_POST['P_date_KTR']!=""){
		$QUERY = "UPDATE project_stages SET P_date_KTR='".$_POST['P_date_KTR']."' WHERE Proj_id=".$_GET["n"];
		mysqli_query($link, $QUERY) or die("Ошибка".mysqli_error($link));
	}
	if($_POST['P_date_PR']!=""){
		$QUERY = "UPDATE project_stages SET P_date_PR='".$_POST['P_date_PR']."' WHERE Proj_id=".$_GET["n"];
		mysqli_query($link, $QUERY) or die("Ошибка".mysqli_error($link));
	}
	if($_POST['P_date_OZ']!=""){
		$QUERY = "UPDATE project_stages SET P_date_OZ='".$_POST['P_date_OZ']."' WHERE Proj_id=".$_GET["n"];
		mysqli_query($link, $QUERY) or die("Ошибка".mysqli_error($link));
	}	
}	

$QUERY ="SELECT F_date_SM, P_date_SM, F_date_ZM, P_date_ZM, F_date_KTR, P_date_KTR, F_date_PR, P_date_PR, F_date_OZ, P_date_OZ FROM project_stages WHERE Proj_id =".$_GET["n"].";";

$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
if($result)
{
	$dates = mysqli_fetch_row($result);
	mysqli_free_result($result);
}
	$QUERY ="SELECT Stat_1, Stat_2, Stat_3, Stat_4 FROM project_stages WHERE Proj_id =".$_GET["n"].";";
	$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
	if($result)
	{
		$stages_stats = mysqli_fetch_row($result);
		mysqli_free_result($result);
	}
	
	$QUERY ="SELECT Stat_2, Stat_1 FROM projects WHERE Proj_id =".$_GET["n"].";";

	$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
	if($result)
	{
		$stats = mysqli_fetch_row($result);
		mysqli_free_result($result);	
	}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Этапы проекта</title>
    <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="./css/bootstrap.min.css">
    <!-- Fluent Design Bootstrap -->
  <link rel="stylesheet" href="./css/fluent.css">
    <!-- Micon icons-->
  <link rel="stylesheet" href="./css/micon.min.css">
    <!--Custom style -->
  <style>

	::-webkit-inner-spin-button { display: none;}
	::-webkit-calendar-picker-indicator { position: relative; top: 0px; left:9px; padding: 0px;}
	::-webkit-datetime-edit-day-field {padding:0px;  }
	::-webkit-datetime-edit-year-field {padding:0px; }
	::-webkit-datetime-edit-month-field {padding:0px; }
	::-webkit-datetime-edit-fields-wrapper {padding:0px; }
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
				<a href="isp_dir_projs"><img src="img/proj_sb_a.png" class="img" title="Проекты"></a>
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
          <div class="row-fluid ml-3">
            <div class="col">
              <p class="sh1">Этапы проекта</p>
            </div>
          </div>
		  <?if($stats[1]==0) echo '<form method="POST">';?>
            <div class="row mt-1 ml-4 mr-3">
			
			  <div class="col-md-2 p-0 ml-4" >
                  <table class="table table-sm" >
                     <tbody>
						<tr> 
							<td  colspan="2"  style="text-align:center; border-top: 0px"><img src="<?if($dates[0]!="") echo "img/ready.png"; else echo "img/active.png";?>" class="img mb-2"></td>
						</tr>
					 	<tr>
							<td  colspan="2" style="text-align:center; border: 1px solid #707070; background-color: rgba(0,0,0,0.1);"><small>Подготовка договора</small></td>
						</tr>
						<tr>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small>План.дата</small></td>
							<td class="p-0" style="border: 1px solid #707070;"><input name="P_date_SM" type="date" value="<? if($dates[1] == "") {echo ""; echo '" style="padding-left: 0.25rem; padding-top: 0.45rem; border: 0px; background-color: rgba(255,255,255,.0); font-size: small; width:84px;"';} else {echo $dates[1]; echo '"style="padding-left: 0.25rem; padding-top: 0.45rem; border: 0px; background-color: rgba(0,0,0,.1); font-size: small; width:84px;" readonly';}if($stats[1]==1) echo "readonly";?>></td> 
						</tr>
						<tr>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small>Факт.дата</small></td>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small><? if($dates[0] == "") echo "Не уст."; else echo date('d.m.Y', strtotime($dates[0]));?></small></td>
							
						</tr>
						<tr>
							<td class="" colspan="2"  style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070; text-align:center;" ><small><a href="isp_dir_cont_prep?n=<?echo $_GET["n"];?>">Подробнее</a></small></td>
						</tr>
						
						
                     </tbody>
                   </table>
              </div>
			  
			  <div class="col-md-2 p-0 ml-4" >
                  <table class="table table-sm" >
                     <tbody>
						<tr>
							<td  colspan="2"  style="text-align:center; border-top: 0px"><img src="<?if(($stages_stats[0]==1)&&($dates[2]!="")) echo "img/ready.png"; else if($dates[0]!=""){echo "img/active.png";} else echo "img/not_active.png";?>" class="img mb-2"></td>
						</tr>
					 	<tr>
							<td  colspan="2" style="text-align:center; border: 1px solid #707070; background-color: rgba(0,0,0,0.1);"><small>Закупка</small></td>
						</tr>
						<tr>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small>План.дата</small></td>
							<td class="p-0" style="border: 1px solid #707070;"><input name="P_date_ZM" min="<?echo date("Y-m-d");?>" type="date" value="<? if($dates[3] == "") {echo ""; echo '" style="padding-left: 0.25rem; padding-top: 0.45rem; border: 0px; background-color: rgba(255,255,255,.0); font-size: small; width:84px;"';} else {echo $dates[3]; echo '"style="padding-left: 0.25rem; padding-top: 0.45rem; border: 0px; background-color: rgba(0,0,0,.1); font-size: small; width:84px;" readonly';}if($stats[1]==1) echo "readonly";?>></td>
						</tr>
						<tr>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small>Факт.дата</small></td>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small><? if($dates[2] == "") echo "Не уст."; else echo date('d.m.Y', strtotime($dates[2]));?></small></td>
						</tr>
						<tr>
							<td class="" colspan="2"  style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070; text-align:center;" ><small><a href="isp_dir_purchase?n=<?echo $_GET["n"];?>">Подробнее</a></small></td>
						</tr>
						

						
						
						<?
						if($dates[3]=="")
						echo '
						<tr>
							<td class="p-0" style="border: 0px solid #707070;" colspan="2">
								<div class="m-0" name="cust_id">
									<button class="btn btn-primary btn-sm btn-block m-0" type="submit" name="submit"><small>Сохранить</small></button>
								</div>
							</td>
						</tr>';
						
						if(($stages_stats[0]==1)&&($dates[2]==""))
							echo '<tr>
							<td class="p-0" style="border: 1px solid #707070;" colspan="2">
								<div class="dropdown">
								  <button class="btn btn-warning btn-sm btn-block dropdown-toggle m-0" id="dropdownMenuButton" aria-expanded="false" aria-haspopup="true" type="button" data-toggle="dropdown" title="Исполнители выставили отметку о выполненных на данном этапе работах. Нажмите \'Принять\', чтобы выставить фактическую дату завершения этапа и перейти к следующему и \'Отклонить\', чтобы отправить этап на доработку.">
									<small>Завершить этап</small>
								  </button>
								  <div class="dropdown-menu m-0 p-0" aria-labelledby="dropdownMenuButton" style="border: 0px solid #707070; left: 0px; top: 0px; position: absolute; transform: translate3d(5px, 49px, 0px); width: 100px; background-color: rgba(0,0,0,.3); " x-placement="bottom-start">
									<a class="dropdown-item pt-2 pb-2 pr-0" href="stages_ending?n='.$_GET["n"].'&stage=ZM&des=true" style="color: white;"><small>Принять</small></a>
									<a class="dropdown-item pt-2 pb-2 pr-0" href="stages_ending?n='.$_GET["n"].'&stage=ZM&des=false" style="color: white;"><small>Отклонить</small></a>
								  </div>
								</div>
							
							</td>
						</tr>';

						
						
						?>
                     </tbody>
                   </table>
              </div>
			  
			  <div class="col-md-2 p-0 ml-4" >
                  <table class="table table-sm" >
                     <tbody>
						<tr>
							<td  colspan="2"  style="text-align:center; border-top: 0px"><img src="<?if(($stages_stats[1]==1)&&($dates[4]!="")) echo "img/ready.png"; else if($dates[2]!=""){echo "img/active.png";} else echo "img/not_active.png";?>" class="img mb-2"></td>
						</tr>
					 	<tr>
							<td  colspan="2" style="text-align:center; border: 1px solid #707070; background-color: rgba(0,0,0,0.1);"><small>КТП</small></td>
						</tr>
						<tr>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small>План.дата</small></td>
							<td class="p-0" style="border: 1px solid #707070;"><input name="P_date_KTR" type="date" min="<?echo date("Y-m-d");?>" value="<? if($dates[5] == "") {echo ""; echo '" style="padding-left: 0.25rem; padding-top: 0.45rem; border: 0px; background-color: rgba(255,255,255,.0); font-size: small; width:84px;"';} else {echo $dates[5]; echo '"style="padding-left: 0.25rem; padding-top: 0.45rem; border: 0px; background-color: rgba(0,0,0,.1); font-size: small; width:84px;" readonly';}if($stats[1]==1) echo "readonly";?>></td>
						</tr>
						<tr>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small>Факт.дата</small></td>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small><? if($dates[4] == "") echo "Не уст."; else echo date('d.m.Y', strtotime($dates[4]));?></small></td>
						</tr>
						<tr>
							<td class="" colspan="2"  style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070; text-align:center;" ><small><a href="isp_dir_ktp?n=<?echo $_GET["n"];?>">Подробнее</a></small></td>
						</tr>
					 	<tr>
						<?
						if($dates[5]=="")
						echo '
						<tr>
							<td class="p-0" style="border: 0px solid #707070;" colspan="2">
								<div class="m-0" name="cust_id">
									<button class="btn btn-primary btn-sm btn-block m-0" type="submit" name="submit"><small>Сохранить</small></button>
								</div>
							</td>
						</tr>';	
						if(($stages_stats[1]==1)&&($dates[4]==""))
						echo '<tr>
							<td class="p-0" style="border: 0px solid #707070;" colspan="2">
								<div class="dropdown">
								  <button class="btn btn-warning btn-sm btn-block dropdown-toggle m-0" id="dropdownMenuButton" aria-expanded="false" aria-haspopup="true" type="button" data-toggle="dropdown" title="Исполнители выставили отметку о выполненных на данном этапе работах. Нажмите \'Принять\', чтобы выставить фактическую дату завершения этапа и перейти к следующему и \'Отклонить\', чтобы отправить этап на доработку.">
									<small>Завершить этап</small>
								  </button>
								  <div class="dropdown-menu m-0 p-0" aria-labelledby="dropdownMenuButton" style="border: 0px solid #707070; left: 0px; top: 0px; position: absolute; transform: translate3d(5px, 49px, 0px); width: 100px; background-color: rgba(0,0,0,.3); " x-placement="bottom-start">
									<a class="dropdown-item pt-2 pb-2 pr-0" href="stages_ending?n='.$_GET["n"].'&stage=KTR&des=true" style="color: white;"><small>Принять</small></a>
									<a class="dropdown-item pt-2 pb-2 pr-0" href="stages_ending?n='.$_GET["n"].'&stage=KTR&des=false" style="color: white;"><small>Отклонить</small></a>
								  </div>
								</div>
							
							</td>
						</tr>';
						?>
                     </tbody>
                   </table>
              </div>
			  
			  <div class="col-md-2 p-0 ml-4" >
                  <table class="table table-sm" >
                     <tbody>
						<tr>
							<td  colspan="2"  style="text-align:center; border-top: 0px"><img src="<?if(($stages_stats[2]==1)&&($dates[6]!="")) echo "img/ready.png"; else if($dates[4]!=""){echo "img/active.png";} else echo "img/not_active.png";?>" class="img mb-2"></td>
						</tr>
					 	<tr>
							<td  colspan="2" style="text-align:center; border: 1px solid #707070; background-color: rgba(0,0,0,0.1);"><small>Произв. работы</small></td>
						</tr>
						<tr>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small>План.дата</small></td>
							<td class="p-0" style="border: 1px solid #707070;"><input name="P_date_PR" type="date" min="<?echo date("Y-m-d");?>" value="<? if($dates[7] == "") {echo ""; echo '" style="padding-left: 0.25rem; padding-top: 0.45rem; border: 0px; background-color: rgba(255,255,255,.0); font-size: small; width:84px;"';} else {echo $dates[7]; echo '"style="padding-left: 0.25rem; padding-top: 0.45rem; border: 0px; background-color: rgba(0,0,0,.1); font-size: small; width:84px;" readonly';}if($stats[1]==1) echo "readonly";?>></td>
						</tr>
						<tr>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small>Факт.дата</small></td>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small><? if($dates[6] == "") echo "Не уст."; else echo date('d.m.Y', strtotime($dates[6]));?></small></td>
						</tr>
						<tr>
							<td class="p-0" colspan="2"  style="text-align:center;" ></td>
						</tr>
					 	<tr>
						<?
						if($dates[7]=="")
						echo '
						<tr>
							<td class="p-0" style="border: 0px solid #707070;" colspan="2">
								<div class="m-0" name="cust_id">
									<button class="btn btn-primary btn-sm btn-block m-0" type="submit" name="submit"><small>Сохранить</small></button>
								</div>
							</td>
						</tr>';	
						
						if(($stages_stats[2]==1)&&($dates[6]==""))
						echo '<tr>
							<td class="p-0" style="border: 1px solid #707070;" colspan="2">
								<div class="dropdown">
								  <button class="btn btn-warning btn-sm btn-block dropdown-toggle m-0" id="dropdownMenuButton" aria-expanded="false" aria-haspopup="true" type="button" data-toggle="dropdown" title="Исполнители выставили отметку о выполненных на данном этапе работах. Нажмите \'Принять\', чтобы выставить фактическую дату завершения этапа и перейти к следующему и \'Отклонить\', чтобы отправить этап на доработку.">
									<small>Завершить этап</small>
								  </button>
								  <div class="dropdown-menu m-0 p-0" aria-labelledby="dropdownMenuButton" style="border: 0px solid #707070; left: 0px; top: 0px; position: absolute; transform: translate3d(5px, 49px, 0px); width: 100px; background-color: rgba(0,0,0,.3); " x-placement="bottom-start">
									<a class="dropdown-item pt-2 pb-2 pr-0" href="stages_ending?n='.$_GET["n"].'&stage=PR&des=true" style="color: white;"><small>Принять</small></a>
									<a class="dropdown-item pt-2 pb-2 pr-0" href="stages_ending?n='.$_GET["n"].'&stage=PR&des=false" style="color: white;"><small>Отклонить</small></a>
								  </div>
								</div>
							
							</td>
						</tr>';
						?>
                     </tbody>
                   </table>
              </div>
			  
			  <div class="col-md-2 p-0 ml-4" >
                  <table class="table table-sm" >
                     <tbody>
						<tr>
							<td  colspan="2"  style="text-align:center; border-top: 0px"><img src="<?if(($stages_stats[3]==1)&&($stats[0]!=0)) echo "img/ready.png"; else if($stages_stats[3]==1){echo "img/active.png";} else echo "img/not_active.png";?>" class="img mb-2"></td>
						</tr>
					 	<tr>
							<td  colspan="2" style="text-align:center; border: 1px solid #707070; background-color: rgba(0,0,0,0.1);"><small>Отгрузка</small></td>
						</tr>
						<tr>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small>План.дата</small></td>
							<td class="p-0" style="border: 1px solid #707070;"><input name="P_date_OZ" type="date" min="<?echo date("Y-m-d");?>" value="<? if($dates[9] == "") {echo ""; echo '" style="padding-left: 0.25rem; padding-top: 0.45rem; border: 0px; background-color: rgba(255,255,255,.0); font-size: small; width:84px;"';} else {echo $dates[9]; echo '"style="padding-left: 0.25rem; padding-top: 0.45rem; border: 0px; background-color: rgba(0,0,0,.1); font-size: small; width:84px;" readonly';}if($stats[1]==1) echo "readonly";?>></td>
						</tr>
						<tr>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small>Факт.дата</small></td>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small><? if($dates[8] == "") echo "Не уст."; else echo date('d.m.Y', strtotime($dates[8]));?></small></td>
						</tr>
						<tr>
							<td class="p-0" colspan="2"  style="text-align:center;" ></td>
						</tr>
					 	<tr>
						<?
						if($dates[9]=="")
						echo '
						<tr>
							<td class="p-0" style="border: 0px solid #707070;" colspan="2">
								<div class="m-0" name="cust_id">
									<button class="btn btn-primary btn-sm btn-block m-0" type="submit" name="submit"><small>Сохранить</small></button>
								</div>
							</td>
						</tr>';	
						
						if(($stages_stats[3]==1)&&($dates[8]==""))
						echo '<tr>
							<td class="p-0" style="border: 1px solid #707070;" colspan="2">
								<div class="dropdown">
								  <button class="btn btn-warning btn-sm btn-block dropdown-toggle m-0" id="dropdownMenuButton" aria-expanded="false" aria-haspopup="true" type="button" data-toggle="dropdown" title="Исполнители выставили отметку о выполненных на данном этапе работах. Нажмите \'Принять\', чтобы выставить фактическую дату завершения этапа и перейти к следующему и \'Отклонить\', чтобы отправить этап на доработку.">
									<small>Завершить этап</small>
								  </button>
								  <div class="dropdown-menu m-0 p-0" aria-labelledby="dropdownMenuButton" style="border: 0px solid #707070; left: 0px; top: 0px; position: absolute; transform: translate3d(5px, 49px, 0px); width: 100px; background-color: rgba(0,0,0,.3); " x-placement="bottom-start">
									<a class="dropdown-item pt-2 pb-2 pr-0" href="stages_ending?n='.$_GET["n"].'&stage=OZ&des=true" style="color: white;"><small>Принять</small></a>
									<a class="dropdown-item pt-2 pb-2 pr-0" href="stages_ending?n='.$_GET["n"].'&stage=OZ&des=false" style="color: white;"><small>Отклонить</small></a>
								  </div>
								</div>
							
							</td>
						</tr>';

						?>
                     </tbody>
                   </table>
              </div> 
            </div>
			


			</div>
			<?if($stats[1]==0) echo '</form>';?>
			

			
			
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


	</script>
	<!-- JQuery -->
  <script type="text/javascript" src="./js/jquery-3.3.1.min.js"></script>
    <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="./js/popper.min.js"></script>
  	<!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="./js/bootstrap.min.js"></script>
</body>

</html>