@extends('default')

@section('style')
    <style>
        .w-10 {
            width: 10%;
        }
    </style>
@endsection

@section('content')
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head-between flex-wrap gap g-2">
                            <div class="nk-block-head-content">
                                <h2 class="nk-block-title">Quản lý tài khoản</h2>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('tai-khoan.index') }}">Quản lý tài khoản</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="nk-block-head">
                        <div class="nk-block-head">
                            <div class="nk-block-head-between flex-wrap gap g-2 align-items-start">
                                <div class="nk-block-head-content">
                                    <div class="d-flex flex-column flex-md-row align-items-md-center">
                                        <div class="media media-huge media-circle"><img src="{{ asset('storage/images/user/' . $user->avatar) }}" class="img-thumbnail"
                                                alt="">
                                        </div>
                                        <div class="mt-3 mt-md-0 ms-md-3">
                                            <h3 class="title mb-1">{{ $user->name }}</h3><span class="small">{{ $user->role_id == 1 ? 'Admin' : 'Nhân viên' }}</span>
                                            <ul class="nk-list-option pt-1">
                                                <li>
                                                    <form action="{{ route('user.changeRole', $user->id) }}" method="post">
                                                        @csrf
                                                        @method('put')
                                                        <button class="btn btn-soft btn-primary">
                                                            <em class="icon ni ni-edit"></em>
                                                            <span>Thay đổi role</span>
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#show-profile" type="button">Thông tin</button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="show-profile">
                            <div class="nk-block">
                                <div class="card card-gutter-md">
                                    <div class="card-body">
                                        <div class="bio-block">
                                            <h4 class="bio-block-title">Thông tin</h4>
                                            <ul class="list-group list-group-borderless small">
                                                <li class="list-group-item"><span class="title fw-medium w-10 d-inline-block">Họ và tên:</span><span
                                                        class="text">{{ $user->name }}</span></li>
                                                <li class="list-group-item"><span class="title fw-medium w-10 d-inline-block">Giới tính:</span><span
                                                        class="text">{{ $user->gioi_tinh }}</span></li>
                                                <li class="list-group-item"><span class="title fw-medium w-10 d-inline-block">Email:</span><span
                                                        class="text">{{ $user->email }}</span></li>
                                                <li class="list-group-item"><span class="title fw-medium w-10 d-inline-block">Số điện thoại:</span><span
                                                        class="text">{{ $user->sdt }}</span></li>
                                                <li class="list-group-item"><span class="title fw-medium w-10 d-inline-block">Địa chỉ:</span><span
                                                        class="text">{{ $user->address }}</span></li>
                                                <li class="list-group-item"><span class="title fw-medium w-10 d-inline-block">Ngày đăng ký:</span><span
                                                        class="text">{{ $user->created_at->format('d-m-Y') }}</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const imgInput = document.getElementById('default-img')
        const img = document.getElementById('img')
        img.src = '{{ asset('storage/images/user') }}/' + imgInput.value
    </script>
@endsection
