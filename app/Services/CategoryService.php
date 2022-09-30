<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryService
{
    public function findAllCategories($userId)
    {
        return Category::where("user_id", $userId)->paginate(10);
    }

    public function createCategory($data, $userId)
    {
        $rules = $this->getCreateValidationRule();
        $validated = $this->validate($data, $rules);
        $validated["user_id"] = $userId;

        return Category::create($validated);
    }

    public function findCategoryById($id, $userId)
    {
        $category = Category::where(["id" => $id, "user_id" => $userId])->first();

        if (!$category)
            throw new NotFoundHttpException("Error: category not found");

        return $category;
    }

    public function updateCategory($data, $id, $userId)
    {
        $rules = $this->getUpdateValidationRule();
        $validated = $this->validate($data, $rules);

        $categoryToUpdate = Category::where([
            "id" => $id,
            "user_id" => $userId
        ])->first();

        if (!$categoryToUpdate)
            throw new NotFoundHttpException("Could not update: category not found");

        $categoryToUpdate->update($validated);

        return Category::where("id", $id)->first();
    }

    public function deleteCategory($id, $userId)
    {
        $categoryToDelete = Category::where(["id" => $id, "user_id" => $userId])->first();

        if (!$categoryToDelete)
            throw new NotFoundHttpException("Failed to delete: category not found");

        return $categoryToDelete->delete();
    }

    private function getCreateValidationRule()
    {
        return
            [
                "title" => ["required", "string", "min:3", "max:50"],
                "color" => ["required", "string", "min:4", "max:7"],
            ];
    }

    private function getUpdateValidationRule()
    {
        return
            [
                "title" => ["string", "min:3", "max:50"],
                "color" => ["string", "min:4", "max:7"],
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
