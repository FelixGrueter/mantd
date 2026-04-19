<?php
/**
 * MANTD Contact Form Handler
 * Processes AJAX requests and sends emails via PHP mail()
 */

header('Content-Type: application/json; charset=utf-8');

// 1. Honeypot check (Bots often fill every field)
// We use a field named 'website' which will be hidden from humans.
if (!empty($_POST['website'])) {
    // If hidden field is filled, it's likely a bot. 
    // We return success to fool the bot into thinking it succeeded.
    echo json_encode(['success' => true, 'message' => 'Message received (bot detected)']);
    exit;
}

// 2. Validate input
$name    = isset($_POST['name'])    ? trim(strip_tags($_POST['name']))    : '';
$email   = isset($_POST['email'])   ? trim(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) : '';
$message = isset($_POST['message']) ? trim(strip_tags($_POST['message'])) : '';

if (empty($name) || empty($email) || empty($message)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Bitte füllen Sie alle Felder korrekt aus.']);
    exit;
}

// 3. Email configuration
$to      = 'info@mantd.org';
$subject = "MANTD Kontakt: $name";
$body    = "Du hast eine neue Nachricht über das MANTD Kontaktformular erhalten:\n\n";
$body   .= "Name: $name\n";
$body   .= "E-Mail: $email\n\n";
$body   .= "Nachricht:\n$message\n";

// Set headers
// Using a fixed 'From' address belonging to the domain (noreply@mantd.org) 
// significantly improves deliverability on servers like All-Inkl.
$from_email = 'noreply@mantd.org';
$headers  = "From: MANTD Webseite <$from_email>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// 4. Send email
if (mail($to, $subject, $body, $headers)) {
    echo json_encode(['success' => true, 'message' => 'Deine Nachricht wurde erfolgreich versendet!']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Es gab einen Serverfehler. Bitte versuche es später erneut.']);
}
?>
