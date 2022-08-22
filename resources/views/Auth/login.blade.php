@extends('navbar')

@section('login')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 col-12 mx-auto">
                @if (Session::has('user'))
                    {!! Session::get('user') !!}
                @endif
                @if (Session::has('email'))
                    {!! Session::get('email') !!}
                @endif
                <div class="card">
                    <div class="card-body">
                        <form action="" method="post">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com">
                                <label for="floatingInput">Email address</label>
                                @error('email')
                                <p class="text-danger text-small">{{ $message }}</p>
                                @enderror
                              </div>
                              <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
                                <label for="floatingPassword">Password</label>
                                @error('password')
                                <p class="text-danger text-small">{{ $message }}</p>
                                @enderror
                              </div>
                              <div class="mb-4">
                                  <input type="submit" value="Sign In" class="btn text-white w-100" style="height: 45px;background-color:black">
                              </div>
                              <div class="mb-5">
                                  <a href="{{ route('signup') }}" class="text-primary float-start"><u>Don't have an Account?</u></a>
                              </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection