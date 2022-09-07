<?php
namespace App\Actions;

use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Http\Request;

class CategoryActions {

    private $category;

    public function __construct(\App\Models\Category $category) {
        $this->category = $category;
    }

    public function delete() {
        return $this->category->delete();
    }

    public function store(StoreCategoryRequest $request) {

        $this->category->fill($request->only('title'));
        $this->category->save();

        return $this->category;
    }
}