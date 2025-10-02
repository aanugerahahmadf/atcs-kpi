<?php

namespace App\Http\Controllers;

use App\Exports\CctvsExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
	public function cctvs()
	{
		return Excel::download(new CctvsExport, 'cctvs.xlsx');
	}
}