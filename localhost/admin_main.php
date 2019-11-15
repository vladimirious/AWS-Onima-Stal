<?
session_start();
if (!isset($_SESSION['hash'])) 
{
		header("Location: login");
		exit;
}
if ($_SESSION['Interface']!='admin')
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

//include 'admin_main.html';

?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Пользователи</title>
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
              <img src="img/users_sb_a.png" class="img">
            </div>
          </div>
          <div class="row-fluid">
            <div class="col text-center nopadding">
              <a href="admin_users_edit"><img src="img/users_edit_sb.png" class="img"></a>
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
              <p class="sh1">Просмотр пользователей</p>
            </div>
          </div>
            <div class="row-fluid ml-3 mr-3">
            <div class="col">
              <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar pr-3">
                  <table class="table table-hover table-striped table-sm" style="overflow: auto">
                    <thead>
                       <tr>
                         <th scope="col"><small>ФИО</small></th>
                         <th scope="col"><small>Должность</small></th>
                         <th scope="col"><small>Подразделение</small></th>
                         <th scope="col"><small>Логин</small></th>
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
    Employees.Name,
    Employees.Sec_name,
    Employees.Surname,
    Dir_Of_positions.Pos_name,
    Dir_of_dep.Dep_name,
    Users.Login   
FROM
    Employees
LEFT JOIN Users ON Employees.TAB_N = Users.TAB_N
LEFT JOIN Dir_of_dep ON Employees.Dep_id = Dir_of_dep.Dep_id
LEFT JOIN Manning_table ON Employees.M_t_id = Manning_table.M_t_id
LEFT JOIN Dir_of_positions ON Manning_table.Pos_id = Dir_of_positions.Pos_id;";

$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
if($result)
{
	$rows = mysqli_num_rows($result); // количество полученных строк
//	echo $rows;
		for ($i = 0 ; $i < $rows ; ++$i)
		{
			echo "<tr>";
			$row = mysqli_fetch_row($result);
			//print_r($result);
			echo "<td><small>".$row[0].' '.$row[1].' '.$row[2]."</small></td>";
				for ($j = 3 ; $j < 6 ; ++$j) echo "<td><small>".$row[$j]."</small></td>";
			echo "</tr>";
		}
		mysqli_free_result($result);
}
?>
                     </tbody>
                   </table>
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