<?php
@$tipo=$_GET['tipo'];
if(!$tipo){
  @$tipo=$_POST['tipo'];
}
$username=$_COOKIE['nome_usuario'];
include "valida_cookies.inc";
//include "fundo.php";
include "construct.php";
include "divfunc.php";

@$codigo=$_POST["codigo"];
if(!isset($codigo)){
	@$codigo=$_GET['codigo'];
}
@$cod_usuario=$_POST["cod_usuario"];
if(!isset($cod_usuario)){
	@$cod_usuario=$_GET['cod_usuario'];
}
@$ver=$_POST["ver"];
if(!isset($ver)){
	@$ver=$_GET['ver'];
}
@$act=$_POST["act"];
if(!isset($act)){
	@$act=$_GET['act'];
}
@$operacao=$_POST["operacao"];
if(!isset($operacao)){
	@$operacao=$_GET['operacao'];
}
@$departamento=maiusculo($_POST["departamento"]);
if(!$departamento){
	@$departamento=maiusculo($_GET["departamento"]);
}

@$nome=maiusculo($_POST["nome"]);

if(@!$nome){
	@$nome=maiusculo($_GET["nome"]);
}
@$nick=maiusculo($_POST["nick"]);
if(!$nick){
	@$nick=maiusculo($_GET["nick"]);
}
//@$username=maiusculo($_POST["username"]);
//if(!$username){
	//@$username=maiusculo($_GET["username"]);
//}
@$tipo=$_POST['tipo'];
if(!isset($tipo)){
	@$tipo=$_GET["tipo"];
}

@$tipo_agente=$usuario['tipo'];

@$status=$_POST["status"];
if(!isset($status)){
	@$status=$_GET["status"];
}
@$id=$_POST["id"];
if(!isset($id)){
	@$id=$_GET['id'];
}
@$email=$_POST['email'];
if(!isset($email)){
	@$email=$_GET['email'];
}
@$cod_usuario=$_POST['cod_usuario'];
if(!isset($cod_usuario)){
	@$cod_usuario=$_GET['cod_usuario'];
}
@$login=maiusculo($_POST['login']);
if(!$login){
	@$login=maiusculo($_GET['login']);
}
@$senha_bd=$_POST['senha_bd'];
if(!isset($operacao)){
	$operacao=null;	
}
if(!isset($nick)){
	$nick=null;
}
if(!isset($username)){
	$username=null;
}

// renova senha

