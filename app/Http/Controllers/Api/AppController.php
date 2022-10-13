<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AppRequest;
use App\Http\Resources\AppCollection;
use App\Http\Resources\AppResource;
use App\Models\App;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(App::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apps = App::where('user_id', Auth::id())->get();

        return new AppCollection($apps);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\AppRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AppRequest $request)
    {
        $app = App::create($request->safe()->toArray());

        return $this->validResponse([
            'app_name' => $app->name,
            'app_token' => $app->app_token,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\App  $app
     * @return \Illuminate\Http\Response
     */
    public function show(App $app)
    {
        return new AppResource($app);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\AppRequest  $request
     * @param  \App\Models\App  $app
     * @return \Illuminate\Http\Response
     */
    public function update(AppRequest $request, App $app)
    {
        $app->update($request->safe()->toArray());

        return $this->validResponse(['message' => __('Application updated successfully.')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\App  $app
     * @return \Illuminate\Http\Response
     */
    public function destroy(App $app)
    {
        $app->delete();

        return $this->validResponse(['message' => __('Application removed successfully.')]);
    }
}
