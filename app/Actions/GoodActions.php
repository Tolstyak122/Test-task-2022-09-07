<?php
namespace App\Actions;

use App\Http\Requests\StoreGoodRequest;
use Illuminate\Http\Request;

class GoodActions {

    private $good;

    public function __construct(\App\Models\Good $good) {
        $this->good = $good;
    }

    public function delete() {
        $this->good->loadMissing(['categories']);
        $this->good->categories()->detach();
        $this->good->delete();
    }

    public function store(StoreGoodRequest $request) {

        $this->good->fill($request->only('title', 'published', 'price'));
        $this->good->save();
        $this->good->categories()->sync($request->input('categories'));

        return $this->good;
    }
}