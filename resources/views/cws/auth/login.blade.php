@extends('cws.auth.auth')

@section('content')
    <div class="panel m-6 w-full max-w-lg sm:w-[480px]">
        <h2 class="mb-3 text-2xl font-bold">Sign In</h2>
        @include('layouts.flash')
        <x-form::open action="{{ route('cws.login') }}" class="space-y-5">
            <div>
                <label for="email">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{old('email') ?? null}}"
                    class="form-input"
                    placeholder="example@gmail.com"
                    required />
            </div>
            <div>
                <label for="password">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="form-input"
                    placeholder="********"
                    required />
            </div>
            <div>
                <label class="cursor-pointer">
                    <input type="checkbox" name="remember" class="form-checkbox" />
                    <span class="text-white-dark">Remember me</span>
                </label>
            </div>
            <button type="submit" class="btn btn-primary w-full">Sign in</button>
        </x-form>
        <div class="relative my-7 h-5 text-center before:absolute before:inset-0 before:m-auto before:h-[1px] before:w-full before:bg-[#ebedf2] dark:before:bg-[#253b5c]">
        </div>
        <p class="text-center">
            Dont't have an account? <a href="{{route('cws.fromSignUp')}}" class="font-bold text-primary hover:underline">Sign Up</a>
        </p>
    </div>
@endsection
