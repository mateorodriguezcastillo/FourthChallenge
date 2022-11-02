@extends('layouts.app')

@section('content')
    <section class="container mx-auto my-12">
        <div class="max-w-lg mx-auto rounded overflow-hidden shadow-lg px-4 py-4 bg-white">
            <div class="px-6 py-4">
                <div class="font-bold text-xl mb-2 text-center">Update Post</div>
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
                <form action="{{ route('cities.update', $city) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="name" class="sr-only">Name</label>
                        <input type="text" name="name" id="name" placeholder="City name" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('name') border-red-500 @enderror" value="{{ $city->name }}">
                        @error('name')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">Update</button>
                    </div>
            </div>
        </div>

    </section>
@endsection
