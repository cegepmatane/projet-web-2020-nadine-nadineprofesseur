<?php 
	include_once "../modele/Contrat.php"; // autoload permis
	include_once "accesseur/ContratSQL.php";

	class Accesseur
	{
		public static $basededonnees = null;

		public static function initialiser()
		{
			$usager = 'administrateur';
			$motdepasse = 'autremotdepasse]xO';
			$hote = 'localhost';
			$base = 'contracteur';
			$dsn = 'mysql:dbname='.$base.';host=' . $hote;
			ContratDAO::$basededonnees = new PDO($dsn, $usager, $motdepasse);
			ContratDAO::$basededonnees->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
	}	
	
	class ContratDAO extends Accesseur implements ContratSQL
	{		
		public static function listerContrats()
		{
			ContratDAO::initialiser();
			$demandeContrats = ContratDAO::$basededonnees->prepare(ContratDAO::SQL_LISTE_CONTRATS);
			$demandeContrats->execute();
			//$contrats = $demandeContrats->fetchAll(PDO::FETCH_OBJ);
			$contratsTableau = $demandeContrats->fetchAll(PDO::FETCH_ASSOC);
			foreach($contratsTableau as $contratTableau) $contrats[] = new Contrat($contratTableau);
			return $contrats;
		}
		
		public static function detaillerContrat($id)
		{
			
			ContratDAO::initialiser();
			$demandeContrat = ContratDAO::$basededonnees->prepare(ContratDAO::SQL_DETAIL_CONTRAT);
			$demandeContrat->bindParam(':id', $id, PDO::PARAM_INT);
			$demandeContrat->execute();
			//$contrat = $demandeContrat->fetchAll(PDO::FETCH_OBJ)[0];
			$contrat = $demandeContrat->fetch(PDO::FETCH_ASSOC);
			return new Contrat($contrat);
		}
		
		public static function ajouterContrat($contrat)
		{
			ContratDAO::initialiser();
			//echo $SQL_AJOUTER_CONTRAT;
			$demandeAjoutContrat = ContratDAO::$basededonnees->prepare(ContratDAO::SQL_AJOUTER_CONTRAT);
			$demandeAjoutContrat->bindValue(':titre',$contrat->titre, PDO::PARAM_STR);
			$demandeAjoutContrat->bindValue(':client',$contrat->client, PDO::PARAM_STR);
			$demandeAjoutContrat->bindValue(':description',$contrat->description, PDO::PARAM_STR);
			$demandeAjoutContrat->bindValue(':technologie',$contrat->technologie, PDO::PARAM_STR);
			$demandeAjoutContrat->bindValue(':debut',$contrat->debut, PDO::PARAM_STR);
			$demandeAjoutContrat->execute();			
		}
		
		public static function editerContrat($contrat)
		{
			//print_r($contrat);
			ContratDAO::initialiser();

			//echo $SQL_EDITER_CONTRAT;
			$demandeEditionContrat = ContratDAO::$basededonnees->prepare(ContratDAO::SQL_EDITER_CONTRAT);
			$demandeEditionContrat->bindValue(':titre',$contrat->titre, PDO::PARAM_STR);
			$demandeEditionContrat->bindValue(':client',$contrat->client, PDO::PARAM_STR);
			$demandeEditionContrat->bindValue(':description',$contrat->description, PDO::PARAM_STR);
			$demandeEditionContrat->bindValue(':technologie',$contrat->technologie, PDO::PARAM_STR);
			$demandeEditionContrat->bindValue(':debut',$contrat->debut, PDO::PARAM_STR);
			$demandeEditionContrat->bindValue(':id',$contrat->id, PDO::PARAM_STR);
			
			$demandeEditionContrat->execute();
			//print_r($demandeEditionContrat->errorInfo());
		}
		
		public static function effacerContrat($id)
		{
			ContratDAO::initialiser();

			//echo $SQL_EFFACER_CONTRAT;
			$demandeEffacementContrat = ContratDAO::$basededonnees->prepare(ContratDAO::SQL_EFFACER_CONTRAT);
			$demandeEffacementContrat->bindParam(':id', $id, PDO::PARAM_INT);
			$demandeEffacementContrat->execute();
		}
		
		
	}

function formater($texte)
{
	//$texte = html_entity_decode($texte,ENT_COMPAT,'UTF-8');
	//$texte = htmlentities($texte,ENT_COMPAT,'ISO-8859-1');
	return $texte;

}
?>
