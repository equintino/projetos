<?php
@$tipo=$_GET['tipo'];
$username=$_COOKIE['nome_usuario'];
include "valida_cookies.inc";
//include "fundo.php";
include "construct.php";
include "divfunc.php";
//include "bdgen.php";

echo "<table border=0 width=100%><tr><td align=right><font color=#008080><B>RELATÓRIOS<br><hr width=50%></td></tr></table>";

@$cliente=MAIUSCULO($_POST["cliente"]);
if (!$cliente){
	@$cliente=MAIUSCULO($_GET["cliente"]);
}
@$codigo=$_GET["codigo"];
@$escolha=$_POST["escolha"];
if (!$escolha){
	@$escolha=$_GET["escolha"];
	if (!$escolha)
		$escolha="data";
}
@$conta=$_GET["conta"];
@$tipo=$_POST["tipo"];
if (!$tipo){
	@$tipo=$_GET["tipo"];
	if (!$tipo){
		$tipo=2;
	}
}
@$data1=$_POST["data1"];
if (!$data1){
	@$data1=$_GET["data1"];	
	@$data1=add_ano($data1);
	if ($data1){
		if (strlen($data1)<4){
			$data1="";
		}
	}
}
@$data2=$_POST["data2"];
if (!$data2){
	@$data2=$_GET["data2"];	
	@$data2=add_ano($data2);
	if ($data2){
		if (strlen($data2)<4){
			$data2="";
		}
	}
}			
@$checa_data1=check_data($data1);
if ($checa_data1==2){
	$data1="";
}
@$checa_data2=check_data($data2);
if ($checa_data2==2){
	$data2="";
}
@$status=$_POST["status"];
if (!$status){
	@$status=$_GET["status"];
	if (!$status){
		$status=1;
	}
	if ($status=="N"){
		$status="0";
	}
}
$mes=mes(mktime(0));
$tabela='chamados';
if ((!$data1)&&(!$data2)){
	if ($status!="T"){
		//$res=mysql_query("select min(abertura) from chamados where status=$status order by abertura");	
		$where="status=\"$status\"";
	}else{
		//$res=mysql_query("select min(abertura) from chamados order by abertura");
		$where=1;
	}
	$lin=Conexao::linhas2Bd($tabela,$where);
	//$lin=mysql_num_rows($res);
	if (!$lin){
		$day1=1;
		$month1=substr(timestamp_para_humano(mktime(0)),3,2);
		$year1=substr(timestamp_para_humano(mktime(0)),6,4);
		$inicio=mktime(0,0,0,"$month1","$day1","$year1");
	}else{
		if ($status=="T"){
			$inicio=mysql_result($res,0);
			$data1=substr(timestamp_para_humano($inicio),0,10);
			$month1=substr($data1,3,2);
			$day1=substr($data1,0,2);
			$year1=substr($data1,6,4);
		}else{
			if($tipo!=1){		
				$day1=1;
				$month1=substr(timestamp_para_humano(mktime(0)),3,2);
				$year1=substr(timestamp_para_humano(mktime(0)),6,4);
				$inicio=mktime(0,0,0,"$month1","$day1","$year1");
			}else{
				$ordem='abertura';
				$res=Conexao::consulta2Bd($tabela,$ordem);
				//$res=mysql_query("select min(abertura) from chamados order by abertura");
				if ($res){
					@$lin=mysql_num_rows($res);
				}
				if ($lin){
					$inicio=mysql_result($res,0);
				}
			}
		}		
	}
	@$data1=substr(timestamp_para_humano($inicio),0,10);
	$data2=substr(timestamp_para_humano(mktime(0)),0,10);
	$fim=mktime(0)+86400;
}elseif (($data1)&&(!$data2)){

	$month1=substr($data1,3,2);
	$day1=substr($data1,0,2);
	$year1=substr($data1,6,4);

	$inicio=mktime(0,0,0,"$month1","$day1","$year1");
	$data2=substr(timestamp_para_humano(mktime()),0,10);
	$fim=mktime()+86400;

}elseif ((!$data1)&&($data2)){
	$res=mysql_query("select min(abertura) from chamados where status=$status order by abertura");
	$lin=mysql_num_rows($res);
	if (!$lin){
		$day1=1;
		$month1=substr(timestamp_para_humano(mktime()),3,2);
		$year1=substr(timestamp_para_humano(mktime()),6,4);
		$inicio=mktime(0,0,0,"$month1","$day1","$year1");
	}else{
		$inicio=mysql_result($res,0);
		$data1=substr(timestamp_para_humano($inicio),0,10);
		$month1=substr($data1,3,2);
		$day1=substr($data1,0,2);
		$year1=substr($data1,6,4);
	}
	
	$data1=substr(timestamp_para_humano($inicio),0,10);
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
	
	$esta=1;	
}


