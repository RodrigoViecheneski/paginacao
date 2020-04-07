<?php
/*
1. 0 -> 10 posts, 11-> 10 posts, 21 -> 10 posts
quantidade de páginas:  1000/10 = 100 páginas
SELECT * FROM posts LIMIT 10, 10;
*/

try{
	$dsn = "mysql:dbname=blog; host=localhost";
	$dbuser = "root";
	$dbpass = "root";
	$pdo = new PDO($dsn, $dbuser, $dbpass);
}catch(PDOException $e){
	die($e->getMessage());
}
/*
1. calcular a quantidade total de paginas.
2. definir o $p
3. fazer a query com LIMIT.
*/
$qt_por_pagina = 15;
$total = 0;
$sql = "SELECT COUNT(*) as c FROM usuarios";
$sql = $pdo->query($sql);
$sql = $sql->fetch();
$total = $sql['c'];

//echo $total;
//exit;
$paginas = $total / $qt_por_pagina;

$p = 0;
$pg = 1;
if(isset($_GET['p']) && !empty($_GET['p'])){
	$pg = addslashes($_GET['p']);
}
$p = ($pg - 1) * $qt_por_pagina;
$sql = "SELECT * FROM usuarios LIMIT $p, $qt_por_pagina";
$sql = $pdo->query($sql);

if($sql->rowCount() > 0){

	foreach($sql->fetchAll() as $item){
		echo $item['id'].' - '.$item['nome'].'<br/>';
	}

}

echo "<br/>";
for($q=0;$q<$paginas;$q++){
	echo '<a href="./?p='.($q+1).'">[ '.($q+1).' ]</a>';
}

?>