<!DOCTYPE html>
<html>
<head>
    <title>Notificação de Tarefa</title>
</head>
<body>
    <h1>Tarefa: {{ $task->title }}</h1>
    <p>Status: {{ $task->status }}</p>
    <p>Descrição: {{ $task->description }}</p>
    <p>Prazo: {{ $task->deadline }}</p>
</body>
</html>
