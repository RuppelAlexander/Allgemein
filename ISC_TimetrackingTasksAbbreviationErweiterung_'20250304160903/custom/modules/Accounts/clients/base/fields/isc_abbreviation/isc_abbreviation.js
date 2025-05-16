/**
 * ------------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ------------------------------------------------------------------------------
 * Author        : MoschkauM
 * Create Date   : 28.02.2025
 * Change Date   : 28.02.2025
 * Main Program  : Zeiterfassung Usability-Anpassungen
 * Description   : custom Account List
 * ------------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * 24.01.2025  DontG  Make Nice layout (more customisations by Option)
 *                    Get Colors By split Value and use Second part
 *                    As Ky for Style List
 * ----------------------------------------------------------------------------
 */
({
    // extendsFrom: 'BaseField',

    baseOptionsDef: {
        "BaseStyle": "width:3em; border-width:3px;border-style:solid;border-radius:3px;text-align:center;font-weight:bold;",
        "enumlist": "isc_abbreviation_style",
    },
    /**
     * @inheritDoc
     */
    initialize: function (options) {

        // Merge Default Options with Options From Php
        options.def = _.extend({}, this.baseOptionsDef, options.def || {});
        this._super('initialize', [options]);
    },
    _render: function () {
        this._super("_render");

        if (this.tplName == 'detail') {
           //Hier Feld anheben in Recordwiew padding-top:8px
        }
        //padding-top:12px;
    },
    /**
     * Formats abbreviation field.
     *
     * @param {String} value abbreviation value .
     * @return object{text,style}   the returned value is an
     *   object with two keys, `text` and `style`. On detail mode the returned
     *   value is a text, Is the display Value
     *   value is a style, ist Splitet style Key (if Found) otherwise '@@@BASE@@@@'
     */
    format: function (value) {
        var self = this;

        if (!value) {
            parts = ['', ''];
        } else {
            parts = value.split('::', 2)
        }
        value = {
            'text': parts[0],
            'style': parts[1] ?? '@@@BASE@@@@',
        };
        return value;
    }

})