if (!@$inicio){
	$data1="";
}

echo "<body onload=\"document.tiporel.tipo.focus()\">";
echo "<center><table cellSpacing=0 cellPadding=0 width=100% border=0><tr>";
echo "<form method=\"POST\" action=\"relatorio.php\" name=tiporel>";
echo "<tr><td colspan=2><font face=verdana size=2>Tipo:<select name=\"tipo\" size=\"1\" onchange=submit()>";

if (!$tipo){
	echo "<option value=''></option>";
	echo "<option value=1>Dívidas não pagas</option>";
	echo "<option value=2>Faturamento</option>";
	echo "<option value=4>Faturamento por Cliente</option>";
	echo "<option value=5>Lista de Clientes Ativos</option>";
	echo "<option value=6>Lista de Clientes Inadimplentes</option>";
	echo "<option value=7>Lista de Clientes Inativos</option>";
	echo "<option value=8>Lista de Clientes Preferenciais</option>";
	echo "<option value=3>Pagamentos Efetuados</option>";
}

if ($tipo==1)
{
	echo "<option value=1>Dívidas não pagas</option>";
	echo "<option value=''></option>";
	echo "<option value=1>Dívidas não pagas</option>";
	echo "<option value=2>Faturamento</option>";
	echo "<option value=4>Faturamento por Cliente</option>";
	echo "<option value=5>Lista de Clientes Ativos</option>";
	echo "<option value=6>Lista de Clientes Inadimplentes</option>";
	echo "<option value=7>Lista de Clientes Inativos</option>";
	echo "<option value=8>Lista de Clientes Preferenciais</option>";
	echo "<option value=3>Pagamentos Efetuados</option>";
}

if ($tipo==2){
	echo "<option value=2>Faturamento</option>";
	echo "<option value=''></option>";
	echo "<option value=1>Dívidas não pagas</option>";
	echo "<option value=2>Faturamento</option>";
	echo "<option value=4>Faturamento por Cliente</option>";
	echo "<option value=5>Lista de Clientes Ativos</option>";
	echo "<option value=6>Lista de Clientes Inadimplentes</option>";
	echo "<option value=7>Lista de Clientes Inativos</option>";
	echo "<option value=8>Lista de Clientes Preferenciais</option>";
	echo "<option value=3>Pagamentos Efetuados</option>";
}

if ($tipo==3){
	echo "<option value=3>Pagamentos Efetuados</option>";
	echo "<option value=''></option>";
	echo "<option value=1>Dívidas não pagas</option>";
	echo "<option value=2>Faturamento</option>";
	echo "<option value=4>Faturamento por Cliente</option>";
	echo "<option value=5>Lista de Clientes Ativos</option>";
	echo "<option value=6>Lista de Clientes Inadimplentes</option>";
	echo "<option value=7>Lista de Clientes Inativos</option>";
	echo "<option value=8>Lista de Clientes Preferenciais</option>";
	echo "<option value=3>Pagamentos Efetuados</option>";	
}

if ($tipo==4)
{
	echo "<option value=4>Faturamento por Cliente</option>";
	echo "<option value=''></option>";
	echo "<option value=1>Dívidas não pagas</option>";
	echo "<option value=2>Faturamento</option>";
	echo "<option value=4>Faturamento por Cliente</option>";
	echo "<option value=5>Lista de Clientes Ativos</option>";
	echo "<option value=6>Lista de Clientes Inadimplentes</option>";
	echo "<option value=7>Lista de Clientes Inativos</option>";
	echo "<option value=8>Lista de Clientes Preferenciais</option>";
	echo "<option value=3>Pagamentos Efetuados</option>";
}

if ($tipo==5){
	echo "<option value=5>Lista de Clientes Ativos</option>";
	echo "<option value=''></option>";
	echo "<option value=1>Dívidas não pagas</option>";
	echo "<option value=2>Faturamento</option>";
	echo "<option value=4>Faturamento por Cliente</option>";
	echo "<option value=5>Lista de Clientes Ativos</option>";
	echo "<option value=6>Lista de Clientes Inadimplentes</option>";
	echo "<option value=7>Lista de Clientes Inativos</option>";
	echo "<option value=8>Lista de Clientes Preferenciais</option>";
	echo "<option value=3>Pagamentos Efetuados</option>";
}


