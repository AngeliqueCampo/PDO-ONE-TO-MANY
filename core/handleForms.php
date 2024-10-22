<?php
require_once 'models.php';

// handle veterinarian form actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['type'] === 'vet') {
        if ($_POST['action'] == 'add') {
            addVeterinarian($_POST['vet_name']);
        } elseif ($_POST['action'] == 'edit') {
            editVeterinarian($_POST['vet_id'], $_POST['vet_name']);
        } elseif ($_POST['action'] == 'delete') {
            deleteVeterinarian($_POST['vet_id']);
        }
        header("Location: ../sql/manage_vets.php"); // redirects back to manage vets after action
        exit();
    }

    // handle appointment form actions
    if (isset($_POST['action']) && $_POST['type'] === 'appointment') {
        if ($_POST['action'] == 'add') {
            addAppointment($_POST['vet_id'], $_POST['pet_name'], $_POST['owner_name'], $_POST['appointment_date'], $_POST['appointment_time']);
        } elseif ($_POST['action'] == 'edit') {
            editAppointment($_POST['appointment_id'], $_POST['vet_id'], $_POST['pet_name'], $_POST['owner_name'], $_POST['appointment_date'], $_POST['appointment_time']);
        }
        header("Location: ../sql/manage_appointments.php"); // redirects back to manage appointments after action
        exit();
    }
}

// handle GET request for deletion
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    if ($_GET['type'] === 'vet') {
        $vet_id = $_GET['vet_id'];
        deleteVeterinarian($vet_id);
        header("Location: ../sql/manage_vets.php"); // redirects back to manage vets after deletion
        exit();
    } elseif ($_GET['type'] === 'appointment') {
        $appointment_id = $_GET['appointment_id'];
        deleteAppointment($appointment_id);
        header("Location: ../sql/manage_appointments.php"); // redirect back to manage appointments after deletion
        exit();
    }
}
?>
