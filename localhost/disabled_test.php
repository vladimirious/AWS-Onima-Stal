<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="utf-8">
  
  <title>Вход</title>
  
  <style>
   
  </style>
</head>

<body>
<div><div><div>
	<form name="" method="POST">

		<input disabled required class="form-control" name="Login" type="text" placeholder="Логин">

		  
		<input disabled required class="form-control" id="password" name="Pass" type="password" placeholder="Пароль" style="background-color: rgba(255,255,255,.15);">

		<button class="btn" type="submit" value=" " name="submit">Вход</button>
		<button class="btn" type="btn" value=" " OnClick="ChangeInputs()">Dis</button>
	</form>		




</div></div></div>

	<script type="text/javascript" src="./js/jquery-3.3.1.min.js"></script>
    <!-- Bootstrap tooltips -->
	<script type="text/javascript" src="./js/popper.min.js"></script>
  	<!-- Bootstrap core JavaScript -->
	<script type="text/javascript" src="./js/bootstrap.min.js"></script>
	<script>
	function ChangeInputs(){
			$('input').removeAttr("disabled")
	}
	</script>
</body>

</html>
