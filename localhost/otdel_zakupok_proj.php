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

if(!$link = mysqli_connect("localhost", "mysql", "mysql", "omima_stal"))
{
	echo "Нет соединения с сервером"; 
	die();
}

if (isset($_POST['submit']))
{
	$QUERY ="UPDATE project_stages SET Stat_1 = 1 WHERE Proj_id =".$_GET["n"];
	mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
}	

	
$QUERY ="SELECT F_date_SM, P_date_SM, F_date_ZM, P_date_ZM, F_date_KTR, P_date_KTR, F_date_PR, P_date_PR, F_date_OZ, P_date_OZ FROM project_stages WHERE Proj_id =".$_GET["n"].";";
$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
if($result)
{
	$dates = mysqli_fetch_row($result);
	mysqli_free_result($result);
			
}
	
	$QUERY ="SELECT Stat_1, Stat_2, Stat_3, Stat_4 FROM project_stages WHERE Proj_id =".$_GET["n"];

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
					<a href="otdel_zakupok_projs"><img src="img/proj_sb_a.png" class="img"></a>
				</div>
			</div>
        </div>
      </div>
      <div class="col-fluid">
	  <form method="POST">
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
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small><? if($dates[1] == "") echo "Не уст."; else echo date('d.m.Y', strtotime($dates[1]));?></small></td>
						</tr>
						<tr>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small>Факт.дата</small></td>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small><? if($dates[0] == "") echo "Не уст."; else echo date('d.m.Y', strtotime($dates[0]));?></small></td>
							
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
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small><? if($dates[3] == "") echo "Не уст."; else echo date('d.m.Y', strtotime($dates[3]));?></small></td>
						</tr>
						<tr>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small>Факт.дата</small></td>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small><? if($dates[2] == "") echo "Не уст."; else echo date('d.m.Y', strtotime($dates[2]));?></small></td>
						</tr>
						<tr>
							<td class="" colspan="2"  style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070; text-align:center;" ><small><a href="otdel_zakupok_purchase?n=<?echo $_GET["n"];?>">Подробнее</a></small></td>
						</tr>
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
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small><? if($dates[5] == "") echo "Не уст."; else echo date('d.m.Y', strtotime($dates[5]));?></small></td>
						</tr>
						<tr>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small>Факт.дата</small></td>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small><? if($dates[4] == "") echo "Не уст."; else echo date('d.m.Y', strtotime($dates[4]));?></small></td>
						</tr>
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
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small><? if($dates[7] == "") echo "Не уст."; else echo date('d.m.Y', strtotime($dates[7]));?></small></td>
						</tr>
						<tr>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small>Факт.дата</small></td>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small><? if($dates[6] == "") echo "Не уст."; else echo date('d.m.Y', strtotime($dates[6]));?></small></td>
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
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small><? if($dates[9] == "") echo "Не уст."; else echo date('d.m.Y', strtotime($dates[9]));?></small></td>
						</tr>
						<tr>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small>Факт.дата</small></td>
							<td style="background-color: rgba(0,0,0,0.1); border: 1px solid #707070;"><small><? if($dates[8] == "") echo "Не уст."; else echo date('d.m.Y', strtotime($dates[8]));?></small></td>
						</tr>
						<tr>
							<td class="p-0" colspan="2"  style="text-align:center;" ></td>
						</tr>
					 	<tr>
                     </tbody>
                   </table>
              </div> 
            </div>
			<div class="row ml-4 mr-3" style="margin-top: 16.5rem;">
				<div class="col-md-2 p-0 ml-4" >
				
			<?if ($stages_stats[0]==0) echo '
					<button class="btn btn-danger btn-sm btn-block m-0" type="submit" name="submit" title="Нажмите, чтобы отправить на согласование завершение этапа закупки."><small>завершить этап</small></button>';
				else if(($stages_stats[0]==1)&&($dates[2]=="")) echo '
					<div class="text-center" style="background-color: #c3562f; color: #ddd8d5; font-size: 15px; padding-top: 4px; padding-right: 10px; padding-bottom: 4px; padding-left: 10px; border: 2px solid #c6535b; cursor:default"  title="Ожидается согласование завершения этапа закупок."><small>ЗАВЕРШАЕТСЯ..</small></div>';
				else echo "";
				#dc3545
			?>
				</div>
			</div>
        </div>
		</form>
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