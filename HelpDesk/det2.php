<meta charset='utf-8'>
<script>	
	function bntEnable(){		   
		if(document.getElementById("gravar").disabled==true){
			document.getElementById("gravar").disabled=false;
		};
	}
</script>
<?php
@$username=$_COOKIE['nome_usuario'];
include "valida_cookies.inc";
$usuario=Conexao::getUsuariosBd($username);
include "divfunc.php";
		date_default_timezone_set("Brazil/East");
if(isset($_COOKIE["nome_usuario"])){
	$nome_usuario = $_COOKIE["nome_usuario"];
}

echo "<div class='bntVoltar'><img height=20 src='imagem/voltar.png' onMouseOver=\"height=25\" onMouseOut=\"height=20\" onclick=\"location.href='tabela2.php?username=$username&tipo=$tipo'\"></div>";

$cod_usuario=$usuario['cod_usuario'];
$tipo=$usuario["tipo"];
$nome=$usuario['nome'];

@$codigo=$_GET["codigo"];
@$sla=$_GET["sla"];
@$chamado=$_POST['chamado'];
if(!$chamado){
	@$chamado=$_GET['chamado'];
}
@$obs_cli=$_POST['obs_cli'];
if(!$obs_cli){
	@$obs_cli=$_GET['obs_cli'];
}
@$act=$_POST["act"];
if(!$act){
	@$act=$_GET['act'];
}
@$status=$_POST["status"];
if(!$status){
	@$status=$_GET['status'];
}
@$deonde=$_GET["deonde"];
@$tipo=$_GET["tipo"];
@$escolha=$_GET["escolha"];
@$cliente=$_POST["cliente"];
if(!$cliente){
	@$cliente=$_GET['cliente'];
}
@$data1=$_GET["data1"];
@$data2=$_GET["data2"];
if ($act=="fecha"){
	$tabela='chamados';
	$where="status=4 and clientes=\"$username\"";
	$resultado=Conexao::consultaChamado2($tabela,$where);
	if(@!$resultado){
			echo "<br><br>";
			echo "<table align=center><form>";
			echo "<tr><td>Não existem solicitações de fechamento de chamados.</td></tr>";
			echo "<tr><td><input type=\"button\" value=\"Voltar\" onclick=history.back()></td></tr>";
			echo "</form></table>";
			exit;				
	}
		foreach($resultado as $key => $item);
		$chamado=$item['numero'];
}

