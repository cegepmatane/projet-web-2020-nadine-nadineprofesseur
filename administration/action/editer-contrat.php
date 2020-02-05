<?php
	//print_r($_POST);
		
	$filtresContrat = 
	array(
		'id' => FILTER_VALIDATE_INT,
		'titre' => FILTER_SANITIZE_ENCODED,
		'client' => FILTER_SANITIZE_ENCODED,
		'description' => FILTER_SANITIZE_ENCODED,
		'technologie' => FILTER_SANITIZE_ENCODED,
		'debut' => FILTER_SANITIZE_ENCODED
	);
	$contrat = filter_input_array(INPUT_POST, $filtresContrat);
	
	$id=filter_var($_GET['contrat'],FILTER_VALIDATE_INT);
	$contrat['id'] = $id;

	//include_once "../accesseur/ContratDAO.php";
	ContratDAO::editerContrat($contrat);
	