<?php

namespace App\Http\Controllers;

use App\Http\Errors\ErrorHandler;
use App\Services\UserService;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $users = $this->userService->findAllUsers();

            return response()->json([
                "currentPage" => $users->currentPage(),
                "users" => $users->items(),
            ]);
        } catch (\Exception $error) {
            return ErrorHandler::handle($error);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $createdUser = $this->userService->createUser($request->all());

            return response()->json([
                "message" => "User created",
                "user" => $createdUser,
            ], 201);
        } catch (\Exception $error) {
            return ErrorHandler::handle($error);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = $this->userService->findUserById($id);

            return response()->json(["user" => $user]);
        } catch (\Exception $error) {
            return ErrorHandler::handle($error);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $updatedUser = $this->userService->updateUser($request->all(), $id);

            return response()->json([
                "message" => "User updated successfully",
                "user" => $updatedUser
            ]);
        } catch (\Exception $error) {
            return ErrorHandler::handle($error);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $isDeleted = $this->userService->deleteUser($id);

            return $isDeleted
                ? response()->json(["message" => "User successfully deleted"])
                : response()->json(["message" => "Could not delete: an unxepected error occurred"]);
        } catch (\Exception $error) {
            return ErrorHandler::handle($error);
        }
    }
}
