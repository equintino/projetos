<?php	
@$username=$_COOKIE['nome_usuario'];
include "valida_cookies.inc";
include "construct.php";
include "divfunc.php";
		date_default_timezone_set("Brazil/East");
if(isset($_COOKIE["nome_usuario"])){
	$login = $_COOKIE["nome_usuario"];
}
@$act=$_POST["act"];
if(!$act){
	@$act=$_GET['act'];
}
@$novaact=$_POST['novaact'];
if(!$novaact){
	@$novaact=$_GET["novaact"];
}
@$novagrava=$_POST['novagrava'];
if(!$novagrava){
	@$novagrava=$_GET["novagrava"];
}
@$cod_usuario=$_POST['cod_usuario'];
if(!$cod_usuario){
	@$cod_usuario=$_GET["cod_usuario"];
}
@$cadok=$_POST['cadok'];
if(!$cadok){
	@$cadok=$_GET["cadok"];
}
@$teste=$_POST['testa'];  
if(!@$testa){
	@$testa=$_GET["testa"];
}
@$ver=$_POST['ver'];
if(!$ver){
	@$ver=$_GET["ver"];
}
@$nome=maiusculo($_POST["nome"]);
if(!$nome){
	@$nome=maiusculo($_GET["nome"]);
}
@$grava=$_POST["grava"];
if(!$grava){
	@$grava=$_GET["grava"];
}
@$contador=$_POST["contador"];
if(!$contador){
	@$contador=$_GET["contador"];
}
@$chamado=$_POST['chamado'];
if(!$chamado){
	@$chamado=$_GET['chamado'];
}
@$cliente=$_POST['cliente'];
if(!$cliente){
	@$cliente=$_GET['cliente'];
}
@$obs=$_POST['obs'];
if(!$obs){
	@$obs=$_GET['obs'];
}
@$obs_cli=$_POST['obs_cli'];
if(!$obs_cli){
	@$obs_cli=$_GET['obs_cli'];
}
@$hoje=Dataatual();
if ($testa){
	$act="exc";
}
@$descricao=$_GET['descricao'];
if(!$descricao){
	@$descricao=$_POST['descricao'];	
}

$cod_usuario=$usuario['cod_usuario'];
//$email=$usuario["email"];
$departamento=$usuario['departamento'];

