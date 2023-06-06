@extends('web.auth.auth_app')

@section('content')
    <div class="card">
        <h3 class="title mb-3">Login</h3>
        {{-- @include('web.auth._social') --}}

        <x-form::open action="{{ route('web.loginGuest') }}">
          <div class="email-login">
             <label for="name"> <b>Name</b> <span class="text-danger">*</span></label>
             <input
                type="text"
                name="name"
                placeholder="Nguyen Van A"
                value="{{old('name') ?? null}}"
                id="name"
                required />
             <label for="account"><b>Email or Phone</b> <span class="text-danger">*</span></label>
             <input
                type="text"
                name="account"
                placeholder="user@gmail.com or 0987223123"
                id="account"
                required />
          </div>
          <button class="cta-btn" type="submit">Login</button>
        </x-form>
    </div>
@endsection
