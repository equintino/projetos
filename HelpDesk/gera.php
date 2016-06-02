<?php
//include "valida_cookies.inc";
include 'class/bd.class.php';
include "divfunc.php";

//$pdo=conectaBd();
date_default_timezone_set("Brazil/East");
@$codigo=$_GET["codigo"];
$chamado=$_GET['chamado'];

$tabela='chamados';
$where="numero=\"$chamado\"";
$resultado=Conexao::consultaChamado2($tabela,$where);
$resultado2=Conexao::usuariosChamados($chamado);
//   if(!$chamado){
       foreach($resultado as $key => $item);
//   }
$cod_cliente=$item["codigo"];
$cliente=$item["clientes"];
$agente=$item["agente"];
$descricao=$item["descricao"];
$solucao=nl2br($item["solucao"]);
$obs_cli=nl2br($item["obs_cli"]);
$obs=nl2br($item["obs"]);
$hinicio=$item["hinicio"];
$hfim=$item["hfim"];
$abertura=$item['abertura'];
$fechamento=$item['fechamento'];
//$hlab=mysql_result($resultado,0,"hlab");
$sla=$item["sla"];


if ($hinicio<>0){
//	$inicio=substr(timestamp_para_humano($hinicio),11,5);
	$inicio=date("d/m/Y à\s H:i",$hinicio);
}
if ($hfim<>0){
//	$fim=substr(timestamp_para_humano($hfim),11,5);
	$fim=date("d/m/Y à\s H:i",$hfim);
}
if($agente<>'DEFINIR'){
	$linha=Conexao::linhas2Bd($tabela,"clientes=\"$agente\"");
}else{
	$nome_agente=$resultado2["nome"];
}
if($fechamento<>0){
	$fechamento=date("d/m/Y à\s H:i",$item["fechamento"]);
}
if($abertura<>0){
	$abertura=date("d/m/Y à\s H:i",$item["abertura"]);
}
//if ($fechamento){
	//$fechamento=substr(timestamp_para_humano($fechamento),0,10);
//}
$obs=$item["obs"];
if (!$obs){
	$obs="&nbsp";
}
$cliente=$item["clientes"];
$departamento=$item["departamento"];
@$nome_cliente=$resultado2['nome'];

$status=$_GET['status'];
$nome_status=statusChamado($status);

echo "<title>Relatório de Atendimento Chamado No $chamado</title>";
echo "<table border=0 width=100% height=100% ><tr><td valign=top>";
echo "<table width=100% border=0 bordercolor=black cellspacing=0 cellpadding=3>";
echo "<tr><td colspan=5 align=left valign=middle>";
echo "<table border=0 width=100% cellspacing=0><tr><td rowspan=1 align=center><img src=\"logo.png\" width=150></td><td ALIGN=CENTER valign=bottom>&nbsp</TD></tr>";
//echo "<td align=center valign=top><font size=5 face=verdana><B>PROSEG <font size=3 face=verdana>GRUPO PROSEG";
echo "<td align=center valign=top><b><p><font size=3 face=verdana>Relatório de Atendimento";
echo "<p><font size=2 face=verdana>www.grupoproseg.com<BR>";
echo "<font size=1 face=verdana></b>Rua Almirante Baltazar, 37 | São Cristóvão | Rio de Janeiro | RJ  CEP: 20941-150<BR>";
echo "Telefone: (21) 2580.0852 | (21) 2589.2451<BR>";
echo "<b>ti@grupoproseg.com";
echo "</td></tr>";
//echo "<tr><td>&nbsp</td></tr>";
echo "<tr><td colspan=2><table border=0 width=100%><td colspan=0 width=40% valign=bottom><font face=verdana size=2>Relatorio de Atendimento: <b>Chamado No $chamado</td>";

