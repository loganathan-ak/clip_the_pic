<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Job Created</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">
    <table style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 6px;">
        <tr>
            <td>
                <h2 style="color: #007bff;">🎉 Job Created Successfully</h2>
                <p>Hello {{ Auth::user()->name }},</p>
                <p>Your new job has been created with the following details:</p>
                <ul>
                    <li><strong>Order ID:</strong> {{ $order->order_id }}</li>
                    <li><strong>Project Title:</strong> {{ $order->project_title }}</li>
                    <li><strong>Request Type:</strong> {{ $order->request_type }}</li>
                    <li><strong>Duration:</strong> {{ $order->duration }}</li>
                </ul>
                <p>You can view more details by logging into your dashboard.</p>
                <p>Thanks,<br>The Design Team</p>
            </td>
        </tr>
    </table>
</body>
</html>
