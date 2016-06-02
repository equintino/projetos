<meta charset='utf-8'>
<?php
function cod_usuario($cod_usuario){
	switch($cod_usuario){
			case 1:
				$funcao_usuario='Diretoria';
				break;
			case 2:
				$funcao_usuario='Gerência';
				break;
			case 3:
				$funcao_usuario='Funcionário';
				break;
			case 4:
				$funcao_usuario='Técnico';
				break;
			default:
				$funcao_usuario=$cod_usuario;
				break;		
		}	
		return $funcao_usuario;
}
function corChamado($status){
	switch($status){
		case 0:
		$color='gold';
		break;
		case 1:
		$color='yellow';
		break;
		case 2:
		$color='#F34616';
		break;
		case 3:
		$color='#1EEE8D';
		break;
		case 4:
		$color='white';
		break;
		case 5:
		$color='#A8BEC1';
		break;
	}
	return $color;
}
function sla($tempo,$severidade){
	$soma=$tempo+$severidade;
	switch($soma){
		case 6:
		$nivelSla="Nível 6";
		break;
		case 5:
		$nivelSla="Nível 5";
		break;
		case 4:
		$nivelSla="Nível 4";
		break;
		case 3:
		$nivelSla="Nível 3";
		break;
		case 2:
		$nivelSla="Nível 2";
		break;
		case 1:
		$nivelSla="Nível 1";
		break;
	}
	return @$nivelSla;
}
function statusChamado($status){
	if($status=='A'){
		$status=0;
	}elseif($status=='T'){
		$status=6;
	}
	switch($status){
		case 0:
			$nome_status='CHAMADO REABERTO';
			break;
		case 1:
			$nome_status='AGUARDANDO RETORNO';
			break;
		case 2:
			$nome_status='PENDÊNCIA GERAL';
			break;
		case 3:
			$nome_status='PENDÊNCIA TÉCNICA';
			break;
		case 4:
			$nome_status='SOLICITADO FECHAMENTO';
			break;
		case 5:
			$nome_status='FECHADO';
			break;
		default:
			$nome_status='TODOS';
			break;
	}
			return $nome_status;
}
function minusculo($string){
	$string=strtolower($string);
	$string=str_replace("Á", "á", $string);
	$string=str_replace("É", "é", $string);
	$string=str_replace("Í", "í", $string);
	$string=str_replace("Ó", "ó", $string);
	$string=str_replace("Ú", "ú", $string);
	$string=str_replace("Â", "â", $string);
	$string=str_replace("Ê", "ê", $string);
	$string=str_replace("Ô", "ô", $string);
	$string=str_replace("Î", "i", $string);
	$string=str_replace("Û", "u", $string);
	$string=str_replace("Ã", "ã", $string);
	$string=str_replace("Õ", "õ", $string);
	$string=str_replace("Ç", "ç", $string);
	$string=str_replace("À", "à", $string);
	return $string;
}
function maiusculo($string){
	$string=strtoupper($string);
	$string=str_replace("á", "Á", $string);
	$string=str_replace("é", "É", $string);
	$string=str_replace("í", "Í", $string);
	$string=str_replace("ó", "Ó", $string);
	$string=str_replace("ú", "Ú", $string);
	$string=str_replace("â", "Â", $string);
	$string=str_replace("ê", "Ê", $string);
	$string=str_replace("ô", "Ô", $string);
	$string=str_replace("Î", "I", $string);
	$string=str_replace("Û", "U", $string);
	$string=str_replace("ã", "Ã", $string);
	$string=str_replace("õ", "Õ", $string);
	$string=str_replace("ç", "Ç", $string);
	$string=str_replace("à", "A", $string);
	return $string;
}
function mes($data){
	$mes=substr(timestamp_para_humano($data),3,2);
	if ($mes=="01"){
		$mes="Janeiro";
	}
	if ($mes=="02"){
		$mes="Fevereiro";
	}
	if ($mes=="03"){
		$mes="Março";
	}		
	if ($mes=="04"){
		$mes="Abril";
	}
	if ($mes=="05"){
		$mes="Maio";
	}
	if ($mes=="06"){
		$mes="Junho";
	}
	if ($mes=="07"){
		$mes="Julho";
	}
	if ($mes=="08"){
		$mes="Agosto";
	}
	if ($mes=="09"){
		$mes="Setembro";
	}
	if ($mes=="10"){
		$mes="Outubro";
	}
	if ($mes=="11"){
		$mes="Novembro";
	}
	if ($mes=="12"){
		$mes="Dezembro";
	}
	return $mes;
}
// Converte formato TIMESTAMP do Unix para o humano 
// 1072834230 -> 30/12/2003 23:30:59 
function timestamp_para_humano($ts){        
        @$d=getdate($ts); 
        $yr=$d["year"]; 
        $mo=$d["mon"]; 
        $da=$d["mday"]; 
        $hr=$d["hours"]; 
        $mi=$d["minutes"]; 
        $se=$d["seconds"]; 
        return date("d/m/Y H:i", mktime($hr,$mi,$se,$mo,$da,$yr)); 
} 
function Dataatual(){
   $date = getDate();
   foreach($date as $item=>$value) {
       if ($value < 10){
           $date[$item] = "0".$value;
	   }
   }
   return $date['mday']."/".$date['mon']."/".$date['year'];
}
function Horaatual(){
   $date = getDate();
   foreach($date as $item=>$value) {
       if ($value < 10){
           $date[$item] = "0".$value;
	   }
   }
   return $date['hours'].":".$date['minutes'];
}
function add_ano($data){
	$len=strlen($data);
	if ($len==6){
		$ano=substr(timestamp_para_humano(mktime()),6,4);
		return $data.$ano;
	}else{
		return $data;
	}
} 
function check_data($data){
	$len=strlen($data);
	for($i=0;$i<$len;$i++){
		$char=substr($data,$i,1);
		if (($i!=2)&&($i!=5)&&($char=="/")){
			return 2;
		}
	}
	return 1;
}
/*
function checa_centavos($valor){
	$tam=strlen($valor);
	for ($i=$tam;$i>=0;$i--){
		$cara=substr($valor,$i,1);
			if ($cara=="."){
				if ($tam-$i==2){
					$valor=$valor."0";
				}
				if ($tam-$i>3){
					$size=$i+3;
					$ultimo=substr($valor,$size,1);
					if ($ultimo>5){
						$valor=(substr($valor,0,$size)+(0.01));
					}else{
						$valor=substr($valor,0,$size);
					}
				}
			}
	}
	return $valor;	
}
function exec_valor($valor){
	if ($valor){
		$valor=checa_centavos($valor);
		$valor=reais($valor);
	}
	return $valor;
}
function dif($inicio,$fim){
	$hora1=substr(timestamp_para_humano($inicio),11,2);
	$min1=substr(timestamp_para_humano($inicio),14,2);
	$fim=mktime($hora,$min);//,$month,$day,$year);
	$hora2=substr(timestamp_para_humano($fim),11,2);
	$min2=substr(timestamp_para_humano($fim),14,2);
	
	if ($min2<$min1){
		$horadif=$hora2-$hora1-1;
	}else{
		$horadif=$hora2-$hora1;
	}
	if ($horadif<10){	
		$horadif="0".$horadif;
	}
	if ($min2<$min1){
		$mindif=60-($min1-$min2);
	}else{
		$mindif=$min2-$min1;
	}
	if ($mindif<10)	{
		$mindif="0".$mindif;
	}
		$dif="$horadif:$mindif";
	return $dif;
}
function hora($valor){
	$tamanho=strlen($valor);
	for ($i=0;$i<$tamanho;$i++){
		$ponto=substr($valor,$i,1);
		if ($ponto=="."){
			$posicao=$i;
			$i=$tamanho;
		}
	}
	$hora=substr($valor,0,$posicao);
	return $hora;
}
function hora2($valor){
	if (($valor>0)&&($valor<1)){
		return 1;
	}
	$tamanho=strlen($valor);
	$posicao=0;
	for ($i=0;$i<$tamanho;$i++){
		$ponto=substr($valor,$i,1);
		if ($ponto=="."){
			$posicao=$i;
			$i=$tamanho;
		}
	}
	$extra=substr($valor,$posicao+1,2);
	if (strlen($extra)<2){
		$extra=$extra."0";
	}
	$hora=substr($valor,0,$posicao);
	if ($extra>=25){
		$hora=$hora+1;
	}
	if (!$posicao){
		return $valor;
	}
	return $hora;
}
function so_data($data){
	$data= substr($data,0,10);
	return $data;
}
function moeda($valor){
	$tipo = substr($valor,strlen($valor)-3,1);
	if ($tipo=="."){
		$valor1 = str_replace (",", "", $valor);
	}else{
		if ($tipo==","){
			$len1=strlen($valor);
			$valor1 = str_replace (".", "", $valor);
			$valor1 = str_replace (",", ".", $valor1);
		}else{
			$valor1=$valor;
		}
	}
	return $valor1;
}
function formataMilhar($valor){
	$len=strlen($valor);
	switch ($len){
		case "1":
			$retorna=$valor;
			break;
		case "2":
			$retorna=$valor;
			break;
		case "3":
			$retorna=$valor;
			break;
		case "4":
			$parte1=substr($valor,0,1);
			$parte2=substr($valor,1,4);
			$valor="$parte1.$parte2";
			$retorna=$valor;
			break;	
		case "5":
			$parte1=substr($valor,0,2);
			$parte2=substr($valor,2,5);
			$valor="$parte1.$parte2";
			$retorna=$valor;
			break;
		case "6":
			$parte1=substr($valor,0,3);
			$parte2=substr($valor,3,6);
			$valor="$parte1.$parte2";
			$retorna=$valor;
			break;	
		case "7":
			$parte1=substr($valor,0,1);
			$parte2=substr($valor,1,4);
			$parte3=substr($valor,4,7);
			$valor="$parte1.$parte2.$parte3";
			$retorna=$valor;
			break;
	}
	return $retorna;
}		
function reais($valor1){
    $len1 = strlen ($valor1); 
    $valor1 = str_replace (".", "", $valor1);
	$valor1 = str_replace (",", "", $valor1);
    $len2 = strlen ($valor1);
	
    if ($len1==$len2){
	    switch ($len1){
        case "1":
            $retorna = "$valor1,00";
            break;
        case "2":
            $retorna = "$valor1,00";
            break;
        case "3":
            $retorna = "$valor1,00";
            break;
        case "4":
            $d1 = substr("$valor1",0,1);
            $d2 = substr("$valor1",1,4);
            $retorna = "$d1.$d2,00";
            break;
        case "5":
            $d1 = substr("$valor1",0,2);
            $d2 = substr("$valor1",2,5);
            $retorna = "$d1.$d2,00";
            break;
        case "6":
            $d1 = substr("$valor1",0,3);
            $d2 = substr("$valor1",3,6);
            $retorna = "$d1.$d2,00";
            break;       
        case "7":
            $d1 = substr("$valor1",0,1);
            $d2 = substr("$valor1",2,3);
            $d3 = substr("$valor1",4,5);
            $retorna = "$d1.$d2.$d3,00";
            break;
	    }
	}else{

		switch ($len2){

			case "2":
				$retorna = "0,$valor1";
				break;
			case "3":
				$d1 = substr("$valor1",0,1);
				$d2 = substr("$valor1",-2,2);
				$retorna = "$d1,$d2";
				break;
			case "4":
				$d1 = substr("$valor1",0,2);
				$d2 = substr("$valor1",-2,2);
				$retorna = "$d1,$d2";
				break;
			case "5":
				$d1 = substr("$valor1",0,3);
				$d2 = substr("$valor1",-2,2);
				$retorna = "$d1,$d2";
				break;
			case "6":
				$d1 = substr("$valor1",1,3);
				$d2 = substr("$valor1",-2,2);
				$d3 = substr("$valor1",0,1);
				$retorna = "$d3.$d1,$d2";
				break;
			// 7 : 99.999,99 reais
			case "7":
				$d1 = substr("$valor1",2,3);
				$d2 = substr("$valor1",-2,2);
				$d3 = substr("$valor1",0,2);
				$retorna = "$d3.$d1,$d2";
				break;
			// 8 : 999.999,99 reais
			case "8":
				$d1 = substr("$valor1",3,3);
				$d2 = substr("$valor1",-2,2);
				$d3 = substr("$valor1",0,3);
				$retorna = "$d3.$d1,$d2";
				break;
		}
    }
    return $retorna;
}
function reais_sql($valor1){
	$valor1 = str_replace (".", "", $valor1);
    $valor1 = str_replace (",", "", $valor1);
    $len = strlen ($valor1);
    switch ($len) {
        case "2":
            $retorna = "0.$valor1";
            break;
        case "3":
            $d1 = substr("$valor1",0,1);
            $d2 = substr("$valor1",-2,2);
            $retorna = "$d1.$d2";
            break;
        case "4":
            $d1 = substr("$valor1",0,2);
            $d2 = substr("$valor1",-2,2);
            $retorna = "$d1.$d2";
            break;
        case "5":
            $d1 = substr("$valor1",0,3);
            $d2 = substr("$valor1",-2,2);
            $retorna = "$d1.$d2";
            break;
        case "6":
            $d1 = substr("$valor1",1,3);
            $d2 = substr("$valor1",-2,2);
            $d3 = substr("$valor1",0,1);
            $retorna = "$d3,$d1.$d2";
            break;
        // 7 : 99.999,99 reais
        case "7":
            $d1 = substr("$valor1",2,3);
            $d2 = substr("$valor1",-2,2);
            $d3 = substr("$valor1",0,2);
            $retorna = "$d3,$d1.$d2";
            break;
        // 8 : 999.999,99 reais
        case "8":
            $d1 = substr("$valor1",3,3);
            $d2 = substr("$valor1",-2,2);
            $d3 = substr("$valor1",0,3);
            $retorna = "$d3,$d1.$d2";
            break;
    } // Fim Switch

    // Por fim , retorna o resultado já formatado
    return $retorna;
} // Fim da function
function formataReais($valor1, $valor2, $operacao){
    // Antes de tudo , arrancamos os "," e os "." dos dois valores passados a função . Para isso , podemos usar str_replace :
    $valor1 = str_replace (",", "", $valor1);
    $valor1 = str_replace (".", "", $valor1);

    $valor2 = str_replace (",", "", $valor2);
    $valor2 = str_replace (".", "", $valor2);

    // Agora vamos usar um switch para determinar qual o tipo de operação que foi definida :
    switch ($operacao) {
        // Adição :
        case "+":
            $resultado = $valor1 + $valor2;
            break;
        // Subtração :
        case "-":
            $resultado = $valor1 - $valor2;
            break;
        // Multiplicação :
        case "*":
            $resultado = $valor1 * $valor2;
            break;
    } // Fim Switch

    // Calcula o tamanho do resultado com strlen
    $len = strlen ($resultado);
    // Novamente um switch , dessa vez de acordo com o tamanho do resultado da operação ($len) :
    // De acordo com o tamanho de $len , realizamos uma ação para dividir o resultado e colocar
    // as vírgulas e os pontos
    switch ($len) {
        // 2 : 0,99 centavos
        case "2":
            $retorna = "0,$resultado";
            break;
        // 3 : 9,99 reais
        case "3":
            $d1 = substr("$resultado",0,1);
            $d2 = substr("$resultado",-2,2);
            $retorna = "$d1,$d2";
            break;
        // 4 : 99,99 reais
        case "4":
            $d1 = substr("$resultado",0,2);
            $d2 = substr("$resultado",-2,2);
            $retorna = "$d1,$d2";
            break;
        // 5 : 999,99 reais
        case "5":
            $d1 = substr("$resultado",0,3);
            $d2 = substr("$resultado",-2,2);
            $retorna = "$d1,$d2";
            break;
        // 6 : 9.999,99 reais
        case "6":
            $d1 = substr("$resultado",1,3);
            $d2 = substr("$resultado",-2,2);
            $d3 = substr("$resultado",0,1);
            $retorna = "$d3.$d1,$d2";
            break;
        // 7 : 99.999,99 reais
        case "7":
            $d1 = substr("$resultado",2,3);
            $d2 = substr("$resultado",-2,2);
            $d3 = substr("$resultado",0,2);
            $retorna = "$d3.$d1,$d2";
            break;
        // 8 : 999.999,99 reais
        case "8":
            $d1 = substr("$resultado",3,3);
            $d2 = substr("$resultado",-2,2);
            $d3 = substr("$resultado",0,3);
            $retorna = "$d3.$d1,$d2";
            break;
    } // Fim Switch

    // Por fim , retorna o resultado já formatado
    return $retorna;
} // Fim da function
function datahora_para_humano($dt){ 
        $yr=strval(substr($dt,0,4)); 
        $mo=strval(substr($dt,5,2)); 
        $da=strval(substr($dt,8,2)); 
        $hr=strval(substr($dt,11,2)); 
        $mi=strval(substr($dt,14,2)); 
        return date("d/m/Y H:i:s", mktime ($hr,$mi,0,$mo,$da,$yr)); 
} 
// Converte formato TIMESTAMP do MySQL para o humano 
// 20031230233029 -> 30/12/2003 23:30:59 
function mysql_timestamp_para_humano($dt){         
        $yr=strval(substr($dt,0,4)); 
        $mo=strval(substr($dt,4,2)); 
        $da=strval(substr($dt,6,2)); 
        $hr=strval(substr($dt,8,2)); 
        $mi=strval(substr($dt,10,2)); 
        $se=strval(substr($dt,12,2));  
        return date("d/m/Y H:i:s", mktime ($hr,$mi,$se,$mo,$da,$yr)); 
} 
function data_year($ts){         
        $d=getdate($ts); 
        $yr=$d["year"]; 
        return $yr;
} 
function data_month($ts){         
        $d=getdate($ts); 
        $mo=$d["month"]; 
        return $mo;
} 
function data_day($ts){         
        $d=getdate($ts); 
        $day=$d["day"]; 
        return $day;
} 
function timestamp_hora_para_humano($ts){         
        $d=getdate($ts); 
        $yr=$d["year"]; 
        $mo=$d["mon"]; 
        $da=$d["mday"]; 
        $hr=$d["hours"]; 
        $mi=$d["minutes"]; 
        $se=$d["seconds"]; 
        return date("H:i", mktime($hr,$mi,$se,$mo,$da,$yr)); 
} 
function horas($hora){
	$recebi= 86400-$hora;
	$today= getdate($recebi);
	
	return $today['hours'].":".$today['minutes'];
	
}
function prazofinal($hora){
//	$recebi= 86400-$hora;
	$today= getdate($recebi);
	
	return $today['hours'].":".$today['minutes'];
	
}

function cliente($chamado,$local,$tipo){
	if (!$chamado){
		echo "<b><font size=2 face=verdana>Chamados Cadastrados:<p><center>";
		$resultado=mysql_query("select * from chamados order by sla");
		$linhas=mysql_num_rows($resultado);
		echo "<table width=100%bgcolor=#336699 height='20px' border=0 cellspacing='0' cellpadding='0'>";
		if (!$linhas){
			echo "Não existem registros.";
			exit;
		}else{
			echo "<tr bgcolor=LIGHTSKYBLUE ><td align=center width=7%><font size=1 face=verdana><b>CHAMADO</b></td><td align=center><font size=1 face=verdana ><b>DESCRIÇÃO</b></td><td width=23% align=center><b><font size=1 face=verdana><b>CLIENTE</b></td><td width=8% align=center><font size=1 face=verdana><b>AGENTE</b></td><td align=center width=7%><font size=1 face=verdana><b>FILA</b></td></tr>";
			for ($i=0;$i<$linhas;$i++){
			// Alternar nas cores de fundo numa tabela
				if ($i%2==0){
					$color="#DEDFDE";
				}else{
					$color="silver";
				}
			// fim Alternar cor
				$reg=mysql_fetch_row($resultado);
				$codigo=$reg[3];
				$sla=$reg[11];
				$descricao=$reg[7];	
				$agente=$reg[2];
				$clienteBd=$reg[5];
				$chamado=$reg[0];
				@$cliente=$_GET['cliente'];
				$resultado2=mysql_query("select nome from usuarios where username=\"$clienteBd\"");
				@$nome_cliente=mysql_result($resultado2,0,"nome");
					if ($tipo==1){
						echo "<tr onmouseover=\"this.style.backgroundColor='yellow';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: white\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"link('clientes.php?act=$local&nome=$nome_cliente&codigo=$codigo&chamado=$chamado','_self')\"><td align=center><font size=1 face=verdana>$codigo</td><td><font size=1 face=verdana>$descricao</td><td align=center><font size=1 face=verdana width=20%>$nome_cliente</td><td align=center><font size=1 face=verdana>$agente</td></tr>";
					}
					if ($tipo==2){
						echo "<tr onmouseover=\"this.style.backgroundColor='cyan';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: $color\" onmouseout=\"this.style.backgroundColor='$color';\" onclick=\"link('clientes.php?act=$local&nome_cliente=$nome_cliente&codigo=$codigo&chamado=$chamado&cliente=$cliente','_self')\"><td align=center><font size=1 face=verdana>$chamado</td><td><font size=1 face=verdana>$descricao</td><td align=center><font size=1 face=verdana width=20%>$nome_cliente</td><td align=center><font size=1 face=verdana>$agente</td><td align=center><font size=1 face=verdana>$sla</td></tr>";
					}
//				}
				}
			echo "</table>";
			exit;
		}
	}else{
		@$chamado=$_GET['chamado'];
		@$cliente=$_GET['cliente'];
		$resultado=mysql_query("SELECT * from chamados where numero like '$chamado' order by sla");
		@$clienteBd=mysql_result($resultado,0,'clientes');
		$resultado2=mysql_query("select nome from usuarios where username='$clienteBd'")or die(mysql_error());
		@$nome_usuarioBd=mysql_result($resultado2,0,"nome");
		$linhas=mysql_num_rows($resultado);
		if (!$linhas){
			$resultado=mysql_query("SELECT * from chamados where numero='$chamado' order by sla");
			$linhas=mysql_num_rows($resultado);		
		}
		if ($linhas==0){
			echo "<b>Chamado não encontrado. Tente na lista abaixo.<BR><BR><input type=button value='Abrir Chamado' onclick=\"location.href='clientes.php?act=cad'\"><p><center>";
			$resultado=mysql_query("select * from chamados where clientes='$cliente' order by sla");
			$resultado2=mysql_query("select nome from usuarios where username='$cliente'")or die(mysql_error());
			$linhas=mysql_num_rows($resultado);
			echo "<table border=0 cellpadding=0 cellspacing=0 width=100%>";
			if (!$linhas){
				echo "Não existem registros.";
				exit;
			}else{			
				echo "<tr bgcolor=LIGHTSKYBLUE ><td align=center width=7%><font size=1 face=verdana><b>CHAMADO</b></td><td align=center><font size=1 face=verdana><b>DESCRIÇÃO</b></td><td width=23% align=center><font size=1 face=verdana><b>CLIENTE</b></td><td width=8% align=center><font size=1 face=verdana><b>AGENTE</b></td><td align=center width=7%><font size=1 face=verdana><b>FILA<b></td></tr>";			
				for ($i=0;$i<$linhas;$i++){
					$reg=mysql_fetch_row($resultado);
					$codigo=$reg[3];
					$descricao=$reg[7];	
					$agente=$reg[2];
					$clienteBd=$reg[5];
					$chamado=$reg[0];
					$sla=$reg[11];
					$cliente=$_GET['cliente'];	
					$nome=$reg[0];
					$nome_cliente=mysql_result($resultado2,0,'nome');
		// Alternar nas cores na tabela
			if ($i%2==0){
				$color="#DEDFDE";
			}else{
				$color="silver";
			}
		// fim cores
				if ($nome!="ASSUNTOS INTERNOS"){
					if ($tipo==1){
						echo "<tr onmouseover=\"this.style.backgroundColor='cyan';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: $color\" onmouseout=\"this.style.backgroundColor='$color';\" onclick=\"link('clientes.php?act=$local&nome=$nome&codigo=$codigo','_self')\"><td align=center><font size=1 face=verdana>$sla</td><td><font size=1 face=verdana>$nome</td><td align=center><font size=1 face=verdana>$fantasia</td></tr>";
					}
					if ($tipo==2){
						echo "<tr onmouseover=\"this.style.backgroundColor='cyan';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: $color\" onmouseout=\"this.style.backgroundColor='$color';\" onclick=\"link('clientes.php?act=$local&nome=$nome&codigo=$codigo&chamado=$chamado&cliente=$cliente','_self')\"><td align=center><font size=1 face=verdana>$chamado</td><td><font size=1 face=verdana>$descricao</td><td align=center><font size=1 face=verdana>$nome_cliente</td><td align=center><font size=1 face=verdana>$agente</td><td align=center><font size=1 face=verdana>$sla</td></tr>";
					}
				}
			}
				echo "</table>";
				exit;
			}
		}else{
			if ($linhas>1){
				echo "<b>Existe mais de um cliente com essa descrição.  Escolha na lista abaixo.<p><center>";
				$resultado=mysql_query("select * from clientes where nome like '%$nome%' order by nome");
				$linhas=mysql_num_rows($resultado);
				echo "<table border=1 cellpadding=1 cellspacing=1 width=100%>";
				echo "<tr bgcolor=LIGHTSKYBLUE ><td align=center width=7%><font size=1 face=verdana><b>CÓDIGO</td><td width=70% align=center><b><font size=1 face=verdana>NOME / RAZÃO SOCIAL</td><td width=20% align=center><b><font size=1 face=verdana>APELIDO</td></tr>";
				for ($i=0;$i<$linhas;$i++){	
					$reg=mysql_fetch_row($resultado);
					$nome=$reg[0];
					$codigo=$reg[5];
					$fantasia=$reg[11];			
				if ($nome!="ASSUNTOS INTERNOS"){
				if (!$fantasia){
					$fantasia="&nbsp";
				}
					if ($tipo==1){
						echo "<tr onmouseover=\"this.style.backgroundColor='yellow';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: white\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"link('clientes.php?act=$local&nome=$nome&codigo=$codigo','_self')\"><td align=center><font size=1 face=verdana>$codigo</td><td><font size=1 face=verdana>$nome</td><td align=center><font size=1 face=verdana>$fantasia</td></tr>";
					}
					if ($tipo==2){
						echo "<tr onmouseover=\"this.style.backgroundColor='yellow';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: white\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"link('clientes2.php?act=$local&nome=$nome&codigo=$codigo','_self')\"><td align=center><font size=1 face=verdana>$codigo</td><td><font size=1 face=verdana>$nome</td><td align=center><font size=1 face=verdana>$fantasia</td></tr>";	
					}
				}
				}
				echo "</table>";
				exit;
			}else{
				return $nome_usuarioBd;
			}
		}
	}
}

function cliente2($nome,$local,$tipo){
	if (!$nome){
		echo "<b><font size=2 face=verdana>Clientes Cadastrados:<p><center>";
		$resultado=mysql_query("select * from clientes order by nome");
		$linhas=mysql_num_rows($resultado);
		echo "<table border=1 cellpadding=1 cellspacing=1 width=100%>";
		if (!$linhas){
			echo "Não existem registros.";
			exit;
		}else{
			echo "<tr bgcolor=LIGHTSKYBLUE ><td align=center width=7%><font size=1 face=verdana><b>CÓDIGO</td><td width=70% align=center><b><font size=1 face=verdana>NOME / RAZÃO SOCIAL</td><td width=20% align=center><b><font size=1 face=verdana>APELIDO</td></tr>";
			for ($i=0;$i<$linhas;$i++){
				$reg=mysql_fetch_row($resultado);
				$nome=$reg[0];
				$codigo=$reg[5];
				$fantasia=$reg[11];
				if ($nome!="ASSUNTOS INTERNOS"){
				if (!$fantasia){
					$fantasia="&nbsp";
						echo "<tr onmouseover=\"this.style.backgroundColor='yellow';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: white\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"link('cham.php?act=$local&nome=$nome&codigo=$codigo','_self')\"><td align=center><font size=1 face=verdana>$codigo</td><td><font size=1 face=verdana>$nome</td><td align=center><font size=1 face=verdana>$fantasia</td></tr>";
				}
			}
			}
			echo "</table>";
			exit;
		}
	}else{
		$resultado=mysql_query("SELECT * from clientes where nome like '%$nome%' order by nome");
		$linhas=mysql_num_rows($resultado);
		if (!$linhas){
			$resultado=mysql_query("SELECT * from clientes where fantasia like '%$nome%' order by nome");
			$linhas=mysql_num_rows($resultado);	
		}	
		if ($linhas==0){
			echo "<b>Cliente não encontrado.  Tente na lista abaixo.<BR><BR><input type=button value=Cadastrar onclick=\"location.href='clientes.php?act=cad'\"><p><center>";
			$resultado=mysql_query("select * from clientes order by nome");
			$linhas=mysql_num_rows($resultado);
			echo "<table border=1 cellpadding=1 cellspacing=1 width=100%>";
			if (!$linhas){
				echo "Não existem registros.";
				exit;
			}else{
				echo "<tr bgcolor=LIGHTSKYBLUE ><td align=center width=7%><font size=1 face=verdana><b>CÓDIGO</td><td width=70% align=center><b><font size=1 face=verdana>NOME / RAZÃO SOCIAL</td><td width=20% align=center><b><font size=1 face=verdana>APELIDO</td></tr>";
				for ($i=0;$i<$linhas;$i++){	
					$reg=mysql_fetch_row($resultado);
					$nome=$reg[0];
					$codigo=$reg[5];
					$fantasia=$reg[11];			
				if ($nome!="ASSUNTOS INTERNOS"){
				if (!$fantasia){
					$fantasia="&nbsp";
						echo "<tr onmouseover=\"this.style.backgroundColor='yellow';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: white\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"link('cham.php?act=$local&nome=$nome&codigo=$codigo','_self')\"><td align=center><font size=1 face=verdana>$codigo</td><td><font size=1 face=verdana>$nome</td><td align=center><font size=1 face=verdana>$fantasia</td></tr>";				}
				}
				}
				echo "</table>";
				exit;
			}
		}else{
			if ($linhas>1){
				echo "<b>Existe mais de um cliente com essa descrição.  Escolha na lista abaixo.<p><center>";
				$resultado=mysql_query("select * from clientes where nome like '%$nome%' order by nome");
				$linhas=mysql_num_rows($resultado);
				echo "<table border=1 cellpadding=1 cellspacing=1 width=100%>";
				echo "<tr bgcolor=LIGHTSKYBLUE ><td align=center width=7%><font size=1 face=verdana><b>CÓDIGO</td><td width=70% align=center><b><font size=1 face=verdana>NOME / RAZÃO SOCIAL</td><td width=20% align=center><b><font size=1 face=verdana>APELIDO</td></tr>";
				for ($i=0;$i<$linhas;$i++){	
					$reg=mysql_fetch_row($resultado);
					$nome=$reg[0];
					$codigo=$reg[5];
					$fantasia=$reg[11];	
					if ($nome!="ASSUNTOS INTERNOS"){
						if (!$fantasia){
							$fantasia="&nbsp";
							echo "<tr onmouseover=\"this.style.backgroundColor='yellow';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: white\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"link('cham.php?act=$local&nome=$nome&codigo=$codigo','_self')\"><td align=center><font size=1 face=verdana>$codigo</td><td><font size=1 face=verdana>$nome</td><td align=center><font size=1 face=verdana>$fantasia</td></tr>";
						}						
					}
				}
					echo "</table>";
					exit;
			}else{
				$codigo=mysql_result($resultado,0,"codigo");
				return $codigo;
			}
		}
	}
}
/*
function forn($nome,$local){
	if (!$nome){
		echo "<b><font size=2 face=verdana>Registros Atuais:<p><center>";
		$resultado=mysql_query("select * from FORNECEDORES order by nome");
		$linhas=mysql_num_rows($resultado);
		echo "<table border=1 cellpadding=1 cellspacing=1 width=100%>";
		if (!$linhas){
			echo "Não existem registros.";
			exit;
		}else{
			echo"<tr bgcolor=LIGHTSKYBLUE><td align=center><font face=verdana size=1><b>CÓDIGO</td><td align=center><font face=verdana size=1><b>FORNECEDOR</td></tr>";
			for ($i=0;$i<$linhas;$i++){	
				$reg=mysql_fetch_row($resultado);
				$nome=$reg[1];
				$cod_agenda=$reg[0];
				echo "<tr onmouseover=\"this.style.backgroundColor='yellow';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: white\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"link('forn.php?cod_agenda=$cod_agenda&operacao=$local','_self')\"><td align=center><font size=1 face=verdana>$cod_agenda</td><td width=90%><font size=1 face=verdana>$nome</td></tr>";
			}
		echo "</table>";
		exit;
		}
	}elseif ($nome){
	
		$resultado=mysql_query("SELECT * from FORNECEDORES where nome LIKE '%$nome%' order by nome");
		$linhas=mysql_num_rows($resultado);
		if ($linhas==0){
			echo "Registro não encontrado.  Tente na lista abaixo.<BR><BR><input type=button value=Cadastrar onclick=\"location.href='forn.php?operacao=cad'\"><p><center>";
			$resultado=mysql_query("select * from FORNECEDORES order by nome");
			$linhas=mysql_num_rows($resultado);
			echo "<table border=1 cellpadding=1 cellspacing=1 width=100%>";
			if (!$linhas){
				echo "Não existem registros.";
				exit;
			}else{
			echo"<tr bgcolor=LIGHTSKYBLUE><td align=center><font face=verdana size=1><b>CÓDIGO</td><td align=center><font face=verdana size=1><b>FORNECEDOR</td></tr>";
				for ($i=0;$i<$linhas;$i++){	
					$reg=mysql_fetch_row($resultado);
					$nome=$reg[1];
					$cod_agenda=$reg[0];
					echo "<tr onmouseover=\"this.style.backgroundColor='yellow';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: white\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"link('forn.php?cod_agenda=$cod_agenda&operacao=$local','_self')\"><td align=center><font size=1 face=verdana>$cod_agenda</td><td width=90%><font size=1 face=verdana>$nome</td></tr>";
				}
				echo "</table>";
				exit;
			}
		}else{
			if ($linhas>1){
				echo "Existe mais de um fornecedor com essa descrição.  Escolha na lista abaixo.<p>";
				$resultado=mysql_query("select * from FORNECEDORES where nome like '%$nome%' order by nome");
				$linhas=mysql_num_rows($resultado);
				echo "<table border=1 cellpadding=1 cellspacing=1 width=100%>";
				echo"<tr bgcolor=LIGHTSKYBLUE><td align=center><font face=verdana size=1><b>CÓDIGO</td><td align=center><font face=verdana size=1><b>FORNECEDOR</td></tr>";
				for ($i=0;$i<$linhas;$i++)
				{	
					$reg=mysql_fetch_row($resultado);
					$nome=$reg[1];
					$cod_agenda=$reg[0];
					echo "<tr onmouseover=\"this.style.backgroundColor='yellow';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: white\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"link('forn.php?cod_agenda=$cod_agenda&operacao=$local','_self')\"><td align=center><font size=1 face=verdana>$cod_agenda</td><td width=90%><font size=1 face=verdana>$nome</td></tr>";
				}	
				echo "</table>";
				exit;
			}else{
				$codigo=mysql_result($resultado,0,"codigo");
			}
			return $codigo;
		}
	}
}	
function forn2($nome,$local){
	if (!$nome){
		echo "<b><font size=2 face=verdana>Registros Atuais:<p><center>";
		$resultado=mysql_query("select * from FORNECEDORES order by nome");
		$linhas=mysql_num_rows($resultado);
		echo "<table border=1 cellpadding=1 cellspacing=1 width=100%>";
		if (!$linhas){
			echo "Não existem registros.";
			exit;
		}else{
			echo"<tr bgcolor=LIGHTSKYBLUE><td align=center><font face=verdana size=1><b>CÓDIGO</td><td align=center><font face=verdana size=1><b>FORNECEDOR</td></tr>";
			for ($i=0;$i<$linhas;$i++){	
				$reg=mysql_fetch_row($resultado);
				$nome=$reg[1];
				$cod_agenda=$reg[0];
				echo "<tr onmouseover=\"this.style.backgroundColor='yellow';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: white\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"link('forn2.php?cod_agenda=$cod_agenda&operacao=$local','_self')\"><td align=center><font size=1 face=verdana>$cod_agenda</td><td width=90%><font size=1 face=verdana>$nome</td></tr>";
			}
		echo "</table>";
		exit;
		}
	}elseif ($nome){
		$resultado=mysql_query("SELECT * from FORNECEDORES where nome LIKE '%$nome%' order by nome");
		$linhas=mysql_num_rows($resultado);
		if ($linhas==0){
			echo "Registro não encontrado.  Tente na lista abaixo.<BR><BR><input type=button value=Cadastrar onclick=\"location.href='forn.php?operacao=cad'\"><p><center>";
			$resultado=mysql_query("select * from FORNECEDORES order by nome");
			$linhas=mysql_num_rows($resultado);
			echo "<table border=1 cellpadding=1 cellspacing=1 width=100%>";
			if (!$linhas){
				echo "Não existem registros.";
				exit;
			}else{
			echo"<tr bgcolor=LIGHTSKYBLUE><td align=center><font face=verdana size=1><b>CÓDIGO</td><td align=center><font face=verdana size=1><b>FORNECEDOR</td></tr>";
				for ($i=0;$i<$linhas;$i++){	
					$reg=mysql_fetch_row($resultado);
					$nome=$reg[1];
					$cod_agenda=$reg[0];
					echo "<tr onmouseover=\"this.style.backgroundColor='yellow';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: white\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"link('forn2.php?cod_agenda=$cod_agenda&operacao=$local','_self')\"><td align=center><font size=1 face=verdana>$cod_agenda</td><td width=90%><font size=1 face=verdana>$nome</td></tr>";
				}
				echo "</table>";
				exit;
			}
		}else{
			if ($linhas>1){
				echo "Existe mais de um fornecedor com essa descrição.  Escolha na lista abaixo.<p>";
				$resultado=mysql_query("select * from FORNECEDORES where nome like '%$nome%' order by nome");
				$linhas=mysql_num_rows($resultado);
				echo "<table border=1 cellpadding=1 cellspacing=1 width=100%>";
				echo"<tr bgcolor=LIGHTSKYBLUE><td align=center><font face=verdana size=1><b>CÓDIGO</td><td align=center><font face=verdana size=1><b>FORNECEDOR</td></tr>";
				for ($i=0;$i<$linhas;$i++){	
					$reg=mysql_fetch_row($resultado);
					$nome=$reg[1];
					$cod_agenda=$reg[0];
					echo "<tr onmouseover=\"this.style.backgroundColor='yellow';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: white\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"link('forn2.php?cod_agenda=$cod_agenda&operacao=$local','_self')\"><td align=center><font size=1 face=verdana>$cod_agenda</td><td width=90%><font size=1 face=verdana>$nome</td></tr>";
				}	
				echo "</table>";
				exit;
			}else{
				$codigo=mysql_result($resultado,0,"codigo");
			}
			return $codigo;
		}
	}
}	
function tabela($nome){
	echo "Existe mais de um cliente com essa descrição.  Escolha na lista abaixo.<p>";
	$resultado=mysql_query("select * from clientes where nome like '%$nome%' order by nome");
	$linhas=mysql_num_rows($resultado);
	echo "<table border=1 cellpadding=1 cellspacing=1 width=100%>";
	for ($i=0;$i<$linhas;$i++){	
		$reg=mysql_fetch_row($resultado);
		$nome=$reg[0];
		$codigo=$reg[6];
		$fantasia=$reg[12];
		echo "<tr onmouseover=\"this.style.backgroundColor='yellow';this.style.cursor='hand';\" style=\"CURSOR: hand; BACKGROUND-COLOR: white\" onmouseout=\"this.style.backgroundColor='white';\" onclick=\"link('tabela.php?codigo=$codigo','_self')\"><td><font size=2>$nome</td><td><font size=1>$fantasia</td></tr>";		
	}
	echo "</table>";
	exit;
}
*/

