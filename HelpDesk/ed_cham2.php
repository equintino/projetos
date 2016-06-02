<?php
@$username=$_COOKIE['nome_usuario'];
include "valida_cookies.inc";
$tipo=$_GET['tipo'];
if(!$tipo){
  $tipo=$_POST['tipo'];
}
include "construct.php";
include "divfunc.php";
@$username=maiusculo($username);

@$codigo=$_GET["codigo"];
@$chamado=$_GET["chamado"];
if(!$chamado){
	@$chamado=$_POST['chamado'];
}

$resultado=Conexao::consultaChamado($chamado);
$cod_cliente=$resultado['codigo'];
$cod_usuario=$resultado['codigo'];
$sla=$resultado["sla"];
$cliente=$resultado['clientes'];

$resultado2=Conexao::usuariosChamados($chamado);
$nome_clienteBd=$resultado2["nome"];

$agente=maiusculo($_GET["agente"]);
@$descricao=$_GET["descricao"];
@$obs=$resultado["obs"];
@$obs_cli=$_GET["obs_cli"];

@$prog=$_GET["prog"];
@$prog_old=$_GET["prog_old"];
@$agente_old=$_GET["agente_old"];
// Fim troca de agente

@$valor_old=$_GET["valor_old"];
@$desc_old=$_GET["desc_old"];
@$obs_old=$_GET["obs_old"];
@$obs_cli_old=$_GET["obs_cli_old"];
@$solucao=$_GET["solucao"];
@$ver=$_GET["ver"];
@$qual=$_GET["qual"];
@$act=$_GET["act"];
if(!$act){	
	@$act=$_POST["act"];
}
@$status=$_GET["status"];
if(!$status){	
	@$status=$_POST["status"];
}
	@$inicio=$_GET["inicio"];
if (!$inicio){
	@$inicio=$_POST["inicio"];
}
	$solucao_old=$resultado["solucao"];
if ($obs){
	$obs_old=$resultado["obs"];
}
if ($obs_cli){
	$obs_cli_old=$resultado["obs_cli"];
}
echo "<center><table width=100% border=0>";
echo "<tr><td align=right><b><font color=#008080>CHAMADO No $chamado - EDIÇÃO<br><hr width=50%></td></tr>";
echo "<tr><td>&nbsp</td></tr></table></center>";
echo "<table border=0 width=100%>";
echo "</table>";
echo "<table border=0 width=100%>";
echo "<tr><td width=100>Cliente:</td><td><font size=2>$nome_clienteBd</td></tr>";
echo "</table>";
echo "<hr color=black>";
echo "<table border=0 width=100%>";
echo "<tr><td valign=top width=50%>";

// OBS
if ($qual=="obs"){
	if ($ver<>"1"){
		echo "<body onload=\"document.inclui.obs.focus()\">";
		echo "<table width=100% border=0>";
		echo "<form name=\"inclui\" method=\"GET\" action=\"ed_cham2.php\">";
		echo "<table border=0>";
		echo "<tr><td valign=top align=right>Observação:</td><td colspan=2 valign=top><TEXTAREA PLACEHOLDER='$obs_old' ROWS=13 COLS=60 NAME=obs></TEXTAREA></td>";
		echo "<input type=hidden name=ver value=\"1\">";
		echo "<input type=hidden name=codigo value='$codigo'>";
		echo "<input type=hidden name=chamado value='$chamado'>";
		echo "<input type=hidden name=username value='$username'>";
		echo "<input type=hidden name=tipo value='$tipo'>";				
		echo "<input type=hidden name=obs_old value='$obs_old'>";
		echo "<input type=hidden name=agente value='$agente'>";
		echo "<input type=hidden name=prog value='$prog'>";
		echo "<input type=hidden name=obs_cli value='$obs_cli'>";
		echo "<input type=hidden name=solucao value='$solucao'>";
		echo "<input type=hidden name=qual value=obs>";
		echo "<input type=hidden name=descricao value='$descricao'>";
		echo "<td valign=top><input type=submit value=\"   Alterar   \"><BR><input type=button value=\"  Cancelar \" onclick=\"location.href='det2.php?codigo=$codigo&chamado=$chamado'\"></td></tr>";
		echo "</table>";
	}else{
		$obs=$_GET['obs'];
		if ($obs<>$obs_old){	
			$resultado2=Conexao::consultaChamado($chamado);
			$obs_old=$resultado2['obs'];
			if ($obs_old!=null){
				$atual=$obs_old."<br>".$obs;
			}else{
				$atual=$obs;
			}
			$tabela='chamados';
			$dados="obs=\"$atual\"";
			$where="numero=\"$chamado\"";

			$atualiza=Conexao::atualizaChamado($tabela,$dados,$chamado);
			echo "Alteração realizada com sucesso!<p>";
			echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"1 URL='det2.php?codigo=$codigo&chamado=$chamado&username=$username&tipo=$tipo'\">";
		}else{
			echo "Nenhuma alteração foi realizada.<p>";
			echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"1;URL='det2.php?codigo=$codigo&chamado=$chamado&username=$username&tipo=$tipo'\">";
		}
	}
}

