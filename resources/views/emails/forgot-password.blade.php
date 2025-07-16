<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your New Password</title>
    <!-- Tailwind CSS CDN for local development/preview. For production, you'd typically compile it. -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom styles for email client compatibility and fine-tuning */
        body {
            font-family: 'Inter', sans-serif; /* Using Inter font as per instructions */
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4; /* Light grey background */
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        p {
            margin-bottom: 15px;
        }
        .password-box {
            background-color: #e0f2fe; /* Tailwind blue-50 light */
            border: 1px solid #bfdbfe; /* Tailwind blue-200 */
            padding: 15px;
            border-radius: 8px; /* Slightly more rounded */
            text-align: center;
            font-size: 1.4em; /* Larger font */
            font-weight: bold;
            color: #1d4ed8; /* Tailwind blue-700 */
            margin: 20px 0;
            letter-spacing: 1px; /* A bit of letter spacing for readability */
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 0.9em;
            color: #777;
        }
        .warning {
            color: #dc2626; /* Tailwind red-600 */
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-gray-100 p-4 sm:p-6 lg:p-8">
    <div class="container bg-white p-6 sm:p-8 lg:p-10 rounded-xl shadow-lg">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-center text-gray-800 mb-6">
            New Password for <span class="text-indigo-600">Clip The Pic</span>
        </h1>

        <p class="text-gray-700 mb-4">Hello {{ $userName ?? 'User' }},</p>
        <p class="text-gray-700 mb-4">You recently requested a new password for your Clip The Pic account. Your new password is:</p>

        <div class="password-box">
            {{ $newPassword }}
        </div>

        <p class="text-gray-700 mb-4">
            <span class="warning">
                <small>For security reasons, we highly recommend logging in and changing this password to something memorable immediately.</small>
            </span>
        </p>
        <p class="text-gray-700 mb-6">If you did not request this, please ignore this email.</p>

        <p class="text-gray-700">Thank you,<br>The Clip The Pic Team</p>

        <div class="footer border-t border-gray-200 pt-6 mt-6">
            <p>&copy; {{ date('Y') }} Clip The Pic. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
