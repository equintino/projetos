<?php	
// Conexão do banco
function conectaBd(){
	$pdo = new PDO("mysql:host=localhost;dbname=helpdesk","root","");
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $pdo;
}
function closeBd($sth,$pdo) {
      unset($pdo); 
      unset($sth);
}

// Dados do usuário
function usuariosBd($user,$pdo){
	$sth = $pdo -> prepare("select * from usuarios where username=:user");
	$sth -> bindValue(':user',$user);
	$sth -> execute();

	$result = $sth->fetch(PDO::FETCH_ASSOC);
	return $result;
}
function usuarios2Bd($id,$pdo){
	$sth = $pdo -> prepare("select * from usuarios where id=:id");
	$sth -> bindValue(':id',$id);
	$sth -> execute();

	$result = $sth->fetch(PDO::FETCH_ASSOC);
	return $result;
}

// Join
function usuariosChamados($chamado,$pdo){
	$sth = $pdo -> prepare("select * from chamados INNER JOIN usuarios ON chamados.clientes=usuarios.username where numero=:chamado");
	
	$sth -> bindValue(':chamado',$chamado);
	$sth -> execute();
	
	$result = $sth -> fetch(PDO::FETCH_ASSOC);
	return $result;
}
function acessos($inicio,$fim,$complemento,$ordenado,$pdo){
	if(!$inicio){
		$sth = $pdo -> query("select * from acessos inner join usuarios on acessos.login=usuarios.username and (data_in<=$fim ) order by acessos.$ordenado $complemento");
	}else{
		$sth = $pdo -> query("select * from acessos inner join usuarios on acessos.login=usuarios.username and (data_in>=$inicio and data_in<=$fim ) order by acessos.$ordenado $complemento");	
	}
	$result = $sth -> fetchAll(PDO::FETCH_ASSOC);
	return $result;
}
function buscaAcessos($cliente,$inicio,$fim,$complemento,$pdo){
	$sth = $pdo -> query("select * from acessos inner join usuarios on acessos.login=usuarios.username and usuarios.username like '%$cliente%' and (data_in>=$inicio and data_in<=$fim) order by data_in $complemento");
	
	$result = $sth -> fetchAll(PDO::FETCH_ASSOC);
	return $result;	
}

// Quantidade de linhas encontradas
function linhasBd($user,$pdo){
	$sth = $pdo -> prepare("select * from usuarios where username=:user");
	$sth -> bindValue(':user',$user);
	$sth -> execute();

	$result = $sth->rowCount();
	return $result;
}
function linhas2Bd($tabela,$pdo,$where){
	$sth = $pdo -> prepare("select * from $tabela where $where");
	$sth -> execute();

	$result = $sth->rowCount();
	return $result;
}
function linhasStatus($status,$pdo){
	if($status=='T'){
		$sth = $pdo -> prepare("select * from chamados");
	}else{
		$sth = $pdo -> prepare("select * from chamados where status=:status");
	}
	$sth -> bindValue(':status',$status);
	$sth -> execute();

	$result = $sth->rowCount();
	return $result;
}

