<?php
$username=$_COOKIE['nome_usuario'];
require("zip.lib.php");
include "valida_cookies.inc";
include "construct.php";
include "divfunc.php";

echo "<table width=100%><tr><td align=right><font color=#008080><B>BACKUP DO SISTEMA<br><hr width=50%></td></tr></table>";

@$bkp=$_GET["bkp"];

if ($bkp){
$data=substr(timestamp_para_humano(mktime(0)),6,4).substr(timestamp_para_humano(mktime(0)),3,2).substr(timestamp_para_humano(mktime(0)),0,2);
$hora=substr(timestamp_para_humano(mktime(0)),11,2).substr(timestamp_para_humano(mktime(0)),14,2);

exec ('mysqldump --database genese -uroot -ptrin123 > bkp.sql');

$arq1 = "bkp.sql";
$abre1 = fopen($arq1, "r");
@$com1 = fread($abre1, filesize($arq1)); //string contendo o arquivo a ser compactado
fclose($abre1);
$zip= new zipfile; //cria o objeto
$zip->addFile($com1,"$arq1"); //adiciona um arquivo ao zip
$strzip=$zip->file(); //string contendo o arquivo zip
$arq="bkp".$data.$hora.".zip";
$abre = fopen($arq, "w");
$salva = fwrite($abre, $strzip);
fclose($abre);

system ('del bkp.sql');
}

echo "<table width=100% border=0 height=300><tr><td align=center><font face=verdana size=2>";
echo "<b><BR><BR>BACKUP - DOWNLOADS<BR><BR>";
echo "<input type=button value='Backup Manual' onclick=\"location.href='bkp.php?bkp=1'\"><p>";

exibe_arquivos();


function exibe_arquivos(){
	echo "<table border=0 width=100%>";
	echo "<tr><td valign=top align=center>";
		$files= array();
		$numfiles=0;
		$dir=dir(".");
		$dir->rewind();
		while($file=$dir->read()){
			if (($file!=".")&&($file!="..")&&(is_file($file))&&(preg_match("/\.zip/",$file))){
				$files[$numfiles]=$file;
				$numfiles++;
			}
		}
		rsort($files);
		reset($files);
	for ($filenum=0;$filenum<$numfiles;$filenum++){
		$dia=substr(($files[$filenum]),9,2);
		$mes=substr(($files[$filenum]),7,2);
		$ano=substr(($files[$filenum]),3,4);
		$hora=substr(($files[$filenum]),11,2);
		$min=substr(($files[$filenum]),13,2);
		
		$horasql=mktime("$hora","$min",0,"$mes","$dia","$ano");

		if ($filenum>15){
			system('del '.$files[$filenum].'');
		}
		$data=$dia."/".$mes."/".$ano." ".$hora.":".$min;

		echo "<a href=".$files[$filenum]."><font face=verdana size=2>".$data."</a><BR>";
	}
}
?>