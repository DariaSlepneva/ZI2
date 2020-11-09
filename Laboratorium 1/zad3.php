<?php

$dsn = "mysql:host=localhost;dbname=sd44498";
$user = "root";
$passwd = "";

$pdo = new PDO($dsn, $user, $passwd);
$stm - $pdo->query("SELECT * FROM customers");
$rows = $stm->fetchAll(PDO::FETCH_ASSOC);

foreach($rows as $row) {
    print("{$roe['customerNumber']} {$row['customerName']}\n");

}

?>