if ($operacao=="renova"){
	$cod_usuario=$usuario["cod_usuario"];
	$nome=$usuario["nome"];
	if(!$senha_bd){
		$senha_bd=$usuario["senha"];
	}
	$tipo=$usuario["tipo"];
	
	echo "<center><table width=100% border=0>";
	echo "<tr><td align=right><b><font color=#008080>USUÁRIOS - RENOVAÇÃO DE SENHA<br><hr width=50%></td></tr>";
	echo "<tr><td>&nbsp</td></tr></table></center>";	
	if ($act!="sim"){
		echo "<body onload='document.altera2.senha_old.focus()'>";
		echo "<form name=\"altera2\" method=\"POST\" action=\"users.php\">";
		echo "<tr><td colspan=2 bgcolor=silver><table width=100% border=0 bgcolor=white><tr><td colspan=2 bgcolor=silver><font face=verdana size=2><b>Dados de Login</td></tr>";
		echo "<tr><td width=15% align=left valign=middle><BR><font color=black face=verdana size=2>Funcionário:</td><td valign=middle><font color=black face=verdana size=2><BR>$nome</td>";
		echo "</tr>";
		echo "<tr><td width=15% align=left valign=middle><BR><font color=black face=verdana size=2>Login:</td><td valign=middle><font color=black face=verdana size=2><BR>$username</td>";
		echo "</tr>";
		echo "<tr><td>&nbsp</td></tr>";
		echo "<tr><td align=left valign=middle><font color=black face=verdana size=2>Senha Atual:</td><td valign=middle><input tabindex=\"5\" type=\"password\" name=\"senha_old\" size=10 maxlength=8></td>";
		echo "</tr>";
		echo "<tr><td>&nbsp</td></tr>";
		echo "<tr><td align=left valign=middle><font color=black face=verdana size=2>Nova Senha:<BR><font color=black face=verdana size=1>(até 8 caracteres)</td><td valign=middle><input tabindex=\"5\" type=\"password\" name=\"senha\" size=10 maxlength=8></td>";
		echo "</tr>";
		echo "<tr><td>&nbsp</td></tr>";
		echo "<tr><td align=left valign=middle><font color=black face=verdana size=2>Confirma Senha</td><td valign=middle><input tabindex=\"6\" type=\"password\" name=\"senha2\" size=10 maxlength=8></td>";
		echo "</tr>";
		echo "<tr><td>&nbsp</td></tr>";
		echo "<input type=hidden value=sim name=act>";
		echo "<input type=hidden value=renova name=operacao>";
		echo "<input type=hidden value=$senha_bd name=senha_bd>";
		echo "<input type=hidden value=$tipo name=tipo>";
		echo "<tr><td><input type=submit value=Envia>";
	}else{
	$senha=sha1(md5(maiusculo($_POST["senha"])));
	$senha2=sha1(md5(maiusculo($_POST["senha2"])));
	$senha_old=sha1(md5(maiusculo($_POST["senha_old"])));	
	echo "senha->$senha senha2->$senha2 senha_old->$senha_old senha_bd->$senha_bd";
		if ($senha!=$senha2){
			echo "<TABLE><TR><TD>";
			echo "A confirmação da <i>senha</i> não bate.<p>";
			echo "<input type=\"button\" value=\"Voltar\" onclick=history.back()>";
			exit;
		}
		if ($senha_old!=$senha_bd){
			echo "<TABLE><TR><TD>";
			echo "A <i>senha atual</i> está incorreta.<p>";
			echo "<input type=\"button\" value=\"Voltar\" onclick=history.back()>";
			exit;
		}

		if ($senha==$senha_bd){
			echo "<TABLE><TR><TD>";
			echo "A <i>senha atual</i> deve ser diferente da <i>senha anterior</i>.<p>";
			echo "<input type=\"button\" value=\"Voltar\" onclick=history.back()>";
			exit;
		}

		if ($tipo==1){
			echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"2;URL=tabela.php\">";
		}else{
			echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"2;URL=tabela2.php\">";
		}
		if ($senha!="67a74306b06d0c01624fe0d0249a570f4d093747"){
			$agora=mktime(date("H"));
			$vai=Conexao::atualizaBd($username,$senha,$agora);
		}
		echo "<TABLE><TR><TD>";		
		echo "<b>Senha alterada com sucesso!<p>";
	}
}

// cadastro de usuarios

