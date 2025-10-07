@extends('layouts.login')

@section('content')
<div class="h-100 d-flex bg-white justify-content-center align-items-center col-md-12 col-lg-8">
    <div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-9">
        <div class="app-logo"></div>
        <h4 class="mb-0">
            <span class="d-block">Login</span>

        </h4>
        <!-- <h6 class="mt-3">No account? <a href="javascript:void(0);" class="text-primary">Sign up now</a></h6> -->
        <div class="divider row"></div>
        <div>
            <form action="{{ route('login.post') }}" method="post">
              @csrf
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                          <label for="exampleEmail" class="">Email</label>
                          <input name="email"  placeholder="Email here..." type="text" class="form-control">

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="position-relative form-group"><label for="examplePassword" class="">Password</label>
                          <input name="password" placeholder="Password here..." type="password" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="position-relative form-check"><input name="check" id="exampleCheck" type="checkbox" class="form-check-input"><label for="exampleCheck" class="form-check-label">Keep me logged in</label></div>
                <div class="divider row"></div>
                <div class="d-flex align-items-center">
                    <!-- <div class="ml-auto"><a href="javascript:void(0);" class="btn-lg btn btn-link">Recover Password</a> -->
                        <button class="btn btn-primary btn-lg" type="submit">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
