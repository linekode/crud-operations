<?php
    require 'db.php';
    $id = $_GET['id'];
    
    $stmt = $pdo->prepare("DELETE FROM users where id= :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header('Location: index.php');
    exit();
?>