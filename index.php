<?php
include 'config.php';

// Vérifiez si une catégorie est sélectionnée
$category = isset($_GET['category']) ? intval($_GET['category']) : 0;

if ($category > 0) {
    // Récupérer les articles de la catégorie sélectionnée
    $stmt = $pdo->prepare('SELECT * FROM article WHERE categorie = ?');
    $stmt->execute([$category]);
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Récupérer tous les articles
    $stmt = $pdo->query('SELECT * FROM article');
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Récupérer toutes les catégories pour la barre de navigation
$stmt = $pdo->query('SELECT * FROM categorie');
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualite</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <header class="header">
        <h1>ACTUALITE POLYTECHNICIEN</h1>
    </header>

    <nav class="navbar">
        <ul>
            <li><a href="index.php">Acceuil</a></li>
            <?php foreach ($categories as $cat) : ?>
                <li><a href="index.php?category=<?= $cat['id'] ?>"><?= htmlspecialchars($cat['libelle']) ?></a></li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <main class="main-content">

        <?php if ($articles) : ?>
            <?php foreach ($articles as $article) : ?>
                <div class="box">
                    <h2><?= htmlspecialchars($article['titre']) ?></h2>
                    <p><?= htmlspecialchars($article['contenu']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>Aucun article trouvé pour cette catégorie.</p>
        <?php endif; ?>

    </main>
</body>

</html>