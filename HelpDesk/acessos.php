<?php
$username=$_COOKIE['nome_usuario'];
include "valida_cookies.inc";
//include "fundo.php";
include "construct.php";
include "divfunc.php";

@$cliente=maiusculo($_POST["cliente"]);
if(!$cliente){
	@$cliente=maiusculo($_GET['cliente']);	
}
@$codigo=$_POST["codigo"];
if(!isset($codigo)){
	@$codigo=$_GET['codigo'];	
}
@$escolha=$_POST["escolha"];
if (!$escolha){
	@$escolha=$_GET["escolha"];
	if (!$escolha){
		$escolha="acesso";
	}
}
@$conta=$_POST["conta"];
if(@!$conta){
	@$conta=$_GET['conta'];	
}
@$data1=$_POST["data1"];
if (!$data1){
	@$data1=$_GET["data1"];
	if ($data1){
		if (strlen($data1)<10){
			$data1="";
		}
	}
}

@$data2=$_POST["data2"];
if (!$data2){
	@$data2=$_GET["data2"];
	if ($data2){
		if (strlen($data2)<10){
			$data2="";
		}
	}
}
if(!isset($_GET["act"])){
	$_GET["act"]='';
}

$mes=mes(mktime(date("m")));

echo "<table width=100%><tr><td align=right><font color=#008080><B>CONTROLE DE ACESSOS<br><hr width=50%></td></tr></table>";
if ($_GET["act"]=="limpa"){
	if (!isset($_GET["go"])){
		echo "<b>Tem certeza de que deseja limpar o log de acessos?<BR><BR>";
		echo "<input type=button value=Limpar onclick=\"location.href='acessos.php?act=limpa&go=1'\"> <input type=button value=Cancelar onclick=\"location.href='acessos.php'\">";
		exit;
	}else{
		$tabela='acessos';
		echo "<b>Log de acessos zerado com sucesso.";
		$limpa=Conexao::limpaTabela($tabela);
		echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"2;URL=acessos.php\">";
		exit;
	}	
}
	$tabela='acessos';
	$where=1;
	$ordem='data_in';
	$lin=Conexao::linhas2Bd($tabela,$where);
	$res=Conexao::consulta2Bd($tabela,$ordem);

if ((!$data1)&&(!$data2)){	
	if (!$lin){
		$day1=1;
		$month1=substr(timestamp_para_humano(mktime(0)),3,2);
		$year1=substr(timestamp_para_humano(mktime(0)),6,4);
		$inicio=mktime(0,0,0,"$month1","$day1","$year1");
	}else{
		if(!isset($status)){
			$status='';
		}
		if ($status=="T"){
			$inicio=$res['data_in'];
			$data1=substr(timestamp_para_humano($inicio),0,10);
			$month1=substr($data1,3,2);
			$day1=substr($data1,0,2);
			$year1=substr($data1,6,4);
		}else{
			$day1=1;
			$month1=substr(timestamp_para_humano(mktime(0)),3,2);
			$year1=substr(timestamp_para_humano(mktime(0)),6,4);
			$inicio=mktime(0,0,0,"$month1","$day1","$year1");
			$inicio=0;
		}		
	}
	$data1="";
	$data2="";	
	$fim=mktime(0)+86400;
}elseif (($data1)&&(!$data2)){
	$month1=substr($data1,3,2);
	$day1=substr($data1,0,2);
	$year1=substr($data1,6,4);

	$inicio=mktime(0,0,0,"$month1","$day1","$year1");
	$data2="";
	$fim=mktime(0)+86400;

}elseif ((!$data1)&&($data2)){
	$data1="";
	$tabela='acessos';
	$where=1;
	$lin=Conexao::linhas2Bd($tabela,$where);
	if (!$lin){
		$day1=1;
		$month1=substr(timestamp_para_humano(mktime()),3,2);
		$year1=substr(timestamp_para_humano(mktime()),6,4);
		$inicio=mktime(0,0,0,"$month1","$day1","$year1");
	}else{
//		$inicio=$res['data_in'];
//		$data1=substr(timestamp_para_humano($inicio),0,10);
//		$month1=substr($data1,3,2);
//		$day1=substr($data1,0,2);
//		$year1=substr($data1,6,4);
	}

	$month2=substr($data2,3,2);
	$day2=substr($data2,0,2);
	$year2=substr($data2,6,4);
	$fim=mktime(0,0,0,"$month2","$day2","$year2")+86400;


}elseif (($data1)&&($data2)){
	$month1=substr($data1,3,2);
	$day1=substr($data1,0,2);
	$year1=substr($data1,6,4);

	$month2=substr($data2,3,2);
	$day2=substr($data2,0,2);
	$year2=substr($data2,6,4);

	$inicio=mktime(0,0,0,"$month1","$day1","$year1");
	$fim=mktime(0,0,0,"$month2","$day2","$year2")+86400;
}
echo "<body onload=\"document.busca.cliente.focus()\">";
echo "<form method=\"POST\" action=\"acessos.php\" name=busca>";
echo "<center><table cellSpacing=0 cellPadding=0 width=100% border=0><tr>";
	if(!isset($data1a)){
		$data1a='';
	}
	if(!isset($data2a)){
		$data2a='';
	}