if ($act=='cham'){
	echo "<table width=100%><tr><td align=right><font color=#008080><B>PESQUISA DE CHAMADOS<br><hr width=50%></td></tr></table>";
			echo "<body onLoad=\"document.escolha.nome.focus()\" >";
			echo "<form name=\"escolha\" method=\"POST\" action=\"clientes.php\">";
			echo "<table border=0><tr>";
			echo "<td valign=middle><font color=black size=2 face=verdana><b>No. do Chamado:</b> </td>";
			echo "<td valign=center><input type=\"text\" name=\"chamado\" size=20>";
			echo "<input type='hidden' name='login' value='$login'>";
			echo "<input type='hidden' name='username' value='$username'>";
			echo "<input type='hidden' name='descrcao' value='$descricao'>";
			echo "<input type='hidden' name='tipo' value='$tipo'>";			
			echo "<input type=\"hidden\" name=\"ver\" value=\"on\">";
			echo "<input type=\"hidden\" name=\"act\" value=\"edita\">";
			echo "</td><td><center><input type=\"submit\" value=\"Procurar >>\"><BR><font size=2 face=verdana></td>";
			echo "</tr>";
			echo "<tr><td colspan=3>(em branco para lista de chamados)</td></tr>";
			echo "</table>";
			exit;
}
if ($act=="altera"){
	echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"1;URL=clientes.php?act=edita&cod_usuario=$cod_usuario&chamado=$chamado&username=$username&tipo=$tipo\">";
	echo "<center><table width=100% border=0>";
	echo "<tr><td align=right><b><font color=#008080>CONSULTA DE CHAMADOS<br><hr width=50%></td></tr>";
	echo "<tr><td><font face=verdana size=2 color=black><b>Aguarde...<p>";
	echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"1;URL=clientes.php?act=edita&cod_usuario=$cod_usuario&chamado=$chamado&username=$username&tipo=$tipo\">";
}
if ($act=="cad"){
	$tabela="chamados";
	$where="status=4 and clientes=\"$username\"";
	$linha=Conexao::linhas2Bd($tabela,$where);
	if($linha!=0){
		echo "<script>alert('Existem ",$linha," solicitações para fechamento de chamado(s)')</script>";		
	}
	$cliente=$usuario['username'];
	$email=$usuario['email'];
	$cod_cli=$usuario['cod_usuario'];
	$departamento=$usuario['departamento'];
	@$cad_obs=$_GET["cad_obs"];
	if(!$cad_obs){
		@$cad_obs=$_POST['cad_obs'];
	}
	@$tempo=$_GET['tempo'];
	if(!$tempo){
		@$tempo=$_POST['tempo'];
	}
	@$severidade=$_GET['severidade'];
	if(!$severidade){
		@$severidade=$_POST['severidade'];
	}
	@$operacao=$_POST["operacao"];
	if(!$operacao){
		@$operacao=$_GET["operacao"];
	}
	if (($operacao!="grava")&&(!$novaact)){	
		$hoje=Dataatual();
		$hora=Horaatual();
		if (!$cliente){
			echo "<body onLoad=\"document.cliente.pessoa.focus()\" onContextMenu=\"return false\" onKeyDown=\"if (window.event.keyCode==13) window.event.keyCode=9;\">";
		}else{
			echo "<body onLoad=\"document.cliente2.descricao.focus()\" onContextMenu=\"return false\" onKeyDown=\"if (window.event.keyCode==13) window.event.keyCode=9;\">";
		}
		echo "<table width=100%><tr><td align=right><font color=#008080><B>ABERTURA DE CHAMADOS<br><hr width=50%></td></tr></table>";	
		echo "<form name=\"cliente2\" method=\"POST\" action=\"clientes.php\">";
		echo "<TABLE BORDER=0><TR><TD align=left WIDTH=200><font face=verdana size=2 color=black><B>Data:  <font color=blue>$hoje</TD><TD align=left WIDTH=200><font face=verdana size=2 color=black><B>Hora:  <font color=blue>$hora</TD>";
		echo "<td valign=middle><font face=verdana size=2 color=black><b>SLA:</td>";
		$nivelSla=sla($tempo,$severidade);
		if($tempo==''){
			echo "<td><a href='avaliaSla.php?tipo=$tipo&username=$username'>Classifique aqui a (SLA)</a></td>";
		}else{
			echo "<td><b>",$nivelSla,"</b></td>";
		}
		echo "</tr></table>";
		echo "<input type=hidden name=sla value='$nivelSla'>";
		echo "<input type=hidden name=nome value=$nome>";
		echo "<input type=hidden name=departamento value=$departamento>";
		echo "<input type=hidden name=status value=1>";
		echo "<input type=hidden name=agente value='definir'>";
		echo "<input type=hidden name=email value=$email>";
		echo "<input type=hidden name=username value=$username>";
		echo "<input type=hidden name=abertura value=",mktime(date("H")),">";
		echo "<br>";
		echo "<table><tr><td>";
		echo "Descreva aqui o seu chamado: <input  size='74' name=descricao>";
		echo "</td></tr>";
		echo "<tr><td>Observações(opcional): <input  size='80' name=obs_cli>";
		echo "</td></tr>";

		echo "<INPUT TYPE=\"HIDDEN\" NAME=\"cod_cli\" VALUE=$cod_cli>";
		echo "<INPUT TYPE=\"HIDDEN\" NAME=\"operacao\" VALUE=\"grava\">";	
		echo "<INPUT TYPE=\"HIDDEN\" NAME=\"act\" VALUE=\"cad\">";	
		echo "<input type=hidden name=username value=$username>";
		echo "<input type=hidden name=tipo value=$tipo>";		
		echo "<tr><td>&nbsp</td></tr>";
		echo"<tr><td><input tabindex=\"23\" type=\"submit\" value=\"Continuar >>\" onKeyDown=\"if (window.event.keyCode==13) cliente.submit();\"></td>";
		echo "</form></tr></table>";
		exit;
	}
	
//para gravar
	if ($operacao=="grava"){
		@$agente=maiusculo($_GET["agente"]);
		if(@!$agente){
			@$agente=maiusculo($_POST["agente"]);	
		}
		@$cod_cli=$_GET["cod_cli"];
		if(!$cod_cli){
			@$cod_cli=$_POST["cod_cli"];	
		}
		@$departamento=maiusculo($_GET["departamento"]);
		if(!$departamento){
			@$departamento=maiusculo($_POST["departamento"]);	
		}
		@$email=minusculo($_GET["email"]);
		if(!$email){
			@$email=minusculo($_POST["email"]);	
		}
		@$abertura=$_GET["abertura"];
		if(!$abertura){
			@$abertura=$_POST["abertura"];	
		}
	//@$cliente=maiusculo($_GET["cliente"]);
		@$sla=$_GET["sla"];
		if(!$sla){
			@$sla=$_POST["sla"];	
		}
		@$status=$_GET["status"];
		if(!$status){
			@$status=$_POST["status"];	
		}
		@$cad=$_GET["cad"];
		if(!$cad){
			@$cad=$_POST["cad"];	
		}
		@$aviso=$_GET['aviso'];
		if(!$aviso){
			@$aviso=$_POST['aviso'];	
		}
		@$descricao=$_GET['descricao'];
		if(!$descricao){
			@$descricao=$_POST['descricao'];	
		}
		@$fechamento=$_GET['fechamento'];
		if(!$fechamento){
			@$fechamento=$_POST['fechamento'];	
		}
		@$acoes=$_GET['acoes'];
		if(!$acoes){
			@$acoes=$_POST['acoes'];	
		}
		if ($cad){
			$month1=substr($cad,3,2);
			$day1=substr($cad,0,2);
			$year1=substr($cad,6,4);
			//$hoje=mktime(0,0,0,"$month1","$day1","$year1");
		}else{
			$hoje=mktime(date("H"));
		}

		if (!$status){
			$status=1;
		}
		if (isset($obs)){
			$obs="";
		}
		if (!$sla){
			$sla='Nível 6';
		}
			echo "<center><table width=100% border=0>";
			echo "<tr><td align=right><b><font color=#008080>ABERTURA DE CHAMADO<br><hr width=50%></td></tr>";
			echo "<tr><td>&nbsp</td></tr></table></center>";
			echo "<table border=0 width=100%><tr><td>";
		if ($descricao==""){
			echo "<b>Erro:</b>  Você não identificou nenhum problema.</td></tr>";
			echo "<tr><td><input type=\"button\" value=\"Voltar\" onclick=history.back()></td>";
			exit;
		}
		echo "<table width=100% height=80% border=0>";
		echo "<center><br><b><font face=tahoma size=2 color=black>Aguarde...<p>";
		echo "</td></tr></table>";
		echo "</html></body>";
			$senha=sha1(md5("SUPORTE"));
			//$abertura=Dataatual();
			//$agente=$nome_usuario;
			@$obs_cli=$_POST['obs_cli'];
			if(!@$obs_cli){
				@$obs_cli=$_GET['obs_cli'];	
			}
			@$cliente=$_POST['username'];
			if(!@$cliente){
				@$cliente=$_GET['username'];	
			}
			@$cod_cli=$_POST['cod_cli'];
			if(!@$cod_cli){
				@$cod_cli=$_GET['cod_cli'];	
			}
///preparar a SLA
			if(!@$obs){
				$obs='';
			}
			if(!@$solucao){
				$solucao='';
			}
			if(!@$prog){
				$prog='';
			}
			if(!@$hinicio){
				$hinicio='';
			}
			if(!@$hfim){
				$hfim='';
			}
		$tabela='chamados';
		$dados="'','$status','$agente','$cod_cli','$abertura','$username','$aviso','$descricao','$fechamento','$departamento','$acoes','$sla','$solucao','$obs','$obs_cli','$prog','$hinicio','$hfim'";
		$grava=Conexao::grava2Bd($tabela,$dados);
		
		echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"1;URL=clientes.php?act=cad&tipo=$tipo&username=$username\">";
		echo "<hr>";
		echo "<b>Chamado gravado com sucesso!</b>";
		exit;
	}
}

