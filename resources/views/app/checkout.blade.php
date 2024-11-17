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
                <a href="{{ route('end', $uniqueId) }}" class="btn bg-red text-white bt5-16-medium">End Session</a>
            </div>
        </div>
    </header>

    <div class="content">
        <div class="checkout-wrapper">
            <div class="products-wrapper">
                <h4 class="bt2-22-semibold text-center mb-4">Selected photos to print</h4>
                <table>
                    <thead>
                        <tr>
                            <th class="bt4-18-semibold text-green">Images</th>
                            <th class="bt4-18-semibold text-green">Size</th>
                            <th class="bt4-18-semibold text-green">Qty</th>
                            <th class="bt4-18-semibold text-green"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($photos as $photo)
                            <tr>
                                <td>
                                    <div class="photo-thumbnail">
                                        <img data-path="{{ $photo->path }}" src="{{ $photo->url }}" alt="">
                                    </div>
                                </td>
                                <td class="bt3-20-bold">4x6</td>
                                <td class="bt3-20-bold">1</td>
                                <td>
                                    <div class="delete-photo">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="payment-wrapper">
                <h4 class="bt2-22-semibold text-center mb-4">Payment</h4>
                <table>
                    <tbody>
                        <tr>
                            <td class="h7-26-regular">{{ count($photos) }}x $1.50</td>
                            <td class="h7-26-bold text-end">${{ number_format(count($photos)*1.50, 2) }}</td>
                        </tr>
                        <tr><td></td><td></td></tr>
                        <tr><td></td><td></td></tr>
                        <tr>
                            <td class="h7-26-regular">Subtotal</td>
                            <td class="h7-26-bold text-end">$6.00</td>
                        </tr>
                        <tr>
                            <td class="h7-26-regular">Tax</td>
                            <td class="h7-26-bold text-end">$0.36</td>
                        </tr>
                        <tr><td></td><td></td></tr>
                        <tr><td></td><td></td></tr>
                        <tr>
                            <td class="h7-26-regular text-red">Total</td>
                            <td class="h7-26-bold text-end text-red">$6.36</td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn bg-red text-white bt5-16-medium mt-3 w-100">Confirm & Pay</button>
            </div>
        </div>
    </div>
@endsection
@section('js')

@endsection
