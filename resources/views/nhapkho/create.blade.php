@extends('default')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head-between flex-wrap gap g-2">
                            <div class="nk-block-head-content">
                                <h2 class="nk-block-title">Nhập kho</h2>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="{{ route('nhap-kho.index') }}">Quản lý nhập
                                                kho</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Nhập kho</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <form action="#" method="POST" id="form-create">
                            @csrf
                            <div class="row g-gs">
                                <div class="col-xxl-12">
                                    <div class="gap gy-4">
                                        <div class="gap-col">
                                            <div class="card card-gutter-md">
                                                <div class="card-body">
                                                    <div class="row g-gs">
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="ma_phieu_nhap" class="form-label">Mã phiếu nhập</label>
                                                                <div class="form-control-wrap">
                                                                    <input style="width:100%" type="text" minlength="1" maxlength="255" class="form-control"
                                                                        id="ma_phieu_nhap" value="{{ $ma_phieu_nhap }}" disabled>
                                                                </div>
                                                                @if ($errors)
                                                                    <span class="text-danger py-1 mt-2">{{ $errors->first('ma_phieu_nhap') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="ngay_nhap" class="form-label">Ngày nhập kho</label>
                                                                <div class="form-control-wrap">
                                                                    <input style="width:100%" placeholder="yyyy/mm/dd" type="date" class="form-control"
                                                                        name="ngay_nhap" value="{{ old('ngay_nhap') }}" id="ngay_nhap" required>
                                                                </div>
                                                                @if ($errors)
                                                                    <span class="text-danger py-1 mt-2">{{ $errors->first('ngay_nhap') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group"> <label for="ma_ncc" class="form-label">Nhà cung cấp</label>
                                                                <div class="form-control-wrap">
                                                                    <select class="js-select" data-search="true" data-sort="false" name="ma_ncc" id="ma_ncc">
                                                                        <option value="">Nhà cung cấp</option>
                                                                        @foreach ($nha_cung_cap as $ncc)
                                                                            <option value="{{ $ncc->ma_ncc }}">{{ $ncc->ten_ncc }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                @if ($errors)
                                                                    <span class="text-danger py-1 mt-2">{{ $errors->first('ma_ncc') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Chi tiết</label>
                                                                <div class="form-control-wrap">
                                                                    <div class="js-quill" id="quill_editor" value="{!! old('mo_ta') !!}" data-toolbar="minimal"
                                                                        data-placeholder="Viết chi tiết sản phẩm vào đây...">
                                                                    </div>
                                                                    <input style="width:100%" type="hidden" name="mo_ta">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="gap-col">
                                            <div class="card card-gutter-md">
                                                <table id="item-table" class="table" data-nk-container="table-responsive">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="tb-col"><span class="overline-title">Mã - tên hàng</span></th>
                                                            <th class="tb-col"><span class="overline-title">SL</span>
                                                            </th>
                                                            <th class="tb-col"><span class="overline-title">Giá</span></th>
                                                            <th class="tb-col"><span class="overline-title">NSX</span></th>
                                                            <th class="tb-col"><span class="overline-title">Bảo
                                                                    quản(tháng)</span></th>
                                                            <th class="tb-col tb-col-end"><span class="overline-title">Hành động</span></th>
                                                        </tr>
                                                    </thead>

                                                    <datalist id="ma_hang_hoa">
                                                        @foreach ($hang_hoa as $hang)
                                                            <option value="{{ $hang->ma_hang_hoa }}">{{ $hang->ten_hang_hoa }}</option>
                                                        @endforeach
                                                    </datalist>

                                                    <tbody id="tb-container">
                                                        <tr class="item-row">
                                                            <td class="tb-col">
                                                                <div class="form-control-wrap d-flex">
                                                                    <input style="width:80%" list="ma_hang_hoa" name="ma_hang_hoa[]" class="form-control">
                                                                    <button class="btn btn-light" type="button" data-bs-toggle="modal"
                                                                        data-bs-target="#them-hang">
                                                                        <em class="icon ni ni-plus-circle"></em>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                            <td class="tb-col">
                                                                <div class="form-control-wrap"><input style="width:100%" type="number" min="1"
                                                                        max="1000000000" class="form-control" name="so_luong[]" required />
                                                                </div>
                                                            </td>
                                                            <td class="tb-col">
                                                                <div class="form-control-wrap"><input style="width:100%" type="number" min="1"
                                                                        max="1000000000" class="form-control" name="gia_nhap[]" required />
                                                                </div>
                                                            </td>
                                                            <td class="tb-col">
                                                                <div class="form-control-wrap"><input style="width:100%" placeholder="dd/mm/yyyy" type="date"
                                                                        class="form-control" name="ngay_san_xuat[]" required>
                                                                </div>
                                                            </td>
                                                            <td class="tb-col">
                                                                <div class="form-control-wrap"><input style="width:100%" type="number" min="1"
                                                                        max="1000000000" class="form-control" name="tg_bao_quan[]" required /></div>
                                                            </td>
                                                            <td class="tb-col tb-col-end text-center"><button type="button"
                                                                    class="btn btn-danger btn-sm remove-item">Xóa</button>
                                                            </td>
                                                        </tr>
                                                        <template id="hang-hoa-template">
                                                            <tr class="item-row">
                                                                <td class="tb-col">
                                                                    <div class="form-control-wrap d-flex">
                                                                        <input style="width:80%" list="ma_hang_hoa" name="ma_hang_hoa[]" class="form-control">
                                                                        <button class="btn btn-light" type="button" data-bs-toggle="modal"
                                                                            data-bs-target="#them-hang">
                                                                            <em class="icon ni ni-plus-circle"></em>
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                                <td class="tb-col">
                                                                    <div class="form-control-wrap">
                                                                        <input style="width:100%" type="number" min="1" max="1000000000"
                                                                            class="form-control" name="so_luong[]" required />
                                                                    </div>
                                                                </td>
                                                                <td class="tb-col">
                                                                    <div class="form-control-wrap"><input style="width:100%" type="number" min="1"
                                                                            max="1000000000" class="form-control" name="gia_nhap[]" required /></div>
                                                                </td>
                                                                <td class="tb-col">
                                                                    <div class="form-control-wrap"><input style="width:100%" placeholder="dd/mm/yyyy"
                                                                            type="date" class="form-control" name="ngay_san_xuat[]" required>
                                                                    </div>
                                                                </td>
                                                                <td class="tb-col">
                                                                    <div class="form-control-wrap"><input style="width:100%" type="number" min="1"
                                                                            max="1000000000" class="form-control" name="tg_bao_quan[]" required /></div>
                                                                </td>
                                                                <td class="tb-col tb-col-end text-center">
                                                                    <button type="button" class="btn btn-danger btn-sm remove-item">Xóa</button>
                                                                </td>
                                                            </tr>
                                                        </template>
                                                    </tbody>
                                                </table>
                                                <button type="button" class="btn btn-primary btn-sm" id="add-item">Thêm</button>
                                            </div>
                                        </div>
                                        <div class="gap-col">
                                            <ul class="d-flex align-items-center gap g-3">
                                                <li><button type="submit" class="btn btn-primary">Lưu</button></li>
                                                <li><a href="{{ url()->previous() }}" class="btn border-0">Quay
                                                        lại</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="ma_phieu_nhap" value="{{ $ma_phieu_nhap }}" disabled>
                            <input type="hidden" name="data">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="them-hang" data-bs-keyboard="false" tabindex="-1" aria-labelledby="scrollableLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-top">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scrollableLabel">Nhập thông tin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="POST" enctype="multipart/form-data" id="form-add">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-gs">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="ma_hang_hoa" class="form-label">Mã hàng hóa</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="ma_hang_hoa1" name="ma_hang_hoa" placeholder="Mã hàng hóa"
                                            maxlength="100" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="ten_hang_hoa" class="form-label">Tên hàng hóa</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="ten_hang_hoa1" name="ten_hang_hoa" placeholder="Tên hàng hóa"
                                            maxlength="255" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="don_vi_tinh" class="form-label"> Đơn vị tính</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="don_vi_tinh1" name="don_vi_tinh" placeholder="Đơn vị tính"
                                            maxlength="50" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="barcode" class="form-label">Barcode</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="barcode1" name="barcode" placeholder="Barcode" maxlength="100">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Loại hàng hóa</label>
                                    <div class="form-control-wrap">
                                        <select class="form-select" name="id_loai_hang1" id="id_loai_hang1" data-search="true" data-sort="false">
                                            <option disabled value="">Loại hàng hóa</option>
                                            @foreach ($loai_hang as $loai)
                                                <option value="{{ $loai->id }}">{{ $loai->ten_loai_hang }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Mô tả</label>
                                    <div class="form-control-wrap">
                                        <div class="js-quill" id="quill_editor1" data-toolbar="minimal" data-placeholder="Viết chi tiết sản phẩm vào đây...">
                                        </div>
                                        <input type="hidden" name="mo_ta1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-sm btn-primary">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/libs/editors/quill.js') }}"></script>

    <script>
        const quill = new Quill('#quill_editor', {
            theme: 'snow'
        });

        const quill1 = new Quill('#quill_editor1', {
            theme: 'snow'
        });

        const token = '{{ csrf_token() }}'
        const formAdd = document.getElementById('form-add');
        formAdd.onsubmit = function(e) {
            e.preventDefault()
            let mo_ta1 = quill1.getContents().ops[0].insert;
            let ma_hang_hoa1 = document.getElementById('ma_hang_hoa1').value
            let ten_hang_hoa1 = document.getElementById('ten_hang_hoa1').value
            let don_vi_tinh1 = document.getElementById('don_vi_tinh1').value
            let barcode1 = document.getElementById('barcode1').value
            let id_loai_hang1 = document.getElementById('id_loai_hang1').value

            let data1 = [{
                ma_hang_hoa: ma_hang_hoa1,
                ten_hang_hoa: ten_hang_hoa1,
                don_vi_tinh: don_vi_tinh1,
                barcode: barcode1,
                id_loai_hang: id_loai_hang1,
                mo_ta: mo_ta1 === "\n" ? '' : mo_ta1,
            }]

            $.ajax({
                type: 'POST',
                url: '{{ route('api.them-hang.add') }}',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                data: JSON.stringify(data1),
                success: function(response) {
                    if (response.type === 'success') {
                        Swal.fire({
                            title: 'Thành công!',
                            text: response.message,
                            icon: 'success',
                        });
                        formAdd.reset()
                    } else {
                        Swal.fire({
                            title: 'Thất bại!',
                            text: response.message,
                            icon: 'error'
                        });
                    }
                },
                error: function(xhr, status, error) {}
            });
            return true
        };


        const addItemBtn = document.getElementById('add-item')
        const container = document.getElementById('tb-container')
        const delBtn = document.querySelector('.remove-item')
        delBtn.addEventListener('click', function() {
            delBtn.closest('.item-row').remove()
        })

        addItemBtn.addEventListener('click', function() {
            const hangHoaTemplate = document.getElementById('hang-hoa-template')
            const hangHoa = hangHoaTemplate.content.cloneNode(true)
            const inputs = hangHoa.querySelectorAll('input')

            inputs.forEach(function(input) {
                input.value = ''
            });

            const delBtn = hangHoa.querySelector('.remove-item')
            delBtn.addEventListener('click', function() {
                delBtn.closest('.item-row').remove()
            })

            container.appendChild(hangHoa);
        });

        const formCreate = document.getElementById('form-create')
        formCreate.onsubmit = function(e) {
            e.preventDefault()
            const ma_phieu_nhap = $('input[name="ma_phieu_nhap"]').val()
            const ngay_nhap = $('input[name="ngay_nhap"]').val()
            const ma_ncc = $('#ma_ncc').find(':selected').val()
            const mo_ta = quill.getContents().ops[0].insert
            id_user = {{ auth()->user()->id }}

            let data = [{
                ma_phieu_nhap: ma_phieu_nhap,
                ma_ncc: ma_ncc,
                ngay_nhap: ngay_nhap,
                mo_ta: mo_ta === "\n" ? '' : mo_ta,
                id_user: id_user
            }]

            $('table tr.item-row').each(function() {
                const item = {
                    ma_hang_hoa: $(this).find('input[name="ma_hang_hoa[]"]').val(),
                    so_luong: $(this).find('input[name="so_luong[]"]').val(),
                    gia_nhap: $(this).find('input[name="gia_nhap[]"]').val(),
                    ngay_san_xuat: $(this).find('input[name="ngay_san_xuat[]"]').val(),
                    tg_bao_quan: $(this).find('input[name="tg_bao_quan[]"]').val()
                }
                data.push(item);
            });

            $.ajax({
                type: 'POST',
                url: '{{ route('api.nhap-kho.store') }}',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                data: JSON.stringify(data),
                success: function(response) {
                    if (response.type === 'success') {
                        Swal.fire({
                            title: 'Thành công!',
                            text: response.message,
                            icon: 'success',
                        });
                        setTimeout(() => {
                            window.location.href = response.redirect;
                        }, 3000);
                    } else {
                        Swal.fire({
                            title: 'Thất bại!',
                            text: response.message,
                            icon: 'error'
                        });
                    }
                },
                error: function(xhr, status, error) {}
            });

            return true
        }
    </script>
@endsection
