<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel='stylesheet' type='text/css' href='css/estilo.css'>
<SCRIPT LANGUAGE="JavaScript">
var ScrnSize = "UnCommon"
ScrnSize = screen.width + "";
switch(ScrnSize){
case "640": document.write('<body background="fundo.jpg" BGPROPERTIES="fixed">');
case "800": document.write('<body background="fundo.jpg" BGPROPERTIES="fixed">');
case "1024": document.write('<body background="fundo.jpg" BGPROPERTIES="fixed">');
case "1152": document.write('<body background="fundo.jpg" BGPROPERTIES="fixed">');
case "1280": document.write('<body background="fundo.jpg" BGPROPERTIES="fixed">');
case "1600": document.write('<body background="fundo.jpg" BGPROPERTIES="fixed">');
case "1920": document.write('<body background="fundo.jpg" BGPROPERTIES="fixed">');
case "2048": document.write('<body background="fundo.jpg" BGPROPERTIES="fixed">');
default: document.write('<body background="fundo.jpg" BGPROPERTIES="fixed">');
}
</script>
<TITLE>.:. Sistema de Ordem de Serviço.:.
<?php
if ($username){
	echo " - Usuário: $username";
}
?>
</TITLE>
<?php
function funcao($funcao){
	switch($funcao){
		case 1:
		$funcao='Diretoria';
		break;
		case 2:
		$funcao='Gerência';
		break;
		case 3:
		$funcao='Funcionário';
		break;
		case 4:
		$funcao='Técnico';
		break;
	}
	return $funcao;
}
if(isset($username)){
	@$username=$_COOKIE["nome_usuario"];
}
include 'class/bd.class.php';
if (@$username){	
$usuario=Conexao::getUsuariosBd($username);
		@$nome=$usuario['nome'];
		@$tipo=$usuario['tipo'];
		@$cod_usuario=$usuario['cod_usuario'];
}
//sessao($usuario);
		
	@$funcao=funcao($cod_usuario);
if(@$username){
	echo "<div class='saudacao'><i>Bem-vindo,</i><b> $nome - </b>
		<i>Função: </i><b>$funcao</b> <img src='imagem/sair2.png' height=18 text=\"sair\" 	onMouseOver=\"this.src='imagem/sair.png'\" onMouseOut=\"this.src='imagem/sair2.png'\" 	onclick=\"link('logoff.php?where=local','_self')\">&nbsp&nbsp</div>";
}
?>
</head>
<body>
<table border=0 width=100% height=10% >
	<tr height=10% >
		<td colspan=3 >
			<center><b><font face=garamond size=5 color=BLUE>Sistema de Ordem de Serviço<br><font face=verdana size=3 color=BLUE>Grupo Proseg
		</td>
	</tr>
</table>
</body>
</html>