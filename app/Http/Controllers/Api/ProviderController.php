<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProviderRequest;
use App\Http\Resources\ProviderCollection;
use App\Http\Resources\ProviderResource;
use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Provider::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $provider = Provider::query();

        $request->has('ids') ? $provider->whereIn('id', explode(',', $request->ids)) : '';
        $request->has('firstname') ? $provider->where('firstname', 'like', '%'.$request->firstname.'%') : '';
        $request->has('lastname') ? $provider->where('lastname', 'like', '%'.$request->lastname.'%') : '';
        $request->has('email') ? $provider->where('email', 'like', '%'.$request->email.'%') : '';
        $request->has('status') ? $provider->where('status', $request->status) : '';
        $request->has('orderBy') ? $provider->orderBy(...explode(',', $request->orderBy)) : '';

        return new ProviderCollection($provider->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\ProviderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProviderRequest $request)
    {
        $provider = Provider::create($request->safe()->except('avatar', 'category'));
        $provider->categories()->attach($request->category);

        $this->uploadImg($request, $provider);

        return $this->validResponse(['message' => __('Provider created successfully.')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function show(Provider $provider)
    {
        return new ProviderResource($provider);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\ProviderRequest  $request
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function update(ProviderRequest $request, Provider $provider)
    {
        $provider->update($request->safe()->except('avatar', 'category'));
        $provider->categories()->attach($request->category);

        $this->uploadImg($request, $provider);

        return $this->validResponse(['message' => __('Provider updated successfully.')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Provider $provider)
    {
        $provider->delete();

        $provider->media()->delete();

        return $this->validResponse(['message' => __('Provider removed successfully.')]);
    }

    private function uploadImg($request, $provider)
    {
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $provider->media()->delete();
            $provider->addMediaFromRequest('avatar')->toMediaCollection('avatar');
        }
    }
}
