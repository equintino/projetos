<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script>
function limpaCookie(){
document.cookie="nome_usuario=";
document.cookie="senha_usuario=";
}
</script>
</head>
<body>
<?php 
include "valida_cookies.inc";
@$username=maiusculo($_COOKIE["nome_usuario"]);
if(@!$username){
	@$username=maiusculo($_POST["username"]);
}
	//@$senha=sha1(md5(maiusculo($_COOKIE["senha_usuario"])));
@$senha=sha1(md5(maiusculo($_COOKIE["senha_usuario"])));
if($senha=='67a74306b06d0c01624fe0d0249a570f4d093747'){
	@$senha=sha1(md5(maiusculo($_POST["senha"])));
}	
			date_default_timezone_set("Brazil/East");
		//setcookie("nome_usuario",$username);
		//setcookie("senha_usuario",$senha);
//function conferir($username){
//print_r($_COOKIE);
//echo "senha->$senha";exit;
if (!$username){
	echo "<script>limpaCookie()</script>";
	echo "<table width=100% height=80% border=0>";
	echo "<tr height=100%>";
	echo "<td width=100% colspan=3 valign=center align=center>";
	echo "<table border=1 bgcolor=#FFFFFF CELLSPACING=3 CELLPADDING=13><tr><td>";
	echo "<center><br><b><font face=tahoma size=2 color=black>Vocк deve entrar com o usuário.<p>";
	//echo "<center><input type=button value=\"Voltar\" onclick=history.back()>";
	echo "<center><input type=button value=\"Voltar\" onclick=\"location.href='index.php'\">";
	echo "</td></tr></table>";
	echo "</td></tr>";
	echo "</table>";
	echo "</td></tr></table>";
	echo "</html></body>";
	exit;
}else{
	//$pdo=conectaBd();
	$linhas=Conexao::linhasBd($username);
	$usuario=Conexao::usuariosBd($username);
}
	//return $linhas;
//}
//$linhas=conferir($username);
if (!$linhas){
	echo "<script>limpaCookie()</script>";
	echo "<table width=100% height=80% border=0>";
	echo "<tr height=100%>";
	echo "<td width=100% colspan=3 valign=center align=center>";
	echo "<table border=1 bgcolor=#FFFFFF CELLSPACING=3 CELLPADDING=13><tr><td>";
	echo "<center><br><b><font face=tahoma size=2 color=black>Usuário não cadastrado.<p>";
	//echo "<center><input type=\"button\" value=\"Voltar\" onclick=history.back()>";
	echo "<center><input type=button value=\"Voltar\" onclick=\"location.href='index.php'\">";
	echo "</td></tr></table>";
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	echo "</td></tr></table>";
	echo "</html></body>";
	exit;
}else{
	$tipo=$usuario["tipo"];
	$senhadb=$usuario["senha"];
	$status=$usuario["status"];
	$cod_usuario=$usuario["cod_usuario"];

	if ($status==0){
		echo "<script>limpaCookie()</script>";
		echo "<table width=100% height=80% border=0>";
		echo "<tr height=100%>";
		echo "<td width=100% colspan=3 valign=center align=center>";
		echo "<table border=1 bgcolor=#FFFFFF CELLSPACING=3 CELLPADDING=13><tr><td>";
		echo "<center><br><b><font face=tahoma size=2 color=black>Este usuário foi desabilitado.<p>";
		//echo "<center><input type=\"button\" value=\"Voltar\" onclick=history.back()>";
		echo "<center><input type=button value=\"Voltar\" onclick=\"location.href='index.php'\">";
		echo "</td></tr></table>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		echo "</td></tr></table>";
		echo "</html></body>";
		exit;
	}
	if ($senha != $senhadb){
		echo "<script>limpaCookie()</script>";
		echo "<table width=100% height=80% border=0>";
		echo "<tr height=80%>";
		echo "<td width=100% colspan=3 valign=center align=center>";
		echo "<table border=1 bgcolor=#FFFFFF CELLSPACING=3 CELLPADDING=13><tr><td>";
		echo "<center><br><b><font face=tahoma size=2 color=black>A senha não confere.<p>";
//		echo "<center><input type=\"button\" value=\"Voltar\" onclick=history.back()>";
		echo "<center><input type=button value=\"Voltar\" onclick=\"location.href='index.php'\">";
		echo "</td></tr></table>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		echo "</td></tr></table>";
		echo "</html></body>";
		exit;
	}else{
		
		$cod_usuario=$usuario["cod_usuario"];
		$tipo=$usuario["tipo"];
		$last=$usuario["last_upd"];
		$agora=mktime(date("H"));
		$compara=$agora-$last;
		$data_in=mktime(date("H"));
		$ip=getenv("REMOTE_ADDR");
		//$ip2=_SERVER["REMOTE_ADDR"];
		//$php=phpinfo();
		
		$result=Conexao::gravaBd($cod_usuario,$agora,$ip,$username);
		
		if (empty($_COOKIE["nome_usuario"])){
			//setcookie ("nome_usuario",$username);
		}else{
			//setcookie("nome_usuario");
			//setcookie ("nome_usuario",$username);
		}

		if (empty($_COOKIE["senha_usuario"])){
			//setcookie ("senha_usuario",$senha); 
		}else{
			//setcookie("senha_usuario");
			//setcookie ("senha_usuario",$senha); 
		}

		if (empty($_COOKIE["status_usuario"])){
			//setcookie ("status_usuario",$status); // linha 102
		}else{
			//setcookie("status_usuario");
			//setcookie ("status_usuario",$status); 
		}
	}
////// Verificar validade & Mensagens de aviso
// tempo de expiraзгo da senha ($compara)
	$abrir=abrir($compara,$tipo,$username,$cod_usuario);
}
//mysql_close($conexao);
exit;
function maiusculo($string){
	$string=strtoupper($string);
	$string=str_replace("б", "Б", $string);
	$string=str_replace("й", "Й", $string);
	$string=str_replace("н", "Н", $string);
	$string=str_replace("у", "У", $string);
	$string=str_replace("ъ", "Ъ", $string);
	$string=str_replace("в", "В", $string);
	$string=str_replace("к", "К", $string);
	$string=str_replace("ф", "Ф", $string);
	$string=str_replace("О", "I", $string);
	$string=str_replace("Ы", "U", $string);
	$string=str_replace("г", "Г", $string);
	$string=str_replace("х", "Х", $string);
	$string=str_replace("з", "З", $string);
	$string=str_replace("а", "A", $string);
	return $string;
}
function abrir($compara,$tipo,$username,$cod_usuario){
  if ($compara>=15552000){
		echo "<script>window.location.replace('users.php?operacao=renova&tipo=$tipo&cod_usuario=$cod_usuario&username=$username');</script>";
		exit;
  }
	if ($tipo==1){
		echo "<script>window.location.replace('tabela.php?tipo=$tipo&cod_usuario=$cod_usuario&username=$username');</script>";
	}else{
		echo "<script>window.location.replace('tabela2.php?tipo=$tipo&cod_usuario=$cod_usuario&username=$username');</script>";
	}
}
?>
</body>
</html>