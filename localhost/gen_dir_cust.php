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

	if(isset($_GET['n']))
	{	

		if(!$link = mysqli_connect("localhost", "mysql", "mysql", "omima_stal"))
		{
			echo "Нет соединения с сервером"; 
			die();
		}
			//echo $_GET['n'];
		$QUERY ='select * FROM customers WHERE Cust_id='.$_GET["n"];
		$result = mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
		$row = mysqli_fetch_row($result);
		mysqli_free_result($result);

		}
	function form_control($string){
		$string=str_replace('"', "", $string);
		$string=str_replace("'", "", $string);
		return $string;
	}		
	
	if(isset($_POST['submit']))
	{	
	
		//if($_POST['new_type_of_work']=="") echo "ЭТО НОВЫЙ ТИП РАБОТ ".$_POST['new_type_of_work']."<BR>";
		//echo "ЭТО ВЫБРАННЫЙ ТИП РАБОТ".$_POST['work_id']."<BR>";
		if($row[1]!=form_control($_POST['cust_name'])){
			$result = mysqli_query($link,"SELECT Cust_name FROM customers WHERE cust_name = '".$_POST['cust_name']."'");
			$result = mysqli_num_rows($result);
			if($result>1){
				$err=1;
			//echo "Заказчик с таким именем уже существует";
			}
		}
		else{
			$QUERY = 'UPDATE customers SET Cust_name="'.form_control($_POST['cust_name']).'", Cust_tel="'.$_POST['tel_num'].'", Cont_cust_name="'.$_POST['cont_name'].'", E_mail="'.$_POST['mail'].'", Kpp='.$_POST['kpp'].', OGRN='.$_POST['ogrn'].', Check_acc='.$_POST['balance'].', ITN='.$_POST['inn'].', Cust_address="'.form_control($_POST['address']).'", Comments="'.$_POST['comment'].'" WHERE Cust_id='.$row[0];
			mysqli_query($link, $QUERY) or die("Ошибка ".mysqli_error($link));
			//echo "OK";
			header("Location: gen_dir_cust?n=".$_GET['n']);
		}
	}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Информация о заказчике</title>
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
          <div class="row-fluid ml-3">
            <div class="col">
              <p class="sh1">Информация о заказчике</p>
            </div>
          </div>
		  
				  <form action="" method="POST">
					<div class="row mt-3 mr-5 align-items-center" style="">
						
						<div class="col-md-3 text-right" style="">
							Заказчик:
						</div>
						
						<input disabled required class="col form-control"  name="cust_name" type="text" placeholder="наименование заказчика" style="border: 1px solid <?if($err)echo "rgba(255,0,0,.40);"; else echo "rgba(0,0,0,.40);";?> background-color: rgba(0,0,0,.10); font-size: small;" value="<?echo $row[1];?>">
						<div class="col-md-3 ml-4">	<?if($err)echo "<span class='badge badge-danger'>Такой заказчик уже существует</span>";?></div>

					</div>
					
					<div class="row mt-3 mr-5 align-items-center" style="">
						<div class="col-md-3 text-right" style="">
							Юр. адрес:
						</div>
						<input disabled required class="col form-control" name="address" id="inputs" type="text" value="<?echo $row[10];?>" placeholder="индекс, страна, город, улица, дом, корпус" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(0,0,0,.10); font-size: small;">
						<div class="col-md-3 ml-4"></div>
					</div>
					
					<div class="row mt-3 mr-5 align-items-center" style="">
						<div class="col-md-3 text-right" style="">
							Контактное лицо:
						</div>
						<input disabled required class="col form-control" name="cont_name" id="inputs" type="text" value="<?echo $row[4];?>" placeholder="ФИО" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(0,0,0,.10); font-size: small;">
						<div class="col-md-3 ml-4"></div>
					</div>

					<div class="row mt-3 mr-5 align-items-center" style="">
						<div class="col-md-3 text-right" style="">
							Контактный тел.:
						</div>
						<input disabled required class="col form-control" name="tel_num" id="inputs" type="text" value="<?echo $row[2];?>" placeholder="номер телефона" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(0,0,0,.10); font-size: small;">
						<div class="col-md-3 ml-4"></div>
					</div>
					
					<div class="row mt-3 mr-5 align-items-center" style="">
						<div class="col-md-3 text-right" style="">
							Электронная почта:
						</div>
						<input disabled required class="col form-control" name="mail" id="inputs" type="email" value="<?echo $row[5];?>" placeholder="email@domain.com" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(0,0,0,.10); font-size: small;">
						<div class="col-md-3 ml-4"></div>
					</div>
					
					<div class="row mt-3 mr-5 align-items-center" style="">
						<div class="col-md-3 text-right" style="">
							ИНН:
						</div>
						<input disabled required class="col form-control" name="inn" id="inputs" type="number" value="<?echo $row[9];?>" placeholder="12 цифр" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(0,0,0,.10); font-size: small;">
						<div class="col-md-3 ml-4"></div>
					</div>					
					
					<div class="row mt-3 mr-5 align-items-center" style="">
						<div class="col-md-3 text-right" style="">
							КПП:
						</div>
						<input disabled required class="col form-control" name="kpp" id="inputs" type="number" value="<?echo $row[6];?>" placeholder="9 цифр" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(0,0,0,.10); font-size: small;">
						<div class="col-md-3 ml-4"></div>
					</div>

					<div class="row mt-3 mr-5 align-items-center" style="">
						<div class="col-md-3 text-right" style="">
							ОГРН:
						</div>
						<input disabled required class="col form-control" name="ogrn" id="inputs" type="number" value="<?echo $row[7];?>" placeholder="13 цифр" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(0,0,0,.10); font-size: small;">
						<div class="col-md-3 ml-4"></div>
					</div>					

					<div class="row mt-3 mr-5 align-items-center" style="">
						<div class="col-md-3 text-right" style="">
							р/с:
						</div>
						<input disabled required class="col form-control" name="balance" id="inputs" type="number" value="<?echo $row[8];?>" placeholder="номер расчетного счета" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(0,0,0,.10); font-size: small;">
						<div class="col-md-3 ml-4"></div>
					</div>	

					<div class="row mt-3 mr-5 align-items-center" style="">
						<div class="col-md-3 text-right" style="">
							Комментарий:
						</div>
						<input disabled required class="col form-control" name="comment" id="inputs" type="text" value="<?echo $row[3];?>" placeholder="комментарий" style="border: 1px solid rgba(0,0,0,.40); background-color: rgba(0,0,0,.10); font-size: small;">
						<div class="col-md-3 ml-4"></div>
					</div>
			
					<div class="row mt-2 mr-5 align-items-center" style="">
						<div class="col-md-3 text-right">
							<div class="p2" ></div>
						</div>
						
						<button class="col-md-2 btn btn-primary btn-sm btn-block ml-0 mt-2 mb-0" type="submit" name="submit"><small>Сохранить</small></button>
							
						<button class="col-md-2 btn btn-secondary btn-sm btn-block ml-3 mt-2 mb-0" id="change_button"><small>Изменить</small></button>

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

	<script>
		document.getElementById("change_button").addEventListener("click", function(event){
			event.preventDefault();
			$("input").removeAttr("disabled");
			$("input").attr("style", "border: 1px solid rgba(0,0,0,.40); background-color: rgba(255,255,255,.20); font-size: small;");
			
		});
	</script>
	<script type="text/javascript" src="./js/jquery-3.3.1.min.js"></script>
		<!-- Bootstrap tooltips -->
	<script type="text/javascript" src="./js/popper.min.js"></script>
		<!-- Bootstrap core JavaScript -->
	<script type="text/javascript" src="./js/bootstrap.min.js"></script>

</body>

</html>