<?php	
// Conexão do banco
class Conexao extends PDO {
    	private static $instancia;
		public $login;
 
    public function Conexao($dsn , $username = "", $password = "") {
        // O construtro abaixo é o do PDO
        $opcao = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',);
        parent::__construct($dsn, $username, $password, $opcao);
    }
 
    public static function getInstance() {
        // Se o a instancia não existe eu faço uma
        if(!isset( self::$instancia )){
            try {
                self::$instancia = new Conexao("mysql:host=localhost;dbname=helpdesk","root","monica924");
                //Conexao->array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',)
            } catch ( Exception $e ) {
                echo 'Erro ao conectar';
                exit ();
            }
        }
        // Se já existe instancia na memória eu retorno ela
        return self::$instancia;
    }
		public static function getUsuariosBd($username) {
			$sql = "select * from usuarios where username=\"$username\"";
			$sth = Conexao::getInstance()->prepare($sql);
			$sth -> execute();
			return $sth->fetch(PDO::FETCH_ASSOC);
		}
		public static function closeBd(){
			self::$instancia = null;
			return self::$instancia;
		}
		public static function consultaChamado($chamado){
			if(!isset($chamado)){
				$sth = Conexao::getInstance() -> prepare("select * from chamados where status=4");
			}else{
				$sth = Conexao::getInstance() -> prepare("select * from chamados where numero='$chamado'");
			}
	
			$sth -> execute();
			$resultado = $sth->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}
		public static function consulta2Bd($tabela,$ordem){
			$sth = Conexao::getInstance() -> prepare("select * from $tabela order by $ordem");
			$sth -> execute();
	
			$result = $sth->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
 
		public static function atualizaChamado($tabela,$dados,$chamado){
			if($chamado){
				$sth = Conexao::getInstance() -> query("update $tabela set $dados where numero=$chamado");
			}else{
				echo "VocÃª nÃ£o selecionou nenhum chamado.";
			}
		}
		public static function atualiza2Bd($tabela,$dados,$where){
			$sth = Conexao::getInstance() -> prepare("update $tabela set $dados where $where");

			$sth -> execute();
		} 
		public static function consultaChamado2($tabela,$where){
			$sth = Conexao::getInstance() -> prepare("select * from $tabela where $where");
	
			$sth -> execute();
		//@$numero=strstr($where,'=',1);
			if(@$numero=='numero'){
				$resultado = $sth->fetch(PDO::FETCH_ASSOC);
			}else{
				$resultado = $sth->fetchAll(PDO::FETCH_ASSOC);
			}
			return $resultado;
		}
		public static function consultaChamado3($tabela,$where){
			$sth = Conexao::getInstance() -> prepare("select * from $tabela where $where");
	
			$sth -> execute();
			$resultado = $sth->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}
		public static function linhasBd($user){
			$sth = Conexao::getInstance() -> prepare("select * from usuarios where username=:user");
			$sth -> bindValue(':user',$user);
			$sth -> execute();

			$result = $sth->rowCount();
			return $result;
		}
		public static function linhas2Bd($tabela,$where){
			$sth = Conexao::getInstance() -> prepare("select * from $tabela where $where");
			$sth -> execute();

			$result = $sth->rowCount();
			return $result;
		}
		public static function gravaBd($codigo,$agora,$ip,$username){
			$sth = Conexao::getInstance() -> prepare("insert into acessos values(0,:codigo,:agora,:ip,:username)");
	
			$sth -> bindValue(':codigo',$codigo);
			$sth -> bindValue(':agora',$agora);
			$sth -> bindValue(':ip',$ip);
			$sth -> bindValue(':username',$username);
	
			$sth -> execute();
		}
		public static function grava2Bd($tabela,$dados){
			$sth = Conexao::getInstance() -> prepare("insert into $tabela values($dados)");

			$sth -> execute();
		}
		public static function usuariosChamados($chamado){
			$sth = Conexao::getInstance() -> prepare("select * from chamados INNER JOIN usuarios ON chamados.clientes=usuarios.username where numero=:chamado");
	
			$sth -> bindValue(':chamado',$chamado);
			$sth -> execute();
	
			$result = $sth -> fetch(PDO::FETCH_ASSOC);
			return $result;
		}
		public static function acessos($inicio,$fim,$complemento,$ordenado){
			if(!$inicio){
				$sth = Conexao::getInstance() -> query("select * from acessos inner join usuarios on acessos.login=usuarios.username and (data_in<=$fim ) order by acessos.$ordenado $complemento");
			}else{
				$sth = Conexao::getInstance() -> query("select * from acessos inner join usuarios on acessos.login=usuarios.username and (data_in>=$inicio and data_in<=$fim ) order by acessos.$ordenado $complemento");	
			}
			$result = $sth -> fetchAll(PDO::FETCH_ASSOC);
			//print_r($result);echo "result->$result sth->$sth";var_dump($result);
			return $result;
		}
		public static function buscaAcessos($cliente,$inicio,$fim,$complemento){
			$sth = Conexao::getInstance() -> query("select * from acessos inner join usuarios on acessos.login=usuarios.username and usuarios.username like '%$cliente%' and (data_in>=$inicio and data_in<=$fim) order by data_in $complemento");
	
			$result = $sth -> fetchAll(PDO::FETCH_ASSOC);
			return $result;	
		}
		public static function limpaTabela($tabela){
			$sth = Conexao::getInstance() -> query("truncate table $tabela");
		}
		public static function exclui($tabela,$where){
			if($where){
				$sth = Conexao::getInstance() -> query("DELETE FROM $tabela WHERE $where");
			}else{
				echo "Você não selecionou nenhum chamado.";
			}
		}

///////////////////////////////////////////////////////////////	
		public static function consultaBd($status,$inicio,$fim,$departamento){
  			if(isset($status) && ($status<>'T')){
				if(!isset($departamento)){
	  				if(!isset($inicio)&& !isset($fim)){
						$sth = Conexao::getInstance() -> prepare("select * from chamados where status=:status order by status,sla asc");
						$sth -> bindValue(':status',$status);
	  				}elseif(isset($inicio)&& !isset($fim)){
						$sth = Conexao::getInstance() -> prepare("select * from chamados where status=:status and (abertura>=:inicio) order by status,sla asc");
						$sth -> bindValue(':status',$status);
						$sth -> bindValue(':inicio',$inicio);				
	  				}elseif(!isset($inicio)&& isset($fim)){
						$sth = Conexao::getInstance() -> prepare("select * from chamados where status=:status and (abertura<=:fim) order by status,sla asc");
						$sth -> bindValue(':status',$status);
						$sth -> bindValue(':fim',$fim);				
	  				}elseif(isset($inicio)&& isset($fim)){
						$sth = Conexao::getInstance() -> prepare("select * from chamados where status=:status and (abertura>=:inicio and  abertura<=:fim) order by status,sla asc");
						$sth -> bindValue(':status',$status);
						$sth -> bindValue(':inicio',$inicio);
						$sth -> bindValue(':fim',$fim);			
	  				}else{
						$sth = Conexao::getInstance() -> prepare("select * from chamados where status=:status order by status,sla asc");
						$sth -> bindValue(':status',$status);
	  				}
				}else{
	  				if(isset($status) && $status<>'T'){
						if(!isset($inicio)&& !isset($fim)){
		  					$sth = Conexao::getInstance() -> prepare("select * from chamados where status=:status and departamento=:departamento order by status,sla asc");
		  					$sth -> bindValue(':departamento',$departamento);
		  					$sth -> bindValue(':status',$status);
						}elseif(isset($inicio)&& !isset($fim)){
		  					$sth = Conexao::getInstance() -> prepare("select * from chamados where status=:status and departamento=:departamento and (abertura>=:inicio) order by status,sla asc");
		  					$sth -> bindValue(':departamento',$departamento);
		  					$sth -> bindValue(':status',$status);
		  					$sth -> bindValue(':inicio',$inicio);				
						}elseif(!isset($inicio)&& isset($fim)){
		  					$sth = Conexao::getInstance() -> prepare("select * from chamados where status=:status and departamento=:departamento and (abertura<=:fim) order by status,sla asc");
		  					$sth -> bindValue(':departamento',$departamento);
		  					$sth -> bindValue(':status',$status);
		  					$sth -> bindValue(':fim',$fim);				
						}elseif(isset($inicio)&& isset($fim)){
		  					$sth = Conexao::getInstance() -> prepare("select * from chamados where status=:status and departamento=:departamento and (abertura>=:inicio and  abertura<=:fim) order by status,sla asc");
		  					$sth -> bindValue(':departamento',$departamento);
		  					$sth -> bindValue(':status',$status);
		  					$sth -> bindValue(':inicio',$inicio);
		  					$sth -> bindValue(':fim',$fim);				
						}else{
		  					$sth = Conexao::getInstance() -> prepare("select * from chamados where status=:status and departamento=:departamento order by status,sla asc");
		  					$sth -> bindValue(':departamento',$departamento);
		  					$sth -> bindValue(':status',$status);
						}
	  				}elseif($status=='T'){
						if(!isset($inicio)&& !isset($fim)){
		  					$sth = Conexao::getInstance() -> prepare("select * from chamados where departamento=:departamento order by status,sla asc");
		  					$sth -> bindValue(':departamento',$departamento);
						}elseif(isset($inicio)&& !isset($fim)){
		  					$sth = Conexao::getInstance() -> prepare("select * from chamados where departamento=:departamento and (abertura>=:inicio) order by status,sla asc");
		  					$sth -> bindValue(':departamento',$departamento);
		  					$sth -> bindValue(':inicio',$inicio);				
						}elseif(!isset($inicio)&& isset($fim)){
		  					$sth = Conexao::getInstance() -> prepare("select * from chamados where departamento=:departamento and (abertura<=:fim) order by status,sla asc");
		  					$sth -> bindValue(':departamento',$departamento);
		  					$sth -> bindValue(':fim',$fim);				
						}elseif(isset($inicio)&& isset($fim)){
		  					$sth = Conexao::getInstance() -> prepare("select * from chamados where departamento=:departamento and (abertura>=:inicio and  abertura<=:fim) order by status,sla asc");
		  					$sth -> bindValue(':departamento',$departamento);
		  					$sth -> bindValue(':inicio',$inicio);
		  					$sth -> bindValue(':fim',$fim);				
						}else{
		  					$sth = Conexao::getInstance() -> prepare("select * from chamados where departamento=:departamento order by status,sla asc");
		  					$sth -> bindValue(':departamento',$departamento);
						}
	  				}
				}
  			}elseif($status=='T'){
				if(!isset($departamento)){
	  				if(!isset($inicio)&& !isset($fim)){
						$sth = Conexao::getInstance() -> prepare("select * from chamados where (status=\"A\" or status=1 or status=2 or status=3 or status=4) order by status,sla asc");
	  				}elseif(isset($inicio)&& !isset($fim)){
						$sth = Conexao::getInstance() -> prepare("select * from chamados where (status='A' or status=1 or status=2 or status=3 or status=4) and (abertura>=:inicio) order by status,sla asc");
						$sth -> bindValue(':inicio',$inicio);				
	  				}elseif(!isset($inicio)&& isset($fim)){
						$sth = Conexao::getInstance() -> prepare("select * from chamados where (status='A' or status=1 or status=2 or status=3 or status=4) and (abertura<=:fim) order by status,sla asc");
						$sth -> bindValue(':fim',$fim);				
	  				}else{
						$sth = Conexao::getInstance() -> prepare("select * from chamados where (status='A' or status=1 or status=2 or status=3 or status=4) and (abertura>=:inicio and  abertura<=:fim) order by status,sla asc");
						$sth -> bindValue(':inicio',$inicio);
						$sth -> bindValue(':fim',$fim);			
	  				}
				}else{
	  				if(!isset($inicio)&& !isset($fim)){
						$sth = Conexao::getInstance() -> prepare("select * from chamados where departamento=:departamento and (status=\"A\" or status=1 or status=2 or status=3 or status=4) order by status,sla asc");
						$sth -> bindValue(':departamento',$departamento);
	  				}elseif(isset($inicio)&& !isset($fim)){
						$sth = Conexao::getInstance() -> prepare("select * from chamados where departamento=:departamento and (abertura>=:inicio) order by status,sla asc");
						$sth -> bindValue(':departamento',$departamento);
						$sth -> bindValue(':inicio',$inicio);				
	  				}elseif(!isset($inicio)&& isset($fim)){
						$sth = Conexao::getInstance() -> prepare("select * from chamados where departamento=:departamento and (abertura<=:fim) order by status,sla asc");
						$sth -> bindValue(':departamento',$departamento);
						$sth -> bindValue(':fim',$fim);				
	  				}else{
						$sth = Conexao::getInstance() -> prepare("select * from chamados where departamento=:departamento and (abertura>=:inicio and  abertura<=:fim) order by status,sla asc");
						$sth -> bindValue(':departamento',$departamento);
						$sth -> bindValue(':inicio',$inicio);
						$sth -> bindValue(':fim',$fim);				
	  				}			
				}	
  			}else{
				$sth = Conexao::getInstance() -> prepare("select * from chamados  order by status,sla asc");
  			}
   			$sth -> execute();
   			$result = $sth->fetchAll(PDO::FETCH_ASSOC);
   			return $result;
		}
		public static function usuariosBd($user){
			$sth = Conexao::getInstance() -> prepare("select * from usuarios where username=:user");
			$sth -> bindValue(':user',$user);
			$sth -> execute();
			$result = $sth->fetch(PDO::FETCH_ASSOC);
			return $result;
		}
}
/*
function conectaBd(){
	$pdo = new PDO("mysql:host=localhost;dbname=helpdesk","root","monica924");
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $pdo;
}
function closeBd($pdo) {
      $pdo=null;
		return $pdo;
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


// Quantidade de linhas encontradas


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
function consultaChamado3($tabela,$pdo,$where){
	$sth = $pdo -> prepare("select * from $tabela where $where");
	
	$sth -> execute();
	$resultado = $sth->fetch(PDO::FETCH_ASSOC);
	return $resultado;
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
		$sth = $pdo -> prepare("select * from chamados where clientes=:cliente and (status=\"A\" or status=1 or status=2 or status=3 or status=4) order by status,sla asc");
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



// Atualizar dados do banco 
function atualizaBd($pdo,$login,$senha,$agora){
	$sth = $pdo -> prepare("update usuarios set senha=:senha,last_upd=:agora where username=:login");
	
	$sth -> bindValue(':login',$login);
	$sth -> bindValue(':senha',$senha);
	$sth -> bindValue(':agora',$agora);
	
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
*/
?>