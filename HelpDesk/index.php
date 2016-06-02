<SCRIPT language="JavaScript">
	self.moveTo(0,0);self.resizeTo(screen.availWidth,screen.availHeight);
function gravaCookie(){
	var dataexp = new Date ();
	var cookie1="nome_usuario=" + document.logon.username.value;
	var cookie2="senha_usuario=" + document.logon.senha.value;
	//dataexp.setTime (dataexp.getTime() + (1 * 60 * 60 * 1000));
//vai valer por 1 hora
	document.cookie=cookie1;//+";expires="+dataexp;
	document.cookie=cookie2;//+";expires="+dataexp;
}
</SCRIPT>
<meta charset='utf-8'>

<?php
	include "fundo.php";
	echo "<body name='nome' onLoad=\"document.logon.username.focus()\">";
	echo "<table width=100% height=80% border=0>";
	echo "<tr height=100%>";
	echo "<tr>";
	echo "<form method=POST action=main.php name=logon >";
	echo "<td rowspan=3 width=1%><font face=tahoma size=1 color=BLACK><center><b>Login<br><hr>";
	echo "<table border=0><tr><td><font face=verdana size=1 color=BLACK>Usuário: </td><td><input type=text name=username size=10 maxlength=10></td></tr>";
	echo "<tr><td><font face=verdana size=1 color=BLACK>Senha: </td><td><input type=password name=senha size=10 maxlength=8></td></tr>";
	echo "</table>";
	echo "</td>";
	echo "<td valign=bottom><table border=0><tr><td><input type=\"submit\" onClick=gravaCookie() value=\"Enviar\"></td></tr></table>";
	echo "</td>";
	echo "</table>";
	echo "</td></tr></table>";
	echo "</html></body>";
?>