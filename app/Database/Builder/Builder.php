<?php

namespace app\Database\Builder;

abstract class Builder
{
    abstract public function select($columns);
    abstract public function from($table);
    abstract public function join($table, $leftCondition, $rightCondition, string $mode = '');
    abstract public function where($field, $value, $operator);
    abstract public static function createSql();
    abstract public function build();
}