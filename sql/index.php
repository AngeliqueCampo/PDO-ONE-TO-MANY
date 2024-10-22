<?php
require_once '../core/dbConfig.php';
require_once '../core/models.php'; // Include models for database operations

// fetch all veterinarians
$stmt = $pdo->query("SELECT * FROM Veterinarians");
$vets = $stmt->fetchAll(PDO::FETCH_ASSOC);

// fetch all appointments
$stmt = $pdo->query("SELECT Appointments.*, Veterinarians.VetName FROM Appointments JOIN Veterinarians ON Appointments.VetID = Veterinarians.VetID");
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// handle add veterinarian form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['type'] === 'vet') {
    if ($_POST['action'] == 'add') {
        addVeterinarian($_POST['vet_name']);
        header("Location: index.php"); // redirect to avoid resubmission
        exit();
    }
}

// handle add appointment form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['type'] === 'appointment') {
    if ($_POST['action'] == 'add') {
        addAppointment($_POST['vet_id'], $_POST['pet_name'], $_POST['owner_name'], $_POST['appointment_date'], $_POST['appointment_time']);
        header("Location: index.php"); // redirect to avoid resubmission
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Veterinary Clinic Management</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Veterinary Clinic Management</h1>

    <!-- add vet form -->
    <h2>Add New Veterinarian</h2>
    <form action="index.php" method="post">
        <input type="hidden" name="type" value="vet">
        <input type="hidden" name="action" value="add">
        <label for="vet_name">Veterinarian Name:</label>
        <input type="text" name="vet_name" required><br>
        <button type="submit">Add Veterinarian</button>
    </form>
    <br>

    <!-- list of vets -->
    <h2>Manage Veterinarians</h2>
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
                            <a href="../core/handleForms.php?action=delete&type=vet&vet_id=<?= $vet['VetID'] ?>" 
                               onclick="return confirm('Are you sure you want to delete this veterinarian?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <br>

    <!-- add appointment form -->
    <h2>Add New Appointment</h2>
    <form action="index.php" method="post">
        <input type="hidden" name="type" value="appointment">
        <input type="hidden" name="action" value="add">
        <label for="vet_id">Veterinarian:</label>
        <select name="vet_id" required>
            <option value="">Select Veterinarian</option>
            <?php foreach ($vets as $vet): ?>
                <option value="<?= $vet['VetID'] ?>"><?= htmlspecialchars($vet['VetName']) ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <label for="pet_name">Pet Name:</label>
        <input type="text" name="pet_name" required>
        <br>
        <label for="owner_name">Owner Name:</label>
        <input type="text" name="owner_name" required>
        <br>
        <label for="appointment_date">Appointment Date:</label>
        <input type="date" name="appointment_date" required>
        <br>
        <label for="appointment_time">Appointment Time:</label>
        <input type="time" name="appointment_time" required>
        <br>
        <button type="submit">Add Appointment</button>
    </form>
    <br>

    <!-- list of appointments -->
    <h2>Manage Appointments</h2>
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
                        <td><?= htmlspecialchars($appointment['VetID']) ?></td>
                        <td><?= htmlspecialchars($appointment['VetName']) ?></td>
                        <td><?= htmlspecialchars($appointment['PetName']) ?></td>
                        <td><?= htmlspecialchars($appointment['OwnerName']) ?></td>
                        <td><?= htmlspecialchars($appointment['AppointmentDate']) ?></td>
                        <td><?= htmlspecialchars($appointment['AppointmentTime']) ?></td>
                        <td>
                            <a href="manage_appointments.php?action=edit&appointment_id=<?= $appointment['AppointmentID'] ?>">Edit</a>
                            <a href="../core/handleForms.php?action=delete&type=appointment&appointment_id=<?= $appointment['AppointmentID'] ?>" 
                               onclick="return confirm('Are you sure you want to delete this appointment?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <br>
</body>
</html>