if ($operacao=="cad"){
	echo "<center><table width=100% border=0>";
	echo "<tr><td align=right><b><font color=#008080>CADASTRO DE USUÁRIOS<br><hr width=50%></td></tr>";
	echo "<tr><td>&nbsp</td></tr></table></center>";
		if ($act<>"grava"){
		echo "<body onLoad=\"document.cadastra.nome.focus()\" >";
		echo "<form name=\"cadastra\" method=\"POST\" action=\"users.php\">";
		echo "<table border=0 cellspacing=3 cellpadding=0><tr>";
		echo "<td valign=middle width=90><font color=black face=verdana size=2>Nome:</td><td valign=middle><input tabindex=\"1\" type=\"text\" name=\"nome\" size=70 value='$nome'></td>";
		echo "</tr><tr>";
		echo "<td valign=middle width=90><font color=black face=verdana size=2>E-mail:</td><td valign=middle><input tabindex=\"2\" type=\"text\" name=\"email\" size=20 ></td>";
		echo "</tr><tr>";
		echo "<td align=left valign=middle><font color=black face=verdana size=2>Departamento:</td><td valign=middle><input tabindex=\"3\" type=\"text\" name=\"departamento\" size=20 value='$departamento'></td>";
		echo "</tr>";
		echo "<tr><td>Função</td>";
		echo "<td><select name='cod_usuario'>";
		echo "<option value=''></option>";
		echo "<option value=1>Diretoria</option>";
		echo "<option value=2>Gerência</option>";
		echo "<option value=3>Funcionário</option>";
		echo "<option value=4>Técnico</option>";
		echo "</select></td></tr>";
		echo "<tr><td>&nbsp</td></tr>";
		echo "<tr><td colspan=2 bgcolor=silver><table width=100% border=0 bgcolor=white><tr><td colspan=2 bgcolor=silver><font face=verdana size=2><b>Dados de Login</td></tr>";
		echo "<tr><td width=25% align=left valign=middle><font color=black face=verdana size=2>Login:<BR><font color=black face=verdana size=1>(até 10 caracteres)</td><td valign=middle><input tabindex=\"4\" type=\"text\" name=\"login\" size=10 maxlength=10></td>";
		echo "</tr>";
		echo "<tr><td>&nbsp</td></tr>";
		echo "<tr><td align=left valign=middle><font color=black face=verdana size=2>Senha Inicial:<BR><font color=black face=verdana size=1>(até 8 caracteres)</td><td valign=middle><input tabindex=\"5\" type=\"password\" name=\"senha\" size=10 maxlength=8></td>";
		echo "</tr>";
		echo "<tr><td>&nbsp</td></tr>";
		echo "<tr><td align=left valign=middle><font color=black face=verdana size=2>Confirma Senha</td><td valign=middle><input tabindex=\"6\" type=\"password\" name=\"senha2\" size=10 maxlength=8></td>";
		echo "</tr>";
		echo "<tr><td>&nbsp</td></tr>";
		echo "<tr><td align=left valign=middle><font color=black face=verdana size=2>Tipo de Usuário:</td><td valign=middle>";
		echo "<select name=tipo tabindex=7 value=$tipo>";
		echo "<option value=''></option>";
		echo "<option value='1'>1 - Administrador</option>";
		echo "<option value='2'>2 - Usuário</option>";	
		echo "</select>";
		echo "</td>";
		echo "</tr></table>";
		echo"</table>";
		echo "<table border=0><tr>";
		echo "<INPUT TYPE=\"HIDDEN\" NAME=act VALUE=grava>";	
		echo "<INPUT TYPE=\"HIDDEN\" NAME=operacao VALUE=cad>";		
		echo"<td><center><input tabindex=\"8\" type=\"submit\" value=\"Cadastrar >>\"></td>";// onKeyDown=\"if (window.event.keyCode==13) cadastra.submit();\"></td>";
		//echo "<td align=right><input tabindex=\"9\" type=\"button\" value=\"Limpar\" onclick=\"location.href='users.php?operacao=cad'\"></td>";//onKeyDown=\"if (window.event.keyCode==13) window.location.reload();\" ></td>";
		echo "</form>";
		echo "</tr></table>";
		echo "</td></tr>";
		echo "</table>";
		}else{
			$senha=sha1(md5(maiusculo($_POST["senha"])));
			$senha2=sha1(md5(maiusculo($_POST["senha2"])));
			if (!$nome){
				echo "<TABLE><TR><TD>";
				echo "Você deve entrar com o <i>nome</i> do usuário.<p>";
				echo "<input type=\"button\" value=\"Voltar\" onclick=history.back()>";
				exit;
			}
			if (!$email){
				echo "<TABLE><TR><TD>";
				echo "Você deve entrar com o seu <i>E-mail</i>.<p>";
				echo "<input type=\"button\" value=\"Voltar\" onclick=history.back()>";
				exit;
			}
			if (!$login){
				echo "<TABLE><TR><TD>";
				echo "Você deve entrar com o <i>login</i> do usuário.<p>";
				echo "<input type=\"button\" value=\"Voltar\" onclick=history.back()>";
				exit;
			}

			if ($senha=="67a74306b06d0c01624fe0d0249a570f4d093747"){
				echo "<TABLE><TR><TD>";
				echo "Você deve entrar com uma <i>senha inicial</i> para o usuário.<p>";
				echo "<input type=\"button\" value=\"Voltar\" onclick=history.back()>";
				exit;
			}
			if (($senha2=="67a74306b06d0c01624fe0d0249a570f4d093747")||($senha!=$senha2)){
				echo "<TABLE><TR><TD>";
				echo "A confirmação da <i>senha</i> não bate.<p>";
				echo "<input type=\"button\" value=\"Voltar\" onclick=history.back()>";
				exit;
			}


			$where="nome=\"$nome\"";
			$confirmaNome=Conexao::linhas2Bd('usuarios',$where);		
				if ($confirmaNome){
					echo "<TABLE><TR><TD>";
					echo "O nome $nome já existe.<p>";
					echo "<input type=\"button\" value=\"Voltar\" onclick=history.back()>";				
					exit;
				}
			$login=$_POST['login'];
			$where2="username=\"$login\"";
			$confirmaLogin=Conexao::linhas2Bd('usuarios',$where2);		
				if ($confirmaLogin){
					echo "<TABLE><TR><TD>";
					echo "O login ",maiusculo($login)," já existe.<p>";
					echo "<input type=\"button\" value=\"Voltar\" onclick=history.back()>";				
					exit;
				}
			if ($tipo_agente==1){
				$agora=mktime(0);
				$tabela='usuarios';
				$dados="$cod_usuario,'$login','$senha','$tipo','$nome','$nick','$departamento','$agora',1,'','$email'";
				$grava=Conexao::grava2Bd($tabela,$dados);
				
				echo "<TABLE><TR><TD>";
				echo "<b>Usuário cadastrado com sucesso!<p>";
				echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"2;URL=users.php?operacao=cad\">";
			}else {
				echo "Você está tentando cadastar um administrador.";				
			}	
		}
}

