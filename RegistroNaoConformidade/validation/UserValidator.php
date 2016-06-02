<?php
/**
 * Validator for {@link Todo}.
 * @see TodoMapper
 */
final class UserValidator {         
    private function __construct() {
    }
    /**
     * Validate the given {@link Todo} instance.
     * @param Todo $todo {@link Todo} instance to be validated
     * @return array array of {@link Error} s
     */
    public static function validate(User $user,$senhas) {
        $errors = array(); 
        if (!trim($user->getLogin())) {
            $errors[] = new Error('login', 'Login não pode estar em branco.');
        } 
        if (!trim($user->getSenha())) {
            $errors[] = new Error('senha', 'Senha não pode estar em branco.');
        } 
        if ($senhas['senha']!=$senhas['senha2']) {
                $errors[] = new Error('senha', 'As senhas não são iguais.');
        }
        if(self::existe($user)){
            $errors[] = new Error('login', 'Login existente.');
        }
        return $errors;
    }
	public static function existe($user){
                $errors = array();
                $dao = new UserDao();
                $search = new UserSearchCriteria();
                $search->setLogin($user->getLogin());
                $users = $dao->find($search);
		return $users;
	}

    /**
     * Validate the given status.
     * @param string $status status to be validated
     * @throws Exception if the status is not known
     */
    public static function validateStatus($status) {
        if (!self::isValidStatus($status)) {
            throw new Exception('Unknown status: ' . $status);
        }
    }

    /**
     * Validate the given priority.
     * @param int $priority priority to be validated
     * @throws Exception if the priority is not known
     */
    public static function validatePriority($priority) {
        if (!self::isValidPriority($priority)) {
            throw new Exception('Unknown priority: ' . $priority);
        }
    }

    private static function isValidStatus($status) {
        return in_array($status, Todo::allStatuses());
    }

    private static function isValidPriority($priority) {
        return in_array($priority, Todo::allPriorities());
    }
}
?>