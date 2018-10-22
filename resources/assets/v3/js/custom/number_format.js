window.number_format = function (number, decimals, dec_point, thousands_sep) {
    var units = number.toString().split(".");
    var decimal = '00';
    if (units.length > 1) {
        decimal = units[1];
        units = units[0];
    } else {
        decimal = '00';
        units = units[0];
    }

    if (decimal.length < 1) {
        decimal = decimal + '0';
    }
    if (decimal.length < 2) {
        decimal = decimal + '0';
    }

    var unitsParts = units.split(/(?=(?:...)*$)/);
    var final = '';
    for (var i = 0; i < unitsParts.length; i++) {
        if (i > 0) final += ',';
        final += unitsParts[i];
    }
    final = final + '.' + decimal;
    return final;
};

