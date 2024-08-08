<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\HangHoa;
use App\Models\LoaiHang;

class HangHoaImport implements ToCollection, WithValidation, WithStartRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $errors = [];

        $validator = Validator::make($rows->toArray(), $this->rules(), $this->customValidationMessages());

        if ($validator->fails()) {
            foreach ($validator->errors()->messages() as $rowErrors) {
                $errors[] = $rowErrors;
            }
        }

        if (count($errors) > 0) {
            return response()->json(['errors' => $errors], 400);
        }

        foreach ($rows as $row) {
            $loai_hang = LoaiHang::where('ten_loai_hang', $row[0])->first();
            HangHoa::create([
                'ma_hang_hoa' => $row[1],
                'ten_hang_hoa' => $row[2],
                'don_vi_tinh' => $row[3],
                'barcode' => $row[4],
                'mo_ta' => $row[5],
                'id_loai_hang' => $loai_hang->id,
                'img' => 'hanghoa.jpg'
            ]);
        }
    }

    public function startRow(): int
    {
        return 2;
    }

    public function rules(): array
    {
        return [
            '*.0' => 'required|string|exists:loai_hang,ten_loai_hang',
            '*.1' => 'required|string|max:50|unique:hang_hoa,ma_hang_hoa',
            '*.2' => 'required|string|max:255',
            '*.3' => 'required|string|max:255',
            '*.4' => 'required|integer|unique:hang_hoa,barcode',
            '*.5' => 'required|string|max:255',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.0.required' => 'Loại hàng không được để trống',
            '*.0.exists' => 'Loại hàng không tồn tại trong hệ thống',
            '*.1.required' => 'Mã hàng hóa là trường bắt buộc',
            '*.1.unique' => 'Mã hàng hóa đã tồn tại',
            '*.2.required' => 'Tên hàng hóa là trường bắt buộc',
            '*.2.max' => 'Tên hàng hóa không được vượt quá :max ký tự',
            '*.3.required' => 'Đơn vị tính là trường bắt buộc',
            '*.3.max' => 'Đơn vị tính không được vượt quá :max ký tự',
            '*.4.required' => 'Barcode là trường bắt buộc',
            '*.4.integer' => 'Barcode phải là số nguyên',
            '*.4.unique' => 'Barcode đã tồn tại',
            '*.5.required' => 'Mô tả là trường bắt buộc',
            '*.5.max' => 'Mô tả không được vượt quá :max ký tự',
        ];
    }
}
