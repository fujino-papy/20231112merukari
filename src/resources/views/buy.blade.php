<script src="https://js.stripe.com/v3/"></script>

@extends('layouts.logined')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/buy.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="item-container">
        <div class="item">
            <div class="item-content">
                <div class="item_img">
                    <img class="img" src="{{ asset($item->image_url) }}" alt="{{ $item->name }}">
                </div>
                <div class="item-info">
                    <h2 class="item-name">{{ $item->name }}</h2>
                    <p class="price">￥{{ $item->price }}</p>
                </div>
            </div>
            <div class="change">
                <div class="pay">
                    <p class="pay_Method">支払方法</p>
                    <button type="button" onclick="togglePaymentSection()" class="Payment-Method_change">変更する</button>
                </div>
                <div class="selectPaymentMethod" style="display: none;">
                    <label>
                        <input type="radio" name="paymentMethod" value="konbini" checked>
                        コンビニ払い
                    </label>
                    <label>
                        <input type="radio" name="paymentMethod" value="card">
                        クレジットカード払い
                    </label>
                        <button onclick="selectPaymentMethod()">選択する</button>
                </div>
                <div class="address">
                    <p class="delivery_address">配送先</p>
                    <a href="" class="address_change">変更する</a>
                </div>
            </div>
        </div>

        <div class="price-info-container">
            <div class="price-info-box">
                <div class="price-info">
                    <ul class="Payment_Information">
                        <li class="item_price">商品代金　￥{{ $item->price }}</li>
                        <li class="total_price">支払金額￥{{ $item->price }}</li>
                        <div class="way" id="selectedPaymentMethod">支払方法　コンビニ払い</div>
                    </ul>

                    <!-- コンビニ払いのボタン -->
                    <form action="{{ asset('pay') }}" method="POST" id="konbiniForm">
                        {{ csrf_field() }}
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <input type="hidden" name="item_price" value="{{ $item->price }}">
                        <button type="submit">コンビニ払いで購入</button>
                    </form>

                    <!-- カード払いのボタン -->
                    <form id="cardForm" style="display: none;" action="{{ asset('pay') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <input type="hidden" name="item_price" value="{{ $item->price }}">
                        <script
                            src="https://checkout.stripe.com/checkout.js"
                            class="stripe-button"
                            data-key="{{ env('STRIPE_KEY') }}"
                            data-amount="{{ $item->price }}"
                            data-name="Stripe決済デモ"
                            data-label="カードで購入"
                            data-description="これはデモ決済です"
                            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                            data-locale="auto"
                            data-currency="JPY">
                        </script>
                    </form>
                </div>
            </div>
        </div>

<div class="selectPaymentMethod" style="display: none;">
    <label>
        <input type="radio" name="paymentMethod" value="konbini" checked>
        コンビニ払い
    </label>
    <label>
        <input type="radio" name="paymentMethod" value="card">
        クレジットカード払い
    </label>
    <button onclick="selectPaymentMethod()">選択する</button>
</div>

<script>
    function togglePaymentSection() {
        var paymentMethodSection = document.querySelector('.selectPaymentMethod');
        if (document.querySelector('input[name="paymentMethod"][value="card"]').checked) {
            paymentMethodSection.style.display = 'block';
            document.getElementById('cardForm').style.display = 'inline-block';
            document.getElementById('konbiniForm').style.display = 'none';
            document.getElementById('selectedPaymentMethod').innerText = '支払方法　クレジットカード払い';
        } else {
            paymentMethodSection.style.display = 'block';
            document.getElementById('konbiniForm').style.display = 'inline-block';
            document.getElementById('cardForm').style.display = 'none';
            document.getElementById('selectedPaymentMethod').innerText = '支払方法　コンビニ払い';
        }
    }

    function selectPaymentMethod() {
        var paymentMethodSection = document.querySelector('.selectPaymentMethod');
        var paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;

        if (paymentMethod === 'konbini') {
            document.getElementById('selectedPaymentMethod').innerText = '支払方法　コンビニ払い';
            document.getElementById('konbiniForm').style.display = 'inline-block';
            document.getElementById('cardForm').style.display = 'none';
        } else if (paymentMethod === 'card') {
            document.getElementById('selectedPaymentMethod').innerText = '支払方法　クレジットカード払い';
            document.getElementById('cardForm').style.display = 'inline-block';
            document.getElementById('konbiniForm').style.display = 'none';
        }

        paymentMethodSection.style.display = 'none';
    }
</script>


@endsection