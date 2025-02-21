<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\CategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends AppBaseController
{
    /** @var CategoryRepository */
    public $categoryRepository;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepository = $categoryRepo;
    }

    public function index(Request $request)
    {
        return view('category.index');
    }

    public function store(CreateCategoryRequest $request): JsonResponse
    {
        $input = $request->all();
        $category = $this->categoryRepository->store($input);

        return $this->sendResponse($category, __('messages.flash.category_saved_successfully'));
    }

    public function edit(Category $category): JsonResponse
    {
        return $this->sendResponse($category,  __('messages.flash.category_retrieved_successfully'));
    }

    public function update(UpdateCategoryRequest $request, $categoryId): JsonResponse
    {
        $input = $request->all();
        $this->categoryRepository->update($input, $categoryId);

        return $this->sendSuccess(__('messages.flash.category_updated_successfully'));
    }

    public function destroy(Category $category): JsonResponse
    {
        $productModels = [
            Product::class,
        ];
        $result = canDelete($productModels, 'category_id', $category->id);
        if ($result) {
            return $this->sendError(__('messages.flash.category_cant_deleted'));
        }
        $category->delete();

        return $this->sendSuccess(__('messages.flash.category_deleted_successfully'));
    }
}