if ($act=="upd"){
	//@$cliente=$_GET['cliente'];
if(!isset($chamado) && !isset($obs_cli)){
	$tabela='chamados';
	$where="status=4 and clientes=\"$cliente\"";
	$resultado=Conexao::consultaChamado2($tabela,$where);
	if(@!$resultado){exit;
			echo "<br><br>";
			echo "<table align=center><form>";
			echo "<tr><td>Não existem solicitações de fechamento de chamados.</td></tr>";
			echo "<tr><td><input type=\"button\" value=\"Voltar\" onclick=history.back()></td></tr>";
			echo "</form></table>";
			exit;				
	}
}
	if ($status==5){
		$fechamento=mktime(date("H"));
		$tabela='chamados';
		$dados="status=$status,fechamento=$fechamento";
		$atualiza=Conexao::atualizaChamado($tabela,$dados,$chamado);
		echo "<table border=0 width=100% height=80%><td align=center valign=center>";
		echo "<font size=3 face=verdana><b>Alterando...";
		
// loop para fechar todas as solicitações de fechamento de chamado
	$tabela='chamados';
	$where="status=4 and clientes=\"$username\"";
	$resultado=Conexao::consultaChamado3($tabela,$where);
		$linhas=Conexao::linhas2Bd($tabela,$where);
		if($linhas>0){
			$statusBd=$resultado['status'];
			$chamado2=$resultado['numero'];
				echo "<script>
						var texto1=\"Ainda existe(em) \";
						var linhas=$linhas;
						var texto2=\" solicitação(ões) para fechamento. Deseja ver?\";				
						var resposta=confirm(texto1+linhas+texto2)</script>";
				echo "<script>if (resposta){
								window.location=\"det2.php?cod_usuario=$cod_usuario&cliente=$cliente&chamado=$chamado2&data1=$data1&data2=$data2&escolha=$escolha&tipo=$tipo&deonde=$deonde&username=$username&tipo=$tipo\";
					 }</script>";
		}
// Fim do loop

		echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"1;URL=det2.php?cod_usuario=$cod_usuario&cliente=$cliente&chamado=$chamado&data1=$data1&data2=$data2&escolha=$escolha&tipo=$tipo&deonde=$deonde&username=$username\">";
		exit;
	}elseif($status=='A'){
			echo "<br><br><form action='det2.php' method=POST>";
			echo "<div align='center'>";
			echo "Escreva o motivo de reabrir este chamado<br>";
			echo "<textarea cols=80 rows=10 name=obs_cli ></textarea><br>";
			echo "<input type=hidden name=act value=upd>";
			echo "<input type=hidden name=cliente value=$cliente>";
			echo "<input type=hidden name=chamado value=$chamado>";
			echo "<input type=hidden name=username value=$username>";
			echo "<input type=hidden name=tipo value=$tipo>";
			echo "<select name=status onchange=\"submit()\">";
			echo "<option value='ok'>Altere aqui para confirmar</option>";
			echo "<option value='ok'>Confirmar</option>";
			echo "</select></td>";
			echo "</form>";
			echo "</div>";
			exit;

	}elseif($status=='ok'){
		if (!$obs_cli && $status<>4){
			echo "<br><br>";
			echo "<table align=center><form>";
			echo "<tr><td>Você não inseriu o motivo de manter o chamado aberto.</td></tr>";
			echo "<tr><td><input type=\"button\" value=\"Voltar\" onclick=history.back()></td></tr>";
			echo "</form></table>";
			exit;
		}
	$resultado=Conexao::consultaChamado($chamado);
	$obs_cli_old=$resultado['obs_cli'];
		if(!$obs_cli_old){
			$obs_cli="Manter aberto porque: $obs_cli";
		}else{
			$obs_cli="$obs_cli_old<br>Manter aberto porque: $obs_cli";
		}
	$dados="`status`='A',`obs_cli`='$obs_cli'";
	$tabela="chamados";
	$atualiza=Conexao::atualizaChamado($tabela,$dados,$chamado);
		echo "<table border=0 width=100% height=80%><td align=center valign=center>";
		echo "<font size=3 face=verdana><b>Alterando...<br>";
		
// loop para fechar todas as solicitações de fechamento de chamado
		$tabela="chamados";
		$where="status=4 and clientes=\"$username\"";
		$linhas=Conexao::linhas2Bd($tabela,$where);
		$resultado=Conexao::consultaChamado3($tabela,$where);
		if($linhas>0){
			$statusBd=$resultado['status'];
			$chamado2=$resultado['numero'];
				echo "<script>
						var texto1=\"Ainda existe(em) \";
						var linhas=$linhas;
						var texto2=\" solicitação(ões) para fechamento. Deseja ver?\";				
						var resposta=confirm(texto1+linhas+texto2)</script>";
				echo "<script>if (resposta){
								window.location=\"det2.php?cod_usuario=$cod_usuario&cliente=$cliente&chamado=$chamado2&data1=$data1&data2=$data2&escolha=$escolha&tipo=$tipo&deonde=$deonde&username=$username&tipo=$tipo\";
							}</script>";
		}
