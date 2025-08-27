<?php 

	include_once "modele/Contrat.php";
	include_once "accesseur/ContratSQL.php";

	class Accesseur
	{
		public static $basededonnees = null;

		public static function initialiser()
		{
			$usager = 'contracteur';
			$motdepasse = 'exdyzmkKKPcM0]xO';
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
	
		
	}

function formater($texte)
{
	//$texte = html_entity_decode($texte,ENT_COMPAT,'UTF-8');
	//$texte = htmlentities($texte,ENT_COMPAT,'ISO-8859-1');
	return $texte;

}
?>
