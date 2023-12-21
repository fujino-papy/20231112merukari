<script src="https://js.stripe.com/v3/"></script>

@extends('layouts.logined')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/buy.css') }}">
@endsection

@section('content')

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="alert alert-danger">
        {{ session('success') }}
    </div>
@endif
<div class="container">
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
                        @if ($item->price >= 300000)
                            <p style="color: red;">￥300,000以上のお支払いはコンビニ払いを選択できません</p>
                        @endif
                    <button type="button" onclick="togglePaymentSection()" class="Payment-Method_change">変更する</button>
                </div>
                <div class="selectPaymentMethod" style="display: none;">
                    <label>
                        <input type="radio" name="paymentMethod" value="konbini" {{ $item->price >= 300000 ? 'disabled' : '' }}>
                        コンビニ払い
                    </label>
                    <label>
                        <input type="radio" name="paymentMethod" value="card" checked>
                        クレジットカード払い
                    </label>
                        <button onclick="selectPaymentMethod()">選択する</button>
                </div>
                <div class="address">
                    <p class="delivery_address">配送先</p>
                    <form class="address_form" action="{{ route('address')}}" method="get">
                        @csrf
                        <button  type="submit" class="address_change">変更する</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="item_container">
            <div class="price-info-container">
                <div class="price-info-box">
                    <div class="price-info">
                        <ul class="Payment_Information">
                            <li class="item_price">商品代金　￥{{ $item->price }}</li>
                            <li class="total_price">支払金額￥{{ $item->price }}</li>
                            <div class="way" id="selectedPaymentMethod">支払方法　カード払い</div>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="buy_button">
                    <!-- コンビニ払いのボタン -->
                    <form action="{{ route('konbiniPay') }}" method="POST" id="konbiniForm" style="display: none;">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <input type="hidden" name="item_price" value="{{ $item->price }}">
                        <button class="konbini_button" type="submit">コンビニ払いで購入</button>
                    </form>

                    <!-- カード払いのボタン -->
                    <form class="button_container" id="cardForm" action="{{ asset('cardPay') }}" method="POST" >
                        {{ csrf_field() }}
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <input type="hidden" name="item_price" value="{{ $item->price }}">
                        <button class="card_button" type="submit" id="customStripeButton">カードで購入</button>
                        <script src="https://checkout.stripe.com/checkout.js"></script>
                        <script>
                            var handler = StripeCheckout.configure({
                                key: "{{ env('STRIPE_KEY') }}",
                                image: "https://stripe.com/img/documentation/checkout/marketplace.png",
                                locale: "auto",
                                currency: "JPY",
                                allowRememberMe: false,
                                token: function (token) {
                                    // ここでトークンを取得した後の処理を行います。
                                    // 例えば、フォームをサブミットするなど。

                                    // 以下は例として、トークンをフォームに追加し、フォームをサブミットするコードです。
                                    var form = document.getElementById('cardForm');
                                    var hiddenInput = document.createElement('input');
                                    hiddenInput.setAttribute('type', 'hidden');
                                    hiddenInput.setAttribute('name', 'stripeToken');
                                    hiddenInput.setAttribute('value', token.id);
                                    form.appendChild(hiddenInput);

                                    // フォームをサブミット
                                    form.submit();
                                }
                            });

                            document.getElementById('customStripeButton').addEventListener('click', function (e) {
                                // Stripe Checkoutを開く処理
                                handler.open({
                                    name: "Stripe決済デモ",
                                    description: "これはデモ決済です",
                                    amount: {{ $item->price }},
                                });
                                e.preventDefault();
                            });

                            // Close Checkout on page navigation
                            window.addEventListener('popstate', function () {
                                handler.close();
                            });
                        </script>
                    </form>
                </div>
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