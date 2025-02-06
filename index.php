<?php
require 'db.php';
$stmt = $pdo->query("SELECT * FROM etudiants");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles.css">
    <title>Liste des utilisateurs</title>
</head>

<body>
    <div class="container">
        <h1>Liste des utilisateurs</h1>

        <!-- Lien pour ajouter un nouvel utilisateur -->
        <a href="./create.php" class="btn">Ajouter un utilisateur</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Âge</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Vérifier si la liste des utilisateurs n'est pas vide -->
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <!-- Protection contre XSS en utilisant htmlspecialchars() -->
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['nom']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['age']) ?></td>
                            <td>
                                <!-- Lien de modification avec l'ID -->
                                <a href="update.php?id=<?= htmlspecialchars($user['id']) ?>">Modifier</a>

                                <!-- Lien de suppression sécurisé avec l'ID -->
                                <a href="delete.php?id=<?= htmlspecialchars($user['id']) ?>">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Affichage d'un message si aucun utilisateur n'est trouvé -->
                    <tr>
                        <td colspan="5" style="text-align:center;">Aucun utilisateur</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>