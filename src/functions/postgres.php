<?php
// Functions for the PostgreSQL database
require_once __DIR__ . '/../../config.php';

// Execute a query and return all results
function pgsql_query_all($pdo, $sql, $params = [])
{
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

// Execute a query
function pgsql_execute($pdo, $sql, $params = [])
{
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($params);
}
