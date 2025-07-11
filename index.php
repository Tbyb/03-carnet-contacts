<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header('Location: connexion.php');
    exit();
}

$fichier = 'contacts.csv';

// Enregistrer nouveau contact
if (isset($_POST['nom'], $_POST['prenom'], $_POST['telephone'], $_POST['email'])) {
    $ligne = [$_POST['nom'], $_POST['prenom'], $_POST['telephone'], $_POST['email']];
    $f = fopen($fichier, 'a');
    fputcsv($f, $ligne);
    fclose($f);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Carnet de contacts</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light p-4">

<div class="container bg-white p-4 shadow rounded">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-person-lines-fill"></i> Carnet de contacts</h2>
        <a href="deconnexion.php" class="btn btn-outline-danger"><i class="bi bi-box-arrow-left"></i> Se déconnecter</a>
    </div>

    <!-- Formulaire d'ajout -->
    <h4><i class="bi bi-person-plus-fill"></i> Ajouter un contact</h4>
    <form method="POST" class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="text" class="form-control" name="nom" placeholder="Nom" required>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="prenom" placeholder="Prénom" required>
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="telephone" placeholder="Téléphone" required>
        </div>
        <div class="col-md-3">
            <input type="email" class="form-control" name="email" placeholder="Email" required>
        </div>
        <div class="col-md-12 text-end">
            <button type="submit" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Ajouter</button>
        </div>
    </form>

    <!-- Recherche -->
    <h4><i class="bi bi-search"></i> Rechercher un contact</h4>
    <form method="GET" class="d-flex mb-4">
        <input type="text" name="recherche" class="form-control me-2" placeholder="Nom, email, etc." value="<?= isset($_GET['recherche']) ? htmlspecialchars($_GET['recherche']) : '' ?>">
        <button type="submit" class="btn btn-outline-secondary"><i class="bi bi-search"></i> Rechercher</button>
    </form>

    <!-- Tableau -->
    <h4><i class="bi bi-journal-text"></i> Liste des contacts</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (file_exists($fichier)) {
                    $f = fopen($fichier, 'r');
                    while ($ligne = fgetcsv($f)) {
                        // Filtrage si recherche
                        if (isset($_GET['recherche']) && $_GET['recherche'] !== '') {
                            $mot = strtolower($_GET['recherche']);
                            $trouve = false;
                            foreach ($ligne as $champ) {
                                if (strpos(strtolower($champ), $mot) !== false) {
                                    $trouve = true;
                                    break;
                                }
                            }
                            if (!$trouve) continue;
                        }

                        echo "<tr>";
                        foreach ($ligne as $champ) {
                            echo "<td>" . htmlspecialchars((string)$champ) . "</td>";
                        }
                        echo "</tr>";
                    }
                    fclose($f);
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
