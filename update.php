<?php
// Inclusion du fichier de connexion à la base de données
require 'db.php';

// Récupération de l'ID de l'utilisateur depuis l'URL
$id = $_GET['id'];

// Préparation de la requête pour récupérer les informations de l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");

// Liaison de la valeur de l'ID avec la requête préparée
$stmt->bindParam(':id', $id);

// Exécution de la requête
$stmt->execute();

// Récupération des informations de l'utilisateur sous forme de tableau associatif
$user = $stmt->fetch();

// Vérifier si le formulaire a été soumis (méthode POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données envoyées par le formulaire
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $age = $_POST['age'];

    // Vérification que tous les champs sont remplis
    if (!empty($nom) && !empty($email) && !empty($age)) {
        // Préparation de la requête pour mettre à jour les informations de l'utilisateur
        $stmt = $pdo->prepare("UPDATE etudiants SET nom = :nom, email = :email, age = :age WHERE id = :id");

        // Liaison des valeurs avec la requête préparée
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':age', $age);

        // Exécution de la requête
        $stmt->execute();

        // Redirection vers la page d'accueil après la mise à jour
        header('Location: index.php');
        exit(); // Arrêter l'exécution du script après la redirection
    } else {
        // Afficher un message d'erreur si un champ est vide
        echo "Tous les champs sont obligatoires";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles.css">
    <title>Modifier un utilisateur</title>
</head>

<body>
    <div class="container">
        <h1>Modifier un utilisateur</h1>

        <!-- Formulaire permettant de modifier les informations de l'utilisateur -->
        <form method="POST">
            <!-- Champ pour modifier le nom -->
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($user['nom']) ?>" required>

            <!-- Champ pour modifier l'email -->
            <label for="email">Email :</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required>

            <!-- Champ pour modifier l'âge -->
            <label for="age">Âge :</label>
            <input type="number" name="age" id="age" value="<?= htmlspecialchars($user['age']) ?>" required>

            <!-- Bouton pour soumettre le formulaire -->
            <button type="submit">Modifier</button>
        </form>
    </div>
</body>

</html>