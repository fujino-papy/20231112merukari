@extends('layouts.logined')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

<form action="{{ asset('pay') }}" method="POST">
    {{ csrf_field() }}
<script
    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key="{{ env('STRIPE_KEY') }}"
    data-amount="100"
    data-name="Stripe決済デモ"
    data-label="決済をする"
    data-description="これはデモ決済です"
    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
    data-locale="auto"
    data-currency="JPY">
</script>
</form>
@endsection