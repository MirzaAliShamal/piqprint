@extends('layouts.app')

@section('content')
    <header>
        <div class="header justify-content-center">
            <div class="header-middle text-center">
                <h3 class="header-logo"><span class="text-red">PiQ</span>print</h3>
            </div>
        </div>
    </header>
    <div class="content">
        <div class="content-heading text-center">
            <h3 class="h3-42-bold">Upload your Photos</h3>
            <p class="bt1-24-medium">Upload your photos for expert <br> editing and flawless prints!</p>
        </div>
        <div class="upload-wrapper">
            <label for="photos" class="upload-photos">
                <img src="{{ asset('images/img-upload.png') }}" width="100px" alt="">
                <button type="button" class="btn bg-red text-white bt5-16-medium">Upload photos</button>
                <input type="file" id="photos" multiple style="display: none;">
            </label>
        </div>
    </div>
@endsection
@section('js')
    <script>
        const uniqueId = "{{ $uniqueId }}";
    </script>
    <script src="{{ asset('js/app/uploader.js?v='.rand()) }}"></script>
@endsection
