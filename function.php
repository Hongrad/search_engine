<?php
/**
* Connexion à la base de données
**/
try {
  $bdd = new PDO('mysql:host=localhost;dbname=search_engine;charset=utf8', 'root', '');
}
catch (Exception $e) {
  die('Erreur : ' . $e->getMessage());
}

if(isset($_GET['recherche'])){

}

/**
* Pour chaque email :
*	  on split le sujet pour avoir une liste des mots.
*	  pour chaque mot de la liste obtenu :
*		on normalise le mot.(enlever les accents, prendre que les 4 premiers caractères
*		on compte le nombre d'occurence du mot.
*   Somme des valeurs des clés communes
**/
$res = $bdd->query("SELECT * FROM mail WHERE _id<=10");

$tabMotSujet = array();
$arrayWordByMail = array();

while ($donnees = $res->fetch())
{
  echo $donnees['Sujet'] . '<br />';
  //$tabMotSujet[$donnees['_id']] = explode(" ",$donnees['Sujet']);
  foreach(explode(" ",$donnees['Sujet']) as $mot){
    // On normalize afin de remplacer les caractères spéciaux
    $tabMotSujet[] = normalizer_normalize($mot, Normalizer::FORM_C );
  }
  foreach(explode(" ",$donnees['Sujet']) as $mot){
    if(array_key_exists($mot,$arrayWordByMail)) {
      $arrayWordByMail[$mot]++;
    }
    else {
      $arrayWordByMail[$mot] = 1;
    }
  }
}
$arrayWordOccurence = array_icount_values($tabMotSujet);
var_dump($arrayWordOccurence);
var_dump($arrayWordByMail);

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
