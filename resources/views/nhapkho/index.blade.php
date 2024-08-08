@extends('default')

@section('content')
    @if (session('errors'))
        @foreach (session('errors') as $error)
            <span class="invalid-feedback" role="alert">
                <strong>{{ $error }}</strong>
            </span>
        @endforeach
    @endif
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head-between flex-wrap gap g-2">
                            <div class="nk-block-head-content">
                                <h2 class="nk-block-title">Quản lý nhập kho</h2>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">Quản lý nhập
                                            kho</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="nk-block-head-content">
                                <ul class="d-flex">
                                    <li>
                                        <a href="{{ route('nhap-kho.create') }}" class="btn btn-primary d-md-inline-flex">
                                            <em class="icon ni ni-plus"></em>
                                            <span>Nhập kho</span>
                                        </a>
                                    </li>
                                    <li style="margin-left: 10px">
                                        <a href="#" class="btn btn-primary d-md-inline-flex" data-bs-toggle="modal" data-bs-target="#nhap_excel">
                                            <em class="icon ni ni-file-xls"></em>
                                            <span>Import</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="card">
                            <table class="datatable-init table" data-nk-container="table-responsive">
                                <thead class="table-light">
                                    <tr>
                                        <th class="tb-col"><span class="overline-title">STT</span></th>
                                        <th class="tb-col"><span class="overline-title">Mã phiếu</span></th>
                                        <th class="tb-col"><span class="overline-title">Người nhập</span></th>
                                        <th class="tb-col" data-type="date" data-format="DD-MM-YYYY"><span class="overline-title">Ngày nhập</span></th>
                                        <th class="tb-col tb-col-end"><span class="overline-title">Hành động</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($phieu_nhap as $key => $phieu)
                                        <tr>
                                            <td class="tb-col"><span>{{ $key + 1 }}</span></td>
                                            <td class="tb-col"><span>{{ $phieu->ma_phieu_nhap }}</span></td>
                                            <td class="tb-col"><span>{{ $phieu->getUsers->name }}</span></td>
                                            <td class="tb-col"><span> {{ \Carbon\Carbon::createFromFormat('Y-m-d', $phieu->ngay_nhap)->format('d-m-Y') }}
                                                </span></td>
                                            <td class="tb-col tb-col-end">
                                                <a href="{{ route('nhap-kho.show', $phieu->ma_phieu_nhap) }}" class="btn btn-info btn-sm"><em
                                                        class="icon ni ni-eye"></em><span>Xem</span></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="nhap_excel" data-bs-keyboard="false" tabindex="-1" aria-labelledby="scrollableLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-top">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scrollableLabel">Nhập thông tin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('nhap-kho.import') }}" method="POST" enctype="multipart/form-data" id="form-create">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-gs">
                            <div class="col-lg-6">
                                <div class="form-group"><label for="ma_phieu_nhap" class="form-label">Mã phiếu nhập</label>
                                    <div class="form-control-wrap">
                                        <input type="text" minlength="1" maxlength="255" class="form-control" id="ma_phieu_nhap" value="#{{ $ma_phieu_nhap }}"
                                            disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group"> <label for="ngay_nhap" class="form-label">Ngày nhập</label>
                                    <div class="form-control-wrap"> <input placeholder="yyyy/mm/dd" type="date" class="form-control" name="ngay_nhap"
                                            value="{{ old('ngay_nhap') }}" id="ngay_nhap" required> </div>
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
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Chi tiết</label>
                                    <div class="form-control-wrap">
                                        <div class="js-quill" id="quill_editor" value="{!! old('mo_ta') !!}" data-toolbar="minimal"
                                            data-placeholder="Viết chi tiết sản phẩm vào đây...">
                                        </div>
                                        <input type="hidden" name="mo_ta">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group"><input type="file" class="form-control" name="excel_file" id="file" required></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-sm btn-primary">Xác nhận</button>
                    </div>
                    <input type="hidden" name="ma_phieu_nhap" value="{{ $ma_phieu_nhap }}">
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
        const form = document.querySelector('#form-create');
        form.onsubmit = function(e) {
            const mo_ta = document.querySelector('input[name=mo_ta]');
            mo_ta.value = JSON.stringify(quill.getContents());

            return true;
        };
    </script>
@endsection
