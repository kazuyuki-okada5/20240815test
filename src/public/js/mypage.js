document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded and parsed');
    
    var showSellingBtn = document.getElementById('show-selling');
    var showPurchasedBtn = document.getElementById('show-purchased');
    var sellingItems = document.getElementById('selling-items');
    var purchasedItems = document.getElementById('purchased-items');

    if (!showSellingBtn || !showPurchasedBtn || !sellingItems || !purchasedItems) {
        console.log('One or more elements not found');
        return;
    }

    showSellingBtn.addEventListener('click', function() {
        console.log('show-selling button clicked');
        showSellingBtn.classList.add('active');
        showPurchasedBtn.classList.remove('active');

        sellingItems.classList.remove('hidden');
        purchasedItems.classList.add('hidden');
    });

    showPurchasedBtn.addEventListener('click', function() {
        console.log('show-purchased button clicked');
        showSellingBtn.classList.remove('active');
        showPurchasedBtn.classList.add('active');

        sellingItems.classList.add('hidden');
        purchasedItems.classList.remove('hidden');
    });
});



