<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ServiceRequest;
use App\Http\Resources\ServiceCollection;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Service::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $service = Service::first();
        dd($service->categories()->get()->toArray());
        $service = Service::query();

        $request->has('ids') ? $service->whereIn('id', explode(',', $request->ids)) : '';
        $request->has('title') ? $service->where('title', 'like', '%'.$request->title.'%') : '';
        $request->has('presence_type') ? $service->where('presence_type', 'like', '%'.$request->presence_type.'%') : '';
        $request->has('status') ? $service->where('status', $request->status) : '';
        $request->has('orderBy') ? $service->orderBy(...explode(',', $request->orderBy)) : '';

        return new ServiceCollection($service->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\ServiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
        $service = Service::create($request->safe()->except('cover', 'gallery'));
        $service->categories()->attach($request->category);

        $this->uploadImg($request, $service);

        return $this->validResponse(['message' => __('Service created successfully.')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        return new ServiceResource($service);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\ServiceRequest  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceRequest $request, Service $service)
    {
        $service->update($request->safe()->except('cover', 'gallery'));
        $service->categories()->attach($request->category);

        $this->uploadImg($request, $service);

        return $this->validResponse(['message' => __('Service updated successfully.')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();

        $service->media()->delete();

        return $this->validResponse(['message' => __('Service removed successfully.')]);
    }

    private function uploadImg($request, $service)
    {
        $service->media()->delete();
        $service->addMediaFromRequest('cover')->toMediaCollection('service-cover');

        foreach ($request->gallery as $image) {
            $service->addMedia($image)->toMediaCollection('service-gallery');
        }
    }
}
