<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
}
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register'])) {
    $nom = htmlspecialchars($_POST['nom']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash du mot de passe

    // Vérifier si l'email existe déjà
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "<div class='alert alert-danger'>Cet email est déjà utilisé.</div>";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (nom, email, password) VALUES (:nom, :email, :password)");
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Inscription réussie. <a href='login.php'>Se connecter</a></div>";
        } else {
            echo "<div class='alert alert-danger'>Erreur lors de l'inscription.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="card-title text-center">Inscription</h2>
                        <form method="post">
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom Complet :</label>
                                <input type="text" name="nom" id="nom" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email :</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe :</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                            <button type="submit" name="register" class="btn btn-primary w-100">S'inscrire</button>
                        </form>
                        <div class="mt-3 text-center">
                            <a href="login.php" class="text-decoration-none">Déjà inscrit? Se connecter</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>