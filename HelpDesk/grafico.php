<?php
//incluindo a classe phplot
include 'class/bd.class.php';
include('phplot-5.0.4/phplot.php');
//Matriz utilizada para gerar os graficos 

$mes=(int)date("m");$mes=1;

for($x=1;$x<13;$x++){
	switch($mes){
		case 1:
		$mes1=array(1 => 'JAN',2 => 'FEV',3 => 'MAR',4 => 'ABR',5 => 'MAI',6 => 'JUN',7 => 'JUL',8 => 'AGO',9 => 'SET',10 => 'OUT',11 => 'NOV',12 => 'DEZ');
		break;
		case 2:
		$mes1=array(1 => 'FEV',2 => 'MAR',3 => 'ABR',4 => 'MAI',5 => 'JUN',6 => 'JUL',7 => 'AGO',8 => 'SET',9 => 'OUT',10 => 'NOV',11 => 'DEZ',12 => 'JAN');
		break;
		case 3:
		$mes1=array(1 => 'MAR',2 => 'ABR',3 => 'MAI',4 => 'JUN',5 => 'JUL',6 => 'AGO',7 => 'SET',8 => 'OUT',9 => 'NOV',10 => 'DEZ',11 => 'JAN',12 => 'FEV');
		break;
		case 4:
		$mes1=array(1 => 'ABR',2 => 'MAI',3 => 'JUN',4 => 'JUL',5 => 'AGO',6 => 'SET',7 => 'OUT',8 => 'NOV',9 => 'DEZ',10 => 'JAN',11 => 'FEV',12 => 'MAR');
		break;
		case 5:
		$mes1=array(1 => 'MAI',2 => 'JUN',3 => 'JUL',4 => 'AGO',5 => 'SET',6 => 'OUT',7 => 'NOV',8 => 'DEZ',9 => 'JAN',10 => 'FEV',11 => 'MAR',12 => 'ABR');
		break;
		case 6:
		$mes1=array(1 => 'JUN',2 => 'JUL',3 => 'AGO',4 => 'SET',5 => 'OUT',6 => 'NOV',7 => 'DEZ',8 => 'JAN',9 => 'FEV',10 => 'MAR',11 => 'ABR',12 => 'MAI');
		break;
		case 7:
		$mes1=array(1 => 'JUL',2 => 'AGO',3 => 'SET',4 => 'OUT',5 => 'NOV',6 => 'DEZ',7 => 'JAN',8 => 'FEV',9 => 'MAR',10 => 'ABR',11 => 'MAI',12 => 'JUN');
		break;
		case 8:
		$mes1=array(1 => 'AGO',2 => 'SET',3 => 'OUT',4 => 'NOV',5 => 'DEZ',6 => 'JAN',7 => 'FEV',8 => 'MAR',9 => 'ABR',10 => 'MAI',11 => 'JUN',12 => 'JUL');
		break;
		case 9:
		$mes1=array(1 => 'SET',2 => 'OUT',3 => 'NOV',4 => 'DEZ',5 => 'JAN',6 => 'FEV',7 => 'MAR',8 => 'ABR',9 => 'MAI',10 => 'JUN',11 => 'JUL',12 => 'AGO');
		break;
		case 10:
		$mes1=array(1 => 'OUT',2 => 'NOV',3 => 'DEZ',4 => 'JAN',5 => 'FEV',6 => 'MAR',7 => 'ABR',8 => 'MAI',9 => 'JUN',10 => 'JUL',11 => 'AGO',12 => 'SET');
		break;
		case 11:
		$mes1=array(1 => 'NOV',2 => 'DEZ',3 => 'JAN',4 => 'FEV',5 => 'MAR',6 => 'ABR',7 => 'MAI',8 => 'JUN',9 => 'JUL',10 => 'AGO',11 => 'SET',12 => 'OUT');
		break;
		case 12:
		$mes1=array(1 => 'DEZ',2 => 'JAN',3 => 'FEV',4 => 'MAR',5 => 'ABR',6 => 'MAI',7 => 'JUN',8 => 'JUL',9 => 'AGO',10 => 'SET',11 => 'OUT',12 => 'NOV');
		break;
	}
}
	$z=(12-count($mes1));
