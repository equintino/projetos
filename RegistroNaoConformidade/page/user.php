<?php
$errors = array();
$user = null;
$edit = array_key_exists('id', $_GET);

if ($edit) {
    $user = Utils_user::getUserByGetId();
}else{
    $user = new User();
}
if (array_key_exists('listar', $_POST)) {
    // redirecionar
    $user = new User();
    Utils::redirect('logins', array('id' => $user->getId()));
} elseif (array_key_exists('save', $_POST)) {
    // for security reasons, do not map the whole $_POST['todo']
    $data = array(
        'login' => @$_POST['user']['login'],
        'senha' => $_POST['user']['senha']
    );
    // mapeamento
    UserMapper::map($user, $data);
    // validar
	$login = $data['login'];
        $senhas = array(
            'senha' => $_POST['user']['senha'],
            'senha2' => $_POST['user']['senha2']
        );
        if($_POST['save']=='GRAVAR'){
            $errors = UserValidator::validate($user,$senhas);
        }
    if (empty($errors)) {
        // gravar
        if($_POST['save']=='GRAVAR'){
            $dao = new UserDao();
            $user = $dao->save($user);
            Flash::addFlash('Usuário criado com sucesso.');
            // redirecionar
            Utils::redirect('user');
        }else{
            $dao = new UserDao();
            $alteraSenha = $dao->save($user);
            Flash::addFlash('Senha alterada com sucesso.');
            // redirecionar
            Utils::redirect('logins');
        }
    }
}
?>