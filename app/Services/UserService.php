<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserService
{
    public function findAllUsers()
    {
        return User::paginate(10);
    }

    public function createUser($data)
    {
        $rules = $this->getCreateValidationRule();
        $validated = $this->validate($data, $rules);

        $validated["password"] = Hash::make($validated["password"]);

        return User::create($validated);
    }

    public function findUserById($id)
    {
        $User = User::find($id);

        if (!$User)
            throw new NotFoundHttpException("Error: user not found");

        return $User;
    }

    public function updateUser($data, $id)
    {
        $rules = $this->getUpdateValidationRule();
        $validated = $this->validate($data, $rules);

        User::where("id", $id)->update($validated);

        return $this->findUserById($id);
    }

    public function deleteUser($id)
    {
        $UserToDelete = User::find($id);

        if (!$UserToDelete)
            throw new NotFoundHttpException("Failed to delete: User not found");

        return $UserToDelete->delete();
    }

    private function getCreateValidationRule()
    {
        return
            [
                "name" => ["required", "string", "min:3", "max:100"],
                "email" => ["required", "string", "unique:users,email", "email", "max:100"],
                "password" => ["required", "string", "alpha_num", "min:6", "max:20"],
                "password_confirmation" => ["same:password"],
            ];
    }

    private function getUpdateValidationRule()
    {
        return
            [
                "name" => ["required", "string", "min:3", "max:100"],
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
