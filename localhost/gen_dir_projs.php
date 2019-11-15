<?php 
session_start();
$err = 0;
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

if(isset($_POST['submit']))
	{	
		//if($_POST['new_type_of_work']=="") echo "ЭТО НОВЫЙ ТИП РАБОТ ".$_POST['new_type_of_work']."<BR>";
		//echo "ЭТО ВЫБРАННЫЙ ТИП РАБОТ".$_POST['work_id']."<BR>";
		
		if(($_POST['work_id']=="not_selected")&&($_POST['new_type_of_work']=="")) 
		{
			$err=1;
		}
		
		else
		{
			if(!$link = mysqli_connect("localhost", "mysql", "mysql", "omima_stal"))
			{
				echo "Нет соединения с сервером"; 
				die();
			}
			$work_id = $_POST['work_id'];
			if($_POST['work_id']=="not_selected"){ //значит введен новый вид работ
				mysqli_query($link, 'INSERT INTO dir_of_works (Work_id, Work_name) VALUES (default, "'.$_POST['new_type_of_work'].'")') or die("Ошибка 1 ".mysqli_error($link)); //вносим новый вид работ
				$result = mysqli_query($link, 'SELECT Work_id FROM dir_of_works WHERE Work_name="'.$_POST['new_type_of_work'].'"') or die("Ошибка 2 ".mysqli_error($link));
				$work_id = mysqli_fetch_row($result);
				$work_id = $work_id[0];
				mysqli_free_result($result);
			}
			$QUERY ='INSERT INTO projects (Proj_id, Cust_id, Work_id, Comments, Start_date) VALUES (default,"'.$_POST['cust_id'].'", "'.$work_id.'", "'.$_POST['comment'].'", "'.date("Y-m-d").'")';
			mysqli_query($link, $QUERY) or die("Ошибка 3 ".mysqli_error($link));
			$QUERY = "INSERT INTO project_stages (Proj_id) SELECT MAX(Proj_id) from projects";
			mysqli_query($link, $QUERY) or die("Ошибка 4 ".mysqli_error($link));
			header("Location: gen_dir_projs");
		}
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
				<img src="img/proj_sb_a.png" class="img">
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
					<?
					if($err)
						echo "<a class='nav-link' id='home-tab' role='tab' aria-selected='false' aria-controls='home' href='#home' data-toggle='tab'><small>Текущие</small></a>"; 
					else 
						echo "<a class='nav-link active show' id='home-tab' role='tab' aria-selected='true' aria-controls='home' href='#home' data-toggle='tab'><small>Текущие</small></a>"?>
					
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="finished-tab" role="tab" aria-selected="false" aria-controls="finished" href="#finished" data-toggle="tab"><small>Завершенные</small></a>
                  </li>
                  <li class="nav-item">
				  <?
					if($err)
						echo "<a class='nav-link active show' id='new-tab' role='tab' aria-selected='true' aria-controls='new' href='#new' data-toggle='tab'><small>Новый проект</small></a>"; 
					else 
						echo "<a class='nav-link ' id='new-tab' role='tab' aria-selected='false' aria-controls='new' href='#new' data-toggle='tab'><small>Новый проект</small></a>"?>
                  </li>
                </ul>
                <div class="tab-content" id="myTabContent" >
                  <div class="tab-pane fade <?if($err)echo ""; else echo "active show";?>" id="home" role="tabpanel" aria-labelledby="home-tab" >
					
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
	$rows = mysqli_num_rows($result); // количество полученных строк
	if ($rows==0) echo "<td  colspan='4'>Текущих проектов не найдено.</td>";
//	echo $rows;
	else {
		for ($i = 0 ; $i < $rows ; ++$i)
		{
			echo "<tr>";
			$row = mysqli_fetch_row($result);
			echo "<td><a href='gen_dir_proj?n=".$row[0]."'>".$row[0]."</td>";
			echo "<td><a href='gen_dir_cust?n=".$row[4]."'>".$row[1]."</td>";
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
	$rows = mysqli_num_rows($result); // количество полученных строк
	if ($rows==0) echo "<td  colspan='5'>Завершенных проектов не найдено.</td>";
//	echo $rows;
	else {
		for ($i = 0 ; $i < $rows ; ++$i)
		{
			echo "<tr>";
			$row = mysqli_fetch_row($result);
			echo "<td><a href='gen_dir_proj?n=".$row[0]."'>".$row[0]."</td>";
			echo "<td><a href='gen_dir_cust?n=".$row[5]."'>".$row[1]."</td>";
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
                  <div class="tab-pane fade <?if($err)echo "active show"; else echo "";?>" id="new" role="tabpanel" aria-labelledby="new-tab">
				  
				  
				  <form action="" method="POST">
					<div class="row mt-4 mr-5 align-items-center" style="">
						<div class="col-md-2 text-right" style="">
							Заказчик:
						</div>
							<select class="col text-left pr-3" name="cust_id" id="cust" style="height:35px; border: 1px solid rgba(0,0,0,.40); background: rgba(255,255,255,.20);font-size: small;">
							
							
<?php
	$QUERY ="SELECT
		Cust_id,
		Cust_name
	FROM
		customers";

	$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
	if($result)
	{
		$rows = mysqli_num_rows($result);
		if ($rows){
			for ($i = 0 ; $i < $rows ; ++$i)
			{
				$row = mysqli_fetch_row($result);
				//print_r($result);
				if($i==0)echo "<option selected value =".$row[0].">".$row[1]."</option>";
				else echo "<option value = ".$row[0].">".$row[1]."</option>";
			}
			mysqli_free_result($result);
		}
	}
?>

						</select>
						
						<button class="col-md-3 btn btn-secondary btn-sm ml-4 mr-0" onClick='location.href="gen_dir_new_cust"' type="button" style="text-transform:none">Добавить нового заказчика</button>
						
						
					</div>
					
					
					<div class="row mt-4 mr-5 align-items-center" >
						<div class="col-md-2 text-right" style="">
							Тип работ:
						</div>
						
							<select class="col text-left" name="work_id" id="work_id" style="height:35px; border: 1px solid <?if($err)echo "rgba(255,0,0,.40);"; else echo "rgba(0,0,0,.40);";?>  background: rgba(255,255,255,.20);font-size: small;">
							
<?php						
	$QUERY ="SELECT
		Work_id,
		Work_name
	FROM
		dir_of_works";
	
	$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
	echo "<option selected value ='not_selected'>Не выбран</option>";
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
						
						<div class="col-md-3 ml-4">
						<?if($err)echo "<span class='badge badge-danger'>Не выбран тип работ</span>";?>
						</div>
					</div>
					
					
					<div class="row mt-4 mr-5 align-items-center" style="">
						<div class="col-md-2"></div>
						<input class="col form-control" id="username" name="new_type_of_work" type="text" placeholder="новый тип работ" style="border: 1px solid <?if($err)echo "rgba(255,0,0,.40);"; else echo "rgba(0,0,0,.40);";?> background-color: rgba(255,255,255,.20); font-size: small;">
						<div class="col-md-3 ml-4">
							<?if($err)echo "<span class='badge badge-danger'> Или не введен тип работ</span>";?>
						</div>
					</div>
					
					<div class="row mt-4 mr-5 align-items-center" style="">
						<div class="col-md-2 text-right">
							Комментарий:
						</div>
						<input class="col form-control" id="username" name="comment" type="text" placeholder="комментарий" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;" >
						<div class="col-md-3 ml-4" style=""></div>
					</div>
					
					<div class="row mt-4 mr-5 align-items-center" style="">
						<div class="col-md-2 text-right">
							
						</div>		
						<button class="col-md-2 btn btn-primary btn-sm btn-block ml-0" type="submit" name="submit"><small>Создать</small></button>
						<div class="col">
						</div>
					</div>
					
					</form>
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