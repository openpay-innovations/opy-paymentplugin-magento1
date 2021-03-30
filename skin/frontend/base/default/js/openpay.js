if('Openpay' in window && Openpay.Checkout) {
    var isOpenpayJsLoaded = true;
    if (Openpay.Checkout.settings.isOnestepcheckoutEnable) {
        /** this fix will work for normal onestepcheckout */
        // var form = $('onestepcheckout-form');
        // var original = form.submit;
        // form.submit = function() {
        //     if (payment.currentMethod == Openpay.Checkout.settings.methodCode) {
        //         window.location.href = Openpay.Checkout.settings.checkoutUrl;
        //     } else {
        //         original.apply(this, arguments);
        //     }
        // }
        /** fix for one merchant which is using afterpay, zip payment with onestepcheckout */
        Event.observe('onestepcheckout-place-order', 'click', function (e) {
            var form = $('onestepcheckout-form');
            var elements = Form.getElements(form);
            var validator = new Validation(form);
            if (validator.validate()) {
                var method = null;
                for (var i=0; i<elements.length; i++) {
                    if (elements[i].name=='payment[method]' || elements[i].name == 'form_key') {
                        if (elements[i].checked) {
                            method = elements[i].value;
                        }
                    }
                }
                if (method == Openpay.Checkout.settings.methodCode) {
                    already_placing_order = true;
                    window.location.href = Openpay.Checkout.settings.checkoutUrl;
                }
            }
        }, false);
    } else {
        if('Review' in window) {
            Review.prototype.save
                = Review.prototype.save.wrap(function(parentMethod){
                if (payment.currentMethod == Openpay.Checkout.settings.methodCode) {
                    window.location.href = Openpay.Checkout.settings.checkoutUrl;
                } else {
                    return parentMethod();
                }  
            });
        }
    }
}