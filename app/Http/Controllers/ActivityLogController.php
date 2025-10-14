<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ActivityLogExport;
use Maatwebsite\Excel\Facades\Excel;

class ActivityLogController extends Controller
{
    public function export()
    {
        return Excel::download(new ActivityLogExport, 'log.xlsx');
    }
}
