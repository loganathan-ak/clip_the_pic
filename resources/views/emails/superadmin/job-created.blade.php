<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Job Notification</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">
    <table style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 6px;">
        <tr>
            <td>
                <h2 style="color: #dc3545;">📥 New Job Created</h2>
                <p>Hello Admin,</p>
                <p>A new job has been created in the system with the following details:</p>
                <ul>
                    <li><strong>Order ID:</strong> {{ $order->order_id }}</li>
                    <li><strong>Project Title:</strong> {{ $order->project_title }}</li>
                    <li><strong>Request Type:</strong> {{ $order->request_type }}</li>
                    <li><strong>Duration:</strong> {{ $order->duration }}</li>
                    <li><strong>Created By:</strong> {{ $order->user->name ?? 'N/A' }}</li>
                    <li><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</li>
                </ul>
                <p>You can review and manage this job from the <a href="{{ route('superadmin.dashboard') }}">Admin Dashboard</a>.</p>
                <p>Regards,<br>The System</p>
            </td>
        </tr>
    </table>
</body>
</html>