// consulta e edição
if ($act=="edita"){
	echo "<center><table width=100% border=0>";
	echo "<tr><td align=right><b><font color=#008080>CONSULTA DE CHAMADOS<br><hr width=50%></td></tr>";
	echo "<tr><td>&nbsp</td></tr></table></center>";
//	if (!$cod_usuario){
	if (($chamado=="") && ($ver<>"on")){
		echo "<body onLoad=\"document.escolha.nome.focus()\" >";
		echo "<form name=\"escolha\" method=\"POST\" action=\"clientes.php\">";
		echo "<table border=0><tr>";
		echo "<td valign=middle><font color=black size=2 face=verdana><b>Cliente:</b> </td>";
		echo "<td valign=center><input type=\"text\" name=\"nome\" size=20>";
		echo "<input type=\"hidden\" name=\"ver\" value=\"on\">";
		echo "<input type=\"hidden\" name=\"act\" value=\"edita\">";
		echo "<input type=hidden name=username value=$username>";
		echo "<input type=hidden name=tipo value=$tipo>";				
		echo "</td><td><center><input type=\"submit\" value=\"Procurar >>\"><BR><font size=2 face=verdana></td>";
		echo "</tr>";
		echo "<tr><td colspan=3>(em branco para lista de chamados)</td></tr>";
		echo "</table>";
		exit;
	}else{
		$tabela='chamados';
		$ordem='sla';
		$where="numero=\"$chamado\"";
		
		$linhas=Conexao::linhas2Bd($tabela,$where);
		if(@$chamado){
			$resultado=Conexao::usuariosChamados($chamado);
			@$nome_cliente=$resultado['nome'];
			@$emailBd=$resultado['email'];
		}
	
		if ($linhas==0 && $chamado){
			echo "<b>Chamado não encontrado. Tente na lista abaixo.<BR><BR><input type=button value='Abrir Chamado' onclick=\"location.href='clientes.php?act=cad&username=$username&tipo=$tipo'\"><p><center>";
			
			$where="status < 5";
			$resultado=Conexao::consultaChamado2($tabela,$where);
			$linhas=count($resultado);
			echo "<table border=0 cellpadding=0 cellspacing=0 width=100%>";
			if (!$linhas){
				echo "Não existem registros.";
				exit;
			}else{
				echo "<tr bgcolor=LIGHTSKYBLUE ><td align=center width=7%><font size=1 face=verdana><b>CHAMADO</b></td><td align=center><font size=1 face=verdana><b>DESCRIÇÃO</b></td><td width=23% align=center><font size=1 face=verdana><b>CLIENTE</b></td><td width=8% align=center><font size=1 face=verdana><b>AGENTE</b></td><td align=center width=7%><font size=1 face=verdana><b>FILA<b></td></tr>";
					$i=0;
					foreach($resultado as $key => $item){
						$cod_usuario=$item['codigo'];
						$tamanho=strlen($item['descricao']);
							if($tamanho>48){
								$descricao=substr($item['descricao'],0,48).'...';
							}else{	
								$descricao=$item['descricao'];	
							}
						$agente=$item['agente'];
						$clienteBd=$item['clientes'];
						$username=$clienteBd;
						$chamado=$item['numero'];
						$sla=$item['sla'];
						$resultado2=Conexao::usuariosBd($username);
						$nome_cliente=$resultado2['nome'];
						$emailBd=$resultado2['email'];
						if(!isset($nome_cliente)){
							$nome_cliente=maiusculo("Cliente foi excluído");
						}
		// Alternar nas cores na tabela
						if ($i%2==0){
							$color="#DEDFDE";
						}else{
							$color="silver";
						}
						$i++;
		// fim cores
						if ($tipo==1){
							echo "<tr onmouseover=\"this.style.backgroundColor='cyan';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: $color\" onmouseout=\"this.style.backgroundColor='$color';\" onclick=\"link('clientes.php?act=edita&nome=$nome&cod_usuario=$cod_usuario&username=$username&tipo=$tipo','_self')\"><td align=center><font size=1 face=verdana>$sla</td><td><font size=1 face=verdana>$nome</td><td align=center><font size=1 face=verdana>$fantasia</td></tr>";
						}
						if ($tipo==2){
							echo "<tr onmouseover=\"this.style.backgroundColor='cyan';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: $color\" onmouseout=\"this.style.backgroundColor='$color';\" onclick=\"link('clientes.php?act=edita&nome=$nome&cod_usuario=$cod_usuario&chamado=$chamado&cliente=$cliente&username=$username&tipo=$tipo','_self')\"><td align=center><font size=1 face=verdana>$chamado</td><td><font size=1 face=verdana>$descricao</td><td align=center><font size=1 face=verdana>$nome_cliente</td><td align=center><font size=1 face=verdana>$agente</td><td align=center><font size=1 face=verdana>$sla</td></tr>";
						}
					}
				echo "</table>";
				exit;
			}
		}
	}
	$tabela='chamados';
	if($cod_usuario==4 || $cod_usuario==1){
		if($chamado){
			$where="numero=\"$chamado\"";
		}else{
			$where="status < 5";	
			$resultado=Conexao::consultaChamado2($tabela,$where);	
		}
								
		$numLinhas=count($resultado);
	}else{
		if($chamado){
			$where="numero=\"$chamado\" and departamento=\"$departamento\"";
		}else{
			$where="departamento=\"$departamento\" and status <> 5";	 
		}
			$resultado=Conexao::consultaChamado2($tabela,$where);
			
			$numLinhas=count($resultado);
	}	
	if(!$numLinhas){
		echo "Você não tem acesso a este chamado.<br>";
		echo "<font color='red' size=1><b>*Só poderá visualizar chamados abertos por você</b></font>";
		echo "<tr><td><input type=\"button\" value=\"Voltar\" onclick=history.back()></td>";
		exit;
	}else{
  		if(@$chamado && ($cod_usuario==3 || $cod_usuario==2)){
    			foreach($resultado as $key => $item);
					$resultado=$item;
  		}
	}	
	if($chamado){	
		$numero=$resultado["numero"];
		$agente=$resultado["agente"];
		$cod_usuario=$resultado["codigo"];
		$abertura=$resultado["abertura"];
		$aviso=$resultado["aviso"];
		@$descricao=$resultado["descricao"];
		@$fechamento=$resultado["fechamento"];
		@$departamento=$resultado["departamento"];
		@$acoes=$resultado["acoes"];
		@$solucao=$resultado["solucao"];
		@$usernameBd=$resultado['clientes'];
		//@$data=substr(timestamp_para_humano(mysql_result($resultado["cadastro"]),0,10);
		@$sla=$resultado["sla"];				
		@$status=$resultado["status"];
		@$obs=$resultado['obs'];
		@$obs_cli=$resultado['obs_cli'];
		$nome_status=statusChamado($status);
	}else{
		echo "<table border=0 cellpadding=0 cellspacing=0 width=100%>";
		echo "<tr bgcolor=LIGHTSKYBLUE ><td align=center width=7%><font size=1 face=verdana><b>CHAMADO</b></td><td align=center><font size=1 face=verdana><b>DESCRIÇÃO</b></td><td width=23% align=center><font size=1 face=verdana><b>CLIENTE</b></td><td width=8% align=center><font size=1 face=verdana><b>AGENTE</b></td><td align=center width=7%><font size=1 face=verdana><b>FILA<b></td></tr>";	
		$i=0;
		foreach($resultado as $key => $item){
			$cod_usuario=$item['codigo'];
			$tamanho=strlen($item['descricao']);
			if($tamanho>48){
				$descricao=substr($item['descricao'],0,68).'...';
			}else{	
				$descricao=$item['descricao'];	
			}
			$agente=$item['agente'];
			$clienteBd=$item['clientes'];
			$usernameBd=$clienteBd;
			$chamado=$item['numero'];
			$sla=$item['sla'];
			$obs=$item['obs'];
			$obs_cli=$item['obs_cli'];
			$resultado2=Conexao::usuariosBd($usernameBd);
			$nome_cliente=$resultado2['nome'];
			if(!isset($nome_cliente)){
				$nome_cliente=maiusculo("Cliente foi excluído");
			}
		// Alternar nas cores na tabela
			if ($i%2==0){
				$color="#DEDFDE";
			}else{
				$color="silver";
			}
			$i++;
		// fim cores
			if ($tipo==1){
				echo "<tr onmouseover=\"this.style.backgroundColor='cyan';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: $color\" onmouseout=\"this.style.backgroundColor='$color';\" onclick=\"link('clientes.php?act=edita&nome=$nome&cod_usuario=$cod_usuario&username=$username&tipo=$tipo','_self')\"><td align=center><font size=1 face=verdana>$sla</td><td><font size=1 face=verdana>$nome</td><td align=center><font size=1 face=verdana>$fantasia</td></tr>";
			}
			if ($tipo==2){
				echo "<tr onmouseover=\"this.style.backgroundColor='cyan';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: $color\" onmouseout=\"this.style.backgroundColor='$color';\" onclick=\"link('clientes.php?act=edita&nome=$nome&cod_usuario=$cod_usuario&chamado=$chamado&cliente=$cliente&username=$username&tipo=$tipo','_self')\"><td align=center><font size=1 face=verdana>$chamado</td><td><font size=1 face=verdana>$descricao</td><td align=center><font size=1 face=verdana>$nome_cliente</td><td align=center><font size=1 face=verdana>$agente</td><td align=center><font size=1 face=verdana>$sla</td></tr>";
			}
		}
		echo "</table>";
		exit;
	}			
	echo "<DIV ALIGN=RIGHT><B>Número do Chamado:  <font color=blue>$chamado</B><br>";
	echo "<table border=1 WIDTH=100% BORDERCOLOR=BLACK cellspacing=0 cellpadding=0 BGCOLOR=WHITE><tr><TD>";
	echo "<table border=0 WIDTH=100% cellspacing=3 cellpadding=0><tr>";
	echo "<td valign=middle colspan=4><table border=0><td><font face=verdana size=2 color=black>Resumo do chamado:</td><td valign=middle onmouseover=\"this.style.backgroundColor='yellow';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: \" onmouseout=\"this.style.backgroundColor='';\" onclick=\"link('edita.php?nome=$nome&cod_usuario=$cod_usuario&field=pessoa')\"><font face=verdana color=blue size=2>";
	echo "</td></tr></table></tr>";
	echo "<tr><td>&nbsp</td></tr>";
	if(!isset($nome_cliente)){
		$nome_cliente=maiusculo("Cliente foi excluído");
	}
	echo "<tr><td valign=middle width=25 colspan=><font face=verdana size=2 color=black>Cliente:</td><td valign=middle width=90% colspan=4><font face=verdana color=blue size=2>$nome_cliente</td>";
	echo "<td valign=TOP><font face=verdana size=2 color=black>Departamento:</td><td colspan=4 width=45% valign=middle \"><font face=verdana color=blue size=2>$departamento</td>";
	echo "</tr><tr>";
	echo "</tr><tr>";
	echo "<td valign=middle colspan=2><font face=verdana size=2 color=black>Descrição do problema:</td><td width=40% valign=middle \"><font face=verdana color=blue size=2>$descricao</td></tr><tr>";
	echo "<td valign=middle colspan=2><font face=verdana size=2 color=black>Abertura do Chamado:</td><td valign=middle\"><font face=verdana color=blue size=2>",date("d/m/Y à\s H:i",$abertura),"</td>";
	echo "</tr><tr>";
	echo "<td valign=middle colspan=2><font face=verdana size=2 color=black>Ações Tomadas:</td><td valign=middle \"><font face=verdana color=blue size=2>$solucao</td>";
	echo "</tr><tr>";
	echo "<td valign=middle colspan=2><font face=verdana size=2 color=black>SLA :</td><td valign=middle \"><font face=verdana color=blue size=2>$sla</td>";
	echo "<td>&nbsp</td>";
	echo "<td align=left valign=middle>";
	if ($emailBd){
		echo "<a href='mailto:$emailBd'><i>";
	}
	echo "<font face=verdana size=2 color=black>Email:</td><td valign=middle \"><font face=verdana color=blue size=2>$emailBd</td>";
	echo "</tr><tr>";
	echo "<tr>";
	echo "<td align=left valign=middle><font face=verdana size=2 color=black>Login:</td><td valign=middle \"><font face=verdana color=blue size=2>$usernameBd</td>";
	echo "<td>&nbsp</td>";
	echo "</tr><tr>";
	if(!isset($nome_status)){
		$nome_status=null;
	}
	echo "<td align=left valign=middle><font face=verdana size=2 color=black>Status:</td><td valign=middle colspan=2\"><font face=verdana color=blue size=2>$nome_status</td>";
	echo "<td>&nbsp</td>";
	echo "</tr><tr>";
	echo "</tr><tr>";
	echo "<form method=GET action='clientes.php'>";
	echo "<input type=hidden name=cod_usuario value='$cod_usuario'>";
	echo "<input type=hidden name=nome value='$nome'>";
	echo "<input type=hidden name=source value='edita'>";
	echo "<input type=hidden name=obs value='$obs'>";
	echo "<input type=hidden name=obs_cli value='$obs_cli'>";
	echo "<tr><td colspan=5><hr color=#DEDFDE></td></tr>";
	echo "<tr><td colspan=5>";
	echo " <input type=button value='Exibir Observações' onclick=\"location.href='clientes.php?cod_usuario=$cod_usuario&act=obs&chamado=$chamado&obs=$obs&obs_cli=$obs_cli&username=$username&tipo=$tipo'\">";
	echo "&nbsp<input type=\"button\" value=\"Voltar\" onclick=history.back()>";
	echo "</td></tr></form>";
}

