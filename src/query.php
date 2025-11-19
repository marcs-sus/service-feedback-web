<?php
require_once __DIR__ . '/db_conn.php';

class Query
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::get_instance();
    }

    // Select method with optional where and order by clauses
    public function select(string $table, array $columns = ['*'], array $where = [], string $order_by = ''): array
    {
        // Column list
        $col_names = implode(', ', $columns);

        // Where clause
        $where_clause = '';
        $params = [];

        if (!empty($where)) {
            $conditions = [];

            foreach ($where as $col => $val) {
                $conditions[] = "$col = :$col";
                $params[":$col"] = $val;
            }

            $where_clause = 'WHERE ' . implode(' AND ', $conditions);
        }

        // Order by clause
        $order_clause = $order_by ? "ORDER BY $order_by" : '';

        // Final query
        $sql = "SELECT $col_names FROM $table $where_clause $order_clause";

        try {
            // Prepare and execute
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            throw new PDOException("Database SELECT query failed: " . $ex->getMessage(), (int)$ex->getCode(), $ex);
        }
    }

    // Specialized Select method to fetch a single row
    public function select_one(string $table, array $columns = ['*'], array $where = []): ?array
    {
        $results = $this->select($table, $columns, $where);

        return $results[0] ?? null;
    }

    // Insert method with named placeholders
    public function insert(string $table, array $data): void
    {
        // Prevent queries with no data.
        if (empty($data)) {
            throw new InvalidArgumentException('Data for INSERT cannot be empty.');
        }

        // Columns and Values
        $columns = array_keys($data);

        // Using named placeholders for consistency with other methods.
        $col_names = implode(', ', $columns);
        $placeholders = implode(', ', array_map(fn($c) => ":$c", $columns));

        // Final query
        $sql = "INSERT INTO $table ($col_names) VALUES ($placeholders)";

        try {
            // Prepare and execute
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($data);
        } catch (PDOException $ex) {
            throw new PDOException("Database INSERT query failed: " . $ex->getMessage(), (int)$ex->getCode(), $ex);
        }
    }

    // Update method with named placeholders
    public function update(string $table, array $data, array $where): void
    {
        // Safeguards for empty data or where clause.
        if (empty($data)) {
            throw new InvalidArgumentException('Data for UPDATE cannot be empty.');
        }
        if (empty($where)) {
            throw new InvalidArgumentException('UPDATE operation must have a WHERE clause.');
        }

        $params = [];

        // Set clause
        $set_parts = [];
        foreach ($data as $col => $val) {
            $placeholder = ":set_$col";
            $set_parts[] = "$col = $placeholder";
            $params[$placeholder] = $val;
        }
        $set_clause = 'SET ' . implode(', ', $set_parts);

        // Where clause
        $where_parts = [];
        foreach ($where as $col => $val) {
            $placeholder = ":where_$col";
            $where_parts[] = "$col = $placeholder";
            $params[$placeholder] = $val;
        }
        $where_clause = 'WHERE ' . implode(' AND ', $where_parts);

        // Final query
        $sql = "UPDATE $table $set_clause $where_clause";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
        } catch (PDOException $ex) {
            throw new PDOException("Database UPDATE query failed: " . $ex->getMessage(), (int)$ex->getCode(), $ex);
        }
    }

    // Delete method with where clause
    public function delete(string $table, array $where): void
    {
        // Safeguard for empty where clause.
        if (empty($where)) {
            throw new InvalidArgumentException('DELETE operation must have a WHERE clause.');
        }

        // Where clause
        $conditions = [];
        $params = [];
        foreach ($where as $col => $val) {
            $conditions[] = "$col = :$col";
            $params[":$col"] = $val;
        }
        $where_clause = 'WHERE ' . implode(' AND ', $conditions);

        // Final query
        $sql = "DELETE FROM $table $where_clause";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
        } catch (PDOException $ex) {
            throw new PDOException("Database DELETE query failed: " . $ex->getMessage(), (int)$ex->getCode(), $ex);
        }
    }

    // Raw query for complex operations
    public function raw_query(string $sql, array $params = []): array
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            throw new PDOException("Database raw query failed: " . $ex->getMessage(), (int)$ex->getCode(), $ex);
        }
    }
}