//obs cliente
if ($qual=="obs_cli"){
	if ($ver<>"1"){
		echo "<body onload=\"document.inclui.obs_cli.focus()\">";
		echo "<table width=100% border=0>";
		echo "<form name=\"inclui\" method=\"GET\" action=\"ed_cham2.php\">";
		echo "<table border=0>";
		echo "<tr><td valign=top align=right>Observação:</td><td colspan=2 valign=top>
		<TEXTAREA PLACEHOLDER='$obs_cli_old' ROWS=13 COLS=60 NAME=obs_cli></TEXTAREA></td>";
		echo "<input type=hidden name=ver value=\"1\">";
		echo "<input type=hidden name=codigo value='$codigo'>";
		echo "<input type=hidden name=agente value='$agente'>";
		echo "<input type=hidden name=descricao value='$descricao'>";
		echo "<input type=hidden name=qual value=obs_cli>";
		echo "<input type=hidden name=username value=$username>";
		echo "<input type=hidden name=tipo value=$tipo>";
		echo "<input type=hidden name=chamado value='$chamado'>";
		echo "<input type=hidden name=obs value='$obs'>";
		echo "<input type=hidden name=prog value='$prog'>";
		echo "<input type=hidden name=solucao value='$solucao'>";
		echo "<td valign=top><input type=submit value=\"    Alterar    \"><BR><input type=button value=\"   Cancelar  \" onclick=\"location.href='det2.php?codigo=$codigo&chamado=$chamado&username=$username&tipo=$tipo'\"></td></tr>";
		echo "</table>";
	}else{
		$obs_cli_old=$resultado['obs_cli'];
		$obs_cli=$_GET['obs_cli'];
		if ($obs_cli){
			if(!$obs_cli_old){
				$observacao=$obs_cli;
			}else{				
				$observacao=$obs_cli_old."<br>".$obs_cli;
			}
			$tabela='chamados';
			$dados="obs_cli=\"$observacao\"";
			Conexao::atualizaChamado($tabela,$dados,$chamado);
			
			echo "Alteração realizada com sucesso!<p>";
			echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"1;URL='det2.php?codigo=$codigo&chamado=$chamado&username=$username&tipo=$tipo'\">";
		}else{
			echo "Nenhuma alteração foi realizada.<p>";
			echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"1;URL='det2.php?codigo=$codigo&chamado=$chamado&username=$username&tipo=$tipo'\">";
		}
	}
}
if ($qual=="prog"){
//@$prog_old=$_GET["prog_old"];
$prog=$_GET["prog"];
	//$encontra=consultaChamado($pdo,$chamado);
	//$encontra=mysql_query("select * from chamados where numero='$chamado'");
		if ($prog==0){
			$prog=$resultado["prog"];
			if ($prog==0){
				$prog_old=0;
			}else{
				$prog_old=timestamp_para_humano($prog);
			}
		}		

	if ($prog_old){
		$data=substr(timestamp_para_humano($prog),0,10);
		$hora=substr(timestamp_para_humano($prog),11,5);
	}
	if ($resultado){
		$inicio=$resultado["hinicio"];
		if (!$inicio)
			$inicio_old="";
		else
			$inicio_old=substr(timestamp_para_humano($inicio),11,5);
		$fim=$resultado["hfim"];
		if (!$fim)
			$fim_old="";
		else
			$fim_old=substr(timestamp_para_humano($fim),11,5);	
		$atend=$resultado["fechamento"];
		if (!$atend)
			$atend_old="";
		else
			$atend_old=substr(timestamp_para_humano($atend),0,10);
	}
	if ($ver<>"1"){
		echo "<body onload=\"document.inclui.data.focus()\">";
		echo "<table width=100% border=0>";
//		echo "<tr><td bgcolor=silver align=center>DETALHE</td></table><p>";
		echo "<form name=\"inclui\" method=\"GET\" action=\"ed_cham2.php\">";
		echo "<table border=0>";
		echo "<tr><td><font face=verdana size=2><b>Programação:</td>";
			if(@!$data){
				$data=null;	
			}
			if(@!$hora){
				$hora=null;	
			}
			if(@!$atend_old){
				$atend_old=null;
			}
			if(@!$inicio_old){
				$inicio_old=null;	
			}
			if(@!$fim_old){
				$fim_old=null;	
			}
		echo "<td valign=top><table><tr><td width=1%><font face=verdana size=2>Dia:</td><td><input tabindex=1 type=text size=10 name=data maxlength=10 onkeydown=\"mascaraData(this)\" value=$data></td><td width=5>&nbsp</td><td width=1%><font face=verdana size=2>Hora:</td><td><input type=text tabindex=2 size=10 name=hora maxlength=5 onkeydown=\"mascaraHora(this)\" value=$hora></td></tr></table></td><td rowspan=2></td></tr></table>";
		echo "<table border=0>";
		echo "<tr><td><font face=verdana size=2><b>Atendimento:</td>";
		echo "<td valign=top><table><tr><td width=1%><font face=verdana size=2>Dia:</td><td><input tabindex=3 type=text size=10 name=atend maxlength=10 onkeydown=\"mascaraData(this)\" value=$atend_old></td><td width=5>&nbsp</td><td width=1%><font face=verdana size=2>Início:</td><td><input tabindex=3 type=text size=10 name=inicio maxlength=10 onkeydown=\"mascaraHora(this)\" value=$inicio_old></td><td width=5>&nbsp</td><td width=1%><font face=verdana size=2>Fim:</td><td><input type=text tabindex=4 size=10 name=fim maxlength=5 onkeydown=\"mascaraHora(this)\" value=$fim_old></td></tr></table></td>";
		echo "</tr>";
		echo "<tr><td>&nbsp</td></tr>";
		echo "<tr><td colspan=2><input type=submit value=\"    Alterar   \"> <input type=button value=\"   Cancelar   \" onclick=\"location.href='det2.php?codigo=$codigo&chamado=$chamado'\"></td></tr>";
		echo "<input type=hidden name=ver value=\"1\">";
		echo "<input type=hidden name=inicio_old value='$inicio_old'>";
		echo "<input type=hidden name=obs value='$obs'>";
		echo "<input type=hidden name=obs_cli value='$obs_cli'>";
		echo "<input type=hidden name=prog value='$prog'>";
		echo "<input type=hidden name=solucao value='$solucao'>";
		echo "<input type=hidden name=fim_old value='$fim_old'>";
		echo "<input type=hidden name=atend_old value='$atend_old'>";
		echo "<input type=hidden name=prog_old value='$prog_old'>";
		echo "<input type=hidden name=username_old value='$username_old'>";
		echo "<input type=hidden name=username value='$username'>";
		echo "<input type=hidden name=tipo_old value='$tipo_old'>";
		echo "<input type=hidden name=tipo value='$tipo'>";
		echo "<input type=hidden name=osb_cli value=$obs_cli>";
		echo "<input type=hidden name=codigo value='$codigo'>";
		echo "<input type=hidden name=qual value=prog>";
		echo "<input type=hidden name=descricao value='$descricao'>";
		echo "<input type=hidden name=agente value='$agente'>";
		echo "</table>";
	}else{
		$inicio_old=$_GET["inicio_old"];
		$prog_old=$_GET["prog_old"];
		$fim_old=$_GET["fim_old"];		
		$inicio=$_GET["inicio"];
		$fim=$_GET["fim"];		
		$inicio_new=$inicio;
		$fim_new=$fim;
		$hora1=substr($inicio,0,2);
		$min1=substr($inicio,3,2);
		$hora2=substr($fim,0,2);
		$min2=substr($fim,3,2);
		if ($inicio)
			$inicio=mktime($hora1,$min1);
		else
			$inicio=0;
		if ($fim)
			$fim=mktime($hora2,$min2);
		else
			$fim=0;
		$data=$_GET["data"];
		$hora=$_GET["hora"];
		$month=substr($data,3,2);
		$day=substr($data,0,2);
		$year=substr($data,6,4);
		$min=substr($hora,3,2);
		$hora=substr($hora,0,2);
		if (!$year){
			$year=substr(timestamp_para_humano(mktime()),6,4);
		}
		$data_fech=$_GET["atend"];
		$month2=substr($data_fech,3,2);
		$day2=substr($data_fech,0,2);
		$year2=substr($data_fech,6,4);
		if (!$year2){
			$year2=substr(timestamp_para_humano(mktime()),6,4);
		}
		if (!$data_fech){
			$atend=mktime();
			$atend_new=$atend;
		}else{			
			$atend=mktime(0,0,0,$month2,$day2,$year2);
			$atend_new=$data_fech;
		}
		if ((!$data) && (!$hora)){
			$prog=0;
		}else{			
			$prog=mktime($hora,$min,0,$month,$day,$year);
			$prog_new=$data." ".$hora.":".$min;
		}
		
		if ((!$inicio)&&($fim)){
			echo "<b><BR><font face=verdana size=2>Você deve entrar com o início do atendimento.<p>";
			echo "<input type=button value=Voltar onclick='history.back()'>";
			exit;
		}
		
		if (($fim_new<$inicio_old) && ($fim_new)){
			echo "<b><BR><font face=verdana size=2>O horário final de atendimento deve ser maior do que o inicial.<p>";
			echo "<input type=button value=Voltar onclick='history.back()'>";
			exit;
		}
			$tabela='chamados';
			$dados="prog=\"$prog\",hinicio=\"$inicio\",hfim=\"$hfim\",fechamento=\"$atend\"";
			$where="numero=\"$chamado\"";
			Conexao::atualiza2Bd($tabela,$dados,$where);
			
	if (($prog_new!=$prog_old) || ($inicio_old!=$inicio_new) || ($fim_old!=$fim_new)){
		echo "<font face=verdana size=2>Alterações realizadas com sucesso!<p>";
			
			
			$res=mysql_query("select hinicio,hfim from chamados where numero=$chamado");
			$hinicio=mysql_result($res,0,"hinicio");
			$hfim=mysql_result($res,0,"hfim");
			$horas=hora2(($hfim-$hinicio)/3600);
			if (!$horas)
				$horas=1;
			$atual=mysql_query("update pagamento set horas=$horas where numero=$chamado");
	}
	else
		echo "<font face=verdana size=2>Nenhuma alteração foi realizada.<p>";

	if ($_GET["source"]=="fim")
		echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"2;URL='det2.php?codigo=$codigo&act=upd&status=8&chamado=$chamado&username=$username&tipo=$tipo'\">";
	else
		echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"2;URL='det2.php?codigo=$codigo&chamado=$chamado&username=$username&tipo=$tipo'\">";
	}
}

