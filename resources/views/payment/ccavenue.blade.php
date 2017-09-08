<html>
<head>
<script>
function load()
{
document.ccavenue_payment_form.submit();
}
</script>
</head>

<body onload="load()">
<form method="post" id="ccavenue_payment_form" action="https://secure.ccavenue.ae/transaction/initTrans" name="ccavenue_payment_form">
    <input type="hidden" name="access_code" value="{{isset($data['accessCode']) ?$data['accessCode'] :0 }}" >
    <input type="hidden" name="merchant_id" value="{{isset($data['merchantId']) ?$data['merchantId'] :0 }}" >
    <input type="hidden" name="order_id" value="{{isset($data['orderId']) ?$data['orderId'] :0 }}" >
    <input type="hidden" name="enc_val" value="{{isset($data['encVal']) ?$data['encVal'] :0 }}" >
    <input type="hidden" name="redirect_url" value="{{isset($data['redirectUrl']) ?$data['redirectUrl'] :0 }}" >
    <input type="hidden" name="cancel_url" value="{{isset($data['cancelUrl']) ?$data['cancelUrl'] :0 }}" >
    <!--<input type="hidden" name="amount" value="{{isset($data['amount']) ?$data['amount'] :0 }}" >
    <input type="hidden" name="currency" value="{{isset($data['currency']) ?$data['currency'] :0 }}" >-->
    <input type="hidden" name="rsa_key_url" value="{{isset($data['rsaKeyUrl']) ?$data['rsaKeyUrl'] :0 }}" >
</form>

</body>
</html>     