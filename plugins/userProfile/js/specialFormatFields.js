(function ($) {
    "use strict";

    var Password = function (options) {
        this.init('passwords', options, Password.defaults);
    };

    //inherit from Abstract input
    $.fn.editableutils.inherit(Password, $.fn.editabletypes.abstractinput);

    $.extend(Password.prototype, {
        /**
         Renders input from tpl
         @method render()
         **/
        render: function() {
            this.$input = this.$tpl.find('input');
           // this.$buttons = $.fn.editableform.buttons; // Move buttons to the bottom of the form template
        },

        /**
         Default method to show value in element. Can be overwritten by display option.

         @method value2html(value, element)
         **/
        value2html: function(value, element) {
            if(!value) {
                $(element).empty();
                return;
            }
            //var html = $('<div>').text(value.password).html() + ', ' + $('<div>').text(value.passwordConfirm).html() + ' st., bld. ';
            //$(element).html(html);
            var editableContent = $(element).innerText;
            $(element).html(editableContent);
        },

        /**
         Gets value from element's html

         @method html2value(html)
         **/
        html2value: function(html) {
            /*
              you may write parsing method to get value by element's html
              e.g. "Moscow, st. Lenina, bld. 15" => {city: "Moscow", street: "Lenina", building: "15"}
              but for complex structures it's not recommended.
              Better set value directly via javascript, e.g.
              editable({
                  value: {
                      city: "Moscow",
                      street: "Lenina",
                      building: "15"
                  }
              });
            */
            return null;
        },

        /**
         Converts value to string.
         It is used in internal comparing (not for sending to server).

         @method value2str(value)
         **/
        value2str: function(value) {
            var str = '';
            if(value) {
                for(var k in value) {
                    str = str + k + ':' + value[k] + ';';
                }
            }
            return str;
        },

        /*
         Converts string to value. Used for reading value from 'data-value' attribute.

         @method str2value(str)
        */
        str2value: function(str) {
            /*
            this is mainly for parsing value defined in data-value attribute.
            If you will always set value by javascript, no need to overwrite it
            */
            return str;
        },

        /**
         Sets value of input.

         @method value2input(value)
         @param {mixed} value
         **/
        value2input: function(value) {
            if(!value) {
                return;
            }
            this.$input.filter('[name="oldPassword"]').val(value.city);
            this.$input.filter('[name="newPassword"]').val(value.city);
            this.$input.filter('[name="passwordConfirm"]').val(value.street);
        },

        /**
         Returns value of input.

         @method input2value()
         **/
        input2value: function() {
            return {
                oldPassword: this.$input.filter('[name="oldPassword"]').val(),
                newPassword: this.$input.filter('[name="newPassword"]').val(),
                passwordConfirm: this.$input.filter('[name="passwordConfirm"]').val(),
            };
        },

        /**
         Activates input: sets focus on the first field.

         @method activate()
         **/
        activate: function() {
            this.$input.filter('[name="password"]').focus();
        },

        /**
         Attaches handler to submit form in case of 'showbuttons=false' mode

         @method autosubmit()
         **/
        autosubmit: function() {
            this.$input.keydown(function (e) {
                if (e.which === 13) {
                    $(this).closest('form').submit();
                }
            });
        }
    });

    Password.defaults = $.extend({}, $.fn.editabletypes.abstractinput.defaults, {
        tpl: '<div id="passwordContainer">' +
            '<div id="oldPassword">Stare hasło</div>' +
            '<input type="text" name="oldPassword" class="input-small">' +
            '<div id="newPassword">Nowe hasło</div>' +
            '<input type="text" name="newPassword" class="input-small">' +
            '<div id="passwordConfirm">Powtórz hasło</div>'+
            '<input type="text" name="passwordConfirm" class="input-small">' +
            '</div>',

        inputclass: ''
    });

    $.fn.editabletypes.passwords = Password;

}(window.jQuery));