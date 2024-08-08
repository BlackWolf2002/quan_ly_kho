<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ExcelRequest;
use App\Imports\HangHoaImport;
use Maatwebsite\Excel\Facades\Excel;

class HangHoaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function import(ExcelRequest $request)
    {
        $file = $request->file('excel_file');
        Excel::import(new HangHoaImport(), $file);


        return response()->json(['message' => 'Nhập hàng hóa thành công!', 'type' => 'success', 'redirect' => route('hang-hoa.index')]);
    }
}
