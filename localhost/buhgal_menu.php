<?php 
session_start();
if (!isset($_SESSION['hash'])) 
{
		header("Location: login");
		exit;
}
if ($_SESSION['Interface']!='buhgal')
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

//include 'admin_menu.html';

?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Меню бухглатерии</title>
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

    .main-w {
    -webkit-backdrop-filter: blur(20px) saturate(125%);
    backdrop-filter: blur(20px) saturate(125%);
    background-color: rgba(0,0,0,.3);
    }

    @supports not ((-webkit-backdrop-filter: blur(20px)) or (backdrop-filter: blur(20px))){
      .main-w {
        background-color: rgba(0,0,0,.7);
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
<!-- Start your project here <a href="auth.html"><img src="img/exit-w.png" class="img"></a>-->
<div style="height: 100%; width: 100%; left: 0; top: 0; position: fixed; display: flex; align-items: center; align-content: center; justify-content: center;">
<!--  <div class="main-w" style="width: 1200px; height:735px;">Max-height 100%</div>-->
    <div class="main-w" style="width: 1080px; height:661px;">
      <div class="container-fluid">
        <div class="row">
          <div class="col text-right nopadding">
				<button class="exit" type="button" data-target="#exampleModal2" data-toggle="modal" style="border: none;">
					<img src="img/exit-w.png" class="img">
				</button>
          </div>
        </div>
		
        <div class="row ml-5 pb-4">
          <div class="col">
            <h1 class="h1" style="color: #FFFFFF; font-weight: bold;">Добро пожаловать</h1>
          </div>
        </div>
		
		
        <div class="row ml-5 pt-4 pb-4">
          <div class="col-md-1">
              <a href="buhgal_projs"><img src="img/proj.png" class="img"></a>
          </div>
          <div class="col">
              <a href="buhgal_projs" style="text-decoration: none;"><div class="sh1" style="color: #FFFFFF; font-weight: italic;">Проекты</div></a>
          </div>
        </div>
		
        <div class="row ml-5 pb-4 pt-4">
          <div class="col-md-1">
              <a href="buhgal_employ"><img src="img/buhgal_employ.png" class="img"></a>
          </div>
          <div class="col">
              <a href="buhgal_employ" style="text-decoration: none;"><div class="sh1" style="color: #FFFFFF;">Сотрудники</div></a>
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