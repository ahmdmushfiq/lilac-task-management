<!DOCTYPE html>
<html>
<head>
    <title>Task Completed</title>
</head>
<body>
    <h2>Task Completed Notification</h2>
    <p>Hello {{ $task->user->name }},</p>
    <p>Your task "<strong>{{ $task->title }}</strong>" has been marked as completed.</p>
    <p>Thank you for using our task management system!</p>
</body>
</html>
