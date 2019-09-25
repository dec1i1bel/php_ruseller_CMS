# ruseller_CMS
учебная CMS по ману https://ruseller.com/project.php?id=11

комментарии
- нет соединения с бд по PDO. драйвер PDO MySQL установлен (смотрел в phpinfo()). отладка показывает пустой PDO-объект, хотя параметры соединения подтягиваются норм

инициализация соединения:
```
<?php 
$config['db']= array(
	'host'     =>"localhost",
	'username' =>'root',
	'password' =>'',
	'dbname'   =>'ustbar'
	);
try{
  $db = new PDO("mysql:host=".$config["db"]["host"].";dbname=".$config["db"]["dbname"],$config["db"]["username"],$config["db"]["password"]);
}catch(PDOException $e){
	echo $e->getMessage();
}
$d=$_POST["entry"];
echo $d;
?>
```