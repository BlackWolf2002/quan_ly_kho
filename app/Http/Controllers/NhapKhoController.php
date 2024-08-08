<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use App\Models\NhapKho;
use App\Models\ChiTietHangHoa;
use App\Models\HangHoa;
use App\Models\NhaCungCap;
use App\Models\LoaiHang;
use Illuminate\Http\Request;
use App\Http\Requests\ExcelRequest;
use App\Imports\ChiTietHangHoaImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class NhapKhoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nha_cung_cap = NhaCungCap::get();
        $ma_phieu_nhap = NhapKho::latest()->first()->ma_phieu_nhap ?? "PN000000";

        $lastNumber = (int) substr($ma_phieu_nhap, 2);
        $lastNumberLength = strlen((string)substr($ma_phieu_nhap, 2));
        $nextNumber = $lastNumber + 1;
        $ma_phieu_nhap = 'PN' . str_pad($nextNumber, $lastNumberLength, '0', STR_PAD_LEFT);

        $phieu_nhap = [];

        NhapKho::orderBy('id', 'DESC')->chunkById(100, function ($chunk) use (&$phieu_nhap) {
            foreach ($chunk as $phieu) {
                $phieu_nhap[] = $phieu;
            }
        });

        return view('nhapkho.index', compact('phieu_nhap', 'ma_phieu_nhap', 'nha_cung_cap'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hang_hoa = HangHoa::get();
        $nha_cung_cap = NhaCungCap::where('id_trang_thai', '!=', 1)->get();
        $loai_hang = LoaiHang::get();
        $ma_phieu_nhap = NhapKho::latest()->first()->ma_phieu_nhap ?? "PN000000";

        $lastNumber = (int) substr($ma_phieu_nhap, 2);
        $lastNumberLength = strlen((string)substr($ma_phieu_nhap, 2));
        $nextNumber = $lastNumber + 1;
        $ma_phieu_nhap = 'PN' . str_pad($nextNumber, $lastNumberLength, '0', STR_PAD_LEFT);


        return view('nhapkho.create', compact('ma_phieu_nhap', 'hang_hoa', 'nha_cung_cap', 'loai_hang'));
    }

    /**
     * Display the specified resource.
     */
    public function show($code)
    {
        $phieu_nhap = NhapKho::where('ma_phieu_nhap', $code)->firstOrFail();

        $chi_tiet_phieu_nhap = ChiTietHangHoa::where('ma_phieu_nhap', $code)->paginate(10);

        $tong = $chi_tiet_phieu_nhap->sum(function($h) {
            return $h->so_luong_goc * $h->gia_nhap;
        });

        $phieu_nhap->tong = $tong;

        return view('nhapkho.show', compact('phieu_nhap', 'chi_tiet_phieu_nhap'));
    }


    public function import(ExcelRequest $request)
    {
        $data = $request->all();

        $validated = Validator::make($data, [
            'ma_phieu_nhap' => 'required',
            'ngay_nhap' => 'required',
            'ma_ncc' => 'required'
        ]);


        if ($validated->fails()) {
            Alert::error('Thất bại', 'Có lỗi xảy ra trong quá trình nhập dữ liệu. Xin vui lòng kiểm tra lại!')->autoClose(5000);
            return back();
        }

        $mo_ta = json_decode($request->mo_ta)->ops[0]->insert;
        $dt = Carbon::now('Asia/Ho_Chi_Minh');

        $phieu_nhap = NhapKho::firstOrCreate([
            'ma_phieu_nhap' => $data['ma_phieu_nhap'],
        ], [
            'ma_phieu_nhap' => $data['ma_phieu_nhap'],
            'ngay_nhap' => $data['ngay_nhap'] ?? $dt->toDateString(),
            'ma_ncc' => $data['ma_ncc'],
            'id_user' => auth()->user()->id,
            'mo_ta' => strlen($mo_ta) == 0 ? 'Không có mô tả cụ thể!' : $mo_ta
        ]);

        try {
            $file = $request->file('excel_file');
            $ma_phieu_nhap = $data['ma_phieu_nhap'];
            $ma_ncc = $data['ma_ncc'];

            $ct_hang_hoa = new ChiTietHangHoaImport();
            $ct_hang_hoa->setMaPhieu($ma_phieu_nhap);
            $ct_hang_hoa->setTrangThai(3);
            $ct_hang_hoa->setNhaCungCap($ma_ncc);

            Excel::import($ct_hang_hoa, $file);
            Alert::success('Thành công', 'Thêm dữ liệu từ file Excel thành công!');
            return redirect()->route('nhap-kho.index');

        } catch(ValidationException $e) {
            NhapKho::destroy($phieu_nhap->id);
            ChiTietHangHoa::where('ma_phieu_nhap', $data['ma_phieu_nhap'])->delete();

            $failures = $e->failures();
            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = "Dòng " . $failure->row() . ": " . $failure->errors()[0];
            }

            Alert::error('Thất bại', 'Xuất hiện lỗi trong khi thêm dữ liệu từ file Excel!')->autoClose(5000);
            return back()->with(['errors' => $errors]);
        }
    }

    public function destroy($code)
    {

    }
}
