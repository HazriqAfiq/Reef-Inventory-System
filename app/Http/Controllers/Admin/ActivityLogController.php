<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = ActivityLog::with('user')->latest()->paginate(50)->appends($request->all());
        
        if ($request->ajax() && !$request->header('X-SPA')) {
            return view('admin.activity-logs.partials.table', compact('logs'))->render();
        }

        return view('admin.activity-logs.index', compact('logs'));
    }
}
