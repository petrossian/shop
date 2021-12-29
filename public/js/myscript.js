
document.getElementById('default_data').addEventListener('click', () => {
    document.getElementsByClassName('card_name')[0].value = "Card Name";
    document.getElementsByClassName('card_number')[0].value = '4242424242424242';
    document.getElementsByClassName('card_cvc')[0].value = '123';
    document.getElementsByClassName('card_expiry_month')[0].value = '12';
    document.getElementsByClassName('card_expiry_year')[0].value = 2055;
});