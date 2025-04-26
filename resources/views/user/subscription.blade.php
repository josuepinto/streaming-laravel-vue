@extends('layouts.disenyo')
@section('content')

<div class="row justify-content-center mt-5">
  @if(session('message'))
    <div class="alert alert-success">
        🎉 <strong>{{ session('message') }}</strong>
    </div>
  @endif
  
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif

  <div class="col-md-6">
    <div class="card shadow p-4">
        <h4 class="mb-4 text-center">Choose Your Plan and Embark on Your Streaming Adventure</h4>
        <form action="{{ route('select.plan') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="plan" class="form-label">Select Plan</label>
                <select class="form-select" id="plan" name="plan">
                    <option value="">-- Choose Plan --</option>
                    <option value="standard_with_ads">Standard with ads: 5.49€</option>
                    <option value="standard">Standard: 12.99€</option>
                    <option value="Premium">Premium: 17.99€</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="cn" class="form-label">Card Number</label>
                <input type="text" class="form-control" id="cn" name="cn" placeholder="Enter your bank card number">
            </div>
            <div class="mb-3">
                <label for="ed" class="form-label">Expiry Date</label>
                <input type="text" class="form-control" id="ed" name="ed" placeholder="MM/YY">
            </div>
            <div class="mb-3">
                <label for="cvv" class="form-label">CVV</label>
                <input type="text" class="form-control" id="cvv" name="cvv" placeholder="Card CVV">
            </div>
            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary">Confirm Payment</button>
            </div>
            <div class="d-flex justify-content-center align-items-center gap-3 mt-3">
                <img src="/image/master.png" alt="MasterCard" height="40">
                <img src="/image/visa.png" alt="Visa" height="40">
                <img src="/image/paypal.png" alt="Paypal" height="40">
            </div>
        </form>
    </div>
  </div>
</div>

@endsection
