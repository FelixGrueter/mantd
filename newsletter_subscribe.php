<?php
/**
 * MANTD Newsletter Subscription Handler (Brevo API v3)
 * Handles AJAX requests from the newsletter popup.
 */

// 1. Configuration
// Load sensitive data from config.php (excluded from Git)
if (file_exists('config.php')) {
    require_once 'config.php';
} else {
    // Fallback or error if config is missing
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Systemfehler: Konfiguration fehlt.']);
    exit;
}

header('Content-Type: application/json');

// 2. Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

// 3. Get and validate email
$email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);

if (!$email) {
    echo json_encode(['success' => false, 'message' => 'Bitte gib eine gültige E-Mail-Adresse ein.']);
    exit;
}

// 4. Prepare Brevo API call
$url = 'https://api.brevo.com/v3/contacts';
$data = [
    'email' => $email,
    'listIds' => [BREVO_LIST_ID],
    'updateEnabled' => true // Updates contact if already exists
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'api-key: ' . BREVO_API_KEY
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

// 5. Handle Response
if ($curlError) {
    echo json_encode(['success' => false, 'message' => 'Verbindungsfehler: ' . $curlError]);
} elseif ($httpCode >= 200 && $httpCode < 300) {
    echo json_encode(['success' => true, 'message' => 'Erfolgreich angemeldet!']);
} else {
    // Parse Brevo error message if available
    $result = json_decode($response, true);
    $errorMsg = $result['message'] ?? 'Ein Fehler ist aufgetreten (Brevo API).';
    echo json_encode(['success' => false, 'message' => 'Fehler: ' . $errorMsg]);
}
