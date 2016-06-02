<?php
include "valida_cookies.inc";
include "divfunc.php";

	@$codigo=$_GET['codigo'];
	if(!$codigo){
		@$codigo=$_POST['codigo'];
	}
	@$chamado=$_GET['chamado'];
	if(!$chamado){
		@$chamado=$_POST['chamado'];
	}
	@$username=$_GET['username'];
	if(!$username){
		@$username=$_POST['username'];
	}
	@$tipo=$_GET['tipo'];
	if(!$tipo){
		@$tipo=$_POST['tipo'];
	}
//include "fundo.php";
	echo "<h2 align=center><font color='blue'>Classifique a \"SLA\" do seu chamado</font></h2><br>";
	
	echo "<form action='clientes.php?username=$username&tipo=$tipo' method=POST>";
	echo "<div class='perguntas'>";
		echo "<input type=hidden name=act value=cad>";
		echo "<input type=hidden name=codigo value=$codigo>";
		echo "<input type=hidden name=chamado value=$chamado>";	
	// Nível de urgência
		echo "<h3>Por quanto tempo pode esperar a solu&ccedil&aumlo do teu problema?</h3>";
		echo "<input type=radio name=tempo value=3 required>Duas horas";
		echo "<input type=radio name=tempo value=2 >Uma hora";
		echo "<input type=radio name=tempo value=1 >Meia hora";
	// Nível de severidade
		echo "<h3>Classifique os danos causados ao neg&oacutecio da empresa?</h3>";
		echo "<input type=radio name=severidade value=3 required>H&aacute impedimento para trabalho individual dos colaboradores;<br>";
		echo "<input type=radio name=severidade value=2>H&aacute a interrup&ccedil&aumlo de trabalho de funcion&aacuterios (um grupo ou todos);<br>";
		echo "<input type=radio name=severidade value=1>H&aacute a interrup&ccedil&aumlo de processos cr&iacuteticos de neg&oacutecio da empresa;<br><br>";
		echo "<input type=submit value='Continuar'>&nbsp";		
		echo "<input type=\"button\" value=\"   Voltar   \" onclick=history.back()>";
	echo "</div>";	
	echo "</form>";
?>