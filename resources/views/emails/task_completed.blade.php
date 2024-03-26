<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Task Completed</title>
    </head>
    <body>
        <h2>Task Completed</h2>
        <p>Hello {{ $task->user->name }},</p>

        <p>Your task "{{ $task->title }}" has been completed successfully.</p>

        <p>Thank you for using our application.</p>
    </body>
</html>
