<?php
// Functions for the PostgreSQL database
require_once __DIR__ . '/../../config.php';

function pg_query_all($pdo, $sql, $params = [])
{
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function pg_execute($pdo, $sql, $params = [])
{
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($params);
}
