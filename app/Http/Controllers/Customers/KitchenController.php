<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\Kitchen;
use Illuminate\Http\Request;

class KitchenController extends Controller
{
    public function index(Request $request)
    {
        $query = Kitchen::with('areas', 'meals', 'categories')
            ->withCount('reviews');

        // Filter by state
        $stateId = $request->state_id ?? session('state_id');
        if ($stateId) {
            $query->inState($stateId);
        }

        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('tagline', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category)
                  ->orWhere('categories.name', $request->category);
            });
        }

        if ($request->has('is_open')) {
            $query->where('is_open', (bool) $request->is_open);
        }

        if ($request->filled('delivery')) {
            $query->where('delivery_available', (bool) $request->delivery);
        }

        return $query->latest()->paginate(20);
    }

    public function show(Kitchen $kitchen)
    {
        return $kitchen->load('areas', 'meals', 'categories')
            ->loadCount('reviews')
            ->loadAvg('reviews', 'rating');
    }

    public function store(\App\Http\Requests\StoreKitchenRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $kitchen = Kitchen::create($data);
        return response()->json($kitchen, 201);
    }

    public function update(\App\Http\Requests\UpdateKitchenRequest $request, Kitchen $kitchen)
    {
        $this->authorize('update', $kitchen);

        $data = $request->validated();
        $kitchen->update($data);
        return $kitchen->fresh()->load('areas', 'categories');
    }

    public function destroy(Kitchen $kitchen)
    {
        $this->authorize('delete', $kitchen);
        $kitchen->delete();
        return response()->noContent();
    }
}
