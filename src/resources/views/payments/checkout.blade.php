@extends('layouts.logined')

@section('content')
<div class="container">
    <!-- 商品情報の表示 -->

    <div class="payment-options">
        <label>
            <input type="radio" name="paymentMethod" value="card" checked>
            クレジットカード
        </label>
        <label>
            <input type="radio" name="paymentMethod" value="konbini">
            コンビニ払い
        </label>
    </div>

    <button id="pay-button">支払う</button>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        // Stripe.jsの初期化
        var stripe = Stripe('{{ config("services.stripe.key") }}');

        // 支払いボタンのクリックイベント
        document.getElementById('pay-button').addEventListener('click', function () {
            var selectedPaymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;

            // Stripe.jsを使用して支払いフローを実装
            stripe.confirmCardPayment("{{ $intent->client_secret }}", {
                payment_method: selectedPaymentMethod === 'card' ? 'card' : {
                    type: 'konbini',
                },
            }).then(function (result) {
                if (result.error) {
                    // エラー時の処理
                    console.error(result.error.message);
                } else {
                    // 支払いが成功した場合の処理
                    window.location.href = '/purchase/complete';
                }
            });
        });
    </script>
</div>
@endsection