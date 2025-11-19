@extends('layouts.app')

@section('title', 'Login - Campus Helpdesk')

@section('content')
    <div class="min-h-[80vh] flex items-center justify-center px-4">
        <div class="w-full max-w-md bg-white border border-slate-200 rounded-2xl shadow-sm p-8">
            <div class="mb-6 text-center">
                <h1 class="text-2xl font-bold text-slate-900">Login</h1>
                <p class="text-slate-600 mt-2">Gunakan akun kampus (.pens.ac.id) untuk melanjutkan</p>
            </div>

            <form action="{{ route('login.perform') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-slate-900 mb-2">Email Kampus</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        placeholder="nama@student.pens.ac.id"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    />
                    @error('email')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-900 mb-2">Password</label>
                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    />
                    @error('password')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        Remember me
                    </label>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Lupa password?</a>
                </div>

                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition shadow-md hover:shadow-lg"
                >
                    Login
                </button>
            </form>
        </div>
    </div>
@endsection