?>

<script language="javascript">
<!--
		function link(pag,modo){
			if (modo=="_blank"){ 
				window.open(pag, '', 'fullscreen=no, scrollbars=auto, toolbar=yes');
			}else{
				location.href=pag;
				//window.close();
			}
		}

		function wide(){
			self.moveTo(0,0);self.resizeTo(screen.availWidth,screen.availHeight);
		}
		

		function printLink(pag,modo){
			if (modo=="_blank") {
				window.open(pag,'', 'fullscreen=no,scrollbars=yes,toolbar=yes,location=no,directories=no,status=no,menubar=no,resizable=no,width=770,height=500,top=0,left=0');
			}else{
				location.href=pag;
				window.close();
			}
		}
		function fecha(){
			window.close();
		}
		function atual(pag,modo){
			window.close();
			window.open(pag, modo, '', '');
		}
	function alerta(){
		alert("Chamado encerrado com sucesso!");
	}
	function popUp(URL){
		day = new Date();
		id = day.getTime();
		eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=700,height=250,left = 50,top = 50');");
	}
	function pops(URL){
		day = new Date();
		id = day.getTime();
		eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=700,height=350,left = 50,top = 50');");
	}
	function popWindow(URL){
		day = new Date();
		id = day.getTime();
		eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=900,height=500,left = 50,top = 50');");
	}
	function popNewWindow(URL){
		day = new Date();
		id = day.getTime();
		eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=600,height=350,left = 50,top = 50');");
	}
	function troca(campo,valor){
		prompt("Entre com o novo valor para "+campo,"");
		
	}
	function resolution(){
		res = (screen.width + " x " + screen.height);
	}
