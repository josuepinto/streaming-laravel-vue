@extends('layouts.disenyo')
@section('content')

<div class="row justify-content-center mt-5">
  <div class="col-md-6">
    <div class="card shadow p-4">
        <h4 class="mb-4 text-center">Choose Your Plan and Embark on Your Streaming Adventure</h4>
        <form>
            <div class="mb-3">
                <label for="plan" class="form-label">Select Plan</label>
                <select class="form-select" id="plan" required>
                    <option value="">-- Choose Plan --</option>
                    <option value="standard_with_ads">Standard with ads: 5.49€</option>
                    <option value="standard">Standard: 12.99€</option>
                    <option value="Premium">Premium: 17.99€</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="cn" class="form-label">Card Number</label>
                <input type="text" class="form-control" id="cn" placeholder="Enter your bank card number" required>
            </div>
            <div class="mb-3">
                <label for="ed" class="form-label">Expiry Date</label>
                <input type="text" class="form-control" id="ed" placeholder="MM/YY" required>
            </div>
            <div class="mb-3">
                <label for="cvv" class="form-label">CVV</label>
                <input type="text" class="form-control" id="cvv" placeholder="Card CVV" required>
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
