@extends('layouts.app')

@section('content')
    <section class="checkout">
        <div class="container">
            <div class="row text-center pb-70">
                <div class="col-lg-12 col-12 header-wrap">
                    <p class="story">
                        YOUR FUTURE CAREER
                    </p>
                    <h2 class="primary-header">
                        Start Invest Today
                    </h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-9 col-12">
                    <div class="row">
                        <div class="col-lg-5 col-12">
                            <div class="item-bootcamp">
                                <img src="{{ asset('images/item_bootcamp.png') }}" alt="" class="cover">
                                <h1 class="package text-uppercase">
                                    {{ $camp->title }}
                                </h1>
                                <p class="description">
                                    Bootcamp ini akan mengajak Anda untuk belajar penuh mulai dari pengenalan dasar sampai
                                    membangun sebuah projek asli
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-1 col-12"></div>
                        <div class="col-lg-6 col-12">
                            <form action="{{ route('checkout.store', $camp->id) }}" class="basic-form" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input name="name" type="text" class="form-control" id="name"
                                        aria-describedby="emailHelp" value="{{ Auth::user()->name }}" required>
                                    @if ($errors->has('name'))
                                        <div class="text-danger mt-2">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>
                                <div class="mb-4">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input name="email" type="email" class="form-control" id="email"
                                        aria-describedby="emailHelp" value="{{ Auth::user()->email }}" required>
                                    @if ($errors->has('email'))
                                        <div class="text-danger mt-2">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>
                                <div class="mb-4">
                                    <label for="occupation" class="form-label">Occupation</label>
                                    <input name="occupation" type="text" class="form-control" id="occupation"
                                        aria-describedby="occupationHelp" value="{{ old('occupation') ?: Auth::user()->occupation }}" required>
                                    @if ($errors->has('occupation'))
                                        <div class="text-danger mt-2">{{ $errors->first('occupation') }}</div>
                                    @endif
                                </div>
                                <div class="mb-4">
                                    <label for="cardNumber" class="form-label">Card Number</label>
                                    <input name="card_number" type="text" class="form-control" id="cardNumber"
                                        aria-describedby="cardNumberHelp" value="{{ old('card_number') ?: Auth::user()->card_number }}" required>
                                    @if ($errors->has('card_number'))
                                        <div class="text-danger mt-2">{{ $errors->first('card_number') }}</div>
                                    @endif
                                </div>
                                <div class="mb-5">
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <label for="expirationDate" class="form-label">Expiration Date (YYYY-MM)</label>
                                            <input name="expired" type="text" class="form-control" id="expirationDate"
                                                placeholder="YYYY-MM" pattern="\d{4}-(0?[1-9]|1[0-2])" required value="{{ old('expired') ?: Auth::user()->expired }}">
                                            @if ($errors->has('expired'))
                                                <div class="text-danger mt-2">{{ $errors->first('expired') }}</div>
                                            @endif
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <label for="cvc" class="form-label">CVC</label>
                                            <input name="cvc" type="number" class="form-control" id="cvc"
                                                maxlength="3"
                                                oninput="if(this.value.length > 3) this.value = this.value.slice(0, 3);" value="{{ old('cvc') ?: Auth::user()->cvc }}" required>
                                            @if ($errors->has('cvc'))
                                                <div class="text-danger mt-2">{{ $errors->first('cvc') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="w-100 btn btn-primary">Pay Now</button>
                                <p class="text-center subheader mt-4">
                                    <img src="{{ asset('images/ic_secure.svg') }}" alt=""> Your payment is secure
                                    and
                                    encrypted.
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
