<?php
/**
* Connexion à la base de données
**/
$tabResultat = array();
try {
  $bdd = new PDO('mysql:host=localhost;dbname=search_engine;charset=utf8', 'root', '');
  init_BDD($bdd);
}
catch (Exception $e) {
  die('Erreur : ' . $e->getMessage());
}

if(isset($_GET['recherche'])){
  foreach (explode(" ", $_GET['searchString']) as $mot) {
    $search = $bdd->query("SELECT * FROM mail WHERE _id<=10 AND Sujet LIKE '%" . $mot ."%'");
    foreach ($search->fetchAll() as $key => $value) {
      array_push($tabResultat, $value);
    }
  }
}

/**
 * Fonction d'initialisation de la base de données
 **/
function init_BDD($bdd){
  $result = $bdd->query("SHOW TABLES LIKE 'Subject'");
  if (!$result->fetch()) {
    /**
    * Pour chaque email :
    *	  on split le sujet pour avoir une liste des mots.
    *	  pour chaque mot de la liste obtenu :
    *		on normalise le mot.(enlever les accents, prendre que les 4 premiers caractères
    *		on compte le nombre d'occurence du mot.
    *   Somme des valeurs des clés communes
    **/
    $res = $bdd->query("SELECT * FROM mail WHERE _id<=10");
    $tabMotSujet = array(); // tableau contenant les mots d'un sujet
    $arrayWordByMail = array(); // tableau contenant pour tous les mots trouvés dans tous les mails leur nombre d'occurence

    while ($donnees = $res->fetch())
    {
      foreach(explode(" ",$donnees['Sujet']) as $mot){
        // On normalize afin de remplacer les caractères spéciaux
        $tabMotSujet[] = normalizer_normalize($mot, Normalizer::FORM_C );
      }
    }
    $arrayWordOccurence = array_icount_values($tabMotSujet);

    // Création de la table subject
    $sql = "CREATE TABLE IF NOT EXISTS Subject (
      Mot varchar(255) NOT NULL,
      Occurence int,
      PRIMARY KEY (Mot)
    );";
    $bdd->query($sql);

    // Insertion des données dans la table Subject
    $sqlInsert = "";
    foreach ($arrayWordOccurence as $mot => $occurence) {
      $sqlInsert .= "INSERT INTO Subject (Mot, Occurence) VALUES ('" . $mot . "', ". $occurence ."); ";
    }
    $bdd->query($sqlInsert);
  }
}
/**
* Fonction qui reprend le principe de array_count_values()
* Elle permet de ne pas tenir compte de la case
**/
function array_icount_values($array) {
  $ret_array = array();
  foreach($array as $value) {
    foreach($ret_array as $key2 => $value2) {
      if(strtolower($key2) == strtolower($value)) {
        $ret_array[$key2]++;
        continue 2;
      }
    }
    $ret_array[$value] = 1;
  }
  return $ret_array;
}
?>
