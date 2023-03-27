<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use App\Models\PhieuXuat;
use App\Models\ChiTietPhieuXuat;
use App\Models\ChiTietHangHoa;
use App\Models\HangHoa;
use App\Exports\PhieuXuatExport;

class PhieuXuatController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('searchInput');

        $selectedValues = $request->input('selectedValues', []);

        $hang_hoa = ChiTietHangHoa::where('ma_hang_hoa', 'LIKE', "%{$query}%")
                                    ->orWhereHas('getHangHoa', function ($q) use ($query) {
                                        $q->where('ten_hang_hoa', 'LIKE', "%{$query}%");
                                    })->with('getHangHoa')->get();

        $result = [];

        foreach ($hang_hoa as $item) {
            if (!in_array($item->id, $selectedValues) && $item->so_luong > 0) {
                $result[] = $item;
            }
        }

        return response()->json($result);
    }

    public function store(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if (count($data) > 1) {
            $mo_ta = json_decode($data[0]['mo_ta'], true) ?? 'Chưa có mô tả cụ thể!';

            $phieu_xuat = PhieuXuat::firstOrCreate(
                ['ma_phieu_xuat' => $data[0]['ma_phieu_xuat']],
                [
                'ma_phieu_xuat' => $data[0]['ma_phieu_xuat'],
                'khach_hang' => $data[0]['khach_hang'],
                'dia_chi' => $data[0]['dia_chi'],
                'ngay_xuat' => $data[0]['ngay_xuat'],
                'id_user' => $data[0]['id_user'],
                'mo_ta' => $mo_ta
            ]);

            if ($phieu_xuat->wasRecentlyCreated) {

                for ($i = 1; $i < count($data); $i++) {
                    $cthh = ChiTietHangHoa::find($data[$i]['id_hang_hoa']);
                    $cthh->so_luong -= $data[$i]['so_luong'];
                    $cthh->so_luong == 0 ?? $cthh->trang_thai = 1;
                    $cthh->save();

                    ChiTietPhieuXuat::create([
                        'ma_phieu_xuat' => $data[0]['ma_phieu_xuat'],
                        'id_chi_tiet_hang_hoa' => $data[$i]['id_hang_hoa'],
                        'so_luong' => $data[$i]['so_luong'],
                        'gia_xuat' => $data[$i]['gia']
                    ]);
                }

                return response()->json(['message'=> 'Xuất kho thành công. Bạn sẽ được chuyển hướng sau vài giây!', 'type' => 'success', 'redirect' => route('xuat-kho.index')], 200);
            }

            return response()->json(['status'=> 'Mã phiếu xuất đã tồn tại. Vui lòng tải lại trang để được nhận mã phiểu mới!']);
        }

        return response()->json(['message'=> 'Có lỗi xảy ra trong quá trình xuất dữ liệu. Vui lòng kiểm tra và thử lại!']);
    }
}