if ($tipo==7){
	echo "<option value=7>Lista de Clientes Inativos</option>";
	echo "<option value=''></option>";
	echo "<option value=1>Dívidas não pagas</option>";
	echo "<option value=2>Faturamento</option>";
	echo "<option value=4>Faturamento por Cliente</option>";
	echo "<option value=5>Lista de Clientes Ativos</option>";
	echo "<option value=6>Lista de Clientes Inadimplentes</option>";
	echo "<option value=7>Lista de Clientes Inativos</option>";
	echo "<option value=8>Lista de Clientes Preferenciais</option>";
	echo "<option value=3>Pagamentos Efetuados</option>";
}

if ($tipo==6){
	echo "<option value=6>Lista de Clientes Inadimplentes</option>";
	echo "<option value=''></option>";
	echo "<option value=1>Dívidas não pagas</option>";
	echo "<option value=2>Faturamento</option>";
	echo "<option value=4>Faturamento por Cliente</option>";
	echo "<option value=5>Lista de Clientes Ativos</option>";
	echo "<option value=6>Lista de Clientes Inadimplentes</option>";
	echo "<option value=7>Lista de Clientes Inativos</option>";
	echo "<option value=8>Lista de Clientes Preferenciais</option>";
	echo "<option value=3>Pagamentos Efetuados</option>";
}

if ($tipo==8){
	echo "<option value=8>Lista de Clientes Preferenciais</option>";
	echo "<option value=''></option>";
	echo "<option value=1>Dívidas não pagas</option>";
	echo "<option value=2>Faturamento</option>";
	echo "<option value=4>Faturamento por Cliente</option>";
	echo "<option value=5>Lista de Clientes Ativos</option>";
	echo "<option value=6>Lista de Clientes Inadimplentes</option>";
	echo "<option value=7>Lista de Clientes Inativos</option>";
	echo "<option value=8>Lista de Clientes Preferenciais</option>";
	echo "<option value=3>Pagamentos Efetuados</option>";
}


echo "</select></tr>";
echo "</form>";


if ($tipo>4){
	echo "<tr><td>&nbsp</td></tr>";

@$hein=$_GET["hein"];
$hein=(!$hein);
if ($hein){
	$complemento="";
}else{
	$complemento="desc";
}


	if ($tipo==5){
		$rel=mysql_query("select * from clientes where status=1 order by nome $complemento");
		$stat="ativos";
	}
	if ($tipo==6){
		$rel=mysql_query("select * from clientes where status=3 order by nome $complemento");
		$stat="inadimplentes";
	}	
	if ($tipo==7){
		$rel=mysql_query("select * from clientes where status=2 order by nome $complemento");
		$stat="inativos";
	}	
	if ($tipo==8){
		$rel=mysql_query("select * from clientes where status=4 order by nome $complemento");
		$stat="preferenciais";
	}	


	
	if ($rel){
		$linhas=mysql_num_rows($rel);
	}	
	if(!@$linhas){
		$linhas=null;	
	}					
		echo "<tr><td align=left><table cellpadding=0 cellspacing=0 border=0 height=1 width=100% bgcolor=lightskyblue>";
		echo "<td align=right><font size=2 face=verdana>Total: <b>$linhas</b> clientes $stat</td></table></td>";
		echo "<br><table width='100%' bgcolor=#336699 height='20px' border=0 cellspacing='2' cellpadding='0'><tr><td align='center'><a href='relatorio.php?escolha=cliente&cliente=$cliente&hein=$hein&status=$status&tipo=$tipo&data1=$data1&data2=$data2'><font size=1 face=verdana color=white>Cliente</font></td></tr></table>";
		echo "<table cellspacing=0 cellpaddin=0 border=2 width=100%>";


		if (!$linhas){
			if ($tipo){
				echo "<tr><td><table width=100% border=0 bgcolor=#DEDFDE><td align=center>Não existem chamados com a descrição solicitada.</td></table></td></tr>";
			exit;
			}
		}else{
			for ($i=0;$i<$linhas;$i++){
				if ($i%2==0){
					$color="#DEDFDE";
				}else{
					$color="silver";
				}
				$codigo=mysql_result($rel,$i,"codigo");
				$nome=mysql_result($rel,$i,"nome");
				$bairro=mysql_result($rel,$i,"bairro");
				$estado=mysql_result($rel,$i,"estado");
				echo "<tr>";
				if ($bairro){
					echo "<td><table bgcolor=$color height=100% width=100% border=0 cellspacing=0 cellpadding=0><tr align=center onmouseover=\"this.style.backgroundColor='cyan';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: $color\" onmouseout=\"this.style.backgroundColor='$color';\" onclick=\"link('clientes.php?act=edita&codigo=$codigo','_self')\"><td align=center width=70%><font size=1 color=black face=verdana><b>$nome ($bairro - $estado)</tr></table></td>";
				}else{
					echo "<td><table bgcolor=$color height=100% width=100% border=0 cellspacing=0 cellpadding=0><tr align=center onmouseover=\"this.style.backgroundColor='cyan';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: $color\" onmouseout=\"this.style.backgroundColor='$color';\" onclick=\"link('clientes.php?act=edita&codigo=$codigo','_self')\"><td align=center width=70%><font size=1 color=black face=verdana><b>$nome</tr></table></td>";
				echo "</tr>";
				}
			}		
		}
echo "</table></table></table>";
echo "<tr><td><table border=0 bgcolor=white width=100%><td align=center><font face=verdana size=1 color=red><B>GENESE - TECNOLOGIA DA INFORMAÇÃO E DESENVOLVIMENTO DE SISTEMAS</td></table></td>";
echo "</tr></table></td></tr></table><BR>";
exit;
}
echo "<form method=\"POST\" action=\"relatorio.php\" name=busca>";
echo "<tr>";
echo "<td colspan=7><table border=0 width=100%><tr><td width=50%><font size=1 face=verdana>Mês Vigente: <b>$mes</td><td></td><td><font size=1>Data Inicial:</td><td><input type=text name=data1 onkeydown=\"mascaraData(this)\" size=10 maxlength=10 value=$data1></td><td><font size=1>Data Final:</td><td><input type=text name=data2  size=10 onkeydown=\"mascaraData(this)\" maxlength=10 value=$data2></td><td><input type=submit value=Filtra></td></tr></table></td></tr>";