echo "<td colspan=7><table border=0 width=100%><tr><td width=50%><font size=1 face=verdana>Mês Vigente: <b>$mes</td><td></td><td><font size=1>Data Inicial:</td><td><input type=text name=data1 onkeydown=\"mascaraData(this)\" size=10 maxlength=10 value=$data1a></td><td><font size=1>Data Final:</td><td><input type=text name=data2  size=10 onkeydown=\"mascaraData(this)\" maxlength=10 value=$data2a></td><td><input type=submit value=Filtra></td></tr></table></td></tr>";
echo "<tr><td>&nbsp</td></tr>";
echo "<tr><td valign=center align=center width=1><font size=1 face=verdana color=black><b>Buscar: </td><td>&nbsp</td><td width=90%> <input type=text name=\"cliente\" size=10>";
echo "&nbsp<input type=submit value=\"Buscar >>\"></td><td width=90%><a href='acessos.php?act=limpa'><font face=verdana size=2>Zerar log de acessos</a></td></tr>";
echo "</td>";
echo "</tr></table>";
echo "<center><table cellspacing=0 cellpadding=3 rules=cols PageCount=1 bordercolor=lightskyblue border=4 id=\"ItemsGrid\" style=\"color:Black;background-color:lightskyblue;border-color:lightskyblue;border-width:1px;border-style:None;font-family:Verdana;font-size:XX-Small;width:80%;border-collapse:collapse;\">";
echo "<tr>";
@$hein=$_GET["hein"];
$hein=(!$hein);
if ($hein){
	$complemento="desc";
}else{
	$complemento="";	
}

if ($escolha=="usuario"){
	$nome_escolha="Usuário";
	$ordenado='login';
}
if ($escolha=="acesso"){
	$nome_escolha="Acesso";
	$ordenado='id_acesso';
}
	@$resultado=Conexao::acessos($inicio,$fim,$complemento,$ordenado);
	
if ($cliente){
	$resultado=Conexao::buscaAcessos($cliente,$inicio,$fim,$complemento);
	$linhas=count($resultado);
}else{
	if ($resultado){
		$linhas=count($resultado);
	}
}
echo "<td align=left><table cellpadding=0 cellspacing=0 border=0 height=1 width=100% bgcolor=lightskyblue><td width=50%><font size=1 face=verdana>Ordenado por: <b>$nome_escolha ";
	if(!isset($linhas)){
		$linhas='';
	}
	if(!isset($stat)){
		$stat='';
	}
echo "</td><td align=right width=50%><font size=1 face=verdana>Total: <b>$linhas</b> acessos $stat</td></table></td>";
echo "<br><center><table width='80%' bgcolor=#336699 height='20px' border=0 cellspacing='2' cellpadding='0'><tr><td width=10% align='center'><a href='acessos.php?escolha=acesso&hein=$hein'><font size=1 face=verdana color=white>Acesso</font></td><td width=20% align='center'><a href='acessos.php?escolha=usuario&hein=$hein'><font size=1 face=verdana color=white>Usuário</font></td><td width=20% align='center'><font size=1 face=verdana color=white>Data e Hora</font></td><td width=15% align='center'><font size=1 face=verdana color=white>Endereço IP</td></tr></table>";
echo "<table cellspacing=0 cellpaddin=0 border=2 width=80%>";
if (!$linhas){
	echo "<tr><td><table width=100% border=0 bgcolor=#DEDFDE><td align=center>Não existem acessos registrados.</td></table></td></tr>";
	exit;
}
	$i=0;
	foreach($resultado as $key => $item){
		if ($i%2==0){
			$color="#DEDFDE";
		}else{
			$color="silver";
		}
	$acesso=$item['id_acesso'];
	$cod_user=$item['cod_usuario'];
	$data_in=$item['data_in'];
	$ip=$item['ip'];
	$login=$item['login'];	
	$data_in=timestamp_para_humano($data_in);	

	$username=$item["nome"];
	echo "<tr height=50%>";
	echo "<td><table bgcolor=$color height=100% width=100% border=0 cellspacing=0 cellpadding=0><tr align=center><td width=10% align='center'><font size=1 face=verdana>$acesso</td><td width=20%><font size=1 color=black face=verdana><b>$login</td><td width=20% align=center><font size=1 face=verdana>$data_in</font></td><td width=15% align=center><font size=1 face=verdana><b>$ip</td></tr></table></td>";
	$i++;
}
echo "</tr></table>";
echo "</table></table>";
echo "<tr><td><table border=0 bgcolor=white width=100%><td align=center><font face=verdana size=1 color=red><B>TECNOLOGIA DA INFORMAÇÃO</td></table></td>";
echo "</tr></table></td></tr></table><BR>";
?>