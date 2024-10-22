<?php
require_once 'dbConfig.php';

// veterinarian CRUD operations
function addVeterinarian($vetName) {
    global $pdo;
    $sql = "INSERT INTO Veterinarians (VetName) VALUES (:vet_name)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute(['vet_name' => $vetName]);
}

function editVeterinarian($vetID, $vetName) {
    global $pdo;
    $sql = "UPDATE Veterinarians SET VetName = :vet_name WHERE VetID = :vet_id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute(['vet_name' => $vetName, 'vet_id' => $vetID]);
}

function deleteVeterinarian($vet_id) {
    global $pdo;

    $stmt = $pdo->prepare("DELETE FROM Appointments WHERE VetID = :vet_id");
    $stmt->execute(['vet_id' => $vet_id]);

    $stmt = $pdo->prepare("DELETE FROM Veterinarians WHERE VetID = :vet_id");
    $stmt->execute(['vet_id' => $vet_id]);
}


// appointment CRUD operations
function addAppointment($vetID, $petName, $ownerName, $appointmentDate, $appointmentTime) {
    global $pdo;
    $sql = "INSERT INTO Appointments (VetID, PetName, OwnerName, AppointmentDate, AppointmentTime) 
            VALUES (:vet_id, :pet_name, :owner_name, :appointment_date, :appointment_time)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        'vet_id' => $vetID,
        'pet_name' => $petName,
        'owner_name' => $ownerName,
        'appointment_date' => $appointmentDate,
        'appointment_time' => $appointmentTime
    ]);
}

function editAppointment($appointmentID, $vetID, $petName, $ownerName, $appointmentDate, $appointmentTime) {
    global $pdo;
    $sql = "UPDATE Appointments 
            SET VetID = :vet_id, PetName = :pet_name, OwnerName = :owner_name, AppointmentDate = :appointment_date, AppointmentTime = :appointment_time 
            WHERE AppointmentID = :appointment_id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        'vet_id' => $vetID,
        'pet_name' => $petName,
        'owner_name' => $ownerName,
        'appointment_date' => $appointmentDate,
        'appointment_time' => $appointmentTime,
        'appointment_id' => $appointmentID
    ]);
}

function deleteAppointment($appointmentID) {
    global $pdo;
    $sql = "DELETE FROM Appointments WHERE AppointmentID = :appointment_id";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute(['appointment_id' => $appointmentID]);
    
    if ($result) {
        echo "Appointment with ID $appointmentID deleted successfully.";
    } else {
        var_dump($stmt->errorInfo());
    }
    return $result;
}

?>
