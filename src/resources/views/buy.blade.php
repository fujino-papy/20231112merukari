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
                    <button onclick="showPaymentOptions()" class="Payment-Method_change">変更する</button>
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
                        <li class="way" id="selectedPaymentMethod">支払方法　コンビニ払い</li>
                    </ul>
                </div>
            </div>
                            <div class="button">
                    <button class="buy-button" >購入する</button>
                </div>
        </div>
    </div>
</div>

<div id="paymentOptionsPopup" class="popup" style="display: none;">
    <div class="popup-content">
        <span class="close" onclick="closePaymentOptionsPopup()">&times;</span>
        <label>
            <input type="radio" name="paymentMethod" value="konbini" onclick="hideCardDetails()" checked>
            コンビニ払い
        </label>
        <label>
            <input type="radio" name="paymentMethod" value="card" onclick="showCardDetails()">
            クレジットカード払い
        </label>
        <div id="cardDetails" style="display: none;">
            <!-- クレジットカード入力フォーム -->
            <label for="cardNumber">カード番号</label>
            <input type="text" id="cardNumber" placeholder="**** **** **** ****">
            
            <label for="expiryDate">有効期限</label>
            <input type="text" id="expiryDate" placeholder="MM/YY">
            
            <label for="cvv">セキュリティコード</label>
            <input type="text" id="cvv" placeholder="CVV">
            <!-- 他のクレジットカード情報の入力フォームを追加 -->
        </div>
        <button onclick="selectPaymentMethod()">選択する</button>
    </div>
</div>

<script>
    function showPaymentOptions() {
        document.getElementById('paymentOptionsPopup').style.display = 'block';
    }

    function closePaymentOptionsPopup() {
        document.getElementById('paymentOptionsPopup').style.display = 'none';
    }

    function selectPaymentMethod() {
        var selectedMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
        document.getElementById('selectedPaymentMethod').innerText = '支払方法　' + (selectedMethod === 'konbini' ? 'コンビニ払い' : 'クレジットカード払い');
        closePaymentOptionsPopup();
    }

    function showCardDetails() {
        var cardDetails = document.getElementById('cardDetails');
        cardDetails.style.display = 'block';
    }

    function hideCardDetails() {
        var cardDetails = document.getElementById('cardDetails');
        cardDetails.style.display = 'none';
    }
    
    function selectPaymentMethod() {
        var selectedMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
        document.getElementById('selectedPaymentMethod').innerText = '支払方法　' + (selectedMethod === 'konbini' ? 'コンビニ払い' : 'クレジットカード払い');
        closePaymentOptionsPopup();
    }
</script>

@endsection