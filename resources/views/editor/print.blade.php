<?php
session_start();
if (!isset($_SESSION['connexion'])) {header("Location:../../");}

require '../connexion/connect.php';
$req_enseign=$bdd->prepare('SELECT * FROM `enseignant` WHERE ID_Enseignant=?');
$req_enseign->execute(array($_GET['id']));
$enseign=$req_enseign->fetch();
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="robots" content="noindex" charset="UTF-8">
	<title>Info enseignant</title>
</head>
<style type="text/css">

*{
	font-family:"Arial Narrow", sans-serif;
}

.nom
{
	color:black;
	font-size:16.0pt;
}
.titre_renseignement
{
  color:black;
  font-size:12.0pt;
  font-weight:700;
  font-style:italic;
  border-collapse: collapse;
  border-right:none;
  border-bottom: 1px solid black;
}
.bd
{
  margin: auto;
  width: 210mm;
  border: 1px solid black;
  padding: 10px;
}
  .tableau
  {
        border-collapse: collapse;
        border: 1px solid black;
        text-align: center;
  }
</style>
<body>

<div class="bd">

<p align="center">INSTITUT SUPERIEUR DE TECHNOLOGIE D'ANTSIRANANA
<br>ETAT DE RENSEIGNEMENT INDIVIDUEL D'ENSEIGNANT</p>
<table>

<tr >
	<td rowspan="5" style='width:144pt'><span style=''><img width=146 height=146
  src="img/<?php echo $enseign['photo']; ?>">
</span></td>
  <td class="nom" ><b><?php echo $enseign['Nom']." ".$enseign['Prenom']; ?><b></td>
  <td ></td>
  <td ></td>
 </tr>
 <tr>
  <td><?php echo $enseign['Statut']; ?></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>
 <tr>
  <td><?php echo $enseign['Ecole']; ?></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>
  <tr>
  <td><?php echo $enseign['Fonction']; ?></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>
  <tr>
  <td><a href="modif.php?id=<?php echo $enseign['ID_Enseignant']; ?>" target="_blank" rel="nofollow">Modifier</a></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>
</table>

<table>
 <tr height="25">
  <td class="titre_renseignement">Contacts <?php for ($i=0; $i < 130; $i++) { echo "&nbsp;";} ?> </td>
 </tr>
</table>

<table>
<tr>
<td>Téléphone 1 :</td>
<td>&nbsp;</td>
<td><?php echo $enseign['Telephone1']; ?></td>
</tr>

<tr>
<td>Téléphone 2 :</td>
<td>&nbsp;</td>
<td><?php echo $enseign['Telephone2']; ?></td>
</tr>

<tr>
<td>Email 1 :</td>
<td>&nbsp;</td>
<td><?php echo $enseign['email1']; ?></td>
</tr>

<tr>
<td>Email 2 :</td>
<td>&nbsp;</td>
<td><?php echo $enseign['email2']; ?></td>
</tr>
</table>

<table>
 <tr height="25">
  <td class="titre_renseignement">Informations personnelles <?php for ($i=0; $i < 100; $i++) { echo "&nbsp;";} ?> </td>
 </tr>
</table>

<table>
<tr>
<td>N° CIN :</td>
<td>&nbsp;</td>
<td><?php echo $enseign['CIN']; ?></td>
</tr>

<tr>
<td>Date CIN :</td>
<td>&nbsp;</td>
<td><?php echo $enseign['date_cin']; ?></td>
</tr>

<tr>
<td>Lieu CIN</td>
<td>&nbsp;</td>
<td><?php echo $enseign['lieu_CIN']; ?></td>
</tr>

<tr>
<td>Date de naissance :</td>
<td>&nbsp;</td>
<td><?php echo $enseign['Date_de_naissance']; ?></td>
</tr>

<tr>
<td>Lieu Naissance :</td>
<td>&nbsp;</td>
<td><?php echo $enseign['Lieu_de_naissance']; ?></td>
</tr>

<tr>
<td>Adresse :</td>
<td>&nbsp;</td>
<td><?php echo $enseign['Adresse']; ?></td>
</tr>

