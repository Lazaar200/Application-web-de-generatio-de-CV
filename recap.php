<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') !== 'validate') {
    $projects = [];

    $starts = $_POST['project_start'] ?? [];
    $ends = $_POST['project_end'] ?? [];
    $locations = $_POST['project_location'] ?? [];
    $descriptions = $_POST['project_description'] ?? [];

    $nombre = max(count($starts), count($ends), count($locations), count($descriptions));

    for ($i = 0; $i < $nombre; $i++) {
        $projects[] = [
            'start' => $starts[$i] ?? '',
            'end' => $ends[$i] ?? '',
            'location' => $locations[$i] ?? '',
            'description' => $descriptions[$i] ?? ''
        ];
    }

    $fileName = '';
    if (isset($_FILES['fichier']) && $_FILES['fichier']['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($_FILES['fichier']['name']);
    }

    $_SESSION['form_data'] = [
        'nom' => $_POST['nom'] ?? '',
        'prenom' => $_POST['prenom'] ?? '',
        'age' => $_POST['age'] ?? '',
        'telephone' => $_POST['telephone'] ?? '',
        'email' => $_POST['email'] ?? '',
        'filiere' => $_POST['filiere'] ?? '',
        'annee' => $_POST['annee'] ?? '',
        'modules' => $_POST['modules'] ?? [],
        'projects' => $projects,
        'interets' => $_POST['interets'] ?? '',
        'competences' => $_POST['competences'] ?? '',
        'remarques' => $_POST['remarques'] ?? '',
        'file_name' => $fileName
    ];
}

$data = $_SESSION['form_data'] ?? [];

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function showList($items) {
    if (empty($items)) return 'Aucune information';
    return e(implode(', ', $items));
}

if (empty($data)) {
    header('Location: formulaire.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récapitulatif - TP1 PHP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="page">
    <header class="intro">
        <p class="small-title">ENSA Tétouan · TP1 PHP</p>
        <h1>Récapitulatif</h1>
        <p>Voici les informations saisies dans le formulaire.</p>
    </header>

    <section class="card recap">
        <h2>Informations personnelles</h2>
        <p><strong>Nom :</strong> <?= e($data['nom']) ?></p>
        <p><strong>Prénom :</strong> <?= e($data['prenom']) ?></p>
        <p><strong>Âge :</strong> <?= e($data['age']) ?></p>
        <p><strong>Téléphone :</strong> <?= e($data['telephone']) ?></p>
        <p><strong>Email :</strong> <?= e($data['email']) ?></p>
    </section>

    <section class="card recap">
        <h2>Renseignements académiques</h2>
        <p><strong>Filière :</strong> <?= e($data['filiere']) ?></p>
        <p><strong>Année :</strong> <?= e($data['annee']) ?></p>
        <p><strong>Modules :</strong> <?= showList($data['modules']) ?></p>
    </section>

    <section class="card recap">
        <h2>Projets et stages</h2>
        <?php foreach ($data['projects'] as $index => $project): ?>
            <div class="project-recap">
                <h3>Projet / stage <?= $index + 1 ?></h3>
                <p><strong>Date de début :</strong> <?= e($project['start']) ?></p>
                <p><strong>Date de fin :</strong> <?= e($project['end']) ?></p>
                <p><strong>Lieu :</strong> <?= e($project['location']) ?></p>
                <p><strong>Description :</strong><br><?= nl2br(e($project['description'])) ?></p>
            </div>
        <?php endforeach; ?>
    </section>

    <section class="card recap">
        <h2>Profil complémentaire</h2>
        <p><strong>Centres d'intérêt :</strong><br><?= nl2br(e($data['interets'])) ?></p>
        <p><strong>Compétences et langues :</strong><br><?= nl2br(e($data['competences'])) ?></p>
        <p><strong>Remarques :</strong><br><?= nl2br(e($data['remarques'])) ?></p>
        <p><strong>Fichier :</strong> <?= e($data['file_name'] ?: 'Aucun fichier sélectionné') ?></p>
    </section>

    <div class="actions">
        <form action="recap.php" method="post" class="inline-form">
            <input type="hidden" name="action" value="validate">
            <button type="submit" class="btn primary">Valider</button>
        </form>

        <form action="formulaire.php" method="post" class="inline-form">
            <input type="hidden" name="action" value="modify">
            <button type="submit" class="btn secondary">Modifier</button>
        </form>
    </div>

    <?php
    if (isset($_POST['action']) && $_POST['action'] === 'validate') {
        $text = "FICHE DE RENSEIGNEMENTS\n";
        $text .= "=======================\n\n";
        $text .= "Nom : " . $data['nom'] . "\n";
        $text .= "Prénom : " . $data['prenom'] . "\n";
        $text .= "Âge : " . $data['age'] . "\n";
        $text .= "Téléphone : " . $data['telephone'] . "\n";
        $text .= "Email : " . $data['email'] . "\n";
        $text .= "Filière : " . $data['filiere'] . "\n";
        $text .= "Année : " . $data['annee'] . "\n";
        $text .= "Modules : " . implode(', ', $data['modules']) . "\n\n";

        foreach ($data['projects'] as $index => $project) {
            $text .= "Projet / stage " . ($index + 1) . "\n";
            $text .= "Début : " . $project['start'] . "\n";
            $text .= "Fin : " . $project['end'] . "\n";
            $text .= "Lieu : " . $project['location'] . "\n";
            $text .= "Description : " . $project['description'] . "\n\n";
        }

        $text .= "Centres d'intérêt : " . $data['interets'] . "\n";
        $text .= "Compétences et langues : " . $data['competences'] . "\n";
        $text .= "Remarques : " . $data['remarques'] . "\n";

        file_put_contents(__DIR__ . '/data/renseignements.txt', $text);

        echo '<div class="success">Les informations ont été enregistrées dans <strong>data/renseignements.txt</strong>.</div>';
    }
    ?>
</div>
</body>
</html>
