$(document).ready(function() {

  var cellAndLandMaskBehavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
  },

  options = {
    onKeyPress: function(val, e, field, options) {
      field.mask(cellAndLandMaskBehavior.apply({}, arguments), options);
    }
  };

  $("input[data-phone-mask='true']").mask(cellAndLandMaskBehavior, options);
});
