<?php
$status = Utils::getUrlParam('status');
TodoValidator::validateStatus($status);

$hoje = new DateTime();
$dao = new TodoDao();
$search = new TodoSearchCriteria();
$search->setStatus($status);

$eliminacao_nome = 'Prazo para Eliminação:';
$resp_verificacao_nome = 'Responsável pela Verificação:';
$acao_eficaz_nome = 'A Ação foi Eficaz?';
$conclusao_nome = 'Conclusão:';
// dados para template
$title = 'Não Conformidades '.Utils::capitalize($status);
if(Utils::capitalize($status)=='Vencido'){
    $title = 'Prazos '.Utils::capitalize($status); 
}elseif(Utils::capitalize($status)=='Cancelado'){
    $title = 'Registros '.Utils::capitalize($status);
}else{
    $title = 'Não Conformidades '.Utils::capitalize($status);
}
$todos = $dao->find($search);
function maiusculo($string){
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
?>