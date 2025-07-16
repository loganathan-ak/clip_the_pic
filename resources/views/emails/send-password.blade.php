<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Registration Password - Clip The Pic</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f5; padding: 20px;">

    <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: 0 auto; background: white; border-radius: 8px; overflow: hidden;">
        <tr>
            <td style="padding: 30px; text-align: center; background-color: #7c3aed; color: white;">
                <h1 style="margin: 0;">🎨 Clip The Pic</h1>
                <p style="margin: 5px 0 0;">Your Registration Password</p>
            </td>
        </tr>
        <tr>
            <td style="padding: 30px;">
                <p style="font-size: 16px; color: #333;">Hello,</p>

                <p style="font-size: 16px; color: #333;">
                    Thank you for registering with <strong>Clip The Pic</strong>! Here is your one-time password to complete your registration:
                </p>

                <div style="margin: 20px 0; text-align: center;">
                    <span style="display: inline-block; padding: 12px 24px; background-color: #e0e7ff; color: #1e40af; font-size: 20px; font-weight: bold; border-radius: 6px;">
                        {{ $password }}
                    </span>
                </div>

                <p style="font-size: 14px; color: #555;">
                    Please go back to the registration form and enter this password to finish creating your account.
                </p>

                <p style="font-size: 14px; color: #999; margin-top: 30px;">
                    If you didn’t request this registration, you can safely ignore this email.
                </p>
            </td>
        </tr>
        <tr>
            <td style="background-color: #f3f4f6; padding: 20px; text-align: center; font-size: 12px; color: #999;">
                &copy; {{ date('Y') }} Clip The Pic. All rights reserved.
            </td>
        </tr>
    </table>

</body>
</html>
