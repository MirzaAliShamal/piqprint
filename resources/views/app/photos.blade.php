@extends('layouts.app')

@section('content')
    <header>
        <div class="header">
            <div class="header-navigator" style="width: calc(100%/3);">
                <a class="header-back">
                    <i class="fa-solid fa-arrow-left-long"></i>
                </a>
            </div>
            <div class="header-middle text-center" style="width: calc(100%/3);">
                <h3 class="header-logo"><span class="text-red">PiQ</span>print</h3>
            </div>
            <div class="header-action text-end" style="width: calc(100%/3);">
                <a href="{{ route('checkout', $uniqueId) }}" class="btn bg-red text-white bt5-16-medium">Next</a>
                <a href="{{ route('end', $uniqueId) }}" class="btn bg-red text-white bt5-16-medium">End Session</a>
            </div>
        </div>
    </header>

    <div class="content">
        <div class="photos-wrapper">
            @foreach ($photos as $photo)
                <div class="photo">
                    <img src="{{ $photo->url }}" alt="">
                    <div class="photo-actions">
                        <div class="edit-photo" onclick="location.href='{{ route('photo', [$uniqueId, $photo->id]) }}'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </div>
                        <div class="delete-photo">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('js')
    <script>
        const uniqueId = "{{ $uniqueId }}";
    </script>
    <script src="{{ asset('js/app/photos.js?v='.rand()) }}"></script>
@endsection