// Consulta ao banco
function consultaChamado($pdo,$chamado){
	if(!isset($chamado)){
			$sth = $pdo -> prepare("select * from chamados where status=4");
	}else{
			$sth = $pdo -> prepare("select * from chamados where numero='$chamado'");
	}
	
	$sth -> execute();
	$resultado = $sth->fetch(PDO::FETCH_ASSOC);
	return $resultado;
}
function consultaChamado2($tabela,$pdo,$where){
	$sth = $pdo -> prepare("select * from $tabela where $where");
	
	$sth -> execute();
	@$numero=strstr($where,'=',1);
	if($numero=='numero'){
		$resultado = $sth->fetch(PDO::FETCH_ASSOC);
	}else{
		$resultado = $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	return $resultado;
}
function consultaChamado3($tabela,$pdo,$where){
	$sth = $pdo -> prepare("select * from $tabela where $where");
	
	$sth -> execute();
	$resultado = $sth->fetch(PDO::FETCH_ASSOC);
	return $resultado;
}
function consulta2Bd($tabela,$pdo,$ordem){
	$sth = $pdo -> prepare("select * from $tabela order by $ordem");
	$sth -> execute();
	
	$result = $sth->fetchAll(PDO::FETCH_ASSOC);
	return $result;
}
function consulta3Bd($tabela,$pdo,$ordem){
	$sth = $pdo -> prepare("select * from $tabela where status<5 order by $ordem");
	$sth -> execute();
	
	$result = $sth->fetchAll(PDO::FETCH_ASSOC);
	return $result;
}
function consultaBd($status,$pdo,$inicio,$fim,$cliente){
  if(isset($status) && ($status<>'T')){
	if(!isset($cliente)){
	  if(!isset($inicio)&& !isset($fim)){
		$sth = $pdo -> prepare("select * from chamados where status=:status order by status,sla asc");
		$sth -> bindValue(':status',$status);
	  }elseif(isset($inicio)&& !isset($fim)){
		$sth = $pdo -> prepare("select * from chamados where status=:status and (abertura>=:inicio) order by status,sla asc");
		$sth -> bindValue(':status',$status);
		$sth -> bindValue(':inicio',$inicio);				
	  }elseif(!isset($inicio)&& isset($fim)){
		$sth = $pdo -> prepare("select * from chamados where status=:status and (abertura<=:fim) order by status,sla asc");
		$sth -> bindValue(':status',$status);
		$sth -> bindValue(':fim',$fim);				
	  }elseif(isset($inicio)&& isset($fim)){
		$sth = $pdo -> prepare("select * from chamados where status=:status and (abertura>=:inicio and  abertura<=:fim) order by status,sla asc");
		$sth -> bindValue(':status',$status);
		$sth -> bindValue(':inicio',$inicio);
		$sth -> bindValue(':fim',$fim);			
	  }else{
		$sth = $pdo -> prepare("select * from chamados where status=:status order by status,sla asc");
		$sth -> bindValue(':status',$status);
	  }
	}else{
	  if(isset($status) && $status<>'T'){
		if(!isset($inicio)&& !isset($fim)){
		  $sth = $pdo -> prepare("select * from chamados where status=:status and clientes=:cliente order by status,sla asc");
		  $sth -> bindValue(':cliente',$cliente);
		  $sth -> bindValue(':status',$status);
		}elseif(isset($inicio)&& !isset($fim)){
		  $sth = $pdo -> prepare("select * from chamados where status=:status and clientes=:cliente and (abertura>=:inicio) order by status,sla asc");
		  $sth -> bindValue(':cliente',$cliente);
		  $sth -> bindValue(':status',$status);
		  $sth -> bindValue(':inicio',$inicio);				
		}elseif(!isset($inicio)&& isset($fim)){
		  $sth = $pdo -> prepare("select * from chamados where status=:status and clientes=:cliente and (abertura<=:fim) order by status,sla asc");
		  $sth -> bindValue(':cliente',$cliente);
		  $sth -> bindValue(':status',$status);
		  $sth -> bindValue(':fim',$fim);				
		}elseif(isset($inicio)&& isset($fim)){
		  $sth = $pdo -> prepare("select * from chamados where status=:status and clientes=:cliente and (abertura>=:inicio and  abertura<=:fim) order by status,sla asc");
		  $sth -> bindValue(':cliente',$cliente);
		  $sth -> bindValue(':status',$status);
		  $sth -> bindValue(':inicio',$inicio);
		  $sth -> bindValue(':fim',$fim);				
		}else{
		  $sth = $pdo -> prepare("select * from chamados where status=:status and clientes=:cliente order by status,sla asc");
		  $sth -> bindValue(':cliente',$cliente);
		  $sth -> bindValue(':status',$status);
		}
	  }elseif($status=='T'){
		if(!isset($inicio)&& !isset($fim)){
		  $sth = $pdo -> prepare("select * from chamados where clientes=:cliente order by status,sla asc");
		  $sth -> bindValue(':cliente',$cliente);
		}elseif(isset($inicio)&& !isset($fim)){
		  $sth = $pdo -> prepare("select * from chamados where clientes=:cliente and (abertura>=:inicio) order by status,sla asc");
		  $sth -> bindValue(':cliente',$cliente);
		  $sth -> bindValue(':inicio',$inicio);				
		}elseif(!isset($inicio)&& isset($fim)){
		  $sth = $pdo -> prepare("select * from chamados where clientes=:cliente and (abertura<=:fim) order by status,sla asc");
		  $sth -> bindValue(':cliente',$cliente);
		  $sth -> bindValue(':fim',$fim);				
		}elseif(isset($inicio)&& isset($fim)){
		  $sth = $pdo -> prepare("select * from chamados where clientes=:cliente and (abertura>=:inicio and  abertura<=:fim) order by status,sla asc");
		  $sth -> bindValue(':cliente',$cliente);
		  $sth -> bindValue(':inicio',$inicio);
		  $sth -> bindValue(':fim',$fim);				
		}else{
		  $sth = $pdo -> prepare("select * from chamados where clientes=:cliente order by status,sla asc");
		  $sth -> bindValue(':cliente',$cliente);
		}
	  }
	}
  }elseif($status=='T'){
	if(!isset($cliente)){
	  if(!isset($inicio)&& !isset($fim)){
		$sth = $pdo -> prepare("select * from chamados where (status=\"A\" or status=1 or status=2 or status=3 or status=4) order by status,sla asc");
	  }elseif(isset($inicio)&& !isset($fim)){
		$sth = $pdo -> prepare("select * from chamados where (status='A' or status=1 or status=2 or status=3 or status=4) and (abertura>=:inicio) order by status,sla asc");
		$sth -> bindValue(':inicio',$inicio);				
	  }elseif(!isset($inicio)&& isset($fim)){
		$sth = $pdo -> prepare("select * from chamados where (status='A' or status=1 or status=2 or status=3 or status=4) and (abertura<=:fim) order by status,sla asc");
		$sth -> bindValue(':fim',$fim);				
	  }else{
		$sth = $pdo -> prepare("select * from chamados where (status='A' or status=1 or status=2 or status=3 or status=4) and (abertura>=:inicio and  abertura<=:fim) order by status,sla asc");
		$sth -> bindValue(':inicio',$inicio);
		$sth -> bindValue(':fim',$fim);			
	  }
	}else{
	  if(!isset($inicio)&& !isset($fim)){
		$sth = $pdo -> prepare("select * from chamados where clientes=:cliente order by status,sla asc");
		$sth -> bindValue(':cliente',$cliente);
	  }elseif(isset($inicio)&& !isset($fim)){
		$sth = $pdo -> prepare("select * from chamados where clientes=:cliente and (abertura>=:inicio) order by status,sla asc");
		$sth -> bindValue(':cliente',$cliente);
		$sth -> bindValue(':inicio',$inicio);				
	  }elseif(!isset($inicio)&& isset($fim)){
		$sth = $pdo -> prepare("select * from chamados where clientes=:cliente and (abertura<=:fim) order by status,sla asc");
		$sth -> bindValue(':cliente',$cliente);
		$sth -> bindValue(':fim',$fim);				
	  }else{
		$sth = $pdo -> prepare("select * from chamados where clientes=:cliente and (abertura>=:inicio and  abertura<=:fim) order by status,sla asc");
		$sth -> bindValue(':cliente',$cliente);
		$sth -> bindValue(':inicio',$inicio);
		$sth -> bindValue(':fim',$fim);				
	  }			
	}	
  }else{
	$sth = $pdo -> prepare("select * from chamados  order by status,sla asc");
  }
   $sth -> execute();
   $result = $sth->fetchAll(PDO::FETCH_ASSOC);
   return $result;
}

// Gravar no banco
function gravaBd($pdo,$codigo,$agora,$ip,$username){
	$sth = $pdo -> prepare("insert into acessos values(0,:codigo,:agora,:ip,:username)");
	
	$sth -> bindValue(':codigo',$codigo);
	$sth -> bindValue(':agora',$agora);
	$sth -> bindValue(':ip',$ip);
	$sth -> bindValue(':username',$username);
	
	$sth -> execute();
}
function grava2Bd($tabela,$pdo,$dados){
	$sth = $pdo -> prepare("insert into $tabela values($dados)");

	$sth -> execute();
}

// Atualizar dados do banco 
function atualizaBd($pdo,$login,$senha,$agora){
	$sth = $pdo -> prepare("update usuarios set senha=:senha,last_upd=:agora where username=:login");
	
	$sth -> bindValue(':login',$login);
	$sth -> bindValue(':senha',$senha);
	$sth -> bindValue(':agora',$agora);
	
	$sth -> execute();
}
function atualiza2Bd($tabela,$pdo,$dados,$where){
	$sth = $pdo -> prepare("update $tabela set $dados where $where");

	$sth -> execute();
}
function atualizaChamado($tabela,$pdo,$dados,$chamado){
	if($chamado){
		$sth = $pdo -> query("update $tabela set $dados where numero=$chamado");
	}else{
		echo "VocÃª nÃ£o selecionou nenhum chamado.";
	}
}

// Excuir dados
function exclui($tabela,$pdo,$where){
	if($where){
		$sth = $pdo -> query("DELETE FROM $tabela WHERE $where");
	}else{
		echo "Você não selecionou nenhum chamado.";
	}
}
function limpaTabela($tabela,$pdo){
	$sth = $pdo -> query("truncate table $tabela");
}

// Confirmar dados
function confirmaDados_($dado1,$pdo,$col,$dado2){
	$sth = $pdo -> prepare("SELECT * FROM usuarios ");
	
	$sth -> execute();
	var_dump($sth -> execute());
	if ($sth){
		echo "<TABLE><TR><TD>";
		echo "O $dado1 $dado2 já existe.<p>";
		echo "<input type=\"button\" value=\"Voltar\" onclick=history.back()>";				
		exit;
	}
}
?>