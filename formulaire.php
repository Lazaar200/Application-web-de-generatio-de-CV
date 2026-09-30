<?php
session_start();

$data = $_SESSION['form_data'] ?? [];

function old($key, $default = '') {
    global $data;
    return htmlspecialchars($data[$key] ?? $default, ENT_QUOTES, 'UTF-8');
}

$projects = $data['projects'] ?? [];

if (empty($projects)) {
    $projects = [
        [
            'start' => '',
            'end' => '',
            'location' => '',
            'description' => ''
        ]
    ];
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Fiche de renseignements - ENSA Tétouan</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="page">

    <header class="intro">

        <p class="small-title">
            ENSA Tétouan 
        </p>

        <h1>
            Fiche de renseignements
        </h1>

        <p>
            Renseignez vos informations simplement.
            Elles seront ensuite affichées dans un récapitulatif.
        </p>

    </header>


    <form
        action="recap.php"
        method="post"
        enctype="multipart/form-data"
        id="cvForm"
    >


        <!-- =====================================================
             INFORMATIONS PERSONNELLES
        ====================================================== -->

        <section class="card">

            <h2>
                Informations personnelles
            </h2>

            <div class="grid two">

                <div class="field">

                    <label for="nom">
                        Nom
                    </label>

                    <input
                        type="text"
                        id="nom"
                        name="nom"
                        value="<?= old('nom') ?>"
                        required
                    >

                </div>


                <div class="field">

                    <label for="prenom">
                        Prénom
                    </label>

                    <input
                        type="text"
                        id="prenom"
                        name="prenom"
                        value="<?= old('prenom') ?>"
                        required
                    >

                </div>


                <div class="field">

                    <label for="age">
                        Âge
                    </label>

                    <input
                        type="number"
                        id="age"
                        name="age"
                        min="16"
                        max="100"
                        value="<?= old('age') ?>"
                    >

                </div>


                <div class="field">

                    <label for="telephone">
                        Numéro de téléphone
                    </label>

                    <input
                        type="tel"
                        id="telephone"
                        name="telephone"
                        value="<?= old('telephone') ?>"
                    >

                </div>


                <div class="field full">

                    <label for="email">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?= old('email') ?>"
                        required
                    >

                </div>

            </div>

        </section>



        <!-- =====================================================
             RENSEIGNEMENTS ACADÉMIQUES
        ====================================================== -->

        <section class="card">

            <h2>
                Renseignements académiques
            </h2>


            <!-- FILIÈRE -->

            <div class="field">

                <span class="label">
                    Filière
                </span>


                <div class="options">

                    <?php

                    /*
                     * Les filières proposées dans notre formulaire.
                     */

                    $filieres = [
                        '2AP' => '2AP',
                        'GSTR' => 'GSTR',
                        'GI' => 'Génie Informatique',
                        'SCM' => 'Supply Chain Management',
                        'Mecatronique' => 'Génie Mécatronique',
                        'BigData' => 'Big Data',
                        'Cybersecurite' => 'Cybersécurité',
                        'GC' => 'Génie Civil'
                    ];


                    foreach ($filieres as $value => $label):

                    ?>

                        <label class="choice">

                            <input
                                type="radio"
                                name="filiere"
                                value="<?= $value ?>"
                                <?= (($data['filiere'] ?? '') === $value) ? 'checked' : '' ?>
                            >

                            <?= $label ?>

                        </label>

                    <?php endforeach; ?>

                </div>

            </div>



            <!-- ANNÉE -->

            <div class="field">

                <span class="label">
                    Année d'étude
                </span>


                <div class="options">

                    <?php for ($i = 1; $i <= 3; $i++): ?>

                        <?php

                        if ($i === 1) {
                            $labelAnnee = '1ère année';
                        } else {
                            $labelAnnee = $i . 'ème année';
                        }

                        ?>

                        <label class="choice">

                            <input
                                type="radio"
                                name="annee"
                                value="<?= $labelAnnee ?>"
                                <?= (($data['annee'] ?? '') === $labelAnnee) ? 'checked' : '' ?>
                            >

                            <?= $labelAnnee ?>

                        </label>

                    <?php endfor; ?>

                </div>

            </div>



            <!-- MODULES -->

            <div class="field">

                <span class="label">
                    Modules suivis cette année
                </span>


                <p class="help-text">
                    Choisissez d'abord votre filière pour afficher les modules correspondants.
                </p>


                <div
                    class="options"
                    id="modulesContainer"
                >

                    <p class="module-message">
                        Sélectionnez une filière.
                    </p>

                </div>

            </div>



            <!-- NOMBRE DE PROJETS -->

            <div class="field short">

                <label for="nombre_projets">
                    Nombre de projets/stages
                </label>

                <input
                    type="number"
                    id="nombre_projets"
                    name="nombre_projets"
                    min="1"
                    max="5"
                    value="<?= count($data['projects'] ?? []) ?: 1 ?>"
                >

            </div>

        </section>



        <!-- =====================================================
             PROJETS ET STAGES
        ====================================================== -->

        <section class="card">

            <div class="section-heading">

                <div>

                    <h2>
                        Projets et stages
                    </h2>

                    <p>
                        Pour chaque projet ou stage,
                        indiquez les informations demandées.
                    </p>

                </div>

            </div>


            <div id="projectsContainer">

                <?php foreach ($projects as $index => $project): ?>

                    <div class="project-box">

                        <h3>
                            Projet / stage <?= $index + 1 ?>
                        </h3>


                        <div class="grid two">


                            <div class="field">

                                <label>
                                    Date de début
                                </label>

                                <input
                                    type="date"
                                    name="project_start[]"
                                    value="<?= htmlspecialchars($project['start'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                >

                            </div>


                            <div class="field">

                                <label>
                                    Date de fin
                                </label>

                                <input
                                    type="date"
                                    name="project_end[]"
                                    value="<?= htmlspecialchars($project['end'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                >

                            </div>


                            <div class="field full">

                                <label>
                                    Lieu
                                </label>

                                <input
                                    type="text"
                                    name="project_location[]"
                                    value="<?= htmlspecialchars($project['location'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                >

                            </div>


                            <div class="field full">

                                <label>
                                    Description
                                </label>

                                <textarea
                                    name="project_description[]"
                                    rows="3"
                                ><?= htmlspecialchars($project['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>

                            </div>


                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        </section>



        <!-- =====================================================
             PROFIL COMPLÉMENTAIRE
        ====================================================== -->

        <section class="card">

            <h2>
                Profil complémentaire
            </h2>


            <div class="field">

                <label for="interets">
                    Centres d'intérêt
                </label>

                <textarea
                    id="interets"
                    name="interets"
                    rows="3"
                    placeholder="Ex. lecture, sport, photographie..."
                ><?= old('interets') ?></textarea>

            </div>


            <div class="field">

                <label for="competences">
                    Compétences et langues
                </label>

                <textarea
                    id="competences"
                    name="competences"
                    rows="4"
                    placeholder="Ex. PHP, HTML/CSS, français, anglais..."
                ><?= old('competences') ?></textarea>

            </div>


            <div class="field">

                <label for="remarques">
                    Vos remarques
                </label>

                <textarea
                    id="remarques"
                    name="remarques"
                    rows="4"
                ><?= old('remarques') ?></textarea>

            </div>


            <div class="field">

                <label for="fichier">
                    Fichier (facultatif)
                </label>

                <input
                    type="file"
                    id="fichier"
                    name="fichier"
                >

                <small>
                    Le fichier est facultatif.
                    Le nom du fichier sera affiché dans le récapitulatif.
                </small>

            </div>

        </section>



        <!-- =====================================================
             BOUTONS
        ====================================================== -->

        <div class="actions">

            <button
                type="submit"
                class="btn primary"
            >
                Envoyer
            </button>


            <button
                type="reset"
                class="btn secondary"
            >
                Effacer
            </button>

        </div>


    </form>

</div>



<script>

/*
=========================================================
1. MODULES PAR FILIÈRE
=========================================================

Chaque filière possède sa propre liste de modules.

L'étudiant choisit une filière.
JavaScript affiche ensuite les modules correspondants.
*/

const modulesParFiliere = {

    "2AP": [

        "Analyse",

        "Algèbre",

        "Physique",

        "Électronique",

        "Mécanique",

        "Informatique",

        "Français",

        "Anglais"

    ],


    "GSTR": [

        "Réseaux",

        "Télécommunications",

        "Systèmes embarqués",

        "Communication",

        "Sécurité des réseaux",

        "Administration réseaux"

    ],


    "GI": [

        "Programmation Orientée Objet",

        "Développement Web avancé",

        "Bases de données",

        "Réseaux",

        "Compilation",

        "Big Data"

    ],


    "SCM": [

        "Théorie des graphes",

        "Recherche opérationnelle",

        "Bases de données",

        "SQL",

        "Statistiques",

        "Gestion de la chaîne logistique"

    ],


    "Mecatronique": [

        "Électronique",

        "Mécanique",

        "Automatique",

        "Mathématiques",

        "Statistiques",

        "Systèmes mécatroniques"

    ],


    "BigData": [

        "Probabilités",

        "Statistiques",

        "Bases de données",

        "SQL",

        "Java",

        "Big Data",

        "Analyse de données"

    ],


    "Cybersecurite": [

        "Réseaux",

        "Sécurité informatique",

        "Systèmes",

        "Cryptographie",

        "Cybersécurité",

        "Administration systèmes"

    ],


    "GC": [

        "Mécanique",

        "Résistance des matériaux",

        "Hydraulique",

        "Béton armé",

        "Géotechnique",

        "Construction"

    ]

};


/*
=========================================================
2. RÉCUPÉRER LES MODULES DÉJÀ CHOISIS
=========================================================

Cette partie permet de garder les cases cochées
lorsqu'on revient sur le formulaire avec "Modifier".
*/

const modulesDejaChoisis =
    <?= json_encode($data['modules'] ?? [], JSON_UNESCAPED_UNICODE) ?>;



/*
=========================================================
3. RÉCUPÉRER LA ZONE DES MODULES
=========================================================
*/

const modulesContainer =
    document.getElementById('modulesContainer');



/*
=========================================================
4. FONCTION QUI AFFICHE LES MODULES
=========================================================
*/

function afficherModules(filiere) {

    /*
     * On vide d'abord la zone.
     */
    modulesContainer.innerHTML = '';


    /*
     * Si aucune filière n'est sélectionnée.
     */
    if (filiere === '') {

        modulesContainer.innerHTML =
            '<p class="module-message">Sélectionnez une filière.</p>';

        return;
    }


    /*
     * Récupération des modules
     * correspondant à la filière.
     */
    const modules = modulesParFiliere[filiere];


    /*
     * Création des cases à cocher.
     */
    modules.forEach(function(module) {

        const label = document.createElement('label');

        label.className = 'choice';


        const checkbox = document.createElement('input');

        checkbox.type = 'checkbox';

        checkbox.name = 'modules[]';

        checkbox.value = module;


        /*
         * Si le module avait déjà été sélectionné,
         * on garde la case cochée.
         */
        if (modulesDejaChoisis.includes(module)) {

            checkbox.checked = true;

        }


        label.appendChild(checkbox);

        label.appendChild(
            document.createTextNode(' ' + module)
        );


        modulesContainer.appendChild(label);

    });

}



/*
=========================================================
5. QUAND ON CHANGE DE FILIÈRE
=========================================================
*/

const filieres =
    document.querySelectorAll('input[name="filiere"]');


filieres.forEach(function(radio) {

    radio.addEventListener('change', function() {

        afficherModules(this.value);

    });

});



/*
=========================================================
6. AFFICHER LES MODULES AU CHARGEMENT
=========================================================

Si l'étudiant revient sur le formulaire avec "Modifier",
on affiche directement les modules de sa filière.
*/

const filiereSelectionnee =
    document.querySelector('input[name="filiere"]:checked');


if (filiereSelectionnee) {

    afficherModules(filiereSelectionnee.value);

}



/*
=========================================================
7. GESTION DES PROJETS / STAGES
=========================================================
*/

const nombreProjets =
    document.getElementById('nombre_projets');


const container =
    document.getElementById('projectsContainer');


nombreProjets.addEventListener('change', function () {

    let nombre =
        parseInt(this.value);


    if (isNaN(nombre) || nombre < 1) {

        nombre = 1;

    }


    if (nombre > 5) {

        nombre = 5;

    }


    this.value = nombre;


    /*
     * On garde les informations déjà saisies
     * dans les projets existants.
     */

    const anciens = [];


    document
        .querySelectorAll('.project-box')
        .forEach(function(box) {

            anciens.push({

                start:
                    box.querySelector(
                        '[name="project_start[]"]'
                    ).value,

                end:
                    box.querySelector(
                        '[name="project_end[]"]'
                    ).value,

                location:
                    box.querySelector(
                        '[name="project_location[]"]'
                    ).value,

                description:
                    box.querySelector(
                        '[name="project_description[]"]'
                    ).value

            });

        });


    /*
     * On vide la zone.
     */

    container.innerHTML = '';


    /*
     * On recrée les projets.
     */

    for (let i = 0; i < nombre; i++) {

        const project =
            anciens[i] || {

                start: '',
                end: '',
                location: '',
                description: ''

            };


        container.innerHTML += `

            <div class="project-box">

                <h3>
                    Projet / stage ${i + 1}
                </h3>


                <div class="grid two">


                    <div class="field">

                        <label>
                            Date de début
                        </label>

                        <input
                            type="date"
                            name="project_start[]"
                            value="${project.start}"
                        >

                    </div>


                    <div class="field">

                        <label>
                            Date de fin
                        </label>

                        <input
                            type="date"
                            name="project_end[]"
                            value="${project.end}"
                        >

                    </div>


                    <div class="field full">

                        <label>
                            Lieu
                        </label>

                        <input
                            type="text"
                            name="project_location[]"
                            value="${project.location}"
                        >

                    </div>


                    <div class="field full">

                        <label>
                            Description
                        </label>

                        <textarea
                            name="project_description[]"
                            rows="3"
                        >${project.description}</textarea>

                    </div>


                </div>

            </div>

        `;

    }

});

</script>

</body>

</html>