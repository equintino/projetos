<meta charset="UTF-8">
<script>
function limpaCookie(){
document.cookie="nome_usuario=";
document.cookie="senha_usuario=";
}
</script>
<?php
if(IsSet($_COOKIE["nome_usuario"]))
	$nome_usuario = $_COOKIE["nome_usuario"];

if(IsSet($_COOKIE["senha_usuario"]))
	$senha_usuario = $_COOKIE["senha_usuario"];
	
if(IsSet($_COOKIE["status_usuario"])){
	$status_usuario = $_COOKIE["status_usuario"];
}

if(@!$nome_usuario){
	if(@!$nome_usuario){
			@$nome_usuario=$_POST['username'];
			if(@!$nome_usuario){
				@$nome_usuario=$_GET['username'];
			}	
	}
}
if(@!$senha_usuario){
	if(@!$senha_usuario){
			@$senha_usuario=$_POST['senha'];
			if(@!$nome_usuario){
				@$senha_usuario=$_GET['senha'];
			}	
	}
}
/*
		//setcookie("nome_usuario",$nome_usuario);
		//setcookie("senha_usuario",$senha_usuario);

$username=$_POST['username'];
*/	
@$index=$_GET['index'];
	include "fundo.php";
if (empty($nome_usuario) && ($index<>'sim')){
	echo "<script>limpaCookie()</script>";
	echo "<table width=100% height=80% border=0>";
	echo "<tr height=100%>";
	echo "<td width=100% colspan=3 valign=center align=center>";
	echo "<table border=1 bgcolor=#FFFFFF CELLSPACING=3 CELLPADDING=13><tr><td>";
	echo "<center><br><b><font face=tahoma size=2 color=black>Você deve efetuar o login para acessar esta página.<p>";
	echo "<center><input type=button value=\"Voltar\" onclick=\"location.href='index.php'\">";
	echo "</td></tr></table>";
	echo "</table>";
	echo "</td></tr></table>";
	echo "</html></body>";
	exit;
}
?>