<?php
$todo = Utils::getTodoByGetId();

$dao = new TodoDao();
$dao->delete($todo->getId());
Flash::addFlash('RNC excluído com sucesso.');

Utils::redirect('list', array('status' => $todo->getStatus()));

?>