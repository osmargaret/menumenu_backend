<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use Illuminate\Http\Request;

class MealController extends Controller
{
    public function index(Request $request)
    {
        $query = Meal::with('kitchen');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('category', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('kitchen_id')) {
            $query->where('kitchen_id', $request->kitchen_id);
        }

        if ($request->has('available')) {
            $query->where('available', (bool) $request->available);
        }

        return $query->latest()->paginate(20);
    }

    public function show(Meal $meal)
    {
        return $meal->load('kitchen');
    }

    public function store(\App\Http\Requests\StoreMealRequest $request)
    {
        $data = $request->validated();

        $this->authorize('create', Meal::class);

        $meal = Meal::create($data);
        return response()->json($meal->load('kitchen'), 201);
    }

    public function update(\App\Http\Requests\UpdateMealRequest $request, Meal $meal)
    {
        $this->authorize('update', $meal);

        $data = $request->validated();
        $meal->update($data);
        return $meal->fresh()->load('kitchen');
    }

    public function destroy(Meal $meal)
    {
        $this->authorize('delete', $meal);
        $meal->delete();
        return response()->noContent();
    }
}
