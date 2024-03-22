<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Scopes\ActiveScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index() {
        $keyword = request()->keyword;
        $categories = Category::withoutGlobalScope(ActiveScope::class)
                        ->where("category", "like", "%$keyword%")
                        ->withCount("courses")
                        ->orderBy("courses_count", "desc")
                        ->paginate(10)
                        ->withQueryString();
        return view("Admin.categories.index", compact("categories", "keyword"));
    }
    public function editStatus(Request $request, Category $category) {
        $context = $request->context;

        $category->status = $context;
        $category->save();

        return 1;
    }
    public function store(Request $request) {
        $validation = Validator::make($request->all(), [
            "category" => "required"
        ]);
        Category::create($validation->validated());

        return 1;
    }
    public function update(Request $request, Category $category) {
        $category->update([
            "category" => $request->category
        ]);
        
        return 1;
    }
    public function destroy(Category $category) { 
        $category->delete();
        return 1;
    }
}
