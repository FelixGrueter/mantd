<?php
/**
 * MANTD Contact Form Handler
 *
 * Zweck:
 * - Verarbeitet Kontaktformular-POSTs
 * - Schützt effektiv gegen Spam & Bots
 * - Liefert konsistente JSON-Antworten
 *
 * Umgebung:
 * - Shared Hosting (z. B. all-inkl)
 * - PHP >= 7.4
 */

declare(strict_types=1);

/* --------------------------------------------------------------------------
 * Basis-Setup
 * -------------------------------------------------------------------------- */

// Session wird benötigt für:
// - Mindest-Ausfüllzeit
// - Rate-Limiting (Cooldown)
session_start();

// Einheitliche JSON-Antworten
header('Content-Type: application/json; charset=utf-8');


/* --------------------------------------------------------------------------
 * Hilfsfunktion: reject()
 *
 * Zweck:
 * - Einheitliches Abweisen von Anfragen
 * - Optionaler HTTP-Statuscode
 * - Sauberes JSON für das Frontend
 *
 * WICHTIG:
 * - NUR für benutzerrelevante Ablehnungen benutzen
 * - NICHT für Honeypot / eindeutige Bots
 * -------------------------------------------------------------------------- */
function reject(
    int $statusCode = 400,
    string $message = 'Anfrage konnte nicht verarbeitet werden.'
): void {
    http_response_code($statusCode);
    echo json_encode([
        'success' => false,
        'message' => $message
    ]);
    exit;
}


/* --------------------------------------------------------------------------
 * 1. Honeypot-Check (BOT-Erkennung)
 *
 * - Feld "website" ist für Menschen unsichtbar
 * - Bots füllen es fast immer aus
 * - Reaktion: stillschweigend abbrechen (KEIN Feedback)
 *
 * WICHTIG:
 * - ABSOLUT ZUERST prüfen
 * - KEIN reject(), damit Bots nichts lernen
 * -------------------------------------------------------------------------- */
if (!empty($_POST['website'] ?? '')) {
    http_response_code(204); // No Content
    exit;
}


/* --------------------------------------------------------------------------
 * 2. Mindest-Ausfüllzeit (Session-basiert)
 *
 * - Menschen brauchen Zeit zum Lesen & Schreiben
 * - Bots sind zu schnell
 * - Session ist nicht manipulierbar
 *
 * Benutzerrelevant → reject()
 * -------------------------------------------------------------------------- */
$minTimeSeconds = 3;

if (
    !isset($_SESSION['form_time']) ||
    (time() - $_SESSION['form_time']) < $minTimeSeconds
) {
    reject(400);
}


/* --------------------------------------------------------------------------
 * 3. Rate-Limiting / Cooldown
 *
 * - Verhindert Doppelklicks & Flooding
 * - Gilt pro Session
 *
 * Benutzerrelevant → JSON-Feedback mit 429
 * -------------------------------------------------------------------------- */
$cooldownSeconds = 30;
$now = time();

if (
    isset($_SESSION['last_submit']) &&
    ($now - $_SESSION['last_submit']) < $cooldownSeconds
) {
    reject(
        429,
        'Bitte warten Sie einen Moment, bevor Sie erneut senden.'
    );
}

// Zeitpunkt des letzten gültigen Versuchs merken
$_SESSION['last_submit'] = $now;


/* --------------------------------------------------------------------------
 * 4. Input auslesen & säubern
 *
 * - Niemals direkt mit $_POST arbeiten
 * - Alles normalisieren, bevor geprüft wird
 * -------------------------------------------------------------------------- */
$name = isset($_POST['name'])
    ? trim(strip_tags($_POST['name']))
    : '';

$emailRaw = isset($_POST['email']) ? trim($_POST['email']) : '';
$email = filter_var($emailRaw, FILTER_VALIDATE_EMAIL) ?: '';

$message = isset($_POST['message'])
    ? trim(strip_tags($_POST['message']))
    : '';


/* --------------------------------------------------------------------------
 * 5. Backend-Validierung
 *
 * - Frontend-Checks sind KEINE Sicherheit
 * - Diese Prüfung ist zwingend
 * -------------------------------------------------------------------------- */
if ($name === '' || $email === '' || $message === '') {
    reject(
        400,
        'Bitte füllen Sie alle Felder korrekt aus.'
    );
}


/* --------------------------------------------------------------------------
 * 6. Mail-Vorbereitung (mit HTML & Text Templates)
 *
 * - Fester Absender (Domain-eigen!) → bessere Zustellbarkeit
 * - Reply-To = Benutzer-Mail
 * - UTF-8-korrektes Encoding
 * - Multipart für saubere Text- und HTML-Ansicht
 * -------------------------------------------------------------------------- */
$to = 'info@mantd.org';
$subject = "MANTD Kontakt: $name";
$fromEmail = 'noreply@mantd.org';

// Templates laden (Variablen $name, $email, $message sind hier verfügbar)
ob_start();
require __DIR__ . '/mail-templates/contact.txt.php';
$textMessage = ob_get_clean();

ob_start();
require __DIR__ . '/mail-templates/contact.html.php';
$htmlMessage = ob_get_clean();

// Boundary für Multipart-E-Mail erstellen
$boundary = md5(uniqid((string)time(), true));

$headers = "From: MANTD Webseite <$fromEmail>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
$headers .= "X-Entity-Ref-ID: " . uniqid('mantd-', true) . "\r\n";
$headers .= "Content-Type: multipart/alternative; boundary=\"$boundary\"\r\n";

$body = "--$boundary\r\n";
$body .= "Content-Type: text/plain; charset=UTF-8\r\n";
$body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
$body .= $textMessage . "\r\n\r\n";

$body .= "--$boundary\r\n";
$body .= "Content-Type: text/html; charset=UTF-8\r\n";
$body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
$body .= $htmlMessage . "\r\n\r\n";
$body .= "--$boundary--";

/* --------------------------------------------------------------------------
 * 7. Mail-Versand
 *
 * - LOKAL: Logging statt mail()
 * - LIVE: mail() aktivieren
 * -------------------------------------------------------------------------- */

// ===== LOKAL (Entwicklung / Test) =====
/*
file_put_contents(
    __DIR__ . '/mail-test.log',
    date('Y-m-d H:i:s') . PHP_EOL .
    print_r($_POST, true) .
    PHP_EOL . "---------------------" . PHP_EOL,
    FILE_APPEND
);

echo json_encode([
    'success' => true,
    'message' => 'Mail wurde lokal simuliert.'
]);
*/

// ===== LIVE (Produktion) =====
if (mail($to, $subject, $body, $headers)) {
    echo json_encode([
        'success' => true,
        'message' => 'Deine Nachricht wurde erfolgreich versendet!'
    ]);
} else {
    reject(
        500,
        'Es gab einen Serverfehler. Bitte versuche es später erneut.'
    );
}
