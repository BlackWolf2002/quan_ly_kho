@extends('default')

@section('content')
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head-between flex-wrap gap g-2">
                            <div class="nk-block-head-content">
                                <h2 class="nk-block-title">Thống kê</h2>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Thống kê</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="nk-block-head-content">
                                <ul class="d-flex">
                                    <li>
                                        <a href="{{ route('thong-ke.export', ['data' => $data->toJson()]) }}" class="btn btn-primary d-md-inline-flex">
                                            <em class="icon ni ni-file-download"></em>
                                            <span>Export excel</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="card">
                            <form method="get" action="{{ route('thong-ke.index') }}">
                                <div class="row" style="margin:0">
                                    <div class="col-md-4 mb-3 px-2 pt-1">
                                        <div class="form-group">
                                            <label for="product_name" class="form-label">Tên hàng hóa</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="ma_ten" name="ma_ten" value="{{ $ma_ten }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3 px-2 pt-1">
                                        <div class="form-group">
                                            <label class="form-label">Thời gian</label>
                                            <div class="input-group js-datepicker" data-range="init">
                                                <span class="input-group-text">Từ</span>
                                                <input placeholder="mm/dd/yyyy" type="text" class="form-control" name="from_date" value="{{ $from_date }}">
                                                <span class="input-group-text">đến</span>
                                                <input placeholder="mm/dd/yyyy" type="text" class="form-control" name="to_date" value="{{ $to_date }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1 mb-3 px-2 pt-1 text-center">
                                        <button type="submit" class="btn btn-primary" style="margin-top: 30px">Lọc</button>
                                    </div>
                                    <input type="hidden" value="{{ $loai }}" name="loai">
                                    <input type="hidden" value="{{ $sap_xep }}" name="sap_xep">
                            </form>

                            <div class="col-md-3 mb-3 px-2 pt-1">
                                <div class="form-group">
                                    <label class="form-label">Sắp xếp</label>
                                    <div class="form-control-wrap">
                                        <select class="js-select" data-sort="false" onchange="location = this.value;">
                                            <option
                                                value="{{ route('thong-ke.index', ['from_date' => $from_date, 'to_date' => $to_date, 'ma_ten' => $ma_ten, 'sap_xep' => 'asc', 'loai' => '']) }}"
                                                {{ $loai == '' && $sap_xep == 'asc' ? 'selected' : '' }}>Mặc định
                                            </option>
                                            <option
                                                value="{{ route('thong-ke.index', ['from_date' => $from_date, 'to_date' => $to_date, 'ma_ten' => $ma_ten, 'sap_xep' => 'asc', 'loai' => 'gia_xuat']) }}"
                                                {{ $loai == 'gia_xuat' && $sap_xep == 'asc' ? 'selected' : '' }}>Doanh thu tăng dần
                                            </option>
                                            <option
                                                value="{{ route('thong-ke.index', ['from_date' => $from_date, 'to_date' => $to_date, 'ma_ten' => $ma_ten, 'sap_xep' => 'desc', 'loai' => 'gia_xuat']) }}"
                                                {{ $loai == 'gia_xuat' && $sap_xep == 'desc' ? 'selected' : '' }}>Doanh thu giảm dần
                                            </option>
                                            <option
                                                value="{{ route('thong-ke.index', ['from_date' => $from_date, 'to_date' => $to_date, 'ma_ten' => $ma_ten, 'sap_xep' => 'asc', 'loai' => 'lai']) }}"
                                                {{ $loai == 'lai' && $sap_xep == 'asc' ? 'selected' : '' }}>Lãi tăng dần
                                            </option>
                                            <option
                                                value="{{ route('thong-ke.index', ['from_date' => $from_date, 'to_date' => $to_date, 'ma_ten' => $ma_ten, 'sap_xep' => 'desc', 'loai' => 'lai']) }}"
                                                {{ $loai == 'lai' && $sap_xep == 'desc' ? 'selected' : '' }}>Lãi giảm dần
                                            </option>
                                            <option
                                                value="{{ route('thong-ke.index', ['from_date' => $from_date, 'to_date' => $to_date, 'ma_ten' => $ma_ten, 'sap_xep' => 'asc', 'loai' => 'so_luong_ban']) }}"
                                                {{ $loai == 'so_luong_ban' && $sap_xep == 'asc' ? 'selected' : '' }}>Xuất kho nhiểu nhất
                                            </option>
                                            <option
                                                value="{{ route('thong-ke.index', ['from_date' => $from_date, 'to_date' => $to_date, 'ma_ten' => $ma_ten, 'sap_xep' => 'desc', 'loai' => 'so_luong_ban']) }}"
                                                {{ $loai == 'so_luong_ban' ? 'selected' : '' }}>Xuất kho ít nhất
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead class="table-light">
                                    <tr>
                                        <th class="tb-col"><span class="overline-title">STT</span></th>
                                        <th class="tb-col"><span class="overline-title">Mã hàng hóa</span></th>
                                        <th class="tb-col"><span class="overline-title">Tên hàng hóa</span></th>
                                        <th class="tb-col"><span class="overline-title">Tồn kho</span></th>
                                        <th class="tb-col"><span class="overline-title">Nhập</span></th>
                                        <th class="tb-col"><span class="overline-title">Tổng giá trị</span></th>
                                        <th class="tb-col"><span class="overline-title">Xuất</span></th>
                                        <th class="tb-col"><span class="overline-title">Doanh thu</span></th>
                                        <th class="tb-col tb-col-end"><span class="overline-title">Lãi</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hang_hoa as $key => $tk)
                                        <tr>
                                            <td class="tb-col"><span>{{ $key + 1 }}</span></td>
                                            <td class="tb-col">
                                                <span>{{ strlen($tk->ma_hang_hoa) > 10 ? substr($tk->ma_hang_hoa, 0, 10) . '...' : substr($tk->ma_hang_hoa, 0, 10) }}</span>
                                            </td>
                                            <td class="tb-col">
                                                <div class="media-text">
                                                    <a class="title" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus"
                                                        data-bs-content="{{ $tk->ten_hang_hoa }}"
                                                        href="{{ route('hang-hoa.show', $tk->ma_hang_hoa) }}">{{ strlen($tk->ten_hang_hoa) > 20 ? substr($tk->ten_hang_hoa, 0, 20) . '...' : substr($tk->ten_hang_hoa, 0, 20) }}</a>
                                                </div>
                                            </td>
                                            <td class="tb-col"><span> {{ $tk->get_chi_tiet_sum_so_luong ?? 0 }}</span></td>
                                            <td class="tb-col"><span> {{ $tk->get_chi_tiet_sum_so_luong_goc }}</span></td>
                                            <td class="tb-col"><span> {{ number_format($tk->gia_nhap, 0, '', '.') }} VNĐ</span></td>
                                            <td class="tb-col"><span> {{ $tk->get_chi_tiet_xuat_kho_sum_so_luong ?? 0 }}</span></td>
                                            <td class="tb-col"><span> {{ number_format($tk->gia_xuat, 0, '', '.') }} VNĐ</span></td>
                                            <td class="tb-col tb-col-end"><span> {{ number_format($tk->lai, 0, '', '.') }} VNĐ</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <nav>
                                <ul class="pagination pagination-s1 flex-wrap justify-content-center py-2">
                                    @if ($hang_hoa->onFirstPage())
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#">
                                                <em class="icon ni ni-chevrons-left"></em>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link"
                                                href="{{ $hang_hoa->appends(['loai' => $loai, 'from_date' => $from_date, 'to_date' => $to_date, 'ma_ten' => $ma_ten, 'sap_xep' => $sap_xep])->url(1) }}">
                                                <em class="icon ni ni-chevrons-left"></em>
                                            </a>
                                        </li>
                                    @endif

                                    @foreach ($hang_hoa->getUrlRange(max(1, $hang_hoa->currentPage() - 2), min($hang_hoa->lastPage(), $hang_hoa->currentPage() + 2)) as $page => $url)
                                        @if ($page == $hang_hoa->currentPage())
                                            <li class="active page-item">
                                                <a class="page-link" href="#">{{ $page }}</a>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $hang_hoa->appends(['loai' => $loai, 'from_date' => $from_date, 'to_date' => $to_date, 'ma_ten' => $ma_ten, 'sap_xep' => $sap_xep])->url($page) }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                    @if ($hang_hoa->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link"
                                                href="{{ $hang_hoa->appends(['loai' => $loai, 'from_date' => $from_date, 'to_date' => $to_date, 'ma_ten' => $ma_ten, 'sap_xep' => $sap_xep])->url($hang_hoa->lastPage()) }}">
                                                <em class="icon ni ni-chevrons-right"></em>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#">
                                                <em class="icon ni ni-chevrons-right"></em>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
