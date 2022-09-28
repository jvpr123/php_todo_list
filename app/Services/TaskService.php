<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TaskService
{
    public function findAllTasks()
    {
        return Task::all();
    }

    public function createTask($data)
    {
        $rules = $this->getCreateValidationRule();
        $validated = $this->validate($data, $rules);

        return Task::create($validated);
    }

    public function findTaskById($id)
    {
        $task = Task::find($id);

        if (!$task)
            throw new NotFoundHttpException("Error: task not found");

        return $task;
    }

    public function updateTask($data, $id)
    {
        $rules = $this->getUpdateValidationRule();
        $validated = $this->validate($data, $rules);

        Task::where("id", $id)->update($validated);

        return $this->findTaskById($id);
    }

    public function deleteTask($id)
    {
        $taskToDelete = Task::find($id);

        if (!$taskToDelete)
            throw new NotFoundHttpException("Failed to delete: task not found");

        return $taskToDelete->delete();
    }

    private function getCreateValidationRule()
    {
        return
            [
                "title" => ["required", "string", "min:3", "max:50"],
                "description" => ["required", "string", "max:255"],
                "deadline" => ["required", "date", "after:now"],
                "done" => ["boolean"],
                "user_id" => ["required", "integer", "exists:users,id"],
                "category_id" => ["required", "integer", "exists:categories,id"],
            ];
    }

    private function getUpdateValidationRule()
    {
        return
            [
                "title" => ["string", "min:3", "max:50"],
                "description" => ["string", "max:255"],
                "deadline" => ["date", "after:now"],
                "done" => ["boolean"],
            ];
    }

    private function validate($data, $rules)
    {
        $validation = Validator::make($data, $rules);

        if ($validation->fails())
            throw new BadRequestHttpException($validation->errors());

        return $validation->validated();
    }
}
