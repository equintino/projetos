<?php
$where=$_GET["where"];
if ($where=="local"){
	setcookie("nome_usuario");
	setcookie("senha_usuario");
	//$apaga=unset($_COOKIE['nome_usuario']);
	//vat_dump($apaga);
	unset($_COOKIE['nome_usuario'],$_COOKIE['username'],$username);
	unset($_COOKIE['senha_usuario'],$senha);
}else{
	//setcookie("cod_cliente");
	//setcookie("senha_cliente");
	unset($_COOKIE['nome_usuario'],$username);
	unset($_COOKIE['senha_usuario'],$senha);
}

if ($where=="local")
		header("Location: index.php");
if ($where=="start")
		header("Location: start.php");
?>