echo "<input type=hidden value=$tipo name=tipo>";

echo "<tr><td valign=center width=1><font size=1 face=verdana color=black><b>Buscar: </td><td width=90%> <input type=text name=\"cliente\" value='$cliente' size=20>";
echo "&nbsp<input type=submit value=\"Buscar >>\">&nbsp<input type=button value=\"Limpar\" onclick=\"location.href='relatorio.php'\">";
echo "</td>";
echo "</td></tr></table>";
if (($checa_data1==2)&&($checa_data2==2)){
	echo "<BR><font face=verdana size=2>Datas de início e término digitadas incorretamente.";
}elseif ($checa_data1==2){
	echo "<BR><font face=verdana size=2>Data de início digitada incorretamente.";
}elseif ($checa_data2==2){
	echo "<BR><font face=verdana size=2>Data de término digitada incorretamente.";
}
echo "<center><table cellspacing=0 cellpadding=3 rules=cols PageCount=1 bordercolor=lightskyblue border=4 id=\"ItemsGrid\" style=\"color:Black;background-color:lightskyblue;border-color:white;border-width:1px;border-style:None;font-family:Verdana;font-size:XX-Small;width:100%;border-collapse:collapse;\">";
echo "<tr>";


@$hein=$_GET["hein"];
@$hein=(!$hein);
if ($hein){
	$complemento="desc";
}else{
	$complemento="";	
}		

if ($tipo==1){
	$status=4;
}
if ($tipo==3){
	$status=5;
}