// Fim
			echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"1;URL=det2.php?cod_usuario=$cod_usuario&cliente=$cliente&chamado=$chamado&data1=$data1&data2=$data2&escolha=$escolha&tipo=$tipo&deonde=$deonde&username=$username\">";
		exit;
	}else{
		$resultado=Conexao::consultaChamado($chamado);
		$solucao=$_GET['solucao'];
		$prog=$resultado['prog'];
		$agente=$resultado['agente'];
		$descricao=$resultado['descricao'];
		$obs=$resultado['obs'];
		$obs_cli=$resultado['obs_cli'];
		$solucao=$resultado['solucao'];
			if(@!$agente){
				$agente='DEFINIR';				
			}			
	
///////////// Solicitar uma solução ///////////		
		if(!$solucao){
			@$solucao=$_POST['solucao'];	
				if(!$solucao){
					echo "<script>var answer=confirm('Não foi dada a entrada de uma solução para este chamado.  Deseja entrar com a solução agora?')</script>";
					echo @"<script>if (answer){
								{window.location='ed_cham2.php?cod_usuario=$cod_usuario&qual=solucao&chamado=$chamado&prog=$prog&agente=$agente&descricao=$descricao&obs=$obs&obs_cli=$obs_cli&solucao=$solucao&status=$status&username=$username&tipo=$tipo'};
								}else{{window.location='det2.php?cod_usuario=$cod_usuario&chamado=$chamado&username=$username&tipo=$tipo'};
								}";
					echo	 "	</script>";
					exit;
				}	
		}

///////////// Fim Solicitar uma solução ///////////

		$tabela="chamados";
		$dados="solucao=\"$solucao\",status=\"$status\"";
		
		$gravanco=Conexao::atualizaChamado($tabela,$dados,$chamado);;
		
		echo "<table width=100% height=80% border=0>";
		echo "<tr height=100%>";
		echo "<td width=100% colspan=3 valign=center align=center>";
		echo "<table border=1 bgcolor=#FFFFFF CELLSPACING=3 CELLPADDING=13><tr><td>";
		echo "<center><br><b><font face=tahoma size=2 color=black>Alterando...<p>";
			echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"1;URL=det2.php?cod_usuario=$cod_usuario&cliente=$cliente&chamado=$chamado&data1=$data1&data2=$data2&escolha=$escolha&tipo=$tipo&deonde=$deonde&status=$status&username=$username\">";
		echo "</td></tr></table>";
		exit;
/*			
///////////// prazo para atendimento conferir ///////////	
		if($prog==0){	
					echo "<script>var answer=confirm('Não foi dada um prazo para atendimento deste chamado.  Deseja fazê-lo agora?')</script>";
					echo @"<script>if (answer){
								{window.location='ed_cham2.php?chamado=$chamado&cod_usuario=$cod_usuario&source=fim&qual=prog&act=upd&status=$status&agente=$agente&descricao=$descricao&obs=$obs&obs_cli=$obs_cli&solucao=$solucao&prog=$prog&tipo=$tipo&username=$username'};
								}else{{window.location='det2.php?cod_usuario=$cod_usuario&chamado=$chamado&status=$status&username=$username&tipo=$tipo'};
								}";
					echo	 "	</script>";
			exit;
			
			
			echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"1;URL=det2.php?cod_usuario=$cod_usuario&cliente=$cliente&chamado=$chamado&data1=$data1&data2=$data2&escolha=$escolha&tipo=$tipo&deonde=$deonde&status=$status&username=$username\">";
			exit;
		}

		@$achasol=mysql_query("select solucao,hinicio,hfim from chamados where numero=$chamado");
		if ($achasol){
			$solucao=mysql_result($achasol,0,"solucao");
			$hinicio=mysql_result($achasol,0,"hinicio");
			$hfim=mysql_result($achasol,0,"hfim");				
		}
		if(!$hinicio){
			@$hinicio=$_GET["hinicio"];
		}
		if(!$hfim){
			@$hfim=$_GET["hfim"];
		}	
		if((!$hinicio)||(!$hfim)){
			echo "<script>var answer=confirm('Não foi dada a entrada da hora de início ou fim para este chamado.  Deseja fazê-lo agora?');";
			echo "if (answer)";
			echo "{window.location='ed_cham2.php?cod_usuario=$cod_usuario&source=fim&qual=prog&act=upd&status=8&agente=$agente&descricao=$descricao&obs=$obs&obs_cli=$obs_cli&solucao=$solucao&prog=$prog&chamado=$chamado&username=$username&tipo=$tipo'};";
			echo "else{window.location='det2.php?cod_usuario=$cod_usuario&chamado=$chamado&usuario=$usuario&tipo=$tipo'};";
			echo "</script>";
			exit;
		}	
*/
/////////////////// Fim de prazo de atendimento ///////////////		
	}	
}
$resultado=Conexao::consultaChamado($chamado);
$clienteBd=$resultado['clientes'];
$resultado2=Conexao::usuariosBd($clienteBd);
@$nome_clienteBd=$resultado2["nome"];
@$login=$resultado2['username'];
	if(!isset($nome_clienteBd)){
		$nome_clienteBd=maiusculo("Cliente foi excluído");
	}
