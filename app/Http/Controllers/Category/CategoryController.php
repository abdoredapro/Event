<?php

namespace App\Http\Controllers\Category;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Category\SubCategoryResource;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

final class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return ResponseHelper::success(data: CategoryResource::collection($categories));
    }

    public function sub_category(Category $category)
    {
        $sub_categories = SubCategory::whereBelongsto($category)->get();

        return ResponseHelper::success(data: SubCategoryResource::collection($sub_categories));
        
    }
}
