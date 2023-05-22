@extends('cws.auth.auth')

@section('content')
    <div class="panel m-6 w-full max-w-lg sm:w-[480px]">
        <h2 class="mb-3 text-2xl font-bold">Sign Up</h2>
        @include('layouts.flash')

        <x-form::open action="{{ route('cws.register') }}" class="space-y-5">
            <div>
                <label for="name">Name</label>
                <input
                    id="name"
                    name="name"
                    value="{{old('name') ?? null}}"
                    type="text"
                    class="form-input"
                    placeholder="Nguyen Van A"
                    required />
            </div>
            <div>
                <label for="email">Email</label>
                <input
                    id="email"
                    name="email"
                    value="{{old('email') ?? null}}"
                    type="email"
                    class="form-input"
                    placeholder="info@plats.network"
                    required />
            </div>
            <div>
                <label for="password">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    placeholder="********"
                    class="form-input w-3/5"
                    required />
                <span class="text-xs text-white-dark ltr:pl-2 rtl:pr-2">Min 8-20 char</span>
            </div>
            <div>
                <label for="password_confirmation">Password confirmation</label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    placeholder="********"
                    class="form-input w-3/5"
                    required />
                <span class="text-xs text-white-dark ltr:pl-2 rtl:pr-2">Min 8-20 char</span>
            </div>
            <div>
                <label class="cursor-pointer">
                    <input type="checkbox" name="term" class="form-checkbox" />
                    <span for="custom_checkbox" class="text-white-dark">I agree the
                        <a href="javascript:;" class="text-primary hover:underline">Terms and Conditions</a>
                    </span>
                </label>
            </div>
            <button type="submit" class="btn btn-primary w-full">SIGN UP</button>
        </x-form>
        <div
            class="relative my-7 h-5 text-center before:absolute before:inset-0 before:m-auto before:h-[1px] before:w-full before:bg-[#ebedf2] dark:before:bg-[#253b5c]">
        </div>
        <p class="text-center">
            Already have an account? <a href="{{route('cws.formLogin')}}" class="font-bold text-primary hover:underline">Sign In</a>
        </p>
    </div>
@endsection
