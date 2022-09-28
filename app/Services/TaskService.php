<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TaskService
{
    public function findAllTasks($userId)
    {
        return Task::where("user_id", $userId)->paginate(10);
    }

    public function createTask($data, $userId)
    {
        $rules = $this->getCreateValidationRule();
        $validated = $this->validate($data, $rules);
        $validated["user_id"] = $userId;

        return Task::create($validated);
    }

    public function findTaskById($id, $userId)
    {
        $task = Task::where(["id" => $id, "user_id" => $userId])->first();

        if (!$task)
            throw new NotFoundHttpException("Error: task not found");

        return $task;
    }

    public function updateTask($data, $id, $userId)
    {
        $rules = $this->getUpdateValidationRule();
        $validated = $this->validate($data, $rules);

        $taskToUpdate = Task::where([
            "id" => $id,
            "user_id" => $userId
        ])->first();

        if (!$taskToUpdate)
            throw new NotFoundHttpException("Could not update: task not found");

        $taskToUpdate->update($validated);

        return Task::where("id", $id)->first();
    }

    public function deleteTask($id, $userId)
    {
        $taskToDelete = Task::where(["id" => $id, "user_id" => $userId])->first();

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
