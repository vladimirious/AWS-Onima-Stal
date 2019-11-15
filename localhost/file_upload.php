<?
$was_sent=0;
if(isset($_POST['submit'])){
	$uploaddir = 'files/contracts/';
	
	$my_string=$_FILES['userfile']['name'];
	$point_place = strrpos($my_string, '.');
	$my_string_len=strlen($my_string);
	$type_len = $my_string_len - $point_place;
	$_FILES['userfile']['name'] = "contract_n".substr($my_string, $point_place, $type_len);
	
	
	$uploadfile = $uploaddir.basename($_FILES['userfile']['name']);
	echo '<pre>';
	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
		echo "Файл корректен и был успешно загружен.\n";
	} else {
		echo "Возможная атака с помощью файловой загрузки!\n";
	}
	//echo 'Некоторая отладочная информация:';
	//print_r($_FILES);
	$was_sent = 1;
	print "</pre>";
}

//$my_string="КП по ОЭ КоловайВА Y2432.docx";
//echo $my_string."<br>";
//
$point_place = strrpos($my_string, '.');
$my_string_len=strlen($my_string);
$type_len = $my_string_len - $point_place;

//echo strrpos($my_string, '.')."<br>";
$my_string = "contract_n".substr($my_string, $point_place, $type_len);
//echo $my_string;
?>


<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>File upload</title>
</head>

<body>

	<form enctype="multipart/form-data" action="" method="POST">
    <!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
    <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
    <!-- Название элемента input определяет имя в массиве $_FILES -->
    Отправить этот файл: <input name="userfile" type="file" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, application/pdf, .docx"/>
    <input type="submit" name="submit" value="Отправить файл" />
</form>

	<?if($was_sent) echo "<a href='".$uploadfile."'>Скачать</a>" ?>
</body>
</html>