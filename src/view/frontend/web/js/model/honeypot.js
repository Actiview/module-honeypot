define([
    'ko',
    'uiComponent',
    'underscore'
], function (ko, Component, _) {
    'use strict';

    return Component.extend({
        defaults: {
            forms: []
        },

        initialize: function () {
            this._super();

            var element = this.createElement();

            _.each(this.forms, function (selector) {
                // Possibly more than one form with same selector
                var forms = document.querySelectorAll(selector);

                _.each(forms, function (form) {
                    form.appendChild(element);
                });
            });
        },

        createElement: function () {
            var element = document.createElement('input');
            element.type = 'text';
            element.name = this.fieldName;
            element.className = this.fieldClass;
            element.style.cssText = 'display: none';

            return element;
        }
    });
});
