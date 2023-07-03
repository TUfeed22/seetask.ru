<?php

namespace app\Database\Builder;

use Exception;
use stdClass;

class PgSqlQueryBuilder extends Builder
{
    protected $query;

    private array $typesRequests = [
        'select',
        'update',
        'delete'
    ];

    public static function createSql(): PgSqlQueryBuilder
    {
        return new self();
    }

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
     * @param array $columns
     * @return PgSqlQueryBuilder
     */
    public function select(array $columns): PgSqlQueryBuilder
    {
        $this->reset();
        $this->query->select = "SELECT " . implode(',', $columns);
        $this->query->type = 'select'; // тип запроса
        return $this;
    }

    /**
     * Вставка
     * @param string $table
     * @return PgSqlQueryBuilder
     */
    public function insert(string $table): PgSqlQueryBuilder
    {
        $this->reset();
        $this->query->insert = "INSERT INTO $table ";
        $this->query->type = 'insert'; // тип запроса
        return $this;
    }

    /**
     * Вставка данных в таблицу, необходимо указать колонки и в двумерном массиве значения для вставки
     * @param array $fields - массив колонок таблицы
     * @param array $values - массив с значениями для вставки в БД.
     *
     * Пример 1: [['item1', 'item2'], ['item3', 'item4']],
     *
     * Пример 2: ['item1', 'item2']
     * @return PgSqlQueryBuilder
     * @throws Exception
     */
    public function values(array $fields, array $values): PgSqlQueryBuilder
    {
        if ($this->query->type != 'insert') {
            throw new Exception('Функцию values() можно использовать только для INSERT');
        }
        // оборачиваем элементы массива в кавычки
        $values = $this->wrappingArrayElementsInQuotationMarks($values);
        $parseValue = '';
        // часть запроса формируется по-разному, в зависимости многомерный массив или нет
        if (!is_array($values[0])) {
            $parseValue .= "(" . implode(',', $values) . ")";
        } else {
            foreach ($values as $value) {
                $parseValue .= "(" . implode(',', $value) . "),";
            }
            $parseValue = rtrim($parseValue, ',');
        }
        $this->query->values = "(" . implode(',', $fields) . ") VALUES $parseValue";
        return $this;
    }

    /**
     * Выбор таблицы
     * @param string $table
     * @return PgSqlQueryBuilder
     */
    public function from(string $table): PgSqlQueryBuilder
    {
        $this->query->from = " FROM $table";
        return $this;
    }

    /**
     * Присоединение к таблицам
     * @param string $table
     * @param string $leftCondition
     * @param string $rightCondition
     * @param string $mode
     * @return PgSqlQueryBuilder
     */
    public function join(string $table, string $leftCondition, string $rightCondition, string $mode = 'INNER'): PgSqlQueryBuilder
    {
        $this->query->join[] = "$mode JOIN $table ON $leftCondition = $rightCondition";
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
        if (!in_array($this->query->type, $this->typesRequests)) {
            throw new Exception('WHERE можно добавить только для SELECT, UPDATE и DELETE.');
        }
        $this->query->where[] = "$field $operator $value";
        return $this;
    }

    /**
     * Строитель запроса
     * @return string
     * @throws Exception
     */
    public function build(): string
    {
        $sql = "";
        switch ($this->query->type) {
            case 'select':
                $sql .= $this->query->select;
                if (empty($this->query->from)) {
                    throw new Exception('Необходимо указать параметр FROM.');
                }
                $sql .= $this->query->from;
                break;
            case 'update':
                $sql .= $this->query->update;
                if (empty($this->query->from)) {
                    throw new Exception('Необходимо указать параметр FROM.');
                }
                $sql .= $this->query->from;
                break;
            case 'insert':
                $sql .= $this->query->insert;
                if (empty($this->query->values)) {
                    throw new Exception('Необходимо указать значения для вставки');
                }
                $sql .= $this->query->values;
                break;
        }

        if (!empty($this->query->join)) {
            $sql .= " " . implode(' ', $this->query->join);
        }

        if (!empty($this->query->where)) {
            $sql .= " WHERE " . implode(' AND ', $this->query->where);
        }
        $sql .= ";";
        return $sql;
    }

    /**
     * Рекурсивная обертка элементов массива в кавычки
     * @param array $values
     * @return array
     */
    private function wrappingArrayElementsInQuotationMarks(array $values): array
    {
        $newValues = [];
        foreach ($values as $value) {
            $newValues[] = is_array($value) ? $this->wrappingArrayElementsInQuotationMarks($value) : "'" . $value . "'";
        }
        return $newValues;
    }
}