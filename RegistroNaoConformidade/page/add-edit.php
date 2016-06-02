<?php
$errors = array();
$todo = null;
$edit = array_key_exists('id', $_GET);

if ($edit) {
    $todo = Utils::getTodoByGetId();
} else {
    // Definição Padrão
    $todo = new Todo();
    $todo->setPriority(Todo::PRIORITY_LOW);
    $dueOn = new DateTime("+5 day", new DateTimeZone('America/Sao_Paulo'));
    $eliminacaoPrazo = new DateTime("+30 day", new DateTimeZone('America/Sao_Paulo'));
    $abrir=$todo->getCreatedOn();
    $dueOn->setTime(0, 0, 0);
    $todo->setDueOn($dueOn);
}
    if($edit){
        $numero = Utils::escape($todo->getNumero()); 
    }else{
        $dao2 = new TodoDao();
        $numero_ = $dao2->find2();
        $rest1 = substr($numero_, 0,-3);
        $numero = str_pad($rest1+1, 3, 0, STR_PAD_LEFT) ."/".date("y");
    }

if (array_key_exists('cancel', $_POST)) {
    // redirecionado
    Utils::redirect('detail', array('id' => $todo->getId()));
} elseif (array_key_exists('save', $_POST)) {
    // por razões de segurança, não mapear o conjunto $_POST['todo']
    $data = array(
        'title' => $_POST['todo']['title'],
        'due_on' => $_POST['todo']['due_on_date'] . ' ' . @$_POST['todo']['due_on_hour'] . ':' . @$_POST['todo']['due_on_minute'] . ':00',
        'priority' => $_POST['todo']['priority'],
        'description' => @$_POST['todo']['description'],
        'comment' => @$_POST['todo']['comment'],
        'descricao' => $_POST['todo']['descricao'],
        'numero' => $_POST['todo']['numero'],
        'origem' => $_POST['todo']['origem'],
        'tipoacao' => $_POST['todo']['tipoacao'],
        'processo' => $_POST['todo']['processo'],
        'identificador' => $_POST['todo']['identificador'],
        'causa' => $_POST['todo']['causa'],
        'imediata' => $_POST['todo']['imediata'],
        'corretiva' => $_POST['todo']['corretiva'],
        'implementador' => $_POST['todo']['implementador'],
        'eliminacao' => $_POST['todo']['eliminacao']. ' ' . date("H").":".$_POST['todo']['eliminacao_min'] . ':00',
        'eliminacao_novo' => $_POST['todo']['eliminacao_novo']. ' ' . date("H").":".$_POST['todo']['eliminacao_novo_min'] . ':00',
	'resp_verificacao' => $_POST['todo']['resp_verificacao'],
	'eficaz_data' => $_POST['todo']['eficaz_data']. ' ' . date("H").":".$_POST['todo']['eficaz_data_min'] . ':00',
	'novo_rnc' => $_POST['todo']['novo_rnc'],
	'eficaz' => @$_POST['todo']['eficaz'],
    );
        if($_POST['todo']['eficaz_data']){
            $data['status'] = 'RESOLVIDA';
        }
        if($_POST['todo']['eliminacao']){
            $data['andamento'] = 1;
        }
    // mapear
    TodoMapper::map($todo, $data);
    // validar
    $errors = TodoValidator::validate($todo);
  
    if (empty($errors)) {
        // gravar
        $dao = new TodoDao();
        $todo = $dao->save($todo);
        Flash::addFlash('RNC salvo com sucesso.');
        // redirecionar
        Utils::redirect('detail', array('id' => $todo->getId()));
    }
}
?>