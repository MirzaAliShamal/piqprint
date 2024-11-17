@extends('layouts.app')

@section('content')
    <header>
        <div class="header">
            <div class="header-navigator">
                <a href="{{ route('photos', $uniqueId) }}" class="header-back">
                    <i class="fa-solid fa-arrow-left-long"></i>
                </a>
            </div>
            <div class="header-action text-end">
                <a href="{{ route('checkout', $uniqueId) }}" class="btn bg-red text-white bt5-16-medium">Next</a>
                <a href="{{ route('end', $uniqueId) }}" class="btn bg-red text-white bt5-16-medium">End Session</a>
            </div>
        </div>
    </header>

    <div class="content content-with-footer">
        <div class="photo-wrapper">
            <img id="img" data-path="{{ $photo->path }}" src="{{ $photo->url }}" alt="">
        </div>
    </div>

    <footer>
        <div class="editor-bar">
            <div class="editor-action crop-photo">
                <svg viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13.6125 26.125H26.125V13.6125C26.125 8.25 24.75 6.875 19.3875 6.875H6.875V19.3875C6.875 24.75 8.25 26.125 13.6125 26.125Z" stroke="white" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6.875 6.875V2.75" stroke="white" stroke-width="2.25" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6.875 6.875H2.75" stroke="white" stroke-width="2.25" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M26.125 26.125V30.25" stroke="white" stroke-width="2.25" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M26.125 26.125H30.25" stroke="white" stroke-width="2.25" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="editor-action filter-photo">
                <svg viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.25 22C19.25 24.4338 18.1913 26.6338 16.5 28.1325C15.0425 29.4525 13.1175 30.25 11 30.25C6.44875 30.25 2.75 26.5513 2.75 22C2.75 18.205 5.335 14.9875 8.8275 14.0388C9.77625 16.4313 11.8113 18.2738 14.3275 18.9613C15.015 19.1538 15.7437 19.25 16.5 19.25C17.2563 19.25 17.985 19.1538 18.6725 18.9613C19.0437 19.8963 19.25 20.9275 19.25 22Z" stroke="white" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M24.75 11C24.75 12.0725 24.5437 13.1038 24.1725 14.0388C23.2237 16.4313 21.1887 18.2737 18.6725 18.9612C17.985 19.1537 17.2563 19.25 16.5 19.25C15.7437 19.25 15.015 19.1537 14.3275 18.9612C11.8113 18.2737 9.77625 16.4313 8.8275 14.0388C8.45625 13.1038 8.25 12.0725 8.25 11C8.25 6.44875 11.9488 2.75 16.5 2.75C21.0512 2.75 24.75 6.44875 24.75 11Z" stroke="white" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M30.25 22C30.25 26.5513 26.5512 30.25 22 30.25C19.8825 30.25 17.9575 29.4525 16.5 28.1325C18.1912 26.6338 19.25 24.4338 19.25 22C19.25 20.9275 19.0437 19.8963 18.6725 18.9613C21.1887 18.2738 23.2237 16.4313 24.1725 14.0388C27.665 14.9875 30.25 18.205 30.25 22Z" stroke="white" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="editor-action rorate-photo">
                <svg viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.96875 30.25H16.1562C21.3125 30.25 23.375 28.1875 23.375 23.0312V16.8438C23.375 11.6875 21.3125 9.625 16.1562 9.625H9.96875C4.8125 9.625 2.75 11.6875 2.75 16.8438V23.0312C2.75 28.1875 4.8125 30.25 9.96875 30.25Z" stroke="white" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M30.25 12.375C30.25 7.05375 25.9462 2.75 20.625 2.75L22.0687 5.15625" stroke="white" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>
    </footer>
@endsection
@section('js')
    <script>
        const uniqueId = "{{ $uniqueId }}";
        const photoId = "{{ $photoId }}";
    </script>
    <script src="{{ asset('js/app/photo.js?v='.rand()) }}"></script>
@endsection
