@extends('layouts.disenyo')

@section('content')
<div class="stream-subscription-page">
    <div class="container-fluid stream-page-wrap">
        @if(session('message'))
            <div class="alert alert-success stream-alert">
                {{ session('message') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger stream-alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="subscription-hero">
            <div class="subscription-copy">
                <span class="catalog-kicker">Subscription</span>
                <h1>Choose the plan that fits your streaming rhythm</h1>
                <p>
                    Upgrade your PiFlix experience with a cleaner, portfolio-ready subscription flow
                    inspired by modern streaming platforms.
                </p>

                <div class="subscription-benefits">
                    <span>Unlimited catalogue access</span>
                    <span>Personal favourites</span>
                    <span>Premium dark experience</span>
                </div>
            </div>

            <div class="subscription-panel">
                <h2>Complete your plan</h2>
                <p>Select a plan and confirm your payment details.</p>

                <form action="{{ route('select.plan') }}" method="POST" class="subscription-form">
                    @csrf

                    <div class="subscription-form-group">
                        <label for="plan">Select plan</label>
                        <select class="form-select subscription-input" id="plan" name="plan">
                            <option value="">-- Choose Plan --</option>
                            <option value="standard_with_ads">Standard with ads · 5.49€</option>
                            <option value="standard">Standard · 12.99€</option>
                            <option value="Premium">Premium · 17.99€</option>
                        </select>
                    </div>

                    <div class="subscription-form-group">
                        <label for="cn">Card number</label>
                        <input type="text" class="form-control subscription-input" id="cn" name="cn" placeholder="Enter your bank card number">
                    </div>

                    <div class="subscription-form-row">
                        <div class="subscription-form-group">
                            <label for="ed">Expiry date</label>
                            <input type="text" class="form-control subscription-input" id="ed" name="ed" placeholder="MM/YY">
                        </div>

                        <div class="subscription-form-group">
                            <label for="cvv">CVV</label>
                            <input type="text" class="form-control subscription-input" id="cvv" name="cvv" placeholder="Card CVV">
                        </div>
                    </div>

                    <button type="submit" class="btn hero-btn hero-btn-primary subscription-submit">
                        Confirm payment
                    </button>

                    <div class="subscription-methods">
                        <img src="{{ asset('image/master.png') }}" alt="MasterCard">
                        <img src="{{ asset('image/visa.png') }}" alt="Visa">
                        <img src="{{ asset('image/paypal.png') }}" alt="Paypal">
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
@endsection