if ($tipo){

if ($escolha=="fantasia"){
	$nome_escolha="Cliente";
	if ($tipo!=2){
		$resultado=mysql_query("select * from chamados inner join clientes on chamados.cod_cliente=clientes.codigo where chamados.status=$status and (fechamento>=$inicio and fechamento<$fim) order by clientes.fantasia $complemento");
	}else{
		$resultado=mysql_query("select * from chamados inner join clientes on chamados.cod_cliente=clientes.codigo where (chamados.status>2 and chamados.status<6) and (fechamento>=$inicio and fechamento<$fim) order by clientes.fantasia $complemento");
	}
}


if ($escolha=="numero"){
	$nome_escolha="RA";
	if ($tipo!=2){
		$resultado=mysql_query("select * from chamados where status=$status and (fechamento>=$inicio and fechamento<$fim) order by ra $complemento");
	}else{
		$resultado=mysql_query("select * from chamados where (status>2 and status<6) and (fechamento>=$inicio and fechamento<$fim or fechamento=0) order by ra $complemento");
	}
}


if ($escolha=="agente"){
	$nome_escolha="Técnico";
	if ($tipo==2){
		$resultado=mysql_query("select * from chamados inner join usuarios on chamados.agente=usuarios.codigo where (chamados.status>2 and chamados.status<6) and (chamados.fechamento>=$inicio and chamados.fechamento<$fim) order by usuarios.nick $complemento");
	}else{
		$resultado=mysql_query("select * from chamados inner join usuarios on chamados.agente=usuarios.codigo where chamados.status=$status and (chamados.fechamento>=$inicio and chamados.fechamento<$fim) order by usuarios.nick $complemento");
	}
}
if ($escolha=="data"){	
	$nome_escolha="Data";
	if ($tipo==2){
		$resultado=mysql_query("select * from chamados where (status>2 and status<6) and (fechamento>=$inicio and fechamento<$fim) order by fechamento $complemento");
	}else{
		@$resultado=mysql_query("select * from chamados where status=$status and (fechamento>=$inicio and fechamento<$fim) order by fechamento $complemento");
	}
}



if ($resultado){
	$linhas=mysql_num_rows($resultado);
}

if ($cliente){
	if ($escolha=="data"){
		$escolha="chamados.abertura";
	}
	if ($escolha=="status"){
		$escolha="chamados.status";
	}
	if ($escolha=="numero"){
		$escolha="chamados.ra";	
	}
	if ($tipo==1){
		$resultado=mysql_query("select * from chamados INNER JOIN clientes ON chamados.cod_cliente=clientes.codigo inner join usuarios on chamados.agente=usuarios.codigo and (chamados.numero like '%$cliente%' or clientes.nome like '%$cliente%' or clientes.fantasia like '%$cliente%' or chamados.descricao like '%$cliente%' or usuarios.nick like '%$cliente' or usuarios.nome like '%$cliente%') and (chamados.status>2 and chamados.status<5) and (chamados.fechamento>=$inicio and chamados.fechamento<$fim or chamados.fechamento=0) order by $escolha $complemento");
	}elseif ($tipo==2){
		$resultado=mysql_query("select * from chamados INNER JOIN clientes ON chamados.cod_cliente=clientes.codigo inner join usuarios on chamados.agente=usuarios.codigo and (chamados.numero like '%$cliente%' or clientes.nome like '%$cliente%' or clientes.fantasia like '%$cliente%' or chamados.descricao like '%$cliente%' or usuarios.nick like '%$cliente' or usuarios.nome like '%$cliente%') and (chamados.status>2 and chamados.status<6) and (chamados.fechamento>=$inicio and chamados.fechamento<$fim or chamados.fechamento=0) order by $escolha $complemento");
	}elseif ($tipo==3){
		$resultado=mysql_query("select * from chamados INNER JOIN clientes ON chamados.cod_cliente=clientes.codigo inner join usuarios on chamados.agente=usuarios.codigo and (chamados.numero like '%$cliente%' or clientes.nome like '%$cliente%' or clientes.fantasia like '%$cliente%' or chamados.descricao like '%$cliente%' or usuarios.nick like '%$cliente' or usuarios.nome like '%$cliente%') and chamados.status=5 and (chamados.fechamento>=$inicio and chamados.fechamento<$fim or chamados.fechamento=0) order by $escolha $complemento");
	}
}  
}

  // fim mostra chamados solicitados


	if ($resultado){
		$linhas=mysql_num_rows($resultado);
	}
if ($tipo!=4){
echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"300;URL=relatorio.php\">";
echo "<td align=left><table cellpadding=0 cellspacing=0 border=0 height=1 width=100% bgcolor=lightskyblue><td width=50%><font size=1 face=verdana>Ordenado por: <b>$nome_escolha ";
if(!isset($linhas)){
	$linhas="";
}
if(!isset($stat)){
	$stat='';
}
echo "</td><td align=right width=50%><font size=1 face=verdana>Total: <b>$linhas</b> chamados $stat</td></table></td>";
echo "<br><table width='100%' bgcolor=#336699 height='20px' border=0 cellspacing='2' cellpadding='0'><tr><td width=10% align='center'><a href='relatorio.php?escolha=numero&cliente=$cliente&hein=$hein&status=$status&tipo=$tipo&data1=$data1&data2=$data2'><font size=1 face=verdana color=white>RA</font></td><td width=25% align='center'><a href='relatorio.php?escolha=fantasia&cliente=$cliente&hein=$hein&status=$status&tipo=$tipo&data1=$data1&data2=$data2'><font size=1 face=verdana color=white>Cliente</font></td><td width=15% align='center'><a href='relatorio.php?escolha=data&cliente=$cliente&hein=$hein&status=$status&tipo=$tipo&data1=$data1&data2=$data2'><font size=1 face=verdana color=white>Data Atendimento</font></td><td align='center' width=13%><a href='relatorio.php?escolha=agente&cliente=$cliente&hein=$hein&status=$status&tipo=$tipo&data1=$data1&data2=$data2'><font size=1 face=verdana color=white>Agente</font></td><td align=center width=5%><font size=1 face=verdana color=white>H.T.</td><td align=center width=5%><font size=1 face=verdana color=white>H.C.</td><td align=center width=12%><font size=1 face=verdana color=white>Valor Peças</td><td align=center width=12%><font size=1 face=verdana color=white>Valor Serviços</td></tr></table>";
}

