<?php

namespace app\Database\Builder;

/**
 * Строитель sql запроса
 */
class QueryBuilder extends Builder
{
    public string $select;
    public string $from;
    public string $join;
    public string $where;

    /**
     * Выбор колонок
     * @param $columns
     * @return $this
     */
    public function select($columns)
    {
        $this->select = "SELECT $columns ";
        return $this;
    }

    /**
     * Выбор таблицы
     * @param $table
     * @return $this
     */
    public function from($table)
    {
        $this->from = "FROM $table ";
        return $this;
    }

    /**
     * Присоединение к таблицам
     * @param string $mode
     * @param $params
     * @return $this
     */
    public function join($params, string $mode = '')
    {
        $this->join = "$mode JOIN ON $params ";
        return $this;
    }

    /**
     * Условия отбора
     * @param $params
     * @return $this
     */
    public function where($params)
    {
        $this->where = "WHERE $params ";
        return $this;
    }

    /**
     * Строитель запроса
     * @return string
     */
    public function builder(): string
    {
        return $this->select . $this->from . $this->join . $this->where;
    }
}