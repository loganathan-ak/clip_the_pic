<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QC Job Review</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f0f2f5; padding: 20px;">
    <table style="max-width: 600px; margin: auto; background-color: #fff; padding: 20px; border-radius: 8px;">
        <tr>
            <td>
                <h2 style="color: #17a2b8;">🧪 Job Ready for QC Review</h2>
                <p>Hello {{ $qcName ?? 'QC Team' }},</p>

                <p>The following job is now ready for your quality review:</p>

                <ul>
                    <li><strong>Order ID:</strong> {{ $order->job_id }}</li>
                    <li><strong>Project Title:</strong> {{ $order->project_title }}</li>
                    <li><strong>Request Type:</strong> {{ $order->request_type }}</li>
                    <li><strong>Assigned Designer:</strong> {{ $order->designer->name ?? 'N/A' }}</li>
                </ul>

                @if($order->instructions)
                    <p><strong>Design Notes:</strong><br>{{ $order->instructions }}</p>
                @endif

                <p>Please review this job in your QC dashboard as soon as possible.</p>

                <p>Regards,<br>{{ config('app.name') }} Team</p>
            </td>
        </tr>
    </table>
</body>
</html>
