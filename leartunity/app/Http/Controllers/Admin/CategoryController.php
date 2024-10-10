<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Scopes\ActiveScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index() {
        $keyword = request()->keyword;
        $categories = Category::withoutGlobalScope(ActiveScope::class)
                        ->where("category", "like", "%$keyword%")
                        ->withCount("courses")
                        ->orderBy("courses_count", "desc")
                        ->paginate(8)
                        ->withQueryString();
        if(request()->wantsJson()) return $categories;

        return Inertia::render("Admin/Categories/Index", [
            "categories" => $categories,
            "keyword" => $keyword
        ]);
    }
    public function editStatus(Request $request, Category $category) {
        $context = $request->context;

        $category->status = (bool)$context;
        $category->save();

    }
    public function store(Request $request) {
        $validation = Validator::make($request->all(), [
            "category" => "required"
        ]);
        Category::create($validation->validated());

        return 1;
    }
    public function update(Request $request, Category $category) {
        $validation = Validator::make($request->all(), [
            "category" => "required"
        ]);
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