if ($fechamento<>0){
	echo "<td align=right width=40%><font face=verdana size=2>Data de Atendimento: <b>$fechamento</td></tr>";
}else{
	echo "<td align=right width=40%><font face=verdana size=2>Data de Atendimento: ____/____/____</td></tr>";
}
echo "</tr></table>";
echo "<tr><td colspan=3><hr color=blue></td></tr>";
echo "</table>";
echo "<table border=0 width=100%><tr><td>";
echo "<table border=0 width=100%>";
echo "<tr><td colspan=7 align=center><font face=verdana size=2><b>Dados do Cliente</td></tr>";
echo "<tr height=10><td colspan=7><table width=100%><td width=70><font size=1 face=verdana color=black>Nome:</td><td colspan=4 bgcolor=white><font size=1 face=arial color=black><B>$nome_cliente</td>";
echo "<td></td><td></td>";
echo "<td align=right><font size=1 face=verdana color=black>Abertura: ";
echo "&nbsp&nbsp";
echo "<font size=1 face=arial color=black><B>";
echo "$abertura</td></tr>";
echo "<table width=100%><td width=70><font size=1 face=verdana color=black>Departamento:</td><td colspan=4 bgcolor=white><font size=1 face=arial color=black><B>$departamento</td></tr></table></table></td></tr>";
echo "<tr><td colspan=5><hr></td></tr>";
echo "<tr><td colspan=5 align=center><font face=verdana size=2><b>Dados do Atendimento</td>";
echo "<tr height=10><td colspan=5><table border=0 width=100%><td width=50 valign=top><font size=1 face=verdana color=black>Ocorrência/Defeito:</td><td bgcolor=white align=left><font size=1 face=arial color=black><B>$descricao</td></table></td></tr>";
echo "<tr height=10><td colspan=5><table border=0 width=100%><td width=50><font size=1 face=verdana color=black>Status:</td><td bgcolor=white align=left width=40%><font size=1 face=arial color=black><B>$nome_status</td><td align=center>";
//<font size=1 face=verdana color=black>Contrato: <font size=1 face=arial color=black><B>$contrato</td></table></td></tr>";
echo "<tr><td colspan=5><hr></td></tr>";
	echo "<tr><td>&nbsp</td></tr>";
echo "<tr><td colspan=5>";
echo "<table border=1 cellspacing=0 bordercolor=black width=100%>";
echo "<tr height=23><td><font face=verdana size=1><b>Procedimentos efetuados:</td></tr>";
if (!$solucao){
	echo "<tr height=23><td>&nbsp</td></tr>";
	echo "<tr height=23><td>&nbsp</td></tr>";
	echo "<tr height=23><td>&nbsp</td></tr>";
	echo "<tr height=23><td>&nbsp</td></tr>";
	echo "<tr height=23><td>&nbsp</td></tr>";
	echo "<tr height=23><td>&nbsp</td></tr>";
}else{
	echo "<tr height=23><td><font face=verdana size=1>$solucao</td></tr>";
}
echo "</table>";
echo "<br>";
echo "<table border=1 bordercolor=black cellspacing=0 width=100%>";
echo "<tr height=23><td><font face=verdana size=1><b>Observações:</td></tr>";
if (!$obs_cli){
	echo "<tr height=23><td><font face=verdana size=1>&nbsp</td></tr>";
	echo "<tr height=23><td>&nbsp</td></tr>";
}else{
	echo "<tr height=23><td><font face=verdana size=1>$obs_cli</td></tr>";
}
echo "</table>";
echo "<br>";
echo "<table border=1 bordercolor=black cellspacing=0 width=100%>";
echo "<tr height=23><td><font face=verdana size=1><b>Observações Técnicas:</td></tr>";
if (!$obs){
	echo "<tr height=23><td><font face=verdana size=1>&nbsp</td></tr>";
	echo "<tr height=23><td>&nbsp</td></tr>";
}else{
	echo "<tr height=23><td><font face=verdana size=1>$obs</td></tr>";
}
echo "</table>";
echo "<tr>&nbsp</tr>";
	echo "<tr><td>&nbsp</td></tr>";
//echo "<font face=verdana size=1>* No tempo de atendimento, caso haja resíduo superior a 15 minutos, será cobrado como 1 hora técnica.<p>";
echo "<table border=0 bordercolor=black width=100%>";
echo "<tr><td width=30% valign=top>";
echo "<table border=0 bordercolor=black width=100%>";
echo "<tr><td width=10%><font size=1 face=verdana><b>Início:</td><td width=50% align=center><font size=2 face=verdana>";
if (@$inicio<>0){
	echo $inicio;
}else{
	echo "&nbsp";
}
echo "</td></tr>";
echo "<tr><td><font size=1 face=verdana><b>Término:</td><td align=center><font size=2 face=verdana>";
if ($fechamento<>0){
	echo "$fechamento";
}else{
	echo "&nbsp";
}
echo "</td></tr>";
echo "</td></tr></table>";
echo "</td>";
echo "<td width=90% align=right valign=top><table border=0 bordercolor=black width=100%>";
echo "<tr><td><table border=1 cellspacing=0 width=100% bordercolor=black><tr><td><font face=verdana size=1><b>Técnico</td>";
echo "<td width=30%><font face=verdana size=1><b>Assinatura</td><td width=50%><font face=verdana size=1><b>De acordo (Cliente)</td></tr>";
echo "<tr><td><font face=verdana size=1>$agente</td><td>&nbsp</td><td>&nbsp</td></tr></table>";
echo "</td></tr>";
echo "</table>";
echo "</td></tr>";
echo "</table>";
echo "</table>";
exit;	
?>