for($x=1;$x<$z+1;$x++){
	$mes2[]=$x;
	echo $x,"<br>";
}

function chamadosFechados(){
	$tabela="chamados";
	$fechado=Conexao::consultaChamado2($tabela,$where="status=5");
	//$linha_fechado=count($fechado);
	$jan=0;$fev=0;$mar=0;$abr=0;$mai=0;$jun=0;
	$jul=0;$ago=0;$set=0;$out=0;$nov=0;$dez=0;
	foreach($fechado as $key=>$item){
		$i=date("m",$item['fechamento']);
			switch($i){
				case 01:
				$jan=$jan+1;
				break;	
				case 02:
				$fev=$fev+1;
				break;	
				case 03:
				$mar=$mar+1;
				break;	
				case 04:
				$abr=$abr+1;
				break;	
				case 05:
				$mai=$mai+1;
				break;	
				case 06:
				$jun=$jun+1;
				break;	
				case 07:
				$jul=$jul+1;
				break;
				case 08:
				$ago=$ago+1;
				break;	
				case 09:
				$set=$set+1;
				break;	
				case 10:
				$out=$out+1;
				break;	
				case 11:
				$nov=$nov+1;
				break;	
				case 12:
				$dez=$dez+1;
				break;		
			}
		$meses=array('JAN'=>$jan,'FEV'=>$fev,'MAR'=>$mar,'ABR'=>$abr,'MAI'=>$mai,'JUN'=>$jun,'JUL'=>$jul,'AGO'=>$ago,'SET'=>$set,'OUT'=>$out,'NOV'=>$nov,'DEZ'=>$dez);
	}
	return @$meses;
}

function chamadosTotal(){	
	$total=Conexao::consultaChamado2('chamados',$where=1);
	$jan=0;$fev=0;$mar=0;$abr=0;$mai=0;$jun=0;
	$jul=0;$ago=0;$set=0;$out=0;$nov=0;$dez=0;
	foreach($total as $key=>$item){
		$i=date("m",$item['abertura']);
			switch($i){
				case 01:
				$jan=$jan+1;
				break;	
				case 02:
				$fev=$fev+1;
				break;	
				case 03:
				$mar=$mar+1;
				break;	
				case 04:
				$abr=$abr+1;
				break;	
				case 05:
				$mai=$mai+1;
				break;	
				case 06:
				$jun=$jun+1;
				break;	
				case 07:
				$jul=$jul+1;
				break;
				case 08:
				$ago=$ago+1;
				break;	
				case 09:
				$set=$set+1;
				break;	
				case 10:
				$out=$out+1;
				break;	
				case 11:
				$nov=$nov+1;
				break;	
				case 12:
				$dez=$dez+1;
				break;		
			}
		$meses=array('JAN'=>$jan,'FEV'=>$fev,'MAR'=>$mar,'ABR'=>$abr,'MAI'=>$mai,'JUN'=>$jun,'JUL'=>$jul,'AGO'=>$ago,'SET'=>$set,'OUT'=>$out,'NOV'=>$nov,'DEZ'=>$dez);
	}
	return @$meses;
}

