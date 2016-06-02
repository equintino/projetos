<html>
    <head></head>
    <body bgcolor=#4cb1f1>
<?php
include '../dao/UserDao.php';
include '../dao/UserSearchCriteria.php';
include '../config/Config.php';
include '../model/User.php';
include '../mapping/UserMapper.php';
class valida_cookies{
    public $login;
    public $senha;
    public $setor;
    public $index;
    
    function __construct(){
    }
    public function fazerLogin(){
        if(empty($this->login)){
	echo "<table width=100% height=80% border=0>";
	echo "<tr height=100%>";
	echo "<td width=100% colspan=3 valign=center align=center>";
	echo "<table border=1 bgcolor=#FFFFFF CELLSPACING=3 CELLPADDING=13><tr><td>";
	echo "<center><br><b><font face=tahoma size=2 color=black>Efetuar o login para obter acesso.<p>";
	echo "<center><input type=button value=\"Voltar\" onclick=\"location.href='index.html'\">";
	echo "</td></tr></table>";
	echo "</table>";
	echo "</td></tr></table>";
	echo "</html></body>";
	exit;
        }
    }
    public function setLogin($login){
            $this->login = $this->maiusculo($login);
    }
    public function getLogin(){
        return $this->login;
    }
    public function setSenha($senha){
        $this->senha = $senha;
    }
    public function getSenha(){
        return $this->senha;
    }
    public function setSetor($setor){
        $this->setor = $setor;
    }
    public function getSetor(){
        return $this->setor;
    }
    public function setIndex($index){
        $this->index = $index;
    }
    public function getIndex(){
        return $this->index;
    }
    public static function limpaCookies(){
	setcookie("login");
	setcookie("senha");
        unset ($_COOKIE['login'],$login);
        unset ($_COOKIE['senha'],$senha);
        unset ($_COOKIE['setor'],$setor);
    }
    public function semLogin(){
        $this->popup('Você deve entrar com o usuário.',null);
    }
    public function loginDb(){
        $dao = new UserDao();
        $search = new UserSearchCriteria();
        $search->setLogin($this->login);
        $user = $dao->find($search);
        foreach($user as $key => $item){
            $senhaDb = @$item->getSenha();
            if($senhaDb==$_COOKIE['senha']){
                $this->popup("Bem-Vindo ".$this->getlogin().".",'sim');
                exit;
            }else{
                $this->popup('A senha não confere.',null);
                exit;
            }
        }
        if(!$user){  
            $this->popup('Usuário não cadastrado.',null); 
        }
    }
    public function maiusculo($string){
	$string=strtoupper($string);
	$string=str_replace("б", "Б", $string);
	$string=str_replace("й", "Й", $string);
	$string=str_replace("н", "Н", $string);
	$string=str_replace("у", "У", $string);
	$string=str_replace("ъ", "Ъ", $string);
	$string=str_replace("в", "В", $string);
	$string=str_replace("к", "К", $string);
	$string=str_replace("ф", "Ф", $string);
	$string=str_replace("О", "I", $string);
	$string=str_replace("Ы", "U", $string);
	$string=str_replace("г", "Г", $string);
	$string=str_replace("х", "Х", $string);
	$string=str_replace("з", "З", $string);
	$string=str_replace("а", "A", $string);
	return $string;
    }
    public function popup($msg,$ok=null){
        echo "<table width=100% height=80% border=0>";
        echo "<tr height=100%>";
        echo "<td width=100% colspan=3 valign=center align=center>";
        echo "<table border=1 bgcolor=#FFFFFF CELLSPACING=3 CELLPADDING=13><tr><td>";
        echo "<center><br><b><font face=tahoma size=2 color=black>$msg<p>";
            if(!$ok){
                echo "<center><input type=button value=\"Voltar\" onclick=history.back()>";
            }else{
                echo "<center><input type=button value=\"Entrar\" onclick=\"location.href='index.php?index=sim'\">";
            }
        echo "</td></tr></table>";
        echo "</td></tr>";
        echo "</table>";
        echo "</td></tr></table>";
        echo "</html></body>";
        exit;
    }
}
?>
    </body>
</html>