<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use Illuminate\Http\Request;

class MealController extends Controller
{
    public function index()
    {
        return Meal::with('vendor','areas')->paginate(20);
    }

    public function show(Meal $meal)
    {
        return $meal->load('vendor','areas');
    }

    public function store(\App\Http\Requests\StoreMealRequest $request)
    {
        $data = $request->validated();

        $this->authorize('create', Meal::class);

        $meal = Meal::create($data);
        return response()->json($meal, 201);
    }

    public function update(\App\Http\Requests\UpdateMealRequest $request, Meal $meal)
    {
        $this->authorize('update', $meal);

        $data = $request->validated();
        $meal->update($data);
        return $meal->fresh();
    }

    public function destroy(Meal $meal)
    {
        $meal->delete();
        return response()->noContent();
    }
}
