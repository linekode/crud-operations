<header>
    <nav>
        <span>Linekode</span>
        <ul>
            <li><a href="./index.php">Acceuil</a></li>
            <li><a href="./create.php">Ajout utilisateur</a></li>
            <li><?= htmlspecialchars($_SESSION['user_nom']) ?></li>
        </ul>
    </nav>
</header>