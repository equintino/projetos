<html>
<head>
<style type=\"text/css">
<!--
A:link {text-decoration: none} A:visited {text-decoration: none}
A:hover { text-decoration: none}
A:active {text-decoration: none}
-->
</style>
</head>
<link rel='stylesheet' type='text/css' href='css/estilo.css'>
<body>
<table border=0 width=100% cellspacing=0 cellpadding=2>
	<tr valign=top rowspan=5>
		<td width=15% rowspan=7 align=center>
			<table border=1 width=100% cellpadding=4 cellspacing=0>
<?php
			date_default_timezone_set("Brazil/East");
if(IsSet($_COOKIE["nome_usuario"])){
	$username = $_COOKIE["nome_usuario"];
}
Conexao::getInstance();
$usuario=Conexao::getUsuariosBd($username);
$tipo=$usuario['tipo'];
if ($tipo==1){
	echo "<tr onmouseover=\"this.style.backgroundColor='orange';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: cornflowerblue\" onmouseout=\"this.style.backgroundColor='cornflowerblue';\" onclick=\"link('acessos.php?tipo=$tipo','_self')\"><td><font size=1 color=white face=verdana><b>ACESSOS</a></td></tr>";
}
if ($tipo==1){
echo "<tr><td bgcolor=cornflowerblue><b><font size=1 color=white face=verdana>USUÁRIOS</b></font></td></tr>";
echo "<tr onmouseover=\"this.style.backgroundColor='white';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: silver\" onmouseout=\"this.style.backgroundColor='silver';\" onclick=\"link('users.php?operacao=cad&tipo=$tipo','_self')\"><td><font size=1 face=verdana color=black>Cadastro</a></td></tr>";
echo "<tr onmouseover=\"this.style.backgroundColor='white';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: silver\" onmouseout=\"this.style.backgroundColor='silver';\" onclick=\"link('users.php?operacao=edita&tipo=$tipo','_self')\"><td><font size=1 face=verdana color=black>Consulta</a></td></tr>";
echo "<tr onmouseover=\"this.style.backgroundColor='white';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: silver\" onmouseout=\"this.style.backgroundColor='silver';\" onclick=\"link('users.php?operacao=exc&tipo=$tipo','_self')\"><td><font size=1 face=verdana color=black>Exclusão</a></td></tr>";
}
if ($tipo==1){
}else{
	echo "<tr><td width=100% bgcolor=cornflowerblue><b><font size=1 color=white face=verdana>CHAMADOS</b></td></tr>";
	echo "<tr onmouseover=\"this.style.backgroundColor='white';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: silver\" onmouseout=\"this.style.backgroundColor='silver';\" onclick=\"link('clientes.php?act=cad&cliente=$nome_usuario&tipo=$tipo&username=$username','_self')\"><td><font size=1 face=verdana color=black>Abrir Chamado</a></td></tr>";
	echo "<tr onmouseover=\"this.style.backgroundColor='white';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: silver\" onmouseout=\"this.style.backgroundColor='silver';\" onclick=\"link('clientes.php?act=cham&tipo=$tipo&username=$username','_self')\"><td><font size=1 face=verdana color=black>Pesquisa de Chamados</a></td></tr>";
	echo "<tr onmouseover=\"this.style.backgroundColor='white';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: silver\" onmouseout=\"this.style.backgroundColor='silver';\" onclick=\"link('tabela2.php?tipo=$tipo&username=$username','_self')\"><td><font size=1 face=verdana color=black>Controle</a></td></tr>";
	echo "<tr onmouseover=\"this.style.backgroundColor='white';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: silver\" onmouseout=\"this.style.backgroundColor='silver';\" onclick=\"link('det2.php?status=4&cliente=$nome_usuario&act=fecha&tipo=$tipo&username=$username','_self')\"><td><font size=1 face=verdana color=black>Fechar Chamados</a></td></tr>";
}
if ($tipo==1){
	echo "<tr onmouseover=\"this.style.backgroundColor='orange';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: cornflowerblue\" onmouseout=\"this.style.backgroundColor='cornflowerblue';\" onclick=\"link('relatorio.php?tipo=$tipo','_self')\"><td><font size=1 color=white face=verdana><b>RELATÓRIOS</a></td></tr>";
}
if ($tipo==1){
	echo "<tr onmouseover=\"this.style.backgroundColor='orange';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: cornflowerblue\" onmouseout=\"this.style.backgroundColor='cornflowerblue';\" onclick=\"link('bkp.php?tipo=$tipo','_self')\"><td><font size=1 color=white face=verdana><b>BACKUP</a></td></tr>";
}
if($cod_usuario==4 || $cod_usuario==1){
	echo "<tr><td width=100% bgcolor=cornflowerblue><b><font size=1 color=white face=verdana>RELATÓRIOS</b></td></tr>";
	echo "<tr onmouseover=\"this.style.backgroundColor='white';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: silver\" onmouseout=\"this.style.backgroundColor='silver';\" onclick=\"printLink('grafico.php','_blank')\"><td><font size=1 face=verdana color=black>Estatística</a></td></tr>";
}
echo "<tr onmouseover=\"this.style.backgroundColor='orange';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: cornflowerblue\" onmouseout=\"this.style.backgroundColor='cornflowerblue';\" onclick=\"link('logoff.php?where=local','_self')\"><td><font size=1 color=white face=verdana><b>LOGOUT</a></td></tr>";			
?>	
		</table></td>
		<td width=80%>
		<tr><td width=80% valign=top>
		<table width=100% cellspacing=5 border=0><tr><td colspan=2>
</body>
</html>