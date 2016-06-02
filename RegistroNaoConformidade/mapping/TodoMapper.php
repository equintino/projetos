<?php
/**
 * Mapper for {@link Todo} from array.
 * @see TodoValidator
 */
final class TodoMapper {
    private function __construct() {
    }
    /**
     * Maps array to the given {@link Todo}.
     * <p>
     * Expected properties are:
     * <ul>
     *   <li>id</li>
     *   <li>priority</li>
     *   <li>created_on</li>
     *   <li>due_on</li>
     *   <li>last_modified_on</li>
     *   <li>title</li>
     *   <li>description</li>
     *   <li>comment</li>
     *   <li>status</li>
     *   <li>deleted</li>
     * </ul>
     * @param Todo $todo
     * @param array $properties
     */
    public static function map(Todo $todo, array $properties) {
        if (array_key_exists('id', $properties)) {
            $todo->setId($properties['id']);
        }
        if (array_key_exists('priority', $properties)) {
            $todo->setPriority($properties['priority']);
        }
        if (array_key_exists('created_on', $properties)) {
            $createdOn = self::createDateTime($properties['created_on']);
            if ($createdOn) {
                $todo->setCreatedOn($createdOn);
            }
        }
        if (array_key_exists('due_on', $properties)) {
            $dueOn = self::createDateTime($properties['due_on']);
            if ($dueOn) {
                $todo->setDueOn($dueOn);
            }
        }
        if (array_key_exists('eliminacao', $properties)) {
            $eliminacao = self::createDateTime($properties['eliminacao']);
            if ($eliminacao) {
                $todo->setEliminacao($eliminacao);
            }
        }
        if (array_key_exists('eliminacao_novo', $properties)) {
            $eliminacao_novo = self::createDateTime($properties['eliminacao_novo']);
            if ($eliminacao_novo) {
                $todo->setEliminacao_novo($eliminacao_novo);
            }
        }
        if (array_key_exists('last_modified_on', $properties)) {
            $lastModifiedOn = self::createDateTime($properties['last_modified_on']);
            if ($lastModifiedOn) {
                $todo->setLastModifiedOn($lastModifiedOn);
            }
        }
        if (array_key_exists('eficaz_data', $properties)) {
            $eficaz_data = self::createDateTime($properties['eficaz_data']);
            if ($eficaz_data) {
                $todo->setEficazData($eficaz_data);
            }
        }
        if (array_key_exists('title', $properties)) {
            $todo->setTitle(trim($properties['title']));
        }
        if (array_key_exists('andamento', $properties)) {
            $todo->setAndamento($properties['andamento']);
        }
        if (array_key_exists('description', $properties)) {
            $todo->setDescription(trim($properties['description']));
        }
        if (array_key_exists('comment', $properties)) {
            $todo->setComment(trim($properties['comment']));
        }
        if (array_key_exists('status', $properties)) {
            $todo->setStatus($properties['status']);
        }
        if (array_key_exists('deleted', $properties)) {
            $todo->setDeleted($properties['deleted']);
        }
        if (array_key_exists('descricao', $properties)){
            $todo->setDescricao($properties['descricao']);
        }
        if (array_key_exists('numero', $properties)) {
            $todo->setNumero(trim($properties['numero']));
        }
        if (array_key_exists('origem', $properties)){
            $todo->setOrigem($properties['origem']);
        }
        if (array_key_exists('tipoacao', $properties)){
            $todo->setTipoacao($properties['tipoacao']);
        }
        if (array_key_exists('processo', $properties)){
            $todo->setProcesso($properties['processo']);
        }
        if (array_key_exists('identificador', $properties)){
            $todo->setIdentificador($properties['identificador']);
        }
        if (array_key_exists('causa', $properties)){
            $todo->setCausa($properties['causa']);
        }
        if (array_key_exists('imediata', $properties)){
            $todo->setImediata($properties['imediata']);
        }
        if (array_key_exists('corretiva', $properties)){
            $todo->setCorretiva($properties['corretiva']);
        }
        if (array_key_exists('implementador', $properties)){
            $todo->setImplementador($properties['implementador']);
        }
        if (array_key_exists('reg_eficacia', $properties)){
            //$todo->setRegEficacia($properties['reg_eficacia']);
        }
        if (array_key_exists('resp_verificacao', $properties)){
            $todo->setRespVerificacao($properties['resp_verificacao']);
        }
        if (array_key_exists('novo_rnc', $properties)) {
            $todo->setNovoRnc($properties['novo_rnc']);
        }
        if (array_key_exists('eficaz', $properties)) {
            $todo->setEficaz($properties['eficaz']);
        }
    }
    private static function createDateTime($input) {
        return DateTime::createFromFormat('Y-n-j H:i:s', $input);
    }
}
?>