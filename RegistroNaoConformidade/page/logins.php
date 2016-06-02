<?php
$dao = new UserDao();
$search = new UserSearchCriteria();

// dados para template
$title = 'Lista de Logins ';
$users = $dao->find($search);
?>