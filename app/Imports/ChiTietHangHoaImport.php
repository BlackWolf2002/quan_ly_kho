<?php

namespace App\Imports;

use App\Models\ChiTietHangHoa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rules\DateFormat;

class ChiTietHangHoaImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    private $ma_phieu_nhap, $trang_thai, $ma_ncc;


    public function setMaPhieu($ma_phieu_nhap)
    {
        $this->ma_phieu_nhap = $ma_phieu_nhap;
    }


    public function setTrangThai($trang_thai)
    {
        $this->trang_thai = $trang_thai;
    }


    public function setNhaCungCap($ma_ncc)
    {
        $this->ma_ncc = $ma_ncc;
    }


    public function headingRow() : int
    {
        return 1;
    }


    public function model(array $row)
    {
        $row['ma_phieu_nhap'] = $this->ma_phieu_nhap;
        $row['trang_thai'] = $this->trang_thai;
        $row['ma_ncc'] = $this->ma_ncc;

        return new ChiTietHangHoa([
            'ma_phieu_nhap' => $row['ma_phieu_nhap'],
            'ma_hang_hoa' => $row['ma_hang_hoa'],
            'ma_ncc' => $row['ma_ncc'],
            'so_luong' => $row['so_luong'],
            'so_luong_goc' => $row['so_luong'],
            'id_trang_thai' => $row['trang_thai'],
            'gia_nhap' => $row['gia_nhap'],
            'ngay_san_xuat' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['ngay_san_xuat'])->format('Y-m-d'),
            'tg_bao_quan' => $row['thoi_gian_bao_quan']
        ]);
    }

    public function rules(): array
    {
        return [
            '*.ma_hang_hoa' => 'required|string|max:50|exists:hang_hoa,ma_hang_hoa',
            '*.so_luong' => 'required|integer',
            '*.gia_nhap' => 'required|integer',
            // '*.ngay_san_xuat' => 'required|date_format:Y-m-d|before:tomorrow',
            '*.thoi_gian_bao_quan' => 'required|integer',
        ];
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
