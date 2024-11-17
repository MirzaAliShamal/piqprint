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
            <h3 class="h3-42-bold">Welcome</h3>
            <p class="bt1-24-medium">Scan the QR Code to effortlessely upload your photos</p>
        </div>
        <div class="qr-wrapper">
            <div class="qr-container text-center"></div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('js/app/index.js?v='.rand()) }}"></script>
@endsection
