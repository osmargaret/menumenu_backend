<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        return AuditLog::with('user')->latest()->paginate(30);
    }

    public function show(AuditLog $auditLog)
    {
        return $auditLog->load('user');
    }
}
