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
	if($_POST['status']=="is_done"){
		if($_POST['P_date_SM']!=""){
			$QUERY = "UPDATE project_stages SET P_date_SM='".$_POST['P_date_SM']."' WHERE Proj_id=".$_GET["n"];
			if($_POST['F_date_SM']!=""){
				$QUERY ="UPDATE project_stages SET P_date_SM='".$_POST['P_date_SM']."', F_date_SM='".$_POST['F_date_SM']."' WHERE Proj_id=".$_GET["n"];
			}
			mysqli_query($link, $QUERY) or die("Ошибка 1".mysqli_error($link));	
		}
		$QUERY = "UPDATE projects SET Stat_1=0, Stat_2=0 WHERE Proj_id=".$_GET["n"];
		mysqli_query($link, $QUERY) or die("Ошибка 2".mysqli_error($link));	
	}
	else if($_POST['status']=="0"){
		if($_POST['P_date_SM']!=""){
			$QUERY = "UPDATE project_stages SET P_date_SM='".$_POST['P_date_SM']."' WHERE Proj_id=".$_GET["n"];
			if($_POST['F_date_SM']!=""){
				$QUERY ="UPDATE project_stages SET P_date_SM='".$_POST['P_date_SM']."', F_date_SM='".$_POST['F_date_SM']."' WHERE Proj_id=".$_GET["n"];
			}
			mysqli_query($link, $QUERY) or die("Ошибка 1".mysqli_error($link));	
		}
		$QUERY = "UPDATE projects SET Stat_1=1, Stat_2=0 WHERE Proj_id=".$_GET["n"];
		mysqli_query($link, $QUERY) or die("Ошибка 2".mysqli_error($link));		
		$QUERY = "UPDATE projects SET End_date = '".date("Y-m-d")."' WHERE Proj_id=".$_GET["n"];
		mysqli_query($link, $QUERY) or die("Ошибка 3".mysqli_error($link));
	}
	else if($_POST['status']=="1"){
		if($_POST['P_date_SM']!=""){
			$QUERY = "UPDATE project_stages SET P_date_SM='".$_POST['P_date_SM']."' WHERE Proj_id=".$_GET["n"];
			if($_POST['F_date_SM']!=""){
				$QUERY ="UPDATE project_stages SET P_date_SM='".$_POST['P_date_SM']."', F_date_SM='".$_POST['F_date_SM']."' WHERE Proj_id=".$_GET["n"];
			}
			mysqli_query($link, $QUERY) or die("Ошибка 1".mysqli_error($link));	
		}
		$QUERY = "UPDATE projects SET Stat_1=1, Stat_2=1 WHERE Proj_id=".$_GET["n"];
		mysqli_query($link, $QUERY) or die("Ошибка 2".mysqli_error($link));
		$QUERY = "UPDATE projects SET End_date = '".date("Y-m-d")."' WHERE Proj_id=".$_GET["n"];
		mysqli_query($link, $QUERY) or die("Ошибка 3".mysqli_error($link));		
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
				<form action="" method="POST">
					<button class="exit" name="logout" value="logout" type="submit" style="border: none;">
						<img src="img/exit-b.png" class="img">
					</button>
				</form>
            </div>
          </div>
          <div class="row-fluid ml-3">
            <div class="col">
              <p class="sh1">Этапы проекта</p>
            </div>
          </div>
		  <form method="POST">
            <div class="row mt-1 ml-4 mr-3">
			
			  <div class="col-md-2 p-0 ml-4" >
                  <table class="table table-sm" >
                     <tbody>
						<tr> 
							<td  colspan="2"  style="text-align:center; border-top: 0px"><img src="<?if($stages_stats[0]==1) echo "img/ready.png"; else echo "img/active.png";?>" class="img mb-2"></td>
						</tr>
					 	<tr>
							<td  colspan="2" style="text-align:center; border: 1px solid #707070; background-color: rgba(0,0,0,0.1);"><small>Подготовка договора</small></td>
						</tr>
						<tr>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small>План.дата</small></td>
							<td class="p-0" style="border: 1px solid #707070;"><input name="P_date_SM" type="date" value="<? if($dates[1] == "") echo ""; else echo $dates[1];?>" style="padding-left: 0.35rem; padding-top: 0.45rem; border: 0px; background-color: rgba(255,255,255,.0); font-size: small; width:84px;"></td> 
						</tr>
						<tr>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small>Факт.дата</small></td>
							<td class="p-0" style="border: 1px solid #707070;"><input name="F_date_SM" type="date" value="<? if($dates[0] == "") echo ""; else echo $dates[0];?>" style="padding-left: 0.35rem; padding-top: 0.45rem; border: 0px; background-color: rgba(255,255,255,.0); font-size: small; width:84px;"></td> 
						</tr>
						<tr>
							<td class="" colspan="2"  style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070; text-align:center;" ><small><a href="gen_dir_cont_prep?n=<?echo $_GET["n"];?>">Подробнее</a></small></td>
						</tr>
					 	<tr>
                     </tbody>
                   </table>
              </div>
			  
			  <div class="col-md-2 p-0 ml-4" >
                  <table class="table table-sm" >
                     <tbody>
						<tr>
							<td  colspan="2"  style="text-align:center; border-top: 0px"><img src="<?if($stages_stats[1]==1) echo "img/ready.png"; else if($stages_stats[0]==1){echo "img/active.png";} else echo "img/not_active.png";?>" class="img mb-2"></td>
						</tr>
					 	<tr>
							<td  colspan="2" style="text-align:center; border: 1px solid #707070; background-color: rgba(0,0,0,0.1);"><small>Закупка</small></td>
						</tr>
						<tr>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small>План.дата</small></td>
							<td class="p-0" style="border: 1px solid #707070;"><input disabled class="" type="date" value="<? if($dates[3] == "") echo ""; else echo $dates[3];?>" style="padding-left: 0.35rem; padding-top: 0.45rem; border: 0px; background-color: rgba(255,255,255,.0); font-size: small; width:84px;"></td> 
						</tr>
						<tr>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small>Факт.дата</small></td>
							<td class="p-0" style="border: 1px solid #707070;"><input disabled class="" type="date" value="<? if($dates[2] == "") echo ""; else echo $dates[2];?>" style="padding-left: 0.35rem; padding-top: 0.45rem; border: 0px; background-color: rgba(255,255,255,.0); font-size: small; width:84px;"></td> 
						</tr>
						<tr>
							<td class="" colspan="2"  style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070; text-align:center;" ><small><a href="gen_dir_purchase?n=<?echo $_GET["n"];?>">Подробнее</a></small></td>
						</tr>
					 	<tr>
                     </tbody>
                   </table>
              </div>
			  
			  <div class="col-md-2 p-0 ml-4" >
                  <table class="table table-sm" >
                     <tbody>
						<tr>
							<td  colspan="2"  style="text-align:center; border-top: 0px"><img src="<?if($stages_stats[2]==1) echo "img/ready.png"; else if($stages_stats[1]==1){echo "img/active.png";} else echo "img/not_active.png";?>" class="img mb-2"></td>
						</tr>
					 	<tr>
							<td  colspan="2" style="text-align:center; border: 1px solid #707070; background-color: rgba(0,0,0,0.1);"><small>КТП</small></td>
						</tr>
						<tr>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small>План.дата</small></td>
							<td class="p-0" style="border: 1px solid #707070;"><input disabled class="" type="date" value="<? if($dates[5] == "") echo ""; else echo $dates[5];?>" style="padding-left: 0.35rem; padding-top: 0.45rem; border: 0px; background-color: rgba(255,255,255,.0); font-size: small; width:84px;"></td> 
						</tr>
						<tr>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small>Факт.дата</small></td>
							<td class="p-0" style="border: 1px solid #707070;"><input disabled class="" type="date" value="<? if($dates[4] == "") echo ""; else echo $dates[4];?>" style="padding-left: 0.35rem; padding-top: 0.45rem; border: 0px; background-color: rgba(255,255,255,.0); font-size: small; width:84px;"></td> 
						</tr>
						<tr>
							<td class="" colspan="2"  style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070; text-align:center;" ><small><a href="gen_dir_ktp?n=<?echo $_GET["n"];?>">Подробнее</a></small></td>
						</tr>
					 	<tr>
                     </tbody>
                   </table>
              </div>
			  
			  <div class="col-md-2 p-0 ml-4" >
                  <table class="table table-sm" >
                     <tbody>
						<tr>
							<td  colspan="2"  style="text-align:center; border-top: 0px"><img src="<?if($stages_stats[3]==1) echo "img/ready.png"; else if($stages_stats[2]==1){echo "img/active.png";} else echo "img/not_active.png";?>" class="img mb-2"></td>
						</tr>
					 	<tr>
							<td  colspan="2" style="text-align:center; border: 1px solid #707070; background-color: rgba(0,0,0,0.1);"><small>Произв. работы</small></td>
						</tr>
						<tr>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small>План.дата</small></td>
							<td class="p-0" style="border: 1px solid #707070;"><input disabled class="" type="date" value="<? if($dates[7] == "") echo ""; else echo $dates[7];?>" style="padding-left: 0.35rem; padding-top: 0.45rem; border: 0px; background-color: rgba(255,255,255,.0); font-size: small; width:84px;"></td> 
						</tr>
						<tr>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small>Факт.дата</small></td>
							<td class="p-0" style="border: 1px solid #707070;"><input disabled class="" type="date" value="<? if($dates[6] == "") echo ""; else echo $dates[6];?>" style="padding-left: 0.35rem; padding-top: 0.45rem; border: 0px; background-color: rgba(255,255,255,.0); font-size: small; width:84px;"></td> 
						</tr>
						<tr>
							<td class="p-0" colspan="2"  style="text-align:center;" ></td>
						</tr>
					 	<tr>
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
							<td class="p-0" style="border: 1px solid #707070;"><input disabled class="" type="date" value="<? if($dates[9] == "") echo ""; else echo $dates[9];?>" style="padding-left: 0.35rem; padding-top: 0.45rem; border: 0px; background-color: rgba(255,255,255,.0); font-size: small; width:84px;"></td> 
						</tr>
						<tr>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small>Факт.дата</small></td>
							<td class="p-0" style="border: 1px solid #707070;"><input disabled class="" type="date" value="<? if($dates[8] == "") echo ""; else echo $dates[8];?>" style="padding-left: 0.35rem; padding-top: 0.45rem; border: 0px; background-color: rgba(255,255,255,.0); font-size: small; width:84px;"></td> 
						</tr>
						<tr>
							<td class="p-0" colspan="2"  style="text-align:center;" ></td>
						</tr>
					 	<tr>
                     </tbody>
                   </table>
              </div> 
            </div>
			
			<div class="row-fluid mt-3 ml-3">
				<div class="col">
				  <p class="sh1">Статусы проекта</p>
				</div>
			</div>
			<div class="row mt-4 ml-5 mr-3 align-items-center">
				<div class="col-md-2" style="">
					Статусы:
				</div>
				<select class="col-md-3 text-left pr-3" name="status" id="status" style="height:35px; border: 1px solid #707070; background: rgba(0,0,0,0.2);font-size: small;">
					<option <?if(($stats[0]==0)&&($stats[1]==0)) echo "selected";?> value ="is_done" style="color: #FFB900">Исполняется</option>";
					<option <?if(($stats[0]==0)&&($stats[1]==1)) echo "selected";?> value ="0" style="color:#DA3B01">Не выполнен и завершен</option>";
					<option <?if(($stats[0]==1)&&($stats[1]==1)) echo "selected";?> value ="1" style="color:#10893E">Выполнен и завершен</option>";
				</select>
			</div>
			<div class="row mt-4 ml-5 mr-3 align-items-center">
				<div class="col-md-2" style=""></div>
				<div class="col-md-2 p-0" name="cust_id">
					<button class="btn btn-primary btn-sm btn-block m-0" type="submit" name="submit">Сохранить</button>
				</div>
			</div>
			</form>
        </div>
      </div>
    </div>
</div>
</div>
	
	<!-- Scripts -->
	<script>

	window.onload=function(){
		var status = document.getElementById("status");
		var selected_color = status.options[status.selectedIndex].style.color;
		document.getElementById("status").style.color = selected_color;
		
		status.addEventListener("click", function() {
			selected_color = status.options[status.selectedIndex].style.color;
			document.getElementById("status").style.color = selected_color;
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