if (!$resultado){
	
	$tabela='chamados';
	if(isset($chamado)){
		$campo="numero=$chamado";
	}else{
		$campo=1;	
	}
	$linhas=Conexao::linhas2Bd($tabela,$campo);	
	if (!$linhas){
		echo "<table border=0 width=100% height=80%><td align=center valign=center>";
		echo "Chamado Nº <b> $chamado<p>";
		echo "Este chamado foi excluído do sistema.";
		echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"2;URL=tabela2.php?username=$username&tipo=$tipo\">";
		exit;
	}	
}
$solucao=$resultado["solucao"];
if (!$solucao){
	$solucao=null;
}
$agente=$resultado["agente"];

$statusBd=$resultado["status"];

$descricao=nl2br($resultado["descricao"]);

if (!$descricao){
	$descricao='Sem descrição do problema.';
}

$cod_usuario=$resultado2["cod_usuario"];
$dados_agente=Conexao::usuariosBd($username);
$cod_agente=$dados_agente['cod_usuario'];
@$obs=nl2br($resultado["obs"]);

if (!$obs){
	$obs=null;
}
$obs_cli=nl2br($resultado["obs_cli"]);

if (!$obs_cli){
	$obs_cli=null;
}

$sla=$resultado["sla"];

if (!$sla){
	$sla=null;
}

@$prog=$resultado["prog"];

if (!$prog){
	$nome_prog="Não Agendado";
}else{
	$nome_prog="Agendado para: ".timestamp_para_humano($prog);
}

$abertura=date("d/m/Y à\s H:i",$resultado["abertura"]);
$abre=timestamp_para_humano($abertura);
@$fechamento=$resultado["fechamento"];

if ($fechamento){
       //$fecha=substr(timestamp_para_humano($fechamento),0,10);
      $fecha=date("d/m/Y à\s H:i",$fechamento);
}
$nome_status=statusChamado($statusBd);
if (!$solucao){
	$solucao=null;
}
if (!$obs){
	$obs=null;
}
if(!$chamado){
	$chamado=($resultado['numero']);
}

echo "<form name=form5 action=det2.php?chamado=$chamado method=GET>";
echo "<table bgcolor=silver border=1 bordercolor=silver width=100% cellpadding=2 cellspacing=3>";
echo "<tr><td bgcolor=#DEDFDE align=center colspan=2>";
echo "<font face=verdana size=2><b>CHAMADO DE No $chamado&nbsp&nbsp&nbsp-&nbsp&nbsp&nbspSLA: $sla </td></tr>";
echo "<tr height=350 bgcolor=white><td width=50% valign=top height=100%>";
echo "<table border=1 bordercolor=WHITE width=100% cellspacing=3 cellpadding=2>";
echo "<tr><td bgcolor=#DEDFDE valign=MIDDLE COLSPAN=4 align=CENTER><font size=2 face=VERDANA COLOR=RED><B>DADOS DO CLIENTE</td>";
echo "<tr><td valign=MIDDLE width=10% align=right><font size=1 face=tahoma>CLIENTE:</td><td valign=top COLSPAN=3><font size=2 face=verdana color=blue>$nome_clienteBd</td></tr>";
echo "</tr></table>";
echo "</td>";
echo "<td valign=top align=right width=50%>";
echo "<table border=1 bordercolor=white bgcolor=white width=100% cellspacing=3 cellpadding=2>";
echo "<tr><td bgcolor=#DEDFDE valign=MIDDLE COLSPAN=2 align=CENTER><font size=2 face=VERDANA COLOR=RED><B>DADOS DO CHAMADO</td>";
echo "<tr><td width=25% valign=MIDDLE align=right><font size=1 face=tahoma>ABERTURA:</td><td valign=top width=50%><font size=2 face=verdana color=blue>$abertura</td></tr>";
if ($fechamento<>0){
	echo "<tr><td width=25% valign=MIDDLE align=right><font size=1 face=tahoma>ENCERRAMENTO:</td><td valign=top><font size=2 face=verdana color=blue>$fecha</td></tr>";
}
echo "<tr><td valign=MIDDLE align=right><font size=1 face=tahoma>LOGIN:</td><td valign=top align=left";
echo "><font size=2 face=verdana color=blue>$login</td></tr>";
echo "<tr><td valign=MIDDLE align=right><font size=1 face=tahoma>TÉCNICO:</td><td valign=top";
echo "><font size=2 face=verdana color=blue>$agente</td></tr>";
echo "<tr><td valign=middle align=right><font size=1 face=tahoma>STATUS:</td><td valign=top align=left><font size=2 face=verdana color=blue>";
		$nome_status=statusChamado($statusBd);
