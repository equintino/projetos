<?php
// classe de aplicativo principal.
final class Index {
    const DEFAULT_PAGE = 'home';
    const PAGE_DIR = '../page/';
    const LAYOUT_DIR = '../layout/';
// System config.
    public function init() {
		// relatório de erros - todos os erros para o desenvolvimento (garantir que você tenha display_errors = no seu arquivo php.ini)
        error_reporting(E_ALL | E_STRICT);
        mb_internal_encoding('UTF-8');
        set_exception_handler(array($this, 'handleException'));
        spl_autoload_register(array($this, 'loadClass'));
        // session
        session_start();
    }
//     Run the application!
    public function run() {
        $this->runPage($this->getPage());
    }
//     Exception handler.
    public function handleException(Exception $ex) {
        $extra = array('message' => $ex->getMessage());
        if ($ex instanceof NotFoundException) {
            header('HTTP/1.0 404 Not Found');
            $this->runPage('404', $extra);
        } else {
            // TODO log exception
            header('HTTP/1.1 500 Internal Server Error');
            $this->runPage('500', $extra);
        }
    }

//    Class loader.
    public function loadClass($name) {
        $classes = array(
            'Config' => '../config/Config.php',
            'Error' => '../validation/Error.php',
            'Flash' => '../flash/Flash.php',
            'NotFoundException' => '../exception/NotFoundException.php',
            'TodoDao' => '../dao/TodoDao.php',
            'UserDao' => '../dao/UserDao.php',
            'TodoMapper' => '../mapping/TodoMapper.php',
            'UserMapper' => '../mapping/UserMapper.php',
            'Todo' => '../model/Todo.php',
            'User' => '../model/User.php',
            'TodoSearchCriteria' => '../dao/TodoSearchCriteria.php',
            'UserSearchCriteria' => '../dao/UserSearchCriteria.php',
            'TodoValidator' => '../validation/TodoValidator.php',
            'UserValidator' => '../validation/UserValidator.php',
            'Utils' => '../util/Utils.php',
            'Utils_user' => '../util/Utils_user.php',
            'valida_cookies' => '../validation/valida_cookies.php',
        );
        if (!array_key_exists($name, $classes)) {
            die('Classe "' . $name . '" não encontrada.');
        }
        require_once $classes[$name];
    }

    private function getPage() {
        $page = self::DEFAULT_PAGE;
        if (array_key_exists('page', $_GET)) {
            $page = $_GET['page'];
        }
        return $this->checkPage($page);
    }

    private function checkPage($page) {
        if (!preg_match('/^[a-z0-9-]+$/i', $page)) {
            // TODO log attempt, redirect attacker, ...
            throw new NotFoundException('Unsafe page "' . $page . '" requested');
        }
        if (!$this->hasScript($page) && !$this->hasTemplate($page)) {
            // TODO log attempt, redirect attacker, ...
            throw new NotFoundException('Page "' . $page . '" not found');
        }
        return $page;
    }

    private function runPage($page, array $extra = array()) {
        $run = false;
        if ($this->hasScript($page)) {
            $run = true;
            require $this->getScript($page);
        }
        if ($this->hasTemplate($page)) {
            $run = true;
            // data for main template
            $template = $this->getTemplate($page);
            $flashes = null;
            if (Flash::hasFlashes()) {
                $flashes = Flash::getFlashes();
            }

            // main template (layout)
            require self::LAYOUT_DIR . 'index.phtml';
        }
        if (!$run) {
            die('Page "' . $page . '" has neither script nor template!');
        }
    }

    private function getScript($page) {
        return self::PAGE_DIR . $page . '.php';
    }

    private function getTemplate($page) {
        return self::PAGE_DIR . $page . '.phtml';
    }

    private function hasScript($page) {
        return file_exists($this->getScript($page));
    }

    private function hasTemplate($page) {
        return file_exists($this->getTemplate($page));
    }
}
$index = new Index();
$index->init();
// Exigir o login para acesso
        $valida = new valida_cookies();
        $valida->setLogin($_COOKIE['login']);
        $valida->setSenha($_COOKIE['senha']);
        @$valida->setIndex($_GET['index']);
        $valida->fazerLogin();
// run application!
$index->run();
?>