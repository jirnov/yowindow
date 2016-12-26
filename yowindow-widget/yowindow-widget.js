function onSelectCustomUnits(fieldName) {
    jQuery('select[name="' + fieldName + '"]').val('custom');
}


function onChangeUnits(units, fields) {
    if ('custom' == units) {
        return;
    }

    fieldNames = fields.split(',');

    jQuery('select[name="' + fieldNames[0] + '"]').val(yoUnits[units]['temperature']);
    jQuery('select[name="' + fieldNames[1] + '"]').val(yoUnits[units]['wind_speed']);
    jQuery('select[name="' + fieldNames[2] + '"]').val(yoUnits[units]['pressure']);
    jQuery('select[name="' + fieldNames[3] + '"]').val(yoUnits[units]['pressure_level']);
    jQuery('select[name="' + fieldNames[4] + '"]').val(yoUnits[units]['distance']);
    jQuery('select[name="' + fieldNames[5] + '"]').val(yoUnits[units]['rain_rate']);
}
