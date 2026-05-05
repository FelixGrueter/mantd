<!doctype html>
<html lang="de">

<head>
    <meta charset="UTF-8">
</head>

<body style="margin:0;padding:0;background:#f4f3ef;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f3ef;padding:30px 0;">
        <tr>
            <td align="center">

                <!-- Container -->
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff;color:#111111;font-family:Arial,Helvetica,sans-serif;">

                    <!-- Header -->
                    <tr>
                        <td style="padding:28px 32px 22px;border-bottom:1px solid rgba(17,17,17,0.12);">
                            <div style="font-size:18px;letter-spacing:0.12em;font-weight:600;">
                                MANTD
                            </div>
                            <div
                                style="margin-top:6px;font-size:11px;letter-spacing:0.2em;text-transform:uppercase;color:#e8622c;">
                                Kontaktanfrage
                            </div>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:32px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="font-size:15px;line-height:1.6;">
                                <tr>
                                    <td style="padding-bottom:16px;">
                                        <strong>Name</strong><br>
                                        <?= htmlspecialchars($name) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom:16px;">
                                        <strong>E-Mail</strong><br>
                                        <?= htmlspecialchars($email) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom:6px;">
                                        <strong>Nachricht</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:18px;background:rgba(232,98,44,0.06);
                             border-left:3px solid #e8622c;white-space:pre-line;">
                                        <?= htmlspecialchars($message) ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding:22px 32px 26px;
                       font-size:12px;color:#6b6b6b;
                       background:#faf9f7;
                       border-top:1px solid rgba(17,17,17,0.08);">
                            Diese Nachricht wurde über das Kontaktformular auf
                            <strong>mantd.org</strong> gesendet.<br>
                            Bitte antworte direkt auf diese E-Mail, um mit der Person in Kontakt zu treten.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>
</body>

</html>