if (($statusBd==4) && ($cod_agente<>4)){
	if($nome_clienteBd==$nome){
		//$chamado=$_GET['chamado'];
			echo "<input type=hidden name=solucao value='$solucao'>";
			echo "<input type=hidden name=act value=upd>";
			echo "<input type=hidden name=sla value=$sla>";
			echo "<input type=hidden name=escolha value=$escolha>";
			echo "<input type=hidden name=cliente value=$cliente>";
			echo "<input type=hidden name=cod_usuario value=$cod_usuario>";
			echo "<input type=hidden name=chamado value=$chamado>";
			echo "<input type=hidden name=username value=$username>";
			echo "<input type=hidden name=tipo value=$tipo>";
			echo "<input type=hidden name=data1 value=$data1>";
			echo "<input type=hidden name=data2 value=$data2>";
			echo "<select name=status onchange=\"bntEnable()\">";
			echo "<option value=''>$nome_status</option>";
			echo "<option value=5>FECHADO</option>";
			echo "<option value='A'>MANTER ABERTO</option>";
			echo "</select>&nbsp&nbsp";
				echo "<button id=\"gravar\" type=\"submit\" disabled=\"disabled\" >Salvar</button></td>";
	}else{
			echo "<input type=hidden name=solucao value='$solucao'>";
			echo "<input type=hidden name=act value=upd>";
			echo "<input type=hidden name=sla value=$sla>";
			echo "<input type=hidden name=escolha value=$escolha>";
			echo "<input type=hidden name=cliente value=$cliente>";
			echo "<input type=hidden name=cod_usuario value=$cod_usuario>";
			echo "<input type=hidden name=chamado value=$chamado>";
			echo "<input type=hidden name=username value=$username>";
			echo "<input type=hidden name=tipo value=$tipo>";
			echo "<input type=hidden name=data1 value=$data1>";
			echo "<input type=hidden name=data2 value=$data2>";
			echo "$nome_status</td>";
	}
}elseif(($statusBd<>5)&&($cod_agente==4)){
		if(($statusBd==4)&&("$nome_clienteBd"=="$nome")){		
			echo "<input type=hidden name=solucao value='$solucao'>";
			echo "<input type=hidden name=act value=upd>";
			echo "<input type=hidden name=sla value=$sla>";
			echo "<input type=hidden name=escolha value=$escolha>";
			echo "<input type=hidden name=cliente value=$cliente>";
			echo "<input type=hidden name=cod_usuario value=$cod_usuario>";
			echo "<input type=hidden name=chamado value=$chamado>";
			echo "<input type=hidden name=username value=$username>";
			echo "<input type=hidden name=tipo value=$tipo>";
			echo "<input type=hidden name=data1 value=$data1>";
			echo "<input type=hidden name=data2 value=$data2>";
			echo "<select name=status onchange=\"bntEnable()\">";
			echo "<option value=''>$nome_status</option>";
			echo "<option value=5>FECHADO</option>";
			echo "<option value='A'>MANTER ABERTO</option>";
			echo "</select>&nbsp&nbsp";
				echo "<button id=\"gravar\" type=\"submit\" disabled=\"disabled\" >Salvar</button></td>";
		}else{
			echo "<input type=hidden name=solucao value='$solucao'>";
			echo "<input type=hidden name=act value=upd>";
			echo "<input type=hidden name=sla value=$sla>";
			echo "<input type=hidden name=escolha value=$escolha>";
			echo "<input type=hidden name=cliente value=$cliente>";
			echo "<input type=hidden name=cod_usuario value=$cod_usuario>";
			echo "<input type=hidden name=chamado value=$chamado>";
			echo "<input type=hidden name=username value=$username>";
			echo "<input type=hidden name=tipo value=$tipo>";
			echo "<input type=hidden name=data1 value=$data1>";
			echo "<input type=hidden name=data2 value=$data2>";
			echo "<select name=status onchange=bntEnable()>";
				if($statusBd=='A'){
					$st=0;
				}else{
					$st=$statusBd;	
				}
			switch($st){
				case 0:
					echo "<option value=''>$nome_status</option>";
					echo "<option value=2>PENDÊNCIA GERAL</option>";
					echo "<option value=3>PENDÊNCIA TÉCNICA</option>";
					echo "<option value=4>SOLICITAR FECHAMENTO</option>";
					break;
				case 1:
					echo "<option value=''>$nome_status</option>";
					echo "<option value=2>PENDÊNCIA GERAL</option>";
					echo "<option value=3>PENDÊNCIA TÉCNICA</option>";
					echo "<option value=4>SOLICITAR FECHAMENTO</option>";
					break;
				case 2:
					echo "<option value=''>$nome_status</option>";
					echo "<option value=3>PENDÊNCIA TÉCNICA</option>";
					echo "<option value=4>SOLICITAR FECHAMENTO</option>";
					break;
				case 3:
					echo "<option value=''>$nome_status</option>";
					echo "<option value=2>PENDÊNCIA GERAL</option>";
					echo "<option value=4>SOLICITAR FECHAMENTO</option>";
					break;
				default:
					echo "<option value=''>$nome_status</option>";
					break;
			}	
				echo "</select>&nbsp&nbsp";
				echo "<button id=\"gravar\" type=\"submit\" disabled=\"disabled\" >Salvar</button></td>";
		}
}else{
		echo statusChamado($statusBd);
}
	
