@extends('layouts.app')

@section('content')
    <section class="container mx-auto my-12">
        <div class="max-w-lg mx-auto rounded overflow-hidden shadow-lg px-4 py-4 bg-white">
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2 text-center">All Cities</div>
                </div>
                <div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('cities.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="sr-only">Name</label>
                            <input type="text" name="name" id="name" placeholder="City name" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('name') border-red-500 @enderror" value="{{ old('name') }}">
                            @error('name')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">Create</button>
                        </div>
                    </form>
                </div>
        </div>
    </section>
@endsection
