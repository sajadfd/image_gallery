@extends('layouts.app')

@section('content')
    <h1 style="text-align:center;">Image Gallery</h1>

    <div style="text-align: center; margin: 20px;">
        <a href="{{ route('image.upload.form') }}" class="btn-upload">
            Upload New Image
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('info'))
        <div class="alert alert-info">
            {{ session('info') }}
        </div>
    @endif

    <div class="gallery">
        @foreach ($images as $hash)
            <img src="{{ route('image.generator', ['name' => $hash, 'size' => $isMobile ? 'mic' : 'min']) }}" alt="Image"
                data-name="{{ $hash }}" class="thumbnail">
        @endforeach
    </div>

    <!-- Modal -->
    <div id="imageModal" class="modal">
        <span class="close">&times;</span>
        <div class="modal-content-container">
            <img class="modal-content" id="modalImage">
            <div id="sizeOptions" class="size-options"></div>
        </div>
    </div>
@endsection
<script>
    const isMobile = @json($isMobile);

    const imageGeneratorUrl = @json(route('image.generator'));
</script>