function chamadosPendentes(){	
	$pendentes=Conexao::consultaChamado2('chamados',$where="status<4 or status='A'");
	$jan=0;$fev=0;$mar=0;$abr=0;$mai=0;$jun=0;
	$jul=0;$ago=0;$set=0;$out=0;$nov=0;$dez=0;
	foreach($pendentes as $key=>$item){
		$i=date("m",$item['hinicio']);
			switch($i){
				case 01:
				$jan=$jan+1;
				break;	
				case 02:
				$fev=$fev+1;
				break;	
				case 03:
				$mar=$mar+1;
				break;	
				case 04:
				$abr=$abr+1;
				break;	
				case 05:
				$mai=$mai+1;
				break;	
				case 06:
				$jun=$jun+1;
				break;	
				case 07:
				$jul=$jul+1;
				break;
				case 08:
				$ago=$ago+1;
				break;	
				case 09:
				$set=$set+1;
				break;	
				case 10:
				$out=$out+1;
				break;	
				case 11:
				$nov=$nov+1;
				break;	
				case 12:
				$dez=$dez+1;
				break;		
			}
		$meses=array('JAN'=>$jan,'FEV'=>$fev,'MAR'=>$mar,'ABR'=>$abr,'MAI'=>$mai,'JUN'=>$jun,'JUL'=>$jul,'AGO'=>$ago,'SET'=>$set,'OUT'=>$out,'NOV'=>$nov,'DEZ'=>$dez);
	}
	return @$meses;
}

$mesesFechado=chamadosFechados();
$mesesTotal=chamadosTotal();
$mesesPendente=chamadosPendentes();

$data = array(
  array($mes1[1], $mesesTotal[$mes1[1]], $mesesFechado[$mes1[1]], $mesesPendente[$mes1[1]]), array($mes1[2], $mesesTotal[$mes1[2]], $mesesFechado[$mes1[2]], $mesesPendente[$mes1[2]]), array($mes1[3], $mesesTotal[$mes1[3]], $mesesFechado[$mes1[3]], $mesesPendente[$mes1[3]]),
  array($mes1[4], $mesesTotal[$mes1[4]], $mesesFechado[$mes1[4]], $mesesPendente[$mes1[4]]), array($mes1[5],  $mesesTotal[$mes1[5]], $mesesFechado[$mes1[5]], $mesesPendente[$mes1[5]]), array($mes1[6],  $mesesTotal[$mes1[6]], $mesesFechado[$mes1[6]], $mesesPendente[$mes1[6]]),
  array($mes1[7], $mesesTotal[$mes1[7]], $mesesFechado[$mes1[7]], $mesesPendente[$mes1[7]]), array($mes1[8], $mesesTotal[$mes1[8]], $mesesFechado[$mes1[8]], $mesesPendente[$mes1[8]]), array($mes1[9], $mesesTotal[$mes1[9]], $mesesFechado[$mes1[9]], $mesesPendente[$mes1[9]]),
  array($mes1[10], $mesesTotal[$mes1[10]], $mesesFechado[$mes1[10]], $mesesPendente[$mes1[10]]), array($mes1[11], $mesesTotal[$mes1[11]], $mesesFechado[$mes1[11]], $mesesPendente[$mes1[11]]), array($mes1[12], $mesesTotal[$mes1[12]], $mesesFechado[$mes1[12]], $mesesPendente[$mes1[12]]),
);


#Instancia o objeto e setando o tamanho do grafico na tela
$plot = new PHPlot(600,400);
#Tipo de borda, consulte a documentacao para ver opcoes(plain,raised)
$plot->SetImageBorderType('plain');
#Tipo de grafico, nesse caso barras(bars), existem diversos: linhas(lines), linhas com pontos(linepoints), área(area), pontos(points), pizza(pie), barras(thinbarline), quadrado(squared)
$plot->SetPlotType('bars');
#Tipo de dados, nesse caso texto que esta no array(text-linear,text-data,linear-linear,linear-linear-error,text-data-pie)
$plot->SetDataType('text-data');
#Setando os valores com os dados do array
$plot->SetDataValues($data);
#Titulo do grafico
$plot->SetTitle('Estatística de Chamados');
# Legenda, nesse caso serao tres pq o array possui 3 valores que serao apresentados
$plot->SetLegend(array('Total de Chamados','Resolvidos', 'Pendentes'));
# Metodos utilizados para marcar labes, necessario mas nao se aplica neste ex. (manual) :
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');
#Gera o grafico na tela
$plot->DrawGraph();
?>