echo "<table cellspacing=0 cellpaddin=0 border=2 width=100%>";


if (!@$linhas){
	if ($tipo){
		echo "<tr><td><table width=100% border=0 bgcolor=#DEDFDE><td align=center>Não existem chamados com a descrição solicitada.</td></table></td></tr>";
	}else{
		echo "<tr><td><table width=100% border=0 bgcolor=#DEDFDE><td align=center>Selecione o tipo de relatório.</td></table></td></tr>";
	}
	exit;
}
$total=0;
$total_serv=0;
$total_pecas=0;
$tht=0;
$thc=0;

for ($i=0;$i<$linhas;$i++){
	if ($i%2==0){
		$color="#DEDFDE";
	}else{
		$color="silver";
	}
}
	$reg=mysql_fetch_row($resultado);
	$codigo=$reg[1];
	$ra=$reg[18];
	$cod_cliente=$reg[4];
	$agente=$reg[2];
	$hlab=$reg[17];
	if (!$hlab){
		$hlab=0;
	}
	$hinicio=$reg[12];
	$hfim=$reg[13];
	$ht=hora2(($hfim-$hinicio)/3600);
	$hc=$ht+$hlab;

	if ($agente==10){
		$cor="red";
		$agente="A DEFINIR";
	}else{
		$cor="black";		
		$cade=mysql_query("select nick from usuarios where codigo=$agente");
		$agente=mysql_result($cade,0,"nick");
	}


	$status=$reg[3];
	
	$data_atend=$reg[6];
	if (!$data_atend){
		$data_atend="ABERTO";
	}else{
		$data_atend=substr(timestamp_para_humano($data_atend),0,10);
	}
	$res=mysql_query("select nome,fantasia from clientes where codigo='$cod_cliente'");
	if ($res){
		$fant=mysql_result($res,0,"fantasia");
	}
	if (!$fant){
		$fant=mysql_result($res,0,"nome");
		if ($fant=="ASSUNTOS INTERNOS"){
			$cor2="BROWN";
		}else{
			$cor2="blue";
		}
	}
	$acha_valor=mysql_query("select parcelas,valor,tipocob,vpc from pagamento where numero=$codigo");
	if ($acha_valor){
		$lin5=mysql_num_rows($acha_valor);
	}

	if ($lin5){
		$parcelas=mysql_result($acha_valor,0,"parcelas");
		$tipocob=mysql_result($acha_valor,0,"tipocob");
		$vpc=mysql_result($acha_valor,0,"vpc");
		$valor_parcela=mysql_result($acha_valor,0,"valor");		
		
		if ($tipocob==1){
			$valor_inicial=($valor_parcela*$hc);
		}elseif ($tipocob==2){
			$valor_inicial=($valor_parcela);
			$hc=0;
		}	
		if (!$vpc){
			$vpc=0;
		}else{
			$vpc=checa_centavos($vpc);
			$total_pecas=checa_centavos($total_pecas+$vpc);
		}

	}else{
		$valor_inicial=0;
		$vpc=0;
		$hc=0;
	}
	if ($ht){
		$tht=$tht+$ht;
	}
	if ($hc){
		$thc=$thc+$hc;
	}
		$v_serv=checa_centavos($valor_inicial);


		$valor=$v_serv+$vpc;
		$total_serv=checa_centavos($total_serv+$v_serv);
		$total=$total+$valor;
	
		$total=checa_centavos($total);

	echo "<tr height=50%>";

	echo "<td><table bgcolor=$color height=100% width=100% border=0 cellspacing=0 cellpadding=0><tr align=center onmouseover=\"this.style.backgroundColor='cyan';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: $color\" onmouseout=\"this.style.backgroundColor='$color';\" onclick=\"link('det.php?codigo=$codigo&tipo=$tipo&data1=$data1&data2=$data2&cliente=$cliente&escolha=$escolha&deonde=relatorio','_self')\"><td width=10% align='center'><font size=1 face=verdana>$ra</td><td width=25%><font size=1 color=$cor2 face=verdana><b>$fant</td><td width=15% align=center><font size=1 face=verdana>$data_atend</font></td><td align='center'width=13%><font size=1 face=verdana color=$cor>$agente</font></td><td width=5% align=center><font size=1 face=verdana color=black>$ht</td><td width=5% align=center><font size=1 face=verdana color=black>$hc</td><td width=12% align=right><font size=1 face=verdana color=black>R$ ".reais($vpc)."</td><td align=right width=12%><font size=1 face=verdana color=black>R$ ".reais($v_serv)."</td></tr></table></td>";
