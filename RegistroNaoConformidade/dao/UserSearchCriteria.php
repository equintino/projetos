<?php
/**
 * Search criteria for {@link TodoDao}.
 * <p>
 * Can be easily extended without changing the {@link TodoDao} API.
 */
final class UserSearchCriteria {
    private $login = null;
    /**
     * @return string
     */
    public function getLogin() {
        return $this->login;
    }
    /**
     * @return TodoSearchCriteria
     */
    public function setLogin($login) {
        $this->login = $login;
        return $this;
    }
}
?>