TP1 - Application web de génération de CV
ENSA Tétouan - PHP basique

STRUCTURE
- formulaire.php : formulaire de saisie
- recap.php : récupération, traitement et affichage des données
- style.css : mise en forme
- data/renseignements.txt : fichier créé lors de la validation
- uploads/ : dossier prévu pour les fichiers facultatifs

INSTALLATION AVEC XAMPP
1. Copier le dossier TP1_CV dans :
   C:\xampp\htdocs\

2. Ouvrir XAMPP et démarrer Apache.

3. Dans le navigateur, ouvrir :
   http://localhost/TP1_CV/formulaire.php

4. Remplir le formulaire puis cliquer sur Envoyer.

5. La page recap.php affiche le récapitulatif.

6. Le bouton Modifier revient au formulaire avec les informations conservées.

7. Le bouton Valider crée :
   data/renseignements.txt

REMARQUE
La partie 2 du TP est une étape de conception séparée dans l'énoncé.
Ce projet réalise principalement la partie 1 : formulaire, traitement serveur,
récapitulatif, modification et enregistrement dans un fichier texte.
