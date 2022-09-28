<?php

namespace App\Http\Controllers;

use App\Http\Errors\ErrorHandler;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    private $taskService;

    public function __construct()
    {
        $this->taskService = new TaskService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            $tasks = $this->taskService->findAllTasks($user->id);

            return response()->json([
                "currentPage" => $tasks->currentPage(),
                "tasks" => $tasks->items(),
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
            $user = $request->user();
            $createdTask = $this->taskService->createTask($request->all(), $user->id);

            return response()->json([
                "message" => "Task created",
                "task" => $createdTask,
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
    public function show(Request $request, $id)
    {
        try {
            $user = $request->user();
            $task = $this->taskService->findTaskById($id, $user->id);

            return response()->json(["task" => $task]);
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
            $user = $request->user();
            $updatedTask = $this->taskService->updateTask($request->all(), $id, $user->id);

            return response()->json([
                "message" => "Task updated successfully",
                "task" => $updatedTask
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
    public function destroy(Request $request, $id)
    {
        try {
            $user = $request->user();
            $isDeleted = $this->taskService->deleteTask($id, $user->id);

            return $isDeleted
                ? response()->json(["message" => "Task successfully deleted"])
                : response()->json(["message" => "Could not delete: an unxepected error occurred"]);
        } catch (\Exception $error) {
            return ErrorHandler::handle($error);
        }
    }
}
