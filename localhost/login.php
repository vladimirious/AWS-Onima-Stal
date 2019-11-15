<?
// Страница авторизации

// Функция для генерации случайной строки
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}

session_start();
// Соединямся с БД
if (isset ($_SESSION['Interface'])){
	unset($_SESSION['User_id']);
	unset($_SESSION['hash']);
	unset($_SESSION['Interface']);
}
$err = 0;

try
{
    if ($link=mysqli_connect("localhost", "mysql", "mysql", "omima_stal"))
    {
        //do something
    }
    else
    {
        throw new Exception('Unable to connect');
    }
}
catch(Exception $e)
{
	$err = 2;
}

if(isset($_POST['submit']))
{
    // Вытаскиваем из БД запись, у которой логин равняеться введенному
    $query = mysqli_query($link,"SELECT User_id, Pass, Interface FROM users WHERE login='".mysqli_real_escape_string($link,$_POST['Login'])."' LIMIT 1");
    $data = mysqli_fetch_assoc($query);
	//echo "Пароль из БД: ".$data['Pass']."<BR>";
	//echo "Пароль из формы: ".md5(md5('otdel_rasch'))."<BR>";	
	
    // Сравниваем пароли
    if($data['Pass'] === md5(md5($_POST['Pass'])))
    {
        // Генерируем случайное число и шифруем его
        $hash = md5(generateCode(10));

        // Записываем в БД новый хеш авторизации и IP
        mysqli_query($link, "UPDATE users SET user_hash='".$hash."' WHERE User_id='".$data['User_id']."'");
        // Ставим куки
		
		$_SESSION["User_id"] = $data['User_id'];
		$_SESSION["hash"] = $hash;
		$_SESSION["Interface"] = $data['Interface'];
		 
		switch ($data['Interface']){
			case "admin":
				header('Location: admin_menu');
				break;
			case "gen_dir":
				header('Location: gen_dir_menu');
				break;
			case "otdel_rasch":
				header('Location: otdel_rasch_menu');
				break;
			case "buhgal":
				header('Location: buhgal_menu');
				break;
			case "isp_dir":
				header('Location: isp_dir_menu');
				break;
			case "otdel_zakupok":
				header('Location: otdel_zakupok_menu');
				break;
			case "konstr_tech":
				header('Location: konstr_tech_menu');
				break;
			case "nach_sklada":
				header('Location: nach_sklada_menu');
				break;
			case "nach_proizv":
				header('Location: nach_proizv_menu');
				break;
		}
		exit();
    }	
    else
    {
		$err=1;
    }
}

if (!isset($POST["Login"])){
	include 'login.html';
}
if($err==1){
echo "

	<div class='container-fluid'>
		<div class='row fixed-bottom'>
				<div class='col' ></div> 
				<div class='col mb-5' style=''>
					<div class='alert alert-danger mb-5' role='alert' style= 'opacity: 0.85;'>
						<b>Вход не удался</b>
						<small><BR>Введен неверный логин или пароль</small>
					</div>
				</div>
				<div class='col'></div>	
		  </div>
		</div>

";
}
if($err==2){
echo "

	<div class='container-fluid'>
		<div class='row fixed-bottom'>
				<div class='col' ></div> 
				<div class='col mb-5' style=''>
					<div class='alert alert-danger mb-5' role='alert' style= 'opacity: 0.85;'>
						<b>ОШИБКА</b>
						<small><BR>Нет соединения с базой данных</small>
					</div>
				</div>
				<div class='col'></div>	
		  </div>
		</div>

";
}
?>