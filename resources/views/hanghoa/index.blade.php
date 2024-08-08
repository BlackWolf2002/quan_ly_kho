@extends('default')

@section('style')
@endsection

@section('content')
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head-between flex-wrap gap g-2">
                            <div class="nk-block-head-content">
                                <h2 class="nk-block-title">Quản lý kho</h2>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">Quản lý
                                            kho</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="nk-block-head-content">
                                @can('user')
                                    <ul class="d-flex">
                                        <li>
                                            <form id="form-import" enctype="multipart/form-data">
                                                <label for="import-excel" class="btn btn-primary d-md-inline-flex" style="margin-right: 10px">
                                                    <em class="icon ni ni-file-xls"></em>
                                                    <span>
                                                        Import
                                                    </span>
                                                </label>
                                                <input type="file" name="excel_file" id="import-excel" accept=".xlsx,.xls" hidden>
                                            </form>
                                        </li>
                                        <li>
                                            <a href="{{ route('hang-hoa.create') }}" class="btn btn-primary d-md-inline-flex">
                                                <em class="icon ni ni-plus"></em>
                                                <span>Thêm hàng hóa</span>
                                            </a>
                                        </li>
                                    </ul>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="card">
                            <table class="datatable-init table" data-nk-container="table-responsive" id="hang-hoa">
                                <thead class="table-light">
                                    <tr>
                                        <th class="tb-col"><span class="overline-title">STT</span></th>
                                        <th class="tb-col"><span class="overline-title">Mã hàng</span></th>
                                        <th class="tb-col"><span class="overline-title">Tên hàng</span></th>
                                        <th class="tb-col"><span class="overline-title">SL</span></th>
                                        <th class="tb-col"><span class="overline-title">Đơn vị</span></th>
                                        <th class="tb-col"><span class="overline-title">Loại hàng</span></th>
                                        <th class="tb-col"><span class="overline-title">Trạng thái</span></th>
                                        <th class="tb-col tb-col-end" data-sortable="false"><span class="overline-title">Hành động</span></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($hang_hoa as $key => $hang)
                                        <tr>
                                            <td class="tb-col">
                                                <span>{{ $key + 1 }}</span>
                                            </td>
                                            <td class="tb-col">
                                                <span>{{ strlen($hang->ma_hang_hoa) > 10 ? substr($hang->ma_hang_hoa, 0, 10) . '...' : substr($hang->ma_hang_hoa, 0, 10) }}</span>
                                            </td>
                                            <td class="tb-col">
                                                <div class="media-group">
                                                    <div class="media media-lg media-middle"><img src="{{ asset('storage/images/hanghoa/' . $hang->img) }}"
                                                            alt="img"></div>
                                                    <div class="media-text">
                                                        <a href="{{ route('hang-hoa.show', $hang->ma_hang_hoa) }}"
                                                            class="title">{{ strlen($hang->ten_hang_hoa) > 20 ? substr($hang->ten_hang_hoa, 0, 20) . '...' : substr($hang->ten_hang_hoa, 0, 20) }}</a>
                                                    </div>
                                                </div>
                                            </td>
                                            @php
                                                $so_luong = 0;
                                                foreach ($hang->getChiTiet as $value) {
                                                    $so_luong += $value->so_luong;
                                                }
                                            @endphp
                                            <td class="tb-col"><span>{{ $so_luong }}</span></td>
                                            <td class="tb-col"><span>{{ $hang->don_vi_tinh }}</span></td>
                                            <td class="tb-col">
                                                <span>{{ strlen($hang->getLoaiHang->ten_loai_hang) > 15 ? substr($hang->getLoaiHang->ten_loai_hang, 0, 15) . '...' : substr($hang->getLoaiHang->ten_loai_hang, 0, 15) }}</span>
                                            </td>
                                            <td class="tb-col">
                                                <span
                                                    class="badge text-bg-{{ $so_luong > 0 ? 'success' : 'danger' }}-soft">{{ $so_luong > 0 ? 'Còn hàng' : 'Hết hàng' }}</span>
                                            </td>
                                            <td class="tb-col tb-col-end">
                                                <div class="dropdown"><a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown"><em
                                                            class="icon ni ni-more-v"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                        <div class="dropdown-content py-1">
                                                            <ul class="link-list link-list-hover-bg-primary link-list-md">
                                                                @can('user')
                                                                    <li><a href="{{ route('hang-hoa.edit', $hang->ma_hang_hoa) }}"><em
                                                                                class="icon ni ni-edit"></em><span>Sửa</span></a>
                                                                    </li>
                                                                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#xoahanghoa{{ $hang->id }}"><em
                                                                                class="icon ni ni-trash"></em><span>Xóa</span></a>
                                                                    </li>
                                                                @endcan
                                                                <li><a href="{{ route('hang-hoa.show', $hang->ma_hang_hoa) }}"><em
                                                                            class="icon ni ni-eye"></em><span>Xem chi
                                                                            tiết</span></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @can('user')
                                            <div class="modal fade" id="xoahanghoa{{ $hang->id }}" data-bs-keyboard="false" tabindex="-1"
                                                aria-labelledby="scrollableLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-top">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="scrollableLabel">Bạn
                                                                chắc chắc muốn xóa?
                                                            </h5> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">Đồng ý
                                                            nghĩa là bạn muốn xóa toàn
                                                            bộ dữ liệu liên quan đến hàng hóa này!
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                            <form method="POST" action="{{ route('hang-hoa.delete', $hang->id) }}" id="delete-form">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" class="btn btn-sm btn-primary">Đồng
                                                                    ý</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endcan
                                    @endforeach

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        $(document).ready(function() {
            $('input[name="excel_file"]').change(function() {
                $('#form-import').submit();
            });

            $('#form-import').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    url: '{{ route('api.them-hang.import') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.type === 'success') {
                            Swal.fire({
                                title: 'Thành công!',
                                text: response.message,
                                icon: 'success',
                            });
                            setTimeout(() => {
                                window.location.href = response.redirect;
                            }, 2000);
                        } else {
                            Swal.fire({
                                title: 'Thất bại!',
                                text: response.message,
                                icon: 'error'
                            });
                        }
                    },
                    error: function(response) {
                        var errors = response.responseJSON.errors;
                        var errorText = '';

                        $.each(errors, function(index, error) {
                            $.each(error, function(key, value) {
                                errorText += value + "\n";
                            })
                        })

                        alert(errorText);
                    }
                })

            })
        })
    </script>
@endsection