echo "</td></tr></table>";
echo "</form>";
echo "</td></tr>";
echo "<tr><td bgcolor=white colspan=2><table border=0 bgcolor=white cellpadding=2 cellspacing=3 width=100%>";
echo "<tr><td bgcolor=#DEDFDE valign=MIDDLE COLSPAN=2 align=CENTER><font size=2 face=VERDANA COLOR=RED><B>DETALHES DO ATENDIMENTO</td>";
echo "<tr><td colspan=2><hr color=#DEDFDE></td></tr>";
echo "<tr><td WIDTH=15% valign=middle align=right><font size=1 face=tahoma>SOLICITAÇÃO/DEFEITO:</td><td valign=top";
echo "><font size=2 face=verdana color=blue>$descricao</td></tr>";
echo "<tr><td colspan=2><hr color=#DEDFDE></td></tr>";
echo "<tr><td valign=middle align=right><font size=1 face=tahoma>SOLUÇÃO:</td><td valign=top";	
if (($statusBd<>5)&&($cod_agente==4)){	
	echo "align=left onmouseover=\"this.style.backgroundColor='yellow';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: white\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"link('ed_cham2.php?qual=solucao&chamado=$chamado&agente=$agente&status=$statusBd&username=$username&tipo=$tipo')\"";
}
echo "><font size=2 face=verdana color=blue>$solucao</td></tr>";
echo "<tr><td colspan=2><hr color=#DEDFDE></td></tr>";
echo "<tr><td valign=middle align=right><font size=1 face=tahoma>OBSERVAÇÕES CLIENTE:</td><td valign=top";
if (($cod_agente<4) && ($statusBd<>5)){
	if($cod_agente==1 && $nome_clienteBd==$nome){
		echo " align=left onmouseover=\"this.style.backgroundColor='yellow';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: white\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"link('ed_cham2.php?cod_usuario=$cod_usuario&qual=obs_cli&chamado=$chamado&agente=$agente&descricao=$descricao&obs=$obs&obs_cli=$obs_cli&solucao=$solucao&prog=$prog&status=$status&username=$username&tipo=$tipo')\"";
		}elseif($cod_agente>1){
			echo " align=left onmouseover=\"this.style.backgroundColor='yellow';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: white\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"link('ed_cham2.php?cod_usuario=$cod_usuario&qual=obs_cli&chamado=$chamado&agente=$agente&descricao=$descricao&obs=$obs&obs_cli=$obs_cli&solucao=$solucao&prog=$prog&status=$status&username=$username&tipo=$tipo')\"";			
		}
}elseif((@$nome=="$nome_clienteBd")&&($statusBd<>5)){
	echo " align=left onmouseover=\"this.style.backgroundColor='yellow';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: white\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"link('ed_cham2.php?cod_usuario=$cod_usuario&qual=obs_cli&chamado=$chamado&agente=$agente&descricao=$descricao&obs=$obs&obs_cli=$obs_cli&solucao=$solucao&prog=$prog&status=$status&username=$username&tipo=$tipo')\"";	
}
echo "><font size=2 face=verdana color=blue>$obs_cli</td></tr>";
echo "<tr><td colspan=2><hr color=#DEDFDE></td></tr>";
echo "<tr><td valign=middle align=right><font size=1 face=tahoma>OBSERVAÇÕES TÉCNICAS:</td><td valign=top";
if (($cod_agente==4)&&($statusBd<>5)){
	echo " align=left onmouseover=\"this.style.backgroundColor='yellow';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: white\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"link('ed_cham2.php?qual=obs&chamado=$chamado&agente=$agente&prog=$prog&status=$status&username=$username&tipo=$tipo')\"";
}
echo "><font size=2 face=verdana color=blue>$obs</td></tr>";
echo "<tr><td colspan=2><hr color=#DEDFDE></td></tr>";
echo "<tr><td valign=middle align=right><font size=1 face=tahoma>ATENDIMENTO:</td><td valign=top";
echo "><font size=2 face=verdana color=blue>$nome_prog";
if(!isset($hinicio)) {
	$hinicio='';
}
if(!isset($hfim)) {
	$hfim='';
}
if (($hinicio) && ($hfim)){
	echo " - Atendido em: $fecha, Início: ".substr($inicio,11,5).", Fim: ".substr($fim,11,5);
}

echo "</td></tr>";
echo "<tr><td colspan=2><hr color=#DEDFDE></td></tr>";
echo "</table>";
echo "</td></tr>";
echo "<tr><td bgcolor=white colspan=2 align=center valign=center>";
echo "</td></tr></table>";
echo "</td></tr>";
echo "<tr><td bgcolor=white colspan=2 align=center valign=center>";
echo "</td></tr>";
echo "<tr><td colspan=2 align=center valign=center>";
echo "<div align=center><table><td>"; 
	echo "<input type=button value=\"Voltar para Controle\" onclick=\"location.href='tabela2.php?username=$username&tipo=$tipo'\">";
	echo"<input type=button value=\"Gerar Relatório\" onclick=\"printLink('gera.php?cod_usuario=$cod_usuario&chamado=$chamado&status=$statusBd&username=$username&tipo=$tipo','_blank')\">";
echo "</td></tr>";
echo "<tr><td colspan=3><table width=100% bgcolor=#DEDFDE border=0><tr><td><font size=1 face=verdana color=red><center><b>TECNOLOGIA DA INFORMAÇÃO</td></tr></table>";
echo "</table>";
echo "</form>";
exit;
?>