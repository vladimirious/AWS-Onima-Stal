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



?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Статистика</title>
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
				<a href="gen_dir_projs"><img src="img/proj_sb.png" class="img" title="Проекты"></a>
            </div>
          </div>
          <div class="row-fluid">
            <div class="col text-center nopadding">
              <a href="gen_dir_effect"><img src="img/effect_sb.png" class="img" title="Эффективность"></a>
            </div>
          </div>
		  <div class="row-fluid">
            <div class="col text-center nopadding">
             <img src="img/gen_dir_stat_sb_a.png" class="img">
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
				<button class="exit" type="button" data-target="#exampleModal2" data-toggle="modal" style="border: none;">
					<img src="img/exit-b.png" class="img">
				</button>
            </div>
          </div>
          <div class="row-fluid ml-3">
            <div class="col">
              <p class="sh1">Статистика</p>
            </div>
          </div>
			<form action="" method="POST">
			<div class="row mt-4 mr-5 ml-5 align-items-center" >
				<select class="col-md-9 text-left" name="work_id" id="work_id" style="height:35px; border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20);font-size: small;">				
<?php

					
	if(!$link = mysqli_connect("localhost", "mysql", "mysql", "omima_stal"))
	{
		echo "Нет соединения с сервером"; 
		die();
	}

	$QUERY ="SELECT
		Work_id,
		Work_name
	FROM
		dir_of_works";
	
	$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
	echo "<option selected value ='not_selected'>Все типы работ</option>";
	if($result)
	{
		$rows = mysqli_num_rows($result);
		if ($rows){
			
			for ($i = 0 ; $i < $rows ; ++$i)
			{
				$row = mysqli_fetch_row($result);
				//print_r($result);
				echo "<option value = ".$row[0].">".$row[1]."</option>";
			}
			mysqli_free_result($result);
		}
	}

?>			
				</select>
				
				<button class="col-md-2 btn btn-primary btn-sm ml-5 mr-0" type="submit" name="submit"><small>Получить</small></button>
				
			</div>		  
			</form>
<?
if(isset($_POST['submit']))
{	
	echo '<div class="row-fluid mt-3 ml-5 mr-5">
            <div class="col pl-0">
              <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar pr-3">
                  <table class="table table-hover table-striped table-sm" style="overflow: auto">
                    <thead>
                       <tr>
                         <th scope="col" style="vertical-align: top;">Тип работ</th>
                         <th scope="col" style="vertical-align: top;">Количество проектов</th>
                       </tr>
                     </thead>
                     <tbody>';
	if($_POST['work_id']=="not_selected")
	{
		$QUERY ="SELECT dir_of_works.Work_name, COUNT(projects.Work_id) FROM projects LEFT JOIN dir_of_works ON projects.Work_id=dir_of_works.Work_id GROUP BY dir_of_works.Work_name";
	}
	else
	{
		$QUERY = "SELECT dir_of_works.Work_name, COUNT(projects.Work_id) FROM projects LEFT JOIN dir_of_works ON projects.Work_id=dir_of_works.Work_id WHERE dir_of_works.Work_id='".$_POST['work_id']."' GROUP BY dir_of_works.Work_name";
	}
	$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
	if($result)
	{
		$rows = mysqli_num_rows($result); // количество полученных строк
		for ($i = 0 ; $i < $rows ; ++$i)
		{
			echo "<tr>";
			$row = mysqli_fetch_row($result);
			for ($j = 0 ; $j < 2 ; ++$j) echo "<td>".$row[$j]."</td>";
			echo "</tr>";
		}
		mysqli_free_result($result);
	}
	echo '                     </tbody>
                   </table>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>';
}
?>

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