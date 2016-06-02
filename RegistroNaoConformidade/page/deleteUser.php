<?php
$todo = Utils_user::getUserByGetId();

$dao = new UserDao();
$dao->delete($todo->getId());
Flash::addFlash('RNC excluído com sucesso.');

Utils_user::redirect('logins');
?>