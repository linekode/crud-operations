<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Récupérer l'utilisateur de manière sécurisée
    $stmt = $pdo->prepare("SELECT id, nom, password FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nom'] = $user['nom'];
        header('Location: index.php');
        exit();
    } else {
        echo "<div class='alert alert-danger'>Identifiants incorrects.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="card-title text-center">Connexion</h2>
                        <form method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email :</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe :</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                            <button type="submit" name="login" class="btn btn-primary w-100">Se connecter</button>
                        </form>
                        <div class="mt-3 text-center">
                            <a href="register.php" class="text-decoration-none">Pas encore inscrit? S'inscrire</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>