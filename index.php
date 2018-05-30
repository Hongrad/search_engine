<?php
include('function.php') ;
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Moteur de recherche mail</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <form class="" action="index.php" method="get">
    <fieldset class="groupeQuestion">
      <legend>Recherche</legend>
      <div class="innerGroupeQuestion">
        <div class="sousGroupe">
          <p>
            <label for="searchString">Mots-clés</label>
            <input type="search" name="searchString" value="" placeholder="Votre recherche" autocomplete="off">
            <p class="action">
              <input class="submit" type="submit" name="recherche" value="Rechercher">
            </p>
          </p>
        </div>
      </div>
      <div class="innerGroupeQuestion filtres">
        <div class="sousGroupe">
          <label>Période</label>
          <p>
            <label for="DATE_DEBUT">Début</label>
            <input type="date" name="DATE_DEBUT" value="" placeholder="Exemple: 20/05/2011">
            <label for="DATE_FIN">Fin</label>
            <input type="date" name="DATE_FIN" value="" placeholder="Exemple: 24/06/2015">
          </p>
        </div>
      </div>
    </fieldset>
  </form>
</body>
</html>
