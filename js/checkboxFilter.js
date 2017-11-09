var $filterCountyCheckboxes = $('input[name="island"]');
$filterCountyCheckboxes.on('change', function() {
    var selectedFilters = {};
    $filterCountyCheckboxes.filter(':checked').each(function() {
        if (!selectedFilters.hasOwnProperty(this.name)) {
            selectedFilters[this.name] = [];
        }
        selectedFilters[this.name].push(this.id);
    });
    var $filteredResults = $('.county');
    $.each(selectedFilters, function(name, filterValues) {
        $filteredResults = $filteredResults.filter(function() {
            var matched = false,
            currentFilterValues = $(this).data('category').split(' ');
            $.each(currentFilterValues, function(_, currentFilterValue) {
                if ($.inArray(currentFilterValue, filterValues) != -1) {
                    matched = true;
                    return false;
                }
            });
            return matched;
        });
    });
    var $filteredResultsPRS = $('.parish');
    $.each(selectedFilters, function(name, filterValues) {
        $filteredResultsPRS = $filteredResultsPRS.filter(function() {
            var matched = false,
            currentFilterValues = $(this).data('category').split(' ');
            $.each(currentFilterValues, function(_, currentFilterValue) {
                if ($.inArray(currentFilterValue, filterValues) != -1) {
                    matched = true;
                    return false;
                }
            });
            return matched;
        });
    });
    $('.county').hide().filter($filteredResults).show();
    $('.parish').hide().filter($filteredResultsPRS).show();
});


var $filterParishCheckboxes = $('input[name="county"]');
$filterParishCheckboxes.on('change', function() {
    var selectedFilters = {};
    $filterParishCheckboxes.filter(':checked').each(function() {
        if (!selectedFilters.hasOwnProperty(this.name)) {
            selectedFilters[this.name] = [];
        }
        selectedFilters[this.name].push(this.id);
    });
    var $filteredResults = $('.parish');
    $.each(selectedFilters, function(name, filterValues) {
        $filteredResults = $filteredResults.filter(function() {
            var matched = false,
            currentFilterValues = $(this).data('category').split(' ');
            $.each(currentFilterValues, function(_, currentFilterValue) {
                if ($.inArray(currentFilterValue, filterValues) != -1) {
                    matched = true;
                    return false;
                }
            });
            return matched;
        });
    });
    $('.parish').hide().filter($filteredResults).show();
});




