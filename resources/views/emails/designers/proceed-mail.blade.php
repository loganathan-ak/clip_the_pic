<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Job Assigned</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 30px;">
    <table style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
        <tr>
            <td>
                <h2 style="color: #007bff;">🎨 New Job Assigned to You</h2>

                <p>Hi {{ $designer->name ?? 'Designer' }},</p>

                <p>A new job has been assigned to you. Please find the details below:</p>

                <ul style="line-height: 1.8;">
                    <li><strong>Job ID:</strong> {{ $suborder->job_id }}</li>
                    <li><strong>Project Title:</strong> {{ $suborder->project_title }}</li>
                    <li><strong>Request Type:</strong> {{ $suborder->request_type }}</li>
                    <li><strong>Deadline:</strong> {{ $suborder->duration ?? 'Not specified' }}</li>
                    <li><strong>Status:</strong> {{ $suborder->status }}</li>
                </ul>

                <p>You can view the job and upload your work from your dashboard.</p>

                <p>Thanks,<br>Team {{ config('app.name') }}</p>
            </td>
        </tr>
    </table>
</body>
</html>
