<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?php 
include '../validation/valida_cookies.php';
$acesso = new valida_cookies();
$acesso->setLogin($_POST['login']);
$acesso->setSenha($_POST['senha']);
if (!$acesso->getLogin()){
    $acesso->popup('Você deve entrar com o usuário.',null);
}else{
    $acesso->loginDb(); 
}
?>
</body>
</html>