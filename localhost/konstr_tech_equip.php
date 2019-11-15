<?php 
session_start();
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

if(isset($_POST['submit']))
{
	$QUERY= "INSERT INTO equip_for_proj (Comments, Proj_id, Equip_id) VALUES ('".$_POST['comment']."', ".$_GET['n'].", ".$_POST['equip_id'].")";
	mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
	header("Location: konstr_tech_ktp?n=".$_GET["n"]."&to_equip=1");
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Оборудование</title>
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
          <div class="row-fluid ml-3">
            <div class="col">
              <p class="sh1">Оборудование</p>
            </div>
          </div>
          <form class="ml-4 mt-5" action="" method="POST">
			<div class="row mt-4 mr-5 align-items-center" style="">
				<div class="col-md-2 text-right" style="">
					Оборудование:
				</div>
				<select required class="col text-left pr-3" name="equip_id" style="height:35px; border: 1px solid rgba(0,0,0,.40); background: rgba(255,255,255,.20);font-size: small;">
					<option value ="">Не выбрано</option>
							
<?php
	$QUERY ="SELECT equipment.*, equip_for_proj.Eq_proj_id, equip_for_proj.Proj_id FROM equipment LEFT JOIN equip_for_proj ON equipment.Equip_id=equip_for_proj.Equip_id WHERE Proj_id IS NULL OR Proj_id<>4";

	$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
	if($result)
	{
		$rows = mysqli_num_rows($result);
		if ($rows){
			for ($i = 0 ; $i < $rows ; ++$i)
			{
				$row = mysqli_fetch_row($result);
				//print_r($result);
				if($i==0)echo "<option value =".$row[0].">НАИМЕНОВАНИЕ: ".$row[1].". SN: ".$row[5].". МЕСТОНАХОЖДЕНИЕ: ".$row[2].".</option>";

			}
			mysqli_free_result($result);
		}
	}
?>

				</select>
			</div>
			<div class="row mt-4 mr-5 align-items-center" style="">
				<div class="col-md-2 text-right">
					Комментарий:
				</div>
				<input class="col form-control" id="username" name="comment" type="text" placeholder="комментарий" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;" >
			</div>
			<div class="row mt-4 mr-5 align-items-center" style="">
				<div class="col-md-2 text-right"></div>
				<button class="col-md-2 btn btn-primary btn-block btn-sm ml-0" type="submit" name="submit"><small>Добавить</small></button>
			</div>
		 </form>
		  
		  
		  
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