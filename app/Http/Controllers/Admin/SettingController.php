<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return Setting::orderBy('group')->orderBy('key')->get();
    }

    public function show(Setting $setting)
    {
        return $setting;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'key' => 'required|string|unique:settings,key',
            'value' => 'nullable',
            'group' => 'nullable|string',
            'autoload' => 'boolean',
        ]);

        $setting = Setting::create($data);

        return response()->json($setting, 201);
    }

    public function update(Request $request, Setting $setting)
    {
        $data = $request->validate([
            'value' => 'nullable',
            'group' => 'nullable|string',
            'autoload' => 'boolean',
        ]);

        $setting->update($data);
        return $setting->fresh();
    }

    public function destroy(Setting $setting)
    {
        $setting->delete();
        return response()->noContent();
    }
}
