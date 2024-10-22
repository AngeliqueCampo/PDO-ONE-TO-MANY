<?php
require_once '../core/dbConfig.php';

// Check for delete action
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['vet_id'])) {
    $vet_id = $_GET['vet_id'];
    
    // Prepare and execute delete query
    $stmt = $pdo->prepare("DELETE FROM Veterinarians WHERE VetID = :vet_id");
    $stmt->execute(['vet_id' => $vet_id]);

    // Redirect back to avoid resubmitting the delete action on refresh
    header("Location: manage_vets.php");
    exit;
}

// Check for edit action
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['vet_id'])) {
    $vet_id = $_GET['vet_id'];
    $stmt = $pdo->prepare("SELECT * FROM Veterinarians WHERE VetID = :vet_id");
    $stmt->execute(['vet_id' => $vet_id]);
    $vet = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fetch all veterinarians
$stmt = $pdo->query("SELECT * FROM Veterinarians");
$vets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Veterinarians</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Manage Veterinarians</h1>

    <!-- Edit veterinarian form -->
    <?php if (isset($vet)): ?>
        <h2>Edit Veterinarian</h2>
        <form action="../core/handleForms.php" method="post">
            <input type="hidden" name="type" value="vet">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="vet_id" value="<?= htmlspecialchars($vet['VetID']) ?>">
            <label for="vet_name">Veterinarian Name:</label>
            <input type="text" name="vet_name" value="<?= htmlspecialchars($vet['VetName']) ?>" required>
            <button type="submit">Update Veterinarian</button>
        </form>
        <br>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Veterinarian ID</th>
                <th>Veterinarian Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($vets)): ?>
                <tr>
                    <td colspan="3">No records. Please add one.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($vets as $vet): ?>
                    <tr>
                        <td><?= htmlspecialchars($vet['VetID']) ?></td>
                        <td><?= htmlspecialchars($vet['VetName']) ?></td>
                        <td>
                            <a href="manage_vets.php?action=edit&vet_id=<?= $vet['VetID'] ?>">Edit</a>
                            |
                            <a href="manage_vets.php?action=delete&vet_id=<?= $vet['VetID'] ?>" onclick="return confirm('Are you sure you want to delete this veterinarian?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="index.php">Back to Home</a>
</body>
</html>
