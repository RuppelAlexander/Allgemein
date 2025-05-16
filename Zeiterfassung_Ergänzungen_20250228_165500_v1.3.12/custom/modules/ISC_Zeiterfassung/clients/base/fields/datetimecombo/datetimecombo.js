/**
 * ----------------------------------------------------------------------------
 *  ISC it & software consultants GmbH
 * ----------------------------------------------------------------------------
 * Author        : RK
 * Create Date   : 15.01.2019
 * Change Date   : 15.01.2019
 * Main Program  : Zeiterfassung_Ergänzungen
 * Description   : Removes the "!" which causes trouble when an error is shown
 *
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */
({
    extendsFrom: 'DatetimecomboField',

    initialize: function (options) {
        this._super('initialize', [options]);
        if (this.name == 'date_to')
        {
            this.def.HideDatepart = 1;
        }
    },
    /**
     * Override decorateError to take into account the two fields.
     *
     * @override
     */
    decorateError: function (errors) {
        var ftag = this.fieldTag || '',
            $ftag = this.$(ftag),
            errorMessages = [],
            $tooltip;

        // Add error styling
        this.$el.closest('.record-cell').addClass('error');
        this.$el.addClass('error');

        if (_.isString(errors)) {
            // A custom validation error was triggered for this field
            errorMessages.push(errors);
        } else {
            // For each error add to error help block
            _.each(errors, function (errorContext, errorName) {
                errorMessages.push(app.error.getErrorString(errorName, errorContext));
            });
        }
    },
    format: function(value) {
        if (!value) {
            return value;
        }
        value = app.date(value);

        if (!value.isValid()) {
            return;
        }

        if (this.action === 'edit' || this.action === 'massupdate') {
            value = {
                'date': value.format(app.date.convertFormat(this.getUserDateFormat())),
                'time': value.format(app.date.convertFormat(this.getUserTimeFormat()))
            };

        } else {

            if (this.name == 'date_to')
            {
                value=   value.format(app.date.convertFormat(this.getUserTimeFormat()));
            }
            else
            {
                value = value.formatUser(false);
            }
        }

        return value;
    },
})