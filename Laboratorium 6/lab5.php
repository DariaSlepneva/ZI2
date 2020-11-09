<?php

require_once __DIR__ .'/vendor/autoload.php';

use \Doctrine\DBAL\DriverManager;

$ConnectionParametrs = array(
    'dbname'=> 'sd44498',
    'user'=> 'root',
    'password'=> '',
    'host'=> 'localhost',
    'driver' => 'pdo_mysql',
);

$Connection = DriverManager::getConnection($ConnectionParametrs);

$queryBuilder = $Connection->createQueryBuilder();


/*Wyświetlić wszystkich klientów (customer) 
mających w kolumnie 'country' wartość 'USA'
*/ 
$queryBuilder->SELECT('*')
    ->FROM('customers')
    ->WHERE('country="USA"');

$stmt = $queryBuilder->execute();
$Results = $stmt->fetchAll();
foreach($Results as $i)
{
    print($i['customerName']);
    print("  ");
    print($i['customerNumber']);
    print("  ");
    print($i['country']);
    print("\n");
}


/*Wyświetlić numer i nazwę wszystkich klientów wraz imieniem i 
nazwiskiem ich opiekuna handlowego (konieczny join pomiędzy tabelami 
customers i employees) */

$queryBuilder = $Connection->createQueryBuilder();

$queryBuilder->SELECT('c.customerNumber','c.customerName','e.firstName','e.lastName')
        ->FROM('customers','c')
        ->INNERJOIN('c','employees','e','c.salesRepEmployeeNumber=e.employeeNumber');

$stmt = $queryBuilder->execute();
$Results = $stmt->fetchAll();

foreach($Results as $j)
{
    print($j['customerNumber']);
    print("  ");
    print($j['customerName']);
    print("  ");
    print($j['firstName']);
    print(" ");
    print($j['lastName']);
    print("\n");
}

/* Stworzyć własną tabelę z użyciem DBAL Schema-Representation 
(kolumny: id - klucz główny, napis - string, liczba - integer)*/


$schema = new \Doctrine\DBAL\Schema\Schema();
$myTable = $schema->createTable("Users");
$myTable->addColumn("ID","integer",array("unsigned" => true));
$myTable->addColumn("UserName","string",array("length" => 32));
$myTable->addColumn("UserAge","integer",array("unsigned" => true));
$myTable->setPrimaryKey(array("ID"));
$myTable->addUniqueIndex(array("UserName"));

$Connection->executeUpdate($schema->toSql($Connection->getDatabasePlatform())[0]);

/*Dodać kilka wartości do nowej tabeli używając DBAL Query Builder z metodą insert() */

$queryBuilder=$Connection->createQueryBuilder();

$queryBuilder->INSERT('Users')
        ->VALUES(
            array(
                'UserName' => '?',
                'UserAge' => '?'
            )
        )
        ->setParameter(0,"Piotr")
        ->setParameter(1,18);

$queryBuilder->execute();

$queryBuilder->INSERT('Users')
        ->VALUES(
            array(
                'UserName' => '?',
                'UserAge' => '?'
            )
        )
        ->setParameter(0,"Michal")
        ->setParameter(1,33);

$queryBuilder->execute();


?>