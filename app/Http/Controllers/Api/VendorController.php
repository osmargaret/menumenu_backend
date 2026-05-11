<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $query = Vendor::with('areas','meals');
        $stateId = session('state_id');
        if ($stateId) {
            $query->inState($stateId);
        }
        return $query->paginate(20);
    }

    public function show(Vendor $vendor)
    {
        return $vendor->load('areas','meals');
    }

    public function store(\App\Http\Requests\StoreVendorRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $vendor = Vendor::create($data);
        return response()->json($vendor, 201);
    }

    public function update(\App\Http\Requests\UpdateVendorRequest $request, Vendor $vendor)
    {
        $this->authorize('update', $vendor);

        $data = $request->validated();
        $vendor->update($data);
        return $vendor->fresh();
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        return response()->noContent();
    }
}