// observações
if ($act=="obs"){
	echo "<center><table width=100% border=0>";
	echo "<tr><td align=right><b><font color=#008080>OBSERVAÇÕES SOBRE O CHAMADO DE No $chamado<br><hr width=50%></td></tr>";
	echo "<tr><td>&nbsp</td></tr></table></center>";
	echo "<form method=GET action=clientes.php>";
	echo "<input type=hidden name=act value=obs>";
	echo "<input type=hidden name=cadastrou value=1>";
	echo "<input type=hidden name=cod_usuario value=$cod_usuario>";		
	echo "<table border=0 width=60% cellpadding='5'>";
	echo "<tr><td valign=top><font face=verdana size=1><b>OBSERVAÇÕES CLIENTE:</td>";
	echo "<td align=left width=65% STYLE='border-style: outset; background: #ccc'>";
		if($obs_cli){
			echo $obs_cli;
		}else{
			echo "Nenhuma observação foi feita pelo cliente.";
		}
	echo "</td></tr>";
	echo "<tr><td>&nbsp</td></tr>";
		//echo "<tr><td colspan=2><hr></td></tr>";
	echo "<tr><td valign=top><font face=verdana size=1><b>OBSERVAÇÕES AGENTE:</td><td align=left width=85% STYLE='border-style: outset; background: #ccc' ><font color='black'>";
		if($obs){
			echo $obs;
		}else{
			echo "Nenhuma observação foi feita pelo agente.";
		}
	echo "</font></td></tr>";
		//echo "<tr><td colspan=2><hr></td></tr>";
	echo "<tr><td>&nbsp</td><td><input type=button value=Voltar onclick='history.back()'>";
	echo "</table>";
	echo "</form>";
	exit;
}
echo "</td></tr>";
echo "</table>";
exit;
?>