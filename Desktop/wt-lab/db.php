<?php
// db.php - Simple File-based Database (Fallback for MongoDB)
// You can later upgrade to MongoDB when extensions are properly configured

// Create data directory if it doesn't exist
$dataDir = __DIR__ . '/data';
if (!file_exists($dataDir)) {
    mkdir($dataDir, 0755, true);
}

// Simple JSON-based storage functions
function saveData($filename, $data) {
    $file = __DIR__ . '/data/' . $filename . '.json';
    return file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
}

function loadData($filename) {
    $file = __DIR__ . '/data/' . $filename . '.json';
    if (file_exists($file)) {
        return json_decode(file_get_contents($file), true);
    }
    return [];
}

// Initialize data files
$users = loadData('users');
$donors = loadData('donors');
$blood_requests = loadData('blood_requests');

// Helper functions
function findUser($email) {
    global $users;
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            return $user;
        }
    }
    return null;
}

function addUser($userData) {
    global $users;
    $users[] = $userData;
    saveData('users', $users);
}

function findDonor($email) {
    global $donors;
    foreach ($donors as $donor) {
        if ($donor['email'] === $email) {
            return $donor;
        }
    }
    return null;
}

function addDonor($donorData) {
    global $donors;
    $donors[] = $donorData;
    saveData('donors', $donors);
}

function countDonors() {
    global $donors;
    return count($donors);
}

function addBloodRequest($requestData) {
    global $blood_requests;
    $blood_requests[] = $requestData;
    saveData('blood_requests', $blood_requests);
}
?>