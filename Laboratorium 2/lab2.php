<?php

$pizza = array('Margherita','Marinara','Carbonara','Crudo','Napoletana','Pugliese','Montanara','Emiliana','Romana','Fattoria');
$numbers = range(100,110);
shuffle($numbers);

try {
	$dbh = new PDO('mysql:host=localhost;dbname=sd44498', 'Daria','');
} catch (PDOException $e) {
	print $e->getMessage();
	die();
}

try {
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->beginTransaction();

    $i = 0;
    while($i < count($pizza))
    {
	$stm = $dbh->prepare("INSERT INTO pizzas(title,num) VALUES('$pizza[$i]','$numbers[$i]')");
	$stm->execute();
	$i = $i + 1;
    }

    $dbh->commit();

} catch (Exception $e) {
	$dbh->rollBack();
	echo 'Error: ' . $e->getMessage();
}

?>
