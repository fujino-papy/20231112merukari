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
                    <form id="purchaseForm" action="{{ route('items.purchase', ['item' => $item->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="paymentIntentId" value="{{ $paymentIntentId }}">
                    <!-- 他のフォーム要素など -->
                    <button type="submit" class="buy-button" onclick="initiatePurchase()">購入する</button>
</form>
                </div>
            </div>
        </div>
    </div>
</div>

        <div class="selectPaymentMethod" style="display: none;">
            <label>
                <input type="radio" name="paymentMethod" value="konbini" checked onclick="hideCardDetails()">
                コンビニ払い
            </label>
            <label>
                <input type="radio" name="paymentMethod" value="card" onclick="showPaymentOptions()">
                クレジットカード払い
            </label>
            <button onclick="selectPaymentMethod()">選択する</button>
        </div>


        <div class="cardDetails" id="cardDetails" style="display: none;">
            <label for="cardNumber">カード番号 有効期限 セキュリティコード</label>
            <div class="cardNumberElement" id="cardNumberElement"></div>
        </div>

<script>
    const stripe = Stripe('pk_test_51ODq37H8tlSpwIEwscawyzv0ZjECOiHqmljeLWjarGb1JU8hqplWJrC0rWHSrrtQftlEXSB8vl6lwxN6R5a1cQmN00VLRoOcn5');
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#cardNumberElement');
    card.mount('#expiryDateElement');
    card.mount('#cvvElement');

    document.getElementById('purchaseForm').addEventListener('submit', async function (event) {
    event.preventDefault();
    selectPaymentMethod();

    const { token, error } = await stripe.createToken(card);

    if (error) {
        // エラー処理
        console.error(error);
    } else {
        // 生成されたトークンをフォームに追加
        const form = document.getElementById('purchaseForm');
        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = 'stripeToken';
        tokenInput.value = token.id;
        form.appendChild(tokenInput);

        // フォームをサーバーサイドに送信
        form.submit();
    }
});

    function showPaymentOptions() {
        var paymentMethodSection = document.querySelector('.selectPaymentMethod');
        var cardDetails = document.getElementById('cardDetails');

        paymentMethodSection.style.display = 'block';

        // ラジオボタンがクレジットカード払いの場合、クレジットカード情報入力フォームを表示
        if (document.querySelector('input[name="paymentMethod"][value="card"]').checked) {
            cardDetails.style.display = 'block';
        } else {
            cardDetails.style.display = 'none';
        }
    }

    function hideCardDetails() {
        var cardDetails = document.getElementById('cardDetails');
        cardDetails.style.display = 'none';
    }

    function togglePaymentSection() {
        var paymentMethodSection = document.querySelector('.selectPaymentMethod');
        var selectedPaymentMethod = document.getElementById('selectedPaymentMethod');

        // ラジオボタンがクレジットカード払いの場合、クレジットカード情報入力フォームを表示
        if (document.querySelector('input[name="paymentMethod"][value="card"]').checked) {
            paymentMethodSection.style.display = 'block';
            selectedPaymentMethod.innerText = '支払方法　クレジットカード払い';
        } else {
            paymentMethodSection.style.display = 'block';
            selectedPaymentMethod.innerText = '支払方法　コンビニ払い';
        }
    }

    function selectPaymentMethod() {
        var selectedPaymentMethod = document.getElementById('selectedPaymentMethod');
        var paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;

        if (paymentMethod === 'konbini') {
            selectedPaymentMethod.innerText = '支払方法　コンビニ払い';
        } else if (paymentMethod === 'card') {
            selectedPaymentMethod.innerText = '支払方法　クレジットカード払い';
        }
    }

    function initiatePurchase() {
        stripe.confirmCardPayment(
            "{{ $clientSecret }}",
            {
                payment_method: {
                    card: card,
                }
            }
        ).then(function(result) {
            if (result.error) {
                console.error(result.error);
            } else {
                // ここでフォームをサーバーサイドに送信
                const form = document.getElementById('purchaseForm');
                form.submit();
            }
        });
    }

</script>

@endsection