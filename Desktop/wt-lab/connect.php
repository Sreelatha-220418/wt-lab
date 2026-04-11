<?php
session_start();
require "db.php";

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: auth.php");
    exit;
}

$successMessage = "";
$errorMessage = "";

/* DONOR REGISTRATION */
if (isset($_POST['register_donor'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $blood_group = trim($_POST['blood_group']);
    $age = (int)$_POST['age'];
    $address = trim($_POST['address']);

    if (empty($name) || empty($email) || empty($phone) || empty($blood_group) || empty($age) || empty($address)) {
        $errorMessage = "All fields are required";
    } elseif ($age < 18 || $age > 65) {
        $errorMessage = "Age must be between 18 and 65";
    } else {
        // Check if donor already exists
        $existingDonor = findDonor($email);

        if ($existingDonor) {
            $errorMessage = "Email already registered as donor";
        } else {
            $donorData = [
                'full_name' => $name,
                'email' => $email,
                'phone' => $phone,
                'blood_group' => $blood_group,
                'age' => $age,
                'address' => $address,
                'registration_date' => date('Y-m-d H:i:s'),
                'status' => 'active'
            ];

            addDonor($donorData);
            $successMessage = "Donor registration successful! Thank you for joining our blood donation camp.";
        }
    }
}

/* BLOOD REQUEST */
if (isset($_POST['request_blood'])) {
    $patient_name = trim($_POST['patient_name']);
    $blood_group = trim($_POST['blood_group']);
    $units_needed = (int)$_POST['units_needed'];
    $hospital = trim($_POST['hospital']);
    $contact_person = trim($_POST['contact_person']);
    $contact_phone = trim($_POST['contact_phone']);
    $urgency = trim($_POST['urgency']);

    if (empty($patient_name) || empty($blood_group) || empty($units_needed) || empty($hospital) || empty($contact_person) || empty($contact_phone)) {
        $errorMessage = "All fields are required";
    } else {
        // Add blood request
        $requestData = [
            'patient_name' => $patient_name,
            'blood_group' => $blood_group,
            'units_needed' => $units_needed,
            'hospital' => $hospital,
            'contact_person' => $contact_person,
            'contact_phone' => $contact_phone,
            'urgency' => $urgency,
            'requester_email' => $_SESSION['user_email'],
            'request_date' => date('Y-m-d H:i:s'),
            'status' => 'pending'
        ];

        addBloodRequest($requestData);
        $successMessage = "Blood request submitted successfully. We will contact you soon.";
    }
}
?>