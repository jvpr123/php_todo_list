<?php

namespace App\Http\Controllers;

use App\Http\Errors\ErrorHandler;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    private $categoryService;

    public function __construct() {
        $this->categoryService = new CategoryService();
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
            $categories = $this
                ->categoryService
                ->findAllCategories($user->id);

            return response()->json([
                "currentPage" => $categories->currentPage(),
                "categories" => $categories->items(),
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
            $createdCategory = $this
                ->categoryService
                ->createCategory($request->all(), $user->id);

            return response()->json([
                "message" => "Category created",
                "category" => $createdCategory,
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
            $category = $this
                ->categoryService
                ->findCategoryById($id, $user->id);
            
            return response()->json(["category" => $category]);
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
            $updatedCategory = $this
                ->categoryService
                ->updateCategory($request->all(), $id, $user->id);

            return response()->json([
                "message" => "Category updated successfully",
                "category" => $updatedCategory,
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
            $isDeleted = $this
                ->categoryService
                ->deleteCategory($id, $user->id);

            return $isDeleted
                ? response()->json(["message" => "Category successfully deleted"])
                : response()->json(["message" => "Could not delete: an unxepected error occurred"]);
        } catch (\Exception $error) {
            return ErrorHandler::handle($error);
        }
    }
}
