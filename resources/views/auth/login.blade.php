@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow">
                <div class="card-body">

                    {{-- TAB HEADER --}}
                    <ul class="nav nav-tabs nav-tabs-line" id="authTab" role="tablist">
                        <li class="nav-item w-50 text-center">
                            <button class="nav-link active w-100" data-bs-toggle="tab" data-bs-target="#login">
                                Login
                            </button>
                        </li>
                        <li class="nav-item w-50 text-center">
                            <button class="nav-link w-100" data-bs-toggle="tab" data-bs-target="#register">
                                Register
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content mt-4">

                        {{-- ================= LOGIN ================= --}}
                        <div class="tab-pane fade show active" id="login">

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-3">
                                    <input type="email" name="email" class="form-control"
                                        placeholder="Email" required autofocus>
                                </div>

                                <div class="mb-3">
                                    <input type="password" name="password" class="form-control"
                                        placeholder="Password" required>
                                </div>

                                <button type="submit" class="btn btn-gradient-primary w-100">
                                    Login
                                </button>
                            </form>
                        </div>


                        {{-- ================= REGISTER ================= --}}
                        <div class="tab-pane fade" id="register">

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="mb-3">
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Nama" required>
                                </div>

                                <div class="mb-3">
                                    <input type="email" name="email" class="form-control"
                                        placeholder="Email" required>
                                </div>

                                <div class="mb-3">
                                    <input type="password" name="password" class="form-control"
                                        placeholder="Password" required>
                                </div>

                                <div class="mb-3">
                                    <input type="password" name="password_confirmation" class="form-control"
                                        placeholder="Konfirmasi Password" required>
                                </div>

                                <button type="submit" class="btn btn-gradient-success w-100">
                                    Register
                                </button>
                            </form>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

