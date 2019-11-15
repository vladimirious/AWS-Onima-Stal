<?php 
session_start();
if (!isset($_SESSION['hash'])) 
{
		header("Location: login");
		exit;
}
if ($_SESSION['Interface']!='nach_sklada')
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
$result = mysqli_query($link,"SELECT Equip_name, Serial_N, Location, Dat_st_exp, Tem_of_exp, Cost FROM equipment WHERE Equip_id=".$_GET["n"]);
$row =  mysqli_fetch_row($result);
mysqli_free_result($result);

$QUERY = "SELECT COUNT(projects.Proj_id) FROM equipment LEFT JOIN equip_for_proj ON equipment.Equip_id=equip_for_proj.Equip_id LEFT JOIN projects ON equip_for_proj.Proj_id=projects.Proj_id WHERE equipment.Equip_id='".$_GET['n']."' AND projects.Stat_1=0";
$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
$enable_del = mysqli_fetch_row($result);
$enable_del = $enable_del[0];
if ($enable_del==0) $enable_del=0;
else $enable_del=1;
	


if(isset($_POST['delete']))
{
	$QUERY = 'DELETE FROM equipment WHERE Equip_id='.$_GET["n"];
	mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
	header("Location: nach_sklada_equip");
	exit;
}	


if(isset($_POST['submit']))
{	
	$QUERY = 'UPDATE equipment SET Location="'.form_control($_POST['place']).'" WHERE Equip_id='.$_GET["n"];
	mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
	header("Location: nach_sklada_equip");
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Изменить оборудование</title>
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
				<a href="nach_sklada_projs"><img src="img/proj_sb.png" class="img" title="Проекты"></a>
            </div>
          </div>
		  <div class="row-fluid">
            <div class="col text-center nopadding">
            <a href="nach_sklada_equip"><img src="img/equip_sb.png" class="img" title="Оборудование"></a>
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
              <p class="sh1">Изменить оборудование</p>
            </div>
          </div>
		  
				<form action="" method="POST">
					<div class="row mt-5 mr-5 align-items-center" style="">
						<div class="col-md-3 text-right" style="">
							Наименование:
						</div>
						<input disabled required class="col form-control" name="name" value="<?echo $row[0];?>" type="text" placeholder="наименование" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(0,0,0,.10); font-size: small;">
						<div class="col-md-3 ml-4">	</div>

					</div>
					
					<div class="row mt-4 mr-5 align-items-center" style="">
						<div class="col-md-3 text-right" style="">
							Серийный номер:
						</div>
						<input disabled required class="col form-control" name="ser_n" value="<?echo $row[1];?>" type="text" placeholder="серийный номер" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(0,0,0,.10); font-size: small;">
						<div class="col-md-3 ml-4"></div>
					</div>
					
					<div class="row mt-4 mr-5 align-items-center" style="">
						<div class="col-md-3 text-right" style="">
							Местонахождение:
						</div>
						<input autofocus required class="col form-control" name="place" value="<?echo $row[2];?>" type="text" placeholder="ремонт/цех/площадка" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;">
						<div class="col-md-3 ml-4"></div>
					</div>

					<div class="row mt-4 mr-5 align-items-center" style="">
						<div class="col-md-3 text-right" style="">
							Дата введения в эксп.:
						</div>
						<input disabled required class="col form-control" name="d_of_exp" value="<?echo $row[3];?>" type="date" max="<? echo date("Y-m-d");?>" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(0,0,0,.10); font-size: small;">
						<div class="col-md-3 ml-4"></div>
					</div>
					
					<div class="row mt-4 mr-5 align-items-center" style="">
						<div class="col-md-3 text-right" style="">
							Срок службы:
						</div>
						<input disabled required class="col form-control" name="l_of_ser" value="<?echo $row[4];?>" type="text" placeholder="информация" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(0,0,0,.10); font-size: small;">
						<div class="col-md-3 ml-4"></div>
					</div>
					
					<div class="row mt-4 mr-5 align-items-center" style="">
						<div class="col-md-3 text-right" style="">
							Цена:
						</div>
						<input disabled required class="col form-control" name="price" value="<?echo $row[5];?>" type="number" placeholder="цена" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(0,0,0,.10); font-size: small;">
						<div class="col-md-3 ml-4"></div>
					</div>

					<div class="row mt-4 mr-5 align-items-center" style="">
						<div class="col-md-3"></div>
						<button class="col-md-2 btn btn-primary btn-block btn-sm ml-0 mt-0 mb-0 mr-0" type="submit" name="submit"><small>Изменить</small></button>
						<?if($enable_del) echo '<div class="col-md-2 text-center ml-4" style="background-color: #c3562f; color: #ddd8d5; font-size: 15px; padding-top: 4px; padding-right: 10px; padding-bottom: 4px; padding-left: 10px; border: 2px solid #c6535b; cursor:default"  title="Удаление невозможно. Оборудование используется в незавершенном проекте."><small>УДАЛИТЬ</small></div>';
						else echo '<button class="col-md-2 btn btn-danger btn-block btn-sm ml-4 mt-0 mb-0 mr-0" type="submit" name="delete"><small>Удалить</small></button>';?>
							
					</div>
				</form>
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