// edita usuarios
if ($operacao=="edita"){
		echo "<center><table width=100% border=0>";
		echo "<tr><td align=right><b><font color=#008080>USUÁRIOS - EDIÇÃO<br><hr width=50%></td></tr>";
		echo "<tr><td>&nbsp</td></tr></table></center>";	
	if ($act<>"grava"){
			$tabela='usuarios';
			$ordem='nome';
			$resultado=Conexao::consulta2Bd($tabela,$ordem);
			$linhas=Conexao::linhas2Bd($tabela,1);
		if (!isset($id)){
			echo "<b><font size=2 face=verdana>Usuários Cadastrados:<p><center>";
			echo "<table border=1 cellpadding=1 cellspacing=1 width=80%>";
			if ($linhas==0){
				echo "<hr>";
				echo "<p align=left>Não existem registros.</p>";
				exit;
			}else{
				echo "<tr bgcolor=white ><td align=center><font size=1 face=verdana><b>FUNÇÃO</td><td width=90% align=center><b><font size=1 face=verdana>USUÁRIO</td><td align=center><b><font size=1 face=verdana>LOGIN</td><td align=center><b><font size=1 face=verdana>STATUS</td></tr>";
					foreach($resultado as $key => $item){
						$nome=$item['nome'];
						$cod_usuario=$item['cod_usuario'];	
						$login=$item['username'];
						$status=$item['status'];
						$id=$item['id'];
						$departamento=$item['departamento'];
						$tipo=$item['tipo'];
						$email=$item['email'];
						$funcao_usuario=cod_usuario($cod_usuario);
							if(!isset($id)){
								$id=null;	
							}
							if ($status==1){
								$nomeStatus="ATIVO";
							}else{
								$nomeStatus="INATIVO";
							}
								echo "<tr onmouseover=\"this.style.backgroundColor='yellow';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: white\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"link('users.php?operacao=edita&cod_usuario=$cod_usuario&id=$id&cod_usuario=$cod_usuario&nome=$nome&login=$login&status=$status&departamento=$departamento&tipo=$tipo&email=$email','_self')\"><td ><font size=1 face=verdana>$funcao_usuario</td><td width=90%><font size=1 face=verdana>$nome</td><td><font size=1 face=verdana>$login</td><td align=center><font size=1 face=verdana>$nomeStatus</td></tr>";
						}
						echo "</table>";
						exit;
					}
			}
			
			$funcao_usuario=cod_usuario($cod_usuario);
			
			echo "<form name=\"altera\" method=\"GET\" action=\"users.php\">";
			echo "<table border=0 width=100% cellspacing=3 cellpadding=0><tr>";
			echo "<td valign=middle width=90><font color=black face=verdana size=2>Nome:</td><td valign=middle colspan=2><input tabindex=\"1\" type=\"text\" name=\"nome\" size=70 value=\"$nome\"></td>";
			echo "</tr><tr>";
			echo "<td valign=middle width=90><font color=black face=verdana size=2>E-mail:</td><td valign=middle colspan=2><input tabindex=\"2\" type=\"text\" name=\"email\" size=40 value='$email'></td>";
			echo "</tr><tr>";		
			echo "<td align=left valign=middle><font color=black face=verdana size=2>Departamento:</td><td valign=middle colspan=2><input tabindex=\"3\" type=\"text\" name=\"departamento\" size=20 value=\"$departamento\"></td>";
			echo "</tr><tr>";		
			echo "<td align=left valign=middle><font color=black face=verdana size=2>Função:</td>";	
				echo "<td><select name=cod_usuario >";
				echo "<option value=$cod_usuario>$funcao_usuario</option>";
				echo "<option value=1>Diretoria</option>";
				echo "<option value=2>Gerência</option>";
				echo "<option value=3>Funcionário</option>";
				echo "<option value=4>Técnico</option>";
				echo "</select></td></tr>";
			echo "<tr><td>&nbsp</td></tr>";
			echo "<tr><td colspan=2><table width=100% border=0 bgcolor=white><tr><td colspan=2 bgcolor=silver><font face=verdana size=2><b>Dados de Login</td></tr>";
			echo "<tr><td width=40% align=left valign=middle><font color=black face=verdana size=2>Login:<BR><font color=black face=verdana size=1>(até 10 caracteres)</td><td valign=middle><input tabindex=\"4\" type=\"text\" name=\"login\" size=10 maxlength=10 value=$login></td>";
			echo "</tr>";
			echo "<tr><td>&nbsp</td></tr>";
			echo "<tr><td align=left valign=middle><font color=black face=verdana size=2>Nova Senha Inicial:<br><font color=black face=verdana size=1>(até 8 caracteres)</td><td valign=middle><input tabindex=\"5\" type=\"password\" name=\"senha\" size=10 maxlength=8></td>";
			echo "</tr>";
			echo "<tr><td>&nbsp</td></tr>";
			echo "<tr><td align=left valign=middle><font color=black face=verdana size=2>Confirma Senha</td><td valign=middle><input tabindex=\"6\" type=\"password\" name=\"senha2\" size=10 maxlength=8></td>";
			echo "</tr>";
			echo "<tr><td>&nbsp</td></tr>";
			echo "<tr><td align=left valign=middle><font color=black face=verdana size=2>Tipo de Usuário:</td><td valign=middle>";
			echo "<select name=tipo tabindex=7>";
			if ($tipo==1){		
				echo "<option value='1'>1 - Administrador</option>";
				echo "<option value='2'>2 - Usuário</option>";	
			}
			if ($tipo==2){
				echo "<option value='2'>2 - Usuário</option>";	
				echo "<option value='1'>1 - Administrador</option>";
			}
			echo "</select>";
			echo "</td>";
			echo "</tr></table>";
			echo "</td>";
			echo "<td width=60%>";
			echo "<table border=0><tr>";
			echo "<INPUT TYPE=\"HIDDEN\" NAME=act VALUE=grava>";
			echo "<INPUT TYPE=\"HIDDEN\" NAME=operacao VALUE=edita>";
			echo "<input type=hidden name=status value=$status>";
			echo "<input type=hidden name=id value=$id>";
			echo"<td colspan=2><center><input tabindex=\"8\" type=\"submit\" value=\"Atualizar >>\"></form>";
			//echo "<input tabindex=\"9\" type=\"\" value=\"Limpar\" onclick=\"location.href='users.php?operacao=edita'\"> ";
			if ($status==1){
				echo "<form name=exc method=POST action='users.php'><input type=hidden name=operacao value=exc><input type=hidden name=login value=$login><input type=hidden name=id value=$id><input type=hidden name=status value=$status><input type=submit value=Desabilitar onclick=\"return confirm('Deseja desabilitar este usuário?')\">";
				echo "<input type=\"button\" value=\"Voltar\" onclick=history.back()></td>";
			}else{
				echo "<form name=exc method=POST action='users.php'><input type=hidden name=operacao value=exc><input type=hidden name=login value=$login><input type=hidden name=id value=$id><input type=hidden name=status value=$status><input type=submit value=Habilitar onclick=\"return confirm('Deseja habilitar este usuário?')\">";				
				echo "<input type=\"button\" value=\"Voltar\" onclick=history.back()></td>";
				echo "</form></tr>";
				echo "<tr><td>&nbsp</td></tr>";
				echo "</tr></table></td>";
				echo "</td></tr>";
				echo "</table>";
			}
		}else{
			@$tipo_old=$usuario["tipo"];
			$senha=sha1(md5(maiusculo($_GET["senha"])));
			$senha2=sha1(md5(maiusculo($_GET["senha2"])));
			$nome=maiusculo($_GET['nome']);
			if (!$nome){
				echo "<TABLE><TR><TD>";
				echo "Você deve entrar com o <i>nome</i> do usuário.<p>";
				echo "<input type=\"button\" value=\"Voltar\" onclick=history.back()>";
				exit;
			}
			if ($senha!=$senha2){
				echo "<TABLE><TR><TD>";
				echo "A confirmação da <i>senha</i> não bate ou campo vazio.<p>";
				echo "<input type=\"button\" value=\"Voltar\" onclick=history.back()>";
				exit;
			}
				$agora=mktime(date("H"));
				$tabela='usuarios';
				$where="id=\"$id\"";
				if ($senha!="67a74306b06d0c01624fe0d0249a570f4d093747"){
					$dados="nome=\"$nome\",username=\"$login\",senha=\"$senha\",departamento=\"$departamento\",tipo=\"$tipo\",status=\"$status\",cod_usuario=\"$cod_usuario\",last_upd=\"$agora\",email=\"$email\"";
				$vai=Conexao::atualiza2Bd($tabela,$dados,$where);			
					echo "<TABLE><TR><TD>";
					echo "<b>Dados do usuário alterados com sucesso!<p>";
				}elseif ($senha=="67a74306b06d0c01624fe0d0249a570f4d093747"){
					$dados="nome=\"$nome\",username=\"$login\",departamento=\"$departamento\",tipo=\"$tipo\",status=\"$status\",cod_usuario=\"$cod_usuario\",last_upd=\"$agora\",email=\"$email\"";
				$vai=Conexao::atualiza2Bd($tabela,$dados,$where);		
					echo "<TABLE><TR><TD>";
					echo "<b>Dados do usuário alterados com sucesso!<p>";
				}else{
					echo "<TABLE><TR><TD>";
					echo "<b>Os dados do usuário não foram alterados!<p>";
					echo "<input type=\"button\" value=\"Voltar\" onclick=history.back()>";
					exit;
				}	
				echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"2;URL=users.php?operacao=edita\">";
			}
}

