<?php

namespace app\Database\Builder;

abstract class Builder
{
    abstract public function select(array $columns);
    abstract public function insert(string $table);
    abstract public function values(array $fields, array $values);
    abstract public function from(string $table);
    abstract public function join(string $table, string $leftCondition, string $rightCondition, string $mode = '');
    abstract public function where($field, $value, $operator);
    abstract public static function createSql();
    abstract public function build();
}