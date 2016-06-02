<meta charset='utf-8'>
<script>
  var login=document.cookie;
//alert(login)
</script>
<?php
@$username=$_GET['username'];
if(!@$username){
  @$username=$_POST['username'];
}
include "divfunc.php";
if(!$username){
	@$username= maiusculo($_POST["nome_usuario"]);
}

include "valida_cookies.inc";
include "construct.php";


$cliente=$usuario['username'];
$nome_cliente=$usuario['nome'];
$tipo=$usuario["tipo"];
@$departamento=$usuario['departamento'];
@$chamado=$_POST["chamado"];
@$escolha=$_POST["escolha"];
@$ver=$_POST['ver'];
if (!$escolha){
	@$escolha=$_GET["escolha"];
	if (!$escolha){
		$escolha="numero";
	}
}
@$conta=$_GET["conta"];
@$data1=$_POST["data1"];
if (!$data1){
	@$data1=$_GET["data1"];
	if ($data1){
		if (strlen($data1)<10){
			$data1=null;
		}
	}
}
@$data2=$_POST["data2"];
if (!$data2){
	@$data2=$_GET["data2"];
	if ($data2){
		if (strlen($data2)<10){
			$data2=null;
		}
	}
}
@$status=$_POST["status"];
if (!$status){
		@$status=$_GET["status"];
	if (!$status && $cod_usuario==4){
		$status=1;
	}else{
		$status=4;
	}
}

