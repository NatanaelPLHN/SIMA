<?php

namespace App\Http\Controllers;

use App\Exports\ActivityLogExport;
use Maatwebsite\Excel\Facades\Excel;

class ActivityLogController extends Controller
{
    public function export()
    {
        return Excel::download(new ActivityLogExport, 'log.xlsx');
    }

    public function exportBorrowingLog()
    {
        return Excel::download(new ActivityLogExport, 'borrowing_log.xlsx');
    }
}
