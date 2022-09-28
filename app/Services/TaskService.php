<?php

namespace App\Services;

use App\Models\Task;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TaskService
{
    public function findAllTasks()
    {
        return Task::all();
    }

    public function createTask($data)
    {
        return Task::create($data);
    }

    public function findTaskById($id)
    {
        $task = Task::find($id);

        if (!$task)
            throw new NotFoundHttpException("Task not found");

        return $task;
    }

    public function deleteTask($id)
    {
        $taskToDelete = Task::find($id);

        if (!$taskToDelete)
            throw new NotFoundHttpException("Failed to delete: task not found");

        return $taskToDelete->delete();
    }
}
