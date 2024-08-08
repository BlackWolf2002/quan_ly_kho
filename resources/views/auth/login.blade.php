@extends('default')

@section('content')
    <div class="container p-2 p-sm-4">
        <div class="wide-xs mx-auto">
            <div class="card card-gutter-lg rounded-4 card-auth">
                <div class="card-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head-content">
                            <h1 class="nk-block-title mb-1 text-center">Đăng nhập</h1>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row gy-3">
                            <div class="col-12">
                                <div class="form-group"><label for="email" class="form-label">Email</label>
                                    <div class="form-control-wrap"><input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                            id="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter email"></div>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group"><label for="password" class="form-label">Password</label>
                                    <div class="form-control-wrap"><input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="password" name="password" required autocomplete="current-password" placeholder="Enter password"></div>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="form-check form-check-sm">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">Nhớ tài khoản</label>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="small">Quên mật khẩu?</a>
                                    @endif

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-grid"><button class="btn btn-primary" type="submit">Đăng nhập</button></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- <div class="text-center mt-5">
                <p class="small">Bạn chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký</a>
                </p>
            </div> --}}
        </div>
    </div>
@endsection