echo "</tr></table>";
$color="skyblue";

echo "<table border=1 width=100% bgcolor=$color><tr><td><table width=100%><tr><td align=center><font face=verdana size=1>TOTAL HORAS TRABALHADAS:  <b><font size=2>$tht</td><td align=center><font face=verdana size=1>TOTAL HORAS COBRADAS:  <b><font size=2>$thc</td><td align=center><font face=verdana size=1>TOTAL PEÇAS:  <b><font size=2>R$ ".reais($total_pecas)."</td><td align=center><font face=verdana size=1>TOTAL SERVIÇOS:  <b><font size=2>R$ ".reais($total_serv)."</td></tr></table></td></tr></table>";
echo "<table border=1 width=100% bgcolor=$color><tr><td align=center><font face=verdana size=2>Valor Total:  <b><font size=3>R$ ".reais($total)."</td></tr></table>";
echo "</table></table>";
echo "<tr><td><table border=0 bgcolor=white width=100%><td align=center><font face=verdana size=1 color=red><B>GENESE - TECNOLOGIA DA INFORMAÇÃO E DESENVOLVIMENTO DE SISTEMAS</td></table></td>";
echo "</tr></table></td></tr></table><BR>";
//else{
// se tipo=4
//}
$hein=$_GET["hein"];
$hein=(!$hein);
if (!$hein){
	$complemento="desc";
}else{
	$complemento="";	
}

if ($cliente){
	$resultado=mysql_query("select * from chamados inner join clientes on chamados.cod_cliente=clientes.codigo and (chamados.status>2 and chamados.status<6) and clientes.nome like '%$cliente%' and (fechamento>=$inicio and fechamento<=$fim) group by clientes.fantasia order by clientes.nome $complemento");
	if ($resultado){
		$linhas=mysql_num_rows($resultado);
	}
	if (!$linhas){
		$resultado=mysql_query("select * from chamados inner join clientes on chamados.cod_cliente=clientes.codigo and (chamados.status>2 and chamados.status<6) and clientes.fant like '%$cliente%' and (fechamento>=$inicio and fechamento<=$fim) group by clientes.fantasia order by clientes.nome $complemento");
	}		
	if ($resultado){
		$linhas=mysql_num_rows($resultado);
	}
	if (!$linhas){
		$resultado=mysql_query("select * from chamados inner join clientes on chamados.cod_cliente=clientes.codigo and (chamados.status>2 and chamados.status<6) and (fechamento>=$inicio and fechamento<=$fim) group by clientes.fantasia order by clientes.nome $complemento");
	}
}else{
	$resultado=mysql_query("select * from chamados inner join clientes on chamados.cod_cliente=clientes.codigo and (chamados.status>2 and chamados.status<6) and (fechamento>=$inicio and fechamento<=$fim) group by clientes.fantasia order by clientes.nome $complemento");
}
if ($resultado){
	$linhas=mysql_num_rows($resultado);
}

echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"300;URL=relatorio.php\">";
echo "<td align=left><table cellpadding=0 cellspacing=0 border=0 height=1 width=100% bgcolor=lightskyblue><td width=50%><font size=1 face=verdana><B>TOTAL DE FATURAMENTO POR CLIENTE";
echo "</td><td align=right width=50%><font size=1 face=verdana>Total: <b>$linhas</b> Clientes</td></table></td>";
echo "<br><table width='100%' bgcolor=#336699 height='20px' border=0 cellspacing='2' cellpadding='0'><tr><td width=8%>&nbsp</td><td width=75% align='left'><a href='relatorio.php?escolha=fantasia&cliente=$cliente&hein=$hein&status=$status&tipo=$tipo&data1=$data1&data2=$data2'><font size=1 face=verdana color=white>Cliente</font></td><td align=center><font size=1 face=verdana color=white>Valor</td></tr></table>";


