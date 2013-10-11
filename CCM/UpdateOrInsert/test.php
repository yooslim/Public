<?php
// Inclusion des classes nécéssaire
require_once 'UpdateOrInsert.class.php';
//require_once 'bdd.php';

// Les données
$mysqlDatas = array('id1', 'id34', 'id3', 'id7', 'id23'); // On a seulement besoin des valeurs de la clé primaire
$newDatas = array(
	array('Identifiant' => 'id1', 'Email' => 'abc1@live.fr'), // Existe déja, sera mis a jour
	array('Identifiant' => 'id3', 'Email' => 'abc33@live.fr'), // Existe déja, sera mis a jour
	array('Identifiant' => 'id21', 'Email' => 'abc21@live.fr'), // N'existe pas, sera inséré
	array('Identifiant' => 'id12', 'Email' => 'abc12@live.fr') // N'existe pas, sera inséré
);

// Lancement du script
$obj = new UpdateOrInsert('table', 'Identifiant');
$obj->setColumnsName(array_keys($newDatas[0]));
$obj->setPrimaryKeyValues($mysqlDatas);
$obj->setNewDatas($newDatas);
$obj->initRequests();

$upReq = $obj->getInsertQuery();
$insReq = $obj->getUpdateQuery();

// Aperçu des requetes
var_dump($upReq);
var_dump($insReq);
die();
// Execution des requetes via PDO
if($upReq != null) {
	$req = $db->prepare($upReq);
	$tab = $obj->getUpdateDatas();
	
	foreach($tab AS $id => $a) {
		$req->bindParam(':pk' . $id, $a['Identifiant'], PDO::PARAM_STR);
		
		foreach($a AS $field => $value)
			$req->bindParam(':up' . $field . $id, $value, PDO::PARAM_STR);
	}
	
	$req->execute();
}

if($insReq != null) {
	$req1 = $db->prepare($insReq);
	$tab = $obj->getInsertDatas();
	
	foreach($tab AS $id => $a) {
		foreach($a AS $field => $value)
			$req1->bindParam(':ins' . $field . $id, $value, PDO::PARAM_STR);
	}
	
	$req1->execute();
}
?>