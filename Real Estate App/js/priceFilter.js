function filterSystem($minValue, $maxValue) {
    $('.propertyShow').filter(function () {
    	var minPrice = $("input[name='minPrice']").val();
    	var maxPrice = $("input[name='maxPrice']").val();
        var price = parseInt($(this).data("price"));
        if (isNaN(price)) {
            price = '0';
        }
        if(minPrice == ""){
        	minPrice = $minValue;
        }
        if(maxPrice == ""){
        	maxPrice = $maxValue;
        }
        $('.propertyShow').hide();
        return price >= minPrice && price <= maxPrice;
    }).show();
}