<tr>
<td>Sexe :</td>
<td>&nbsp;</td>
<td><?php echo $enseign['Sexe']; ?></td>
</tr>
</table>

<table>
 <tr height="25">
  <td class="titre_renseignement">Informations pédagogiques <?php for ($i=0; $i < 98; $i++) { echo "&nbsp;";} ?> </td>
 </tr>
</table>

<table>
<tr>
<td>Statut :</td>
<td>&nbsp;</td>
<td><?php echo $enseign['Statut']; ?></td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>Catégorie :</td>
<td>&nbsp;</td>
<td><?php echo $enseign['Categorie']; ?></td>
</tr>

<tr>
<td>IM / N° Contrat :</td>
<td>&nbsp;</td>
<td><?php echo $enseign['IM_NContrat']; ?></td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>Diplôme :</td>
<td>&nbsp;</td>
<td><?php echo $enseign['Diplome']; ?></td>
</tr>

<tr>
<td>Ecole :</td>
<td>&nbsp;</td>
<td><?php echo $enseign['Ecole']; ?></td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>Spécialité :</td>
<td>&nbsp;</td>
<td><?php echo $enseign['Specialit']; ?></td>
</tr>

<tr>
<td>Date de contrat :</td>
<td>&nbsp;</td>
<td><?php echo $enseign['Date_contrat']; ?></td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>Recherche :</td>
<td>&nbsp;</td>
<td><?php echo $enseign['domaine_de_recherche']; ?></td>
</tr>

<tr>
<td>Date prise service :</td>
<td>&nbsp;</td>
<td><?php echo $enseign['Date_prise_service']; ?></td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>Fonction :</td>
<td>&nbsp;</td>
<td><?php echo $enseign['Fonction']; ?></td>
</tr>

<tr>
<td>Activité ou Maintien :</td>
<td>&nbsp;</td>
<td><?php echo $enseign['Maintien_activit']; ?></td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>Mention :</td>
<td>&nbsp;</td>
<td><?php echo $enseign['Mention']; ?></td>
</tr>

<tr>
<td>Parcours :</td>
<td>&nbsp;</td>
<td><?php echo $enseign['Parcours']; ?></td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>Grade :</td>
<td>&nbsp;</td>
<td><?php echo $enseign['Grade']; ?></td>
</tr>

<tr>
<td>Taux :</td>
<td>&nbsp;</td>
<td><?php echo $enseign['Taux']; ?></td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>Titre</td>
<td>&nbsp;</td>
<td><?php echo $enseign['Titre']; ?></td>
</tr>

<tr>
<td><a href="piece_jointe/<?php echo $enseign['piece_jointe']; ?>" target="_blank">Pièces jointes</a></td>
<td>&nbsp;</td>
<td></td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td></td>
<td>&nbsp;</td>
<td></td>
</tr>

</table>

<p align="center"><b>RELEVE D'IDENTITE BANCAIRE - RIB</b></p>
<table align="center" class="tableau">
 <tr class="tableau">
  <td class="tableau">Banque</td>
  <td class="tableau">Domiciliation</td>
  <td class="tableau">Guichet</td>
  <td class="tableau">Titulaire de compte</td>
  <td class="tableau">Numéro de compte</td>
  <td class="tableau">Clé</td>
 </tr>
 <tr class="tableau">
  <td class="tableau"><?php echo sprintf("%'05d", $enseign['CodeBanque']); ?></td>
  <td class="tableau"><?php echo $enseign['DomicileBanque']; ?></td>
  <td class="tableau"><?php echo sprintf("%'05d", $enseign['CodeGuichet']); ?></td>
  <td class="tableau"><?php echo $enseign['Nom']." ".$enseign['Prenom']; ?></td>
  <td class="tableau"><?php echo sprintf("%'011d", $enseign['NumCompteBanque']); ?></td>
  <td class="tableau"><?php echo sprintf("%'02d", $enseign['RIB']); ?></td>
 </tr>
</table>

</div>

</body>
</html>