if(!isset($inicio)){
	$inicio=null;
}
if(!isset($fim)){
	$fim=null;
}
$mes=mes(mktime(date ("m")));
if ((!$data1)&&(!$data2)){
	$data1=null;
	$data2=null;
}elseif (($data1)&&(!$data2)){
	$month1=substr($data1,3,2);
	$day1=substr($data1,0,2);
	$year1=substr($data1,6,4);
	@$inicio=mktime(0,0,0,"$month1","$day1","$year1");
	$data2=null;
}elseif ((!$data1)&&($data2)){
	$data1=null;
	$month2=substr($data2,3,2);
	$day2=substr($data2,0,2);
	$year2=substr($data2,6,4);
	@$fim=mktime(0,0,0,"$month2","$day2","$year2")+86400;
}elseif (($data1)&&($data2)){
	$month1=substr($data1,3,2);
	$day1=substr($data1,0,2);
	$year1=substr($data1,6,4);
	$month2=substr($data2,3,2);
	$day2=substr($data2,0,2);
	$year2=substr($data2,6,4);
	@$inicio=mktime(0,0,0,"$month1","$day1","$year1");
	@$fim=mktime(0,0,0,"$month2","$day2","$year2")+86400;
}
echo "<body onload=document.busca.cliente.focus()>";
echo "<form method=\"POST\" action=\"tabela2.php\" name=busca>";
echo "<input type=hidden name=username value=$username>";
echo "<input type=hidden name=tipo value=$tipo>";
echo "<table cellSpacing=0 cellPadding=0 width=100% border=0><tr>";
if(!isset($data1a) && !isset($data2a)){
	$data1a=null;
	$data2a=null;
}
echo "<td colspan=7><table border=0 width=100%><tr><td width=50%><font size=1 face=verdana>Mês Vigente: <b>$mes</td><td></td><td><font size=1>Data Inicial:</td><td><input type=text name=data1 onkeydown=\"mascaraData(this)\" size=10 maxlength=10 value=$data1a></td><td><font size=1>Data Final:</td><td><input type=text name=data2  size=10 onkeydown=\"mascaraData(this)\" maxlength=10 value=$data2a></td><td><input type=submit value=Filtra></td></tr></table></td></tr>";
echo "<td align=right valign=center><font size=1 face=verdana color=black><b>Situação: </td><td>&nbsp</td><td width=1%>";
echo "<select name=\"status\" size=\"1\" onchange=submit()>";
	if ($status==4){
		echo "<option value='4'><font size=2>SOLICITADO FECHAMENTO</option>";
		echo "<option value=''><font size=2></option>";
		echo "<option value='A'><font size=2>CHAMADO REABERTO</option>";
		echo "<option value='1'><font size=2>AGUARDANDO RETORNO</option>";
		echo "<option value='5'><font size=2>FECHADOS</option>";
		echo "<option value='2'><font size=2>PENDÊNCIA GERAL</option>";		
		echo "<option value='3'><font size=2>PENDÊNCIA TÉCNICA</option>";
		echo "<option value='4'><font size=2>SOLICITADO FECHAMENTO</option>";		
		echo "<option value='T'><font size=2>TODOS</option>";
	}
	if ($status=="T"){
		echo "<option value='T'><font size=2>TODOS</option>";
		echo "<option value=''><font size=2></option>";
		echo "<option value='A'><font size=2>CHAMADO REABERTO</option>";
		echo "<option value='1'><font size=2>AGUARDANDO RETORNO</option>";	
		echo "<option value='5'><font size=2>FECHADOS</option>";
		echo "<option value='2'><font size=2>PENDÊNCIA GERAL</option>";
		echo "<option value='3'><font size=2>PENDÊNCIA TÉCNICA</option>";
		echo "<option value='4'><font size=2>SOLICITADO FECHAMENTO</option>";
		echo "<option value='T'><font size=2>TODOS</option>";
	}
	if ($status==1){
		echo "<option value='1'><font size=2>AGUARDANDO RETORNO</option>";
		echo "<option value=''><font size=2></option>";
		echo "<option value='A'><font size=2>CHAMADO REABERTO</option>";
		echo "<option value='5'><font size=2>FECHADOS</option>";
		echo "<option value='2'><font size=2>PENDÊNCIA GERAL</option>";
		echo "<option value='3'><font size=2>PENDÊNCIA TÉCNICA</option>";
		echo "<option value='4'><font size=2>SOLICITADO FECHAMENTO</option>";
		echo "<option value='T'><font size=2>TODOS</option>";
	}
	if ($status==2){
		echo "<option value='2'><font size=2>PENDÊNCIA GERAL</option>";		
		echo "<option value=''><font size=2></option>";
		echo "<option value='A'><font size=2>CHAMADO REABERTO</option>";
		echo "<option value='1'><font size=2>AGUARDANDO RETORNO</option>";
		echo "<option value='5'><font size=2>FECHADOS</option>";
		echo "<option value='2'><font size=2>PENDÊNCIA GERAL</option>";		
		echo "<option value='3'><font size=2>PENDÊNCIA TÉCNICA</option>";
		echo "<option value='4'><font size=2>SOLICITADO FECHAMENTO</option>";
		echo "<option value='T'><font size=2>TODOS</option>";
	}
	if ($status==3){
		echo "<option value='3'><font size=2>PENDÊNCIA TÉCNICA</option>";
		echo "<option value=''><font size=2></option>";
		echo "<option value='A'><font size=2>CHAMADO REABERTO</option>";
		echo "<option value='1'><font size=2>AGUARDANDO RETORNO</option>";
		echo "<option value='5'><font size=2>FECHADOS</option>";
		echo "<option value='2'><font size=2>PENDÊNCIA GERAL</option>";				
		echo "<option value='3'><font size=2>PENDÊNCIA TÉCNICA</option>";
		echo "<option value='4'><font size=2>SOLICITADO FECHAMENTO</option>";
		echo "<option value='T'><font size=2>TODOS</option>";
	}
	if ($status==5){
		echo "<option value='5'><font size=2>FECHADOS</option>";
		echo "<option value=''><font size=2></option>";
		echo "<option value='A'><font size=2>CHAMADO REABERTO</option>";
		echo "<option value='1'><font size=2>AGUARDANDO RETORNO</option>";
		echo "<option value='5'><font size=2>FECHADOS</option>";
		echo "<option value='2'><font size=2>PENDÊNCIA GERAL</option>";				
		echo "<option value='3'><font size=2>PENDÊNCIA TÉCNICA</option>";
		echo "<option value='4'><font size=2>SOLICITADO FECHAMENTO</option>";
		echo "<option value='T'><font size=2>TODOS</option>";
	}
	if ($status=='A'){
		echo "<option value='A'><font size=2>CHAMADO REABERTO</option>";
		echo "<option value=''><font size=2></option>";
		echo "<option value='1'><font size=2>AGUARDANDO RETORNO</option>";
		echo "<option value='5'><font size=2>FECHADOS</option>";
		echo "<option value='2'><font size=2>PENDÊNCIA GERAL</option>";				
		echo "<option value='3'><font size=2>PENDÊNCIA TÉCNICA</option>";
		echo "<option value='4'><font size=2>SOLICITADO FECHAMENTO</option>";
		echo "<option value='T'><font size=2>TODOS</option>";
	}
$hein=$_GET["hein"];
$hein=(!$hein);
if ($hein){
	$complemento="desc";
}else{
	$complemento=null;	
}
echo "</select>";
echo "</td></tr></table>";

	if(@$cod_usuario != 4 && @$cod_usuario != 1){
		$resultado=Conexao::consultaBd($status,$inicio,$fim,$departamento);
		//$resultado=consultaBd($status,$pdo,$inicio,$fim,$cliente);
	}else{
		$resultado=Conexao::consultaBd($status,$inicio,$fim,null);
		//$resultado=consultaBd($status,$pdo,$inicio,$fim,null);	
	}