echo "<table cellspacing=0 cellpaddin=0 border=2 width=100%>";


if (!$linhas){
	if ($tipo){
		echo "<tr><td><table width=100% border=0 bgcolor=#DEDFDE><td align=center>Não existem clientes com a descrição solicitada.</td></table></td></tr>";
	}
	exit;
}
$total=0;

for ($i=0;$i<$linhas;$i++){
	if ($i%2==0){
		$color="#DEDFDE";
	}else{
		$color="silver";
	}
}
	$reg=mysql_fetch_row($resultado);
	$codigo=$reg[1];
	$cod_cliente=$reg[4];
	$agente=$reg[2];
	$hlab=$reg[17];
	if (!$hlab){
		$hlab=0;
	}

	$res=mysql_query("select nome,fantasia,bairro,estado from clientes where codigo='$cod_cliente'");
	if ($res){
		$fant=mysql_result($res,0,"nome");
		$bairro=mysql_result($res,0,"bairro");
		$estado=mysql_result($res,0,"estado");		
	}
	$cor2="blue";
	$total_cliente=0;
	$acha_valor=mysql_query("select pagamento.numero,parcelas,valor,tipocob,vpc,chamados.hlab from pagamento inner join chamados on pagamento.numero=chamados.numero and (chamados.status>2 and chamados.status<6) and pagamento.cod_cliente='$cod_cliente' and (chamados.fechamento>=$inicio and chamados.fechamento<=$fim)");
	if ($acha_valor){
		$lin5=mysql_num_rows($acha_valor);
		if ($lin5){
			$quant=mysql_num_rows($acha_valor);
		}
	}
	for ($soma=0;$soma<$quant;$soma++){
		$tipocob=mysql_result($acha_valor,$soma,"tipocob");
		$vpc=mysql_result($acha_valor,$soma,"vpc");
		$valor_parcela=mysql_result($acha_valor,$soma,"valor");
		$codigo=mysql_result($acha_valor,$soma,"numero");
		$hlab=mysql_result($acha_valor,$soma,"chamados.hlab");
		if ($tipocob==1){
			$pega=mysql_query("select hinicio,hfim from chamados where numero=$codigo");
			if ($pega){
				$linpeg=mysql_num_rows($pega);
			}
			if (($pega)&&($linpeg)){
				$hinicio=mysql_result($pega,0,"hinicio");
				$hfim=mysql_result($pega,0,"hfim");
				$horas=hora2(($hfim-$hinicio)/3600)+$hlab;
			}
			if ($tipocob==1){
				$vl=($valor_parcela*$horas)+$vpc;
			}elseif ($tipocob==2){
				$vl=($valor_parcela+$vpc);
			}
			$total_cliente=$total_cliente+$vl;
		}else{
			$total_cliente=0;	
		}
		$total_cliente=checa_centavos($total_cliente);
	}

$total=$total+$total_cliente;
$total=checa_centavos($total);

$total_cliente="R$ ".reais($total_cliente);

	echo "<tr height=50%>";
	if ($bairro){
		echo "<td><table bgcolor=$color height=100% width=100% border=0 cellspacing=0 cellpadding=0><tr align=center><td align=left width=70%><font size=1 color=$cor2 face=verdana><b>&nbsp $fant ($bairro - $estado)</td><td align=right><font size=2 face=verdana color=black>$total_cliente</td><td width=5%>&nbsp</td></tr></table></td>";
	}else{
		echo "<td><table bgcolor=$color height=100% width=100% border=0 cellspacing=0 cellpadding=0><tr align=center><td align=left width=70%><font size=1 color=$cor2 face=verdana><b>&nbsp $fant</td><td align=right><font size=2 face=verdana color=black>$total_cliente</td><td width=5%>&nbsp</td></tr></table></td>";
	}
echo "</tr></table>";

echo "<table border=1 width=100% bgcolor=skyblue><tr><td align=center><font face=verdana size=2>Valor Total:  <font face=verdana size=3><b>R$ ".reais($total)."</td></tr></table>";
echo "</table></table>";
echo "<tr><td><table border=0 bgcolor=white width=100%><td align=center><font face=verdana size=1 color=red><B>GENESE - TECNOLOGIA DA INFORMAÇÃO E DESENVOLVIMENTO DE SISTEMAS</td></table></td>";
echo "</tr></table></td></tr></table><br>";
?>