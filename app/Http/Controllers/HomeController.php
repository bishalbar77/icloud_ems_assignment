<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BulkImportData;
use Excel;
use App\Imports\FeeDataImport;
use DataTables;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('welcome');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = BulkImportData::select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->make(true);
        }
    }

    public function import(Request $request){
        Excel::import(new FeeDataImport,
                      $request->file('file')->store('files'));
        return redirect()->back();
    }
}