echo "<center><table cellspacing=0 cellpadding=3 rules=cols PageCount=1 bordercolor=lightskyblue border=4 id=\"ItemsGrid\" style=\"color:Black;background-color:lightskyblue;border-color:lightskyblue;border-width:1px;border-style:None;font-family:Verdana;font-size:XX-Small;width:100%;border-collapse:collapse;\">";
echo "<tr>";
echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"300;URL=tabela2.php\">";
echo "<td align=left><table cellpadding=0 cellspacing=0 border=0 height=1 width=100% bgcolor=lightskyblue><td width=50%><font size=1 face=verdana>&nbsp";
$nomStatus=statusChamado($status);
$linhas=count($resultado);
if(!isset($linhas)){
	$linhas=null;
}
echo "</td><td align=right width=50%><font size=1 face=verdana>Total: <b>$linhas</b> chamados $nomStatus</td></table></td>";
echo "<br><table width='100%' bgcolor=#336699 height='20px' border=0 cellspacing='2' cellpadding='0'><tr><td align='center' width=7%><font size=1 face=verdana color=white>Chamado</font></td><td width=19% align='center'><font size=1 face=verdana color=white>Cliente</font></td><td width=8% align='center'><font size=1 face=verdana color=white>Data Abertura</font></td><td align='center'><font size=1 face=verdana color=white>Descrição Breve</font></td><td align='center' width=8%><font size=1 face=verdana color=white>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspAgente</font></td><td align=center><font size=1 face=verdana color=white >Status&nbsp&nbsp&nbsp&nbsp</td><td width=7% align='center'><font size=1 face=verdana color=white >Fila</font></td></tr></table>";
echo "<table cellspacing=0 cellpaddin=0 border=2 width=100%>";
if (!@$linhas){
	echo "<tr><td><table width=100% border=0 bgcolor=#DEDFDE><td align=center>Não existem chamados com a descrição solicitada.</td></table></td></tr>";
	exit;
}
	$i=0;
	foreach($resultado as $chaves => $itens){
	$desc='';
	if ($i%2==0){
		$color="#DEDFDE";
	}else{
		$color="silver";
	}
	$i++;
	$codigo=$itens['codigo'];
	@$sla=$itens['sla'];
	@$cliente=$itens['clientes'];
	
	$reg2=Conexao::usuariosBd($cliente);
	$nome_clienteBd=($reg2['nome']);
	
	if(!isset($nome_clienteBd)){
		$nome_clienteBd=maiusculo("Cliente foi excluído");
	}
	
	$agente=$itens['agente'];
	@$desc=substr($itens['descricao'],0,40);
	$chamado=$itens['numero'];
	$cor="black";
	$statusBd=$itens['status'];
	
	$nomStatusBd=statusChamado($statusBd);
	
	if($status=='A'){
		$color=corChamado(0);
	}
		$color=corChamado($statusBd);
	$data_abre=substr(timestamp_para_humano($itens['abertura']),0,10);
	if ($status==2){
		$cor3="red";
	}else{
		$cor3="black";
	}
	if ($nome_clienteBd==$username){
		$cor2="red";
	}else{
		$cor2="black";
	}	
	echo "<tr height=50%>";
	$fant='';
	echo "<td><table bgcolor=$color height=100% width=100% border=0 cellspacing=0 cellpadding=0><tr align=center onmouseover=\"this.style.backgroundColor='cyan';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: $color\" onmouseout=\"this.style.backgroundColor='$color';\" onclick=\"link('det2.php?sla=$sla&tipo=$tipo&escolha=$escolha&cliente=$cliente&data1=$data1&data2=$data2&chamado=$chamado&statusBd=$statusBd&username=$username&tipo=$tipo','_self')\"><td align=center width=7%><font size=1 face=verdana>$chamado</font></td><td width=19% ><font size=1 color=$cor2 face=verdana>$nome_clienteBd</td><td  align=center width=8%><font size=1 face=verdana>$data_abre</font></td><td align=left ><font size=1 face=verdana>&nbsp&nbsp$desc</font></td><td align='center' width=10%><font size=1 face=verdana color=$cor >$agente</font></td><td align=left width=15%><font size=1 face=verdana color=$cor3>$nomStatusBd</td><td align='center' width=7%><font size=1 face=verdana>$sla</td></tr></table></td>";
}
echo "</tr></table>";
echo "</table></table>";
echo "<tr><td><table border=0 bgcolor=white width=100%><td align=center><font face=verdana size=1 color=red><B>TECNOLOGIA DA INFORMAÇÃO</td></table></td>";
echo "</tr></table></td></tr></table><BR>";
//mysql_close($conexao);
?>