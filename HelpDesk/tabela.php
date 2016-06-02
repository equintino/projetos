<?php
@$username=$_COOKIE['nome_usuario'];
@$tipo=$_GET['tipo'];
//@$username=$_GET['username'];
include "valida_cookies.inc";
//include "fundo.php";
include "construct.php";
include "divfunc.php";
echo "<table width=100%><tr><td align=right><font color=#008080><B>CONTROLE DE CHAMADOS<br><hr width=50%></td></tr></table>";

@$cliente=MAIUSCULO($_POST["cliente"]);
if (!$cliente){
	@$cliente=MAIUSCULO($_GET["cliente"]);
}
@$cliente2=MAIUSCULO($_POST["cliente2"]);
if (!$cliente2){
	@$cliente2=MAIUSCULO($_GET["cliente2"]);
}
@$cliente3=MAIUSCULO($_POST["cliente3"]);
if (!$cliente3){
	@$cliente3=MAIUSCULO($_GET["cliente3"]);	
}
@$codigo=$_GET["codigo"];
@$escolha=$_POST["escolha"];
if (!$escolha){
	@$escolha=$_GET["escolha"];
	if (!$escolha){
		@$escolha="numero";
	}
}
@$conta=$_GET["conta"];
@$data1=$_POST["data1"];
if (!$data1){
	@$data1=$_GET["data1"];
	if ($data1){
		if (strlen($data1)<10){
			@$data1=add_ano($data1);
		}
	}
}

@$data2=$_POST["data2"];
if (!$data2){
	@$data2=$_GET["data2"];
	if ($data2){
		if (strlen($data2)<10){
			$data2=add_ano($data2);
		}
	}
}

@$status=$_POST["status"];
if (!$status){
	@$status=$_GET["status"];
	if (!$status){
		$status='T';
	}
}
$mes=mes(mktime(0));
//$pdo=conectaBd();
$tabela='chamados';
$ordem='abertura';

if ((!$data1)&&(!$data2)){
	if ($status!="T"){
		$res=Conexao::consultaBd($status,$inicio=null,$fim=null,null);
		//$res=Conexao::consulta2Bd($tabela,$ordem);
	}
}
	if (!@$res){
		$day1=1;
		$month1=substr(timestamp_para_humano(mktime(0)),3,2);
		$year1=substr(timestamp_para_humano(mktime(0)),6,4);
		$inicio=mktime(0,0,0,"$month1","$day1","$year1");
	}else{
		if ($status=="T")	{
			$inicio=mysql_result($res,0);
			$data1=substr(timestamp_para_humano($inicio),0,10);
			$month1=substr($data1,3,2);
			$day1=substr($data1,0,2);
			$year1=substr($data1,6,4);
		}else{
			$inicio=0;
		}		
	$data1="";
	$data2="";
	$fim=mktime(0)+86400;
}
?>