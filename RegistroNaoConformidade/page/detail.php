<?php
// dados para template
$hoje = new DateTime();
$todo = Utils::getTodoByGetId();
$tooLate = $todo->getStatus() == Todo::STATUS_PENDING && $todo->getDueOn()->getTimestamp() < $hoje->getTimestamp() && $todo->getEliminacao()->format('d/m/Y') == $todo->getCreatedOn()->format('d/m/Y');
$tooLate2 = ($todo->getStatus() == Todo::STATUS_PENDING) && ($todo->getEliminacao()->getTimestamp() < $hoje->getTimestamp() && $todo->getEliminacao()->format('d/m/Y') <> $todo->getCreatedOn()->format('d/m/Y')) && $todo->getEliminacao_novo()->format('d/m/Y') == $todo->getCreatedOn()->format('d/m/Y');
$tooLate3 = $todo->getStatus() == Todo::STATUS_PENDING && ($todo->getEliminacao_novo()->getTimestamp() < $hoje->getTimestamp() && $todo->getEliminacao_novo()->format('d/m/Y') <> $todo->getCreatedOn()->format('d/m/Y')) && ($todo->getEficazData()->format('d/m/Y') == $todo->getCreatedOn()->format('d/m/Y'));
?>