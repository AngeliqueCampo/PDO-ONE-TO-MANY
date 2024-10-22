<?php
require_once '../core/dbConfig.php';

// fetch all veterinarians
$vetStmt = $pdo->query("SELECT * FROM Veterinarians");
$vets = $vetStmt->fetchAll(PDO::FETCH_ASSOC);

// fetch all appointments
$stmt = $pdo->query("SELECT Appointments.*, Veterinarians.VetName FROM Appointments JOIN Veterinarians ON Appointments.VetID = Veterinarians.VetID");
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// check for edit action
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['appointment_id'])) {
    $appointment_id = $_GET['appointment_id'];
    $stmt = $pdo->prepare("SELECT * FROM Appointments WHERE AppointmentID = :appointment_id");
    $stmt->execute(['appointment_id' => $appointment_id]);
    $appointment = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Appointments</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Manage Appointments</h1>

    <!-- add/edit appointment form -->
    <h2><?= isset($appointment) ? 'Edit Appointment' : 'Add New Appointment' ?></h2>
    <form action="../core/handleForms.php" method="post">
    <input type="hidden" name="type" value="appointment">
    <input type="hidden" name="action" value="<?= isset($appointment) ? 'edit' : 'add' ?>">
    <?php if (isset($appointment)): ?>
        <input type="hidden" name="appointment_id" value="<?= htmlspecialchars($appointment['AppointmentID']) ?>">
    <?php endif; ?>

    <label for="vet_id">Veterinarian:</label><br>
    <select name="vet_id" required>
        <option value="">Select a Veterinarian</option>
        <?php foreach ($vets as $vet): ?>
            <option value="<?= $vet['VetID'] ?>" <?= isset($appointment) && $appointment['VetID'] == $vet['VetID'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($vet['VetName']) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="pet_name">Pet Name:</label><br>
    <input type="text" name="pet_name" value="<?= isset($appointment) ? htmlspecialchars($appointment['PetName']) : '' ?>" required><br><br>

    <label for="owner_name">Owner Name:</label><br>
    <input type="text" name="owner_name" value="<?= isset($appointment) ? htmlspecialchars($appointment['OwnerName']) : '' ?>" required><br><br>

    <label for="appointment_date">Date:</label><br>
    <input type="date" name="appointment_date" value="<?= isset($appointment) ? htmlspecialchars($appointment['AppointmentDate']) : '' ?>" required><br><br>

    <label for="appointment_time">Time:</label><br>
    <input type="time" name="appointment_time" value="<?= isset($appointment) ? htmlspecialchars($appointment['AppointmentTime']) : '' ?>" required><br><br>

    <button type="submit"><?= isset($appointment) ? 'Update Appointment' : 'Add Appointment' ?></button>
</form>

    <br>

    <table>
        <thead>
            <tr>
                <th>Appointment ID</th>
                <th>Vet ID</th>
                <th>Veterinarian</th>
                <th>Pet Name</th>
                <th>Owner Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($appointments)): ?>
                <tr>
                    <td colspan="8">No records. Please add one.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($appointments as $appointment): ?>
                    <tr>
                        <td><?= htmlspecialchars($appointment['AppointmentID']) ?></td>
                        <td><?= htmlspecialchars($appointment['VetID']) ?></td> <!-- Display VetID -->
                        <td><?= htmlspecialchars($appointment['VetName']) ?></td>
                        <td><?= htmlspecialchars($appointment['PetName']) ?></td>
                        <td><?= htmlspecialchars($appointment['OwnerName']) ?></td>
                        <td><?= htmlspecialchars($appointment['AppointmentDate']) ?></td>
                        <td><?= htmlspecialchars($appointment['AppointmentTime']) ?></td>
                        <td>
                            <a href="manage_appointments.php?action=edit&appointment_id=<?= $appointment['AppointmentID'] ?>">Edit</a>
                            <a href="../core/handleForms.php?action=delete&type=appointment&appointment_id=<?= $appointment['AppointmentID'] ?>" onclick="return confirm('Are you sure you want to delete this appointment?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <br>
    <a href="index.php">Back to Home</a>
</body>
</html>
