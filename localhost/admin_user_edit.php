<?php 
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
    exit();
}
	
if(isset($_POST['submit']))
	{	
		$User_id = $_GET['n'];
		$selectTab_n = $_POST['tab_n'];
		$login = ($_POST['Login']);
		$pass = md5(md5($_POST['Pass']));
		
		//echo $User_id." ".$selectTab_n." ".$login." ".$pass;
			
		if(!$link = mysqli_connect("localhost", "mysql", "mysql", "omima_stal"))
		{
			echo "Нет соединения с сервером"; 
			die();
		}
	$QUERY ='UPDATE users SET TAB_N = '.$selectTab_n.', Login = "'.$login.'", Pass = "'.$pass.'" WHERE User_id = '.$User_id;
		mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
		//mysqli_free_result($result);
		header("Location: admin_users_edit");
	}

//include 'admin_main.html';

?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>User's edit</title>
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
}

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
  <div class="container" container>
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
				<a href="admin_main"><img src="img/users_sb.png" class="img" title="Пользователи"></a>
            </div>
          </div>
          <div class="row-fluid">
            <div class="col text-center nopadding">
              <img src="img/users_edit_sb_a.png" class="img">
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
          <div class="row-fluid ml-3" ">
            <div class="col">
              <p class="sh1">Изменение учетных данных пользователя</p>
            </div>
          </div>
			<form name="input" action="" method="POST">
            <div class="row mt-5 ml-3 mr-3 align-items-center" style="">
				<div class="col-md-3 text-right">
					<div class="p2" >Табельный номер:</div>
				</div>
				
					<select class="col-md-5" name="tab_n" id="tab_n" style="height:35px; border: 1px solid rgba(0,0,0,.40); background: rgba(255,255,255,.20); padding: 6px; font-size: small;">
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
				Employees.TAB_N
			FROM
				Employees
			WHERE 
				TAB_N=".$_GET['n'];

	$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
	if($result)
	{
			$row = mysqli_fetch_row($result);
			echo "<option selected value =".$row[3].">".$row[3]." - ".$row[0]." ".$row[1]." ".$row[2]."</option>";
			mysqli_free_result($result);
	}
//запрос на остальнуй часть выпадающего списка
	$QUERY ="SELECT
				Employees.Name,
				Employees.Sec_name,
				Employees.Surname,
				Employees.TAB_N
			FROM
				Employees
			LEFT JOIN users ON employees.TAB_N = users.TAB_N
			WHERE
				users.Login IS NULL AND users.Pass IS NULL";
	$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
	if($result)
	{
		$rows = mysqli_num_rows($result); // количество полученных строк
//	echo $rows;
		for ($i = 0 ; $i < $rows ; ++$i)
		{

			$row = mysqli_fetch_row($result);
			//print_r($result);
			echo "<option value = ".$row[3].">".$row[3]." - ".$row[0]." ".$row[1]." ".$row[2]."</option>";
		}
		mysqli_free_result($result);
	}
//echo <option value="1931">1931</option>
?>						
						
					</select>
				
				<div class="col"></div>
            </div>
			<div class="row mt-3 ml-3 mr-3 align-items-center" style="">
				<div class="col-md-3 text-right">
					<div class="p2" >Логин:</div>
				</div>
					<input class="col-md-5" required pattern="[A-Za-z0-9_-]{6,16}" class="form-control" id="username" name="Login" type="text"  placeholder="6-16, лат. букв, цифр, нижних подчеркивание" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;" >
				<div class="col"></div>

            </div>
			<div class="row mt-3 ml-3 mr-3 align-items-center" style="">
				<div class="col-md-3 text-right">
					<div class="p2" >Пароль:</div>
				</div>
				<input class="col-md-5" required pattern="[A-Za-z0-9_-]{6,16}" class="form-control" id="password" name="Pass" type="password" placeholder="6-16, лат. букв, цифр, нижних подчеркивание" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;">
				<div class="col"></div>

            </div>
			
			<div class="row mt-3 ml-3 mr-3 align-items-center" style="">
				<div class="col-md-3"></div>
				<div class="col pl-0 ml-0">
					<button class="btn btn-primary btn-sm ml-0" type="submit" name="submit"><small>Сохранить</small></button>
				</div>
				<div class="col"></div>
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
		<script>
		</script>
	<!-- Scripts -->
	<!-- JQuery -->
  <script type="text/javascript" src="./js/jquery-3.3.1.min.js"></script>
    <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="./js/popper.min.js"></script>
  	<!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="./js/bootstrap.min.js"></script>
</body>

</html>