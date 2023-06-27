<?php

namespace app\Database\Builder;

use Exception;
use stdClass;

class PgSqlQueryBuilder extends Builder
{
    protected $query;

    private array $requests = [
        'select',
        'update',
        'delete'
    ];

    /**
     * Создаем новый объект для каждого нового запроса (select, update, delete)
     * @return void
     */
    protected function reset(): void
    {
        $this->query = new stdClass();
    }

    /**
     * Построение select
     * @param $columns
     * @return PgSqlQueryBuilder
     */
    public function select($columns): PgSqlQueryBuilder
    {
        $this->reset();
        $this->query->select = "SELECT " . implode(',' ,$columns);
        $this->query->type = 'select'; // тип запроса
        return $this;
    }

    /**
     * Выбор таблицы
     * @param $table
     * @return PgSqlQueryBuilder
     */
    public function from($table): PgSqlQueryBuilder
    {
        $this->query->from = " FROM $table";
        return $this;
    }

    /**
     * Присоединение к таблицам
     * @param $params
     * @param string $mode
     * @return PgSqlQueryBuilder
     */
    public function join($params, string $mode = ''): PgSqlQueryBuilder
    {
        $this->query->join = " $mode JOIN ON $params ";
        return $this;
    }

    /**
     * Условия отбора
     * @param $field
     * @param $value
     * @param $operator
     * @return PgSqlQueryBuilder
     * @throws Exception
     */
    public function where($field, $value, $operator): PgSqlQueryBuilder
    {
        if (!in_array($this->query->type, $this->requests)) {
            throw new Exception('WHERE можно добавить только для SELECT, UPDATE и DELETE.');
        }
        $this->query->where[] = "$field $operator $value";
        return $this;
    }

    /**
     * Строитель запроса
     * @return string
     */
    public function build(): string
    {
        $sql = '';
        switch ($this->query->type) {
            case 'select':
                $sql .= $this->query->select;
                $sql .= $this->query->from;
                break;
            case 'update':
                $sql .= $this->query->update;
                $sql .= $this->query->from;
                break;
        }

        if (!empty($this->query->where)) {
            $sql .= " WHERE " . implode(' AND ', $this->query->where);
        }
        $sql .= ";";
        return $sql;
    }
}