// exclui usuarios

if ($operacao=="exc"){
	echo "<center><table width=100% border=0>";
	echo "<tr><td align=right><b><font color=#008080>USUÁRIOS - MANUTENÇÃO<br><hr width=50%></td></tr>";
	echo "<tr><td>&nbsp</td></tr></table></center>";
	echo "<table border=0 width=100%><tr><td colspan=2>";
	echo "<center><table border=0 width=100% cellspacing=3 cellpadding=3><tr>";
	if(isset($status)) {
		$tabela='usuarios';
		$where="id=$id";
		if ($status==1){
			echo "<td><font face=verdana size=2><b>Usuário desabilitado com sucesso!</td></tr></table>";
			$dados='status=0';
			$desabilita=Conexao::atualiza2Bd($tabela,$dados,$where);
		}else{
			echo "<td><font face=verdana size=2><b>Usuário habilitado com sucesso!</td></tr></table>";
			$dados='status=1';
			$habilita=Conexao::atualiza2Bd($tabela,$dados,$where);
		}
		echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"2;URL=users.php?operacao=edita\">";
		exit;
	}
//=====monta tabela======
		if ($act<>"grava"){
	if (!$codigo){
		echo "<b><font size=2 face=verdana>Clique em cima para excluir.<p><center>";
		$tabela='usuarios';
		$ordem='nome';		
		$resultado=Conexao::consulta2Bd($tabela,$ordem);	
		echo "<table border=1 cellpadding=1 cellspacing=1 width=80%>";
		if (!isset($resultado)){
			echo "Não existem registros.";
			exit;
		}else	{
			echo "<tr bgcolor=white ><td align=center><font size=1 face=verdana><b>FUNÇÃO</td><td width=90% align=center><b><font size=1 face=verdana>CLIENTE</td><td align=center><b><font size=1 face=verdana>LOGIN</td><td align=center><b><font size=1 face=verdana>STATUS</td></tr>";
				foreach ($resultado as $key => $item){
				$nome=$item['nome'];
				$cod_usuario=cod_usuario($item['cod_usuario']);	
				$login=$item['username'];
				$status=$item['status'];
				if ($status==1){
					$status="ATIVO";
				}else{
					$status="INATIVO";
				}
				if (($codigo!=10)&&($codigo!=6)){
					echo "<tr onmouseover=\"this.style.backgroundColor='yellow';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: white\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"link('users.php?operacao=exclusao&login=$login &nome=$nome','_self')\"><td width=15%><font size=1 face=verdana>$cod_usuario</td><td><font size=1 face=verdana>$nome</td><td><font size=1 face=verdana>$login</td><td align=center><font size=1 face=verdana>$status</td></tr>";
				}
			}
				echo "</table>";
				exit;
		}
	}
 }
//=====fim monta tabela====
}
//====Confirma exclusão====
if ($operacao=="exclusao"){
	echo "Confirma a exclusão de $nome?<br>";
	echo "<input type=button onclick=\"link('users.php?operacao=confirma&cod_usuario=$cod_usuario &nome=$nome','_self')\" value='Sim'>";
	echo "<input type=button onclick=history.back() value='Nào'>";
}
if ($operacao=="confirma"){
	$tabela='usuarios';
	$where="nome=\"$nome\"";
	$deleta=Conexao::exclui($tabela,$where);
	echo "Exclusão de $nome feita com sucesso.";
		echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"2;URL=users.php?operacao=exc\">";
		exit;
}
exit;
?>