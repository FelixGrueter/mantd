<?php
session_start();
$_SESSION['form_time'] = time();
?>


<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Mail Test</title>
</head>

<body>

    <h1>PHP Mail Test</h1>

    <form action="contact.php" method="post">
        <label>
            Name:
            <input type="text" name="name" required>
        </label>
        <br><br>

        <label>
            E-Mail:
            <input type="email" name="email" required>
        </label>
        <br><br>

        <label>
            Nachricht:
            <textarea name="message" required></textarea>
        </label>
        <br><br>

        <input type="text" name="website" style="display:none">

        <button type="submit">Absenden</button>
    </form>

</body>

</html>