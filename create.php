<?php
// Inclusion du fichier de connexion à la base de données
require 'db.php';

// Vérifier si le formulaire a été soumis via la méthode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des valeurs saisies dans le formulaire
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $age = $_POST['age'];

    // Vérifier que tous les champs sont remplis avant l'insertion
    if (!empty($nom) && !empty($email) && !empty($age)) {
        // Préparation de la requête SQL pour insérer un nouvel utilisateur
        $stmt = $pdo->prepare("INSERT INTO etudiants (nom, email, age) VALUES (:nom, :email, :age)");

        // Liaison des valeurs avec les paramètres de la requête préparée
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':age', $age);

        // Exécution de la requête et vérification de la réussite
        if ($stmt->execute()) {
            // Redirection vers la page d'accueil après l'ajout de l'utilisateur
            header('Location: index.php');
            exit(); // Assurer l'arrêt du script après la redirection
        }
    } else {
        // Message d'erreur si un champ est vide
        echo "Tous les champs sont obligatoires.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles.css">
    <title>Ajouter un utilisateur</title>
</head>

<body>
    <div class="container">
        <h1>Ajouter un utilisateur</h1>

        <!-- Formulaire permettant d'ajouter un nouvel utilisateur -->
        <form method="POST">
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" required>

            <label for="email">Email :</label>
            <input type="email" name="email" id="email" required>

            <label for="age">Âge :</label>
            <input type="number" name="age" id="age" required>

            <!-- Bouton pour soumettre le formulaire -->
            <button type="submit">Ajouter</button>
        </form>
    </div>
</body>

</html>
