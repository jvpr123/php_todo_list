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
    public function index()
    {
        try {
            $tasks = $this->taskService->findAllTasks();

            return response()->json(["tasks" => $tasks]);
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
            $createdTask = $this->taskService->createTask($request->all());

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
    public function show($id)
    {
        try {
            $task = $this->taskService->findTaskById($id);

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
            $updatedTask = $this->taskService->updateTask($request->all(), $id);

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
    public function destroy($id)
    {
        try {
            $isDeleted = $this->taskService->deleteTask($id);

            return $isDeleted
                ? response()->json(["message" => "Task successfully deleted"])
                : response()->json(["message" => "Could not delete: an unxepected error occurred"]);
        } catch (\Exception $error) {
            return ErrorHandler::handle($error);
        }
    }
}