// solucao
if ($qual=="solucao"){
	if ($ver<>"1"){
		$inicio=mktime(date("H"));
		echo "<body onload=\"document.inclui.solucao.focus()\">";
		echo "<table width=100% border=0>";
	//	echo "<tr><td bgcolor=silver align=center>DETALHE</td></table><p>";
		echo "<form name=\"inclui\" method=\"GET\" action=\"ed_cham2.php\">";
		echo "<table border=0>";
		echo "<tr><td align=right valign=top>Solução:</td><td colspan=2><TEXTAREA ROWS=13 COLS=60 NAME=solucao PLACEHOLDER=\"$solucao_old\"></TEXTAREA></td>";
		echo "<input type=hidden name=ver value=1>";
		echo "<input type=hidden name=chamado value='$chamado'>";
		echo "<input type=hidden name=inicio value='$inicio'>";
		//echo "<input type=hidden name=codigo value=4>";
		echo "<input type=hidden name=cod_usuario value=$cod_usuario>";
		echo "<input type=hidden name=status value='$status'>";
		echo "<input type=hidden name=agente value='$agente'>";
		echo "<input type=hidden name=descricao value='$descricao'>";
		echo "<input type=hidden name=solucao_old value='$solucao_old'>";
		echo "<input type=hidden name=obs value='$obs'>";
		echo "<input type=hidden name=prog value='$prog'>";
		echo "<input type=hidden name=username value='$username'>";
		echo "<input type=hidden name=tipo value='$tipo'>";
		echo "<input type=hidden name=obs_cli value='$obs_cli'>";
		echo "<input type=hidden name=qual value=solucao>";	
		//echo "<input type=hidden name=act value=$act>";	
////// direto pela solução /////		
		echo "<td valign=top><input type=submit value=\"    Alterar    \"><BR><input type=button value=\"   Cancelar  \" onclick=\"location.href='det2.php?codigo=$codigo&chamado=$chamado&agente=$nome_usuario&username=$username&tipo=$tipo'\"></td></tr>";
		echo "</table>";
	}else{
		if (("$solucao"<>"$solucao_old") && ($solucao)){
			$solucao_old=$resultado['solucao'];
			if(@$solucao_old){
				$atual=$solucao_old."<br>".$solucao;
			}else{
				$atual=$solucao;	
			}
			$tabela='chamados';
			$where="numero=\"$chamado\"";
			if($solucao_old){
				if($agente=="DEFINIR"){
					$dados="solucao=\"$atual\",status=\"$status\",agente=\"$username\",hinicio=\"$inicio\"";
				}else{
					$dados="status=\"$status\",solucao=\"$atual\"";
				}
					Conexao::atualiza2Bd($tabela,$dados,$where);
			}else{
				$tabela='chamados';
				$where="numero=\"$chamado\"";
				if($agente=="DEFINIR"){
					$dados="solucao=\"$atual\",status=\"$status\",agente=\"$username\",hinicio=\"$inicio\"";
				}else{
					$dados="status=\"$status\",solucao=\"$atual\"";
				}
					Conexao::atualiza2Bd($tabela,$dados,$where);
			}
			echo "Alteração realizada com sucesso!<p>";
			echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"1;URL='det2.php?codigo=$codigo&solucao=$solucao&chamado=$chamado&username=$username&tipo=$tipo'\">";
		}else{
			echo "Nenhuma alteração foi realizada.<p>";
			echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"1;URL='det2.php?codigo=$codigo&solucao=$solucao&chamado=$chamado&username=$username&tipo=$tipo'\">";
		}
	}
}
exit;
?>