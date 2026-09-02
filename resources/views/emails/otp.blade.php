<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UYA Connect Code</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f7; padding: 24px;">
    <table role="presentation" width="100%" style="max-width: 480px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden;">
        <tr>
            <td style="background-color: #224d5b; padding: 20px; text-align: center;">
                <h2 style="color: #ffffff; margin: 0;">UYA Connect</h2>
            </td>
        </tr>
        <tr>
            <td style="padding: 28px;">
                <p style="color: #333333; font-size: 15px;">
                    @if ($purpose === 'password reset')
                        Use the code below to reset your password.
                    @else
                        Use the code below to verify your email address and finish creating your account.
                    @endif
                </p>

                <p style="text-align: center; margin: 28px 0;">
                    <span style="display: inline-block; font-size: 32px; letter-spacing: 8px; font-weight: bold; color: #224d5b; background: #f8f9fa; padding: 12px 20px; border-radius: 8px;">
                        {{ $otp }}
                    </span>
                </p>

                <p style="color: #666666; font-size: 13px;">
                    This code expires in 10 minutes. If you didn't request this, you can safely ignore this email.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