function mascaraCep(objeto){
	if (objeto.value.indexOf("-") == -1 && objeto.value.length > 5){ 
		objeto.value = ""; 
	}
	if (objeto.value.length == 5){
		objeto.value += "-";
	}
}
function mascaraTelefone(objeto){
	if (objeto.value.indexOf("-") == -1 && objeto.value.length > 5){ 
		objeto.value = ""; 
	}
	if (objeto.value.length == 4){
		objeto.value +="-";
	}
}
function mascaraData(objeto){
	if (objeto.value.indexOf("/") == -1 && objeto.value.length > 2){ 
		objeto.value = ""; 
	}
	if (objeto.value.length == 2){
		objeto.value += "/";
	}
	if (objeto.value.length == 5){
		objeto.value += "/";
	}
}    
function mascaraHora(objeto){
	if (objeto.value.indexOf(":") == -1 && objeto.value.length > 2){ 
		objeto.value = ""; 
	}
	if (objeto.value.length == 2){
		objeto.value += ":";
	}
}            
function mascaraCNPJ(objeto){
	if (objeto.value.indexOf(".") == -1 && objeto.value.length > 2){ 
		objeto.value = ""; 
	}
	if (objeto.value.length == 2){
		objeto.value += ".";
	}
	if (objeto.value.length == 6){
		objeto.value += ".";
	}
	if (objeto.value.length == 10){
		objeto.value += "/";
	}
	if (objeto.value.length == 15){
		objeto.value += "-";
	}
}
function mascaraCPF(objeto){
	if (objeto.value.indexOf(".") == -1 && objeto.value.length > 3){ 
		objeto.value = ""; 
	}
	if (objeto.value.length == 3){
		objeto.value += ".";
	}
	if (objeto.value.length == 7){
		objeto.value += ".";
	}
	if (objeto.value.length == 11){
		objeto.value += "-";
	}
}
function mascaraValor(fld,e){
	var milSep = ".";
	var decSep = ",";
	var sep = 0;
	var key = '';
	var i = j = 0;
	var len = len2 = 0;
	var strCheck = '0123456789';
	var aux = aux2 = '';
	var whichCode = (window.Event) ? e.which : e.keyCode;

	if (whichCode == 13){
		return true;
	}
		key = String.fromCharCode(whichCode);

	if (strCheck.indexOf(key) == -1){
		return false;
	}
		len = fld.value.length;

	for (i = 0; i < len; i++){
		if ((fld.value.charAt(i) != '0') && (fld.value.charAt(i) != decSep)){
			break;
		}
		aux = '';
	}
	for (; i < len; i++){
		if (strCheck.indexOf(fld.value.charAt(i))!=-1){
			aux += fld.value.charAt(i);
		}
		aux += key;
		len = aux.length;
	}
	if (len == 0){
		fld.value = '';
	}
	if (len == 1){
		fld.value = '0'+ decSep + '0' + aux;
	}
	if (len == 2){
		fld.value = '0'+ decSep + aux;
	}
	if (len > 2){
		aux2 = '';
	}
	for (j = 0, i = len - 3; i >= 0; i--){
		if (j == 3){
			aux2 += milSep;
			j = 0;
		}
		aux2 += aux.charAt(i);
		j++;
	}

	fld.value = '';
	len2 = aux2.length;

	for (i = len2 - 1; i >= 0; i--){
		fld.value += aux2.charAt(i);
		fld.value += decSep + aux.substr(len - 2, len);
	}

	return false;

}
</script>