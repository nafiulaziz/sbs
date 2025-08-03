<?php
// app/Http/Controllers/Api/ServiceController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::active()->get();
        
        return response()->json([
            'services' => $services,
        ]);
    }

    public function store(ServiceRequest $request)
    {
        $service = Service::create($request->validated());

        return response()->json([
            'message' => 'Service created successfully',
            'service' => $service,
        ], 201);
    }

    public function show(Service $service)
    {
        return response()->json([
            'service' => $service,
        ]);
    }

    public function update(ServiceRequest $request, Service $service)
    {
        $service->update($request->validated());

        return response()->json([
            'message' => 'Service updated successfully',
            'service' => $service,
        ]);
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return response()->json([
            'message' => 'Service deleted successfully',
        ]);
    }
}