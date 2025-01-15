@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Upload Image</h2>

        @if (session('success'))
            <div class="messages">
                <p class="success">{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="messages">
                <p class="error">{{ session('error') }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="messages">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="error">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('image.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="image">Choose JPEG Image:</label>
            <input type="file" name="image" id="image" accept="image/jpeg, image/jpg" required>
            <button type="submit">Upload</button>
        </form>

        <div class="back-link">
            <a href="{{ route('gallery.index') }}">← Back to Gallery</a>
        </div>
    </div>
@endsection
