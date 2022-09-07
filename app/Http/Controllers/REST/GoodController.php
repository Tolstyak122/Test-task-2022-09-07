<?php

namespace App\Http\Controllers\REST;

use Illuminate\Http\Request;
use App\Http\Requests\StoreGoodRequest;
use Inertia\Inertia;

class GoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $goods = \App\Models\Good::CatIdSearch($request->query('cat_id'))
                                    ->CatNameSearch($request->query('cat_name'))
                                    ->PublishedOnly($request->query('published'))
                                    ->WithTrash($request->query('trash'))
                                    ->TitleSearch($request->query('good_name'))
                                    ->PriceLimit($request->query('price'))
                                    ->get();
        return response()->json($goods);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Good');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGoodRequest $request) {
        $actions = \App::make(\App\Actions\GoodActions::class);
        $good = $actions->store($request);
        return new \App\Http\Resources\GoodResource($good);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(\App\Models\Good $good)
    {
        $good->loadMissing(['categories:id']);
        return new \App\Http\Resources\GoodResource($good);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreGoodRequest $request, \App\Models\Good $good)
    {
        $actions = \App::makeWith(\App\Actions\GoodActions::class, ['good' => $good]);
        $good = $actions->store($request);
        return new \App\Http\Resources\GoodResource($good);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(\App\Models\Good $good) {
        if($good) {
            $actions = \App::makeWith(\App\Actions\GoodActions::class, ['good' => $good]);
            $actions->delete();
        }
        return response()->json(['status' => 'ok']);
    }
}
