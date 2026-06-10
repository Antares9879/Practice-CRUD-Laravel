@extends('layouts/auth')

@push('title', 'Halaman Login')


@section('content')

<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
            <div class="col-lg-7">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                    </div>


                    <form class="user" action="/login" method="POST"> @csrf
                        <div class="form-group">
                            <input type="email" name="email" class="form-control form-control-user 
                            @error('email') is-invalid @enderror" id="exampleInputEmail" 
                            value="{{ old('email') }}"
                            placeholder="Alamat E-Mail">

                            @error('email')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>


                        <div class="form-group">
                            <input type="password" name="password" class="form-control form-control-user 
                            @error('password') is-invalid @enderror" id="exampleInputPassword" 
                            value="{{ old('password') }}"
                            placeholder="Password">
                            
                            @error('password')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                        </div>



                        <button type="submit" role="button" class="btn btn-primary btn-user btn-block">
                            Login
                        </button>
                    </form>
                    <hr>
                    <div class="text-center">
                        <a class="small" href="/register">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

