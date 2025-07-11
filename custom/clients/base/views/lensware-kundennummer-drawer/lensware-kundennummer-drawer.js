/**
 * ----------------------------------------------------------------------------
 * © ISC it & software consultants GmbH  (All rights reserved.)
 * DO NOT MODIFY THIS FILE !
 * ----------------------------------------------------------------------------
 * Author        : RuppelA
 * Create Date   : 08.09.2023
 * Change Date   : 08.09.2023
 * Main Program  : de_DE.LenswareKundenNummer.php
 * Description   : lensware-kundennummer-drawer.js
 * ----------------------------------------------------------------------------
 * Change Log    :
 * Date        Name    Description
 * ----------------------------------------------------------------------------
 * ----------------------------------------------------------------------------
 */
({
    extendsFrom: 'BaseView',
    lensware_kundennummer: 0,
    initialize: function (options) {
        self = this;
        this._super('initialize', [options]);
        uri = App.api.buildURL('isc_lenswaresettings', 'load');
        app.api.call('create', uri, {}, {
            success: function (data) {
                if (data.success) {
                    self.lensware_kundennummer = data.lensware_kundennummer;
                    self.render();
                } else {
                    app.alert.show('error-message', {
                        level: 'error',
                        messages: 'Fehler beim Laden der Daten',
                        autoClose: true,
                        autoCloseDelay: 5000
                    });
                }
            },
            error: function (error) {
                app.alert.show('error-message', {
                    level: 'error',
                    messages: 'API-Fehler: ' + error,
                    autoClose: true,
                    autoCloseDelay: 5000
                });
            }
        });
    },

    events: {
        'click .btn-primary': 'saveLenswareKundennummer',
        'click .btn-invisible': 'cancelDrawer'
    },

    saveLenswareKundennummer: function () {
        var self = this;
        var valueToSave = this.$('#lensware-kundennummer-field').val();

        if (!valueToSave) {
            app.alert.show('error-message', {
                level: 'error',
                messages: 'Bitte geben Sie einen Wert ein',
                autoClose: true,
                autoCloseDelay: 5000
            });
            return;
        }

        // Überprüfen Sie zuerst, ob die Nummer bereits existiert
        uri = App.api.buildURL('isc_lenswaresettings', 'check');
        app.api.call('create', uri, {lensware_kundennummer_value: valueToSave}, {
            success: function (data) {
                if (data.exists) {
                    app.alert.show('warning-message', {
                        level: 'warning',
                        messages: 'Die Nummer ist bereits vorhanden!',
                        autoClose: true,
                        autoCloseDelay: 5000
                    });
                }

                // Speichern Sie die Nummer, unabhängig davon, ob sie bereits existiert oder nicht
                uri = App.api.buildURL('isc_lenswaresettings', 'save');
                app.api.call('create', uri, {lensware_kundennummer_value: valueToSave}, {
                    success: function (data) {
                        if (data.success) {
                            self.lensware_kundennummer = valueToSave;
                            app.alert.show('success-message', {
                                level: 'success',
                                messages: 'Erfolgreich gespeichert!',
                                autoClose: true
                            });
                        } else {
                            app.alert.show('error-message', {
                                level: 'error',
                                messages: 'Fehler beim Speichern: ' + data.error,
                                autoClose: true,
                                autoCloseDelay: 5000
                            });
                        }
                    },
                    error: function (error) {
                        app.alert.show('error-message', {
                            level: 'error',
                            messages: 'API-Fehler: ' + error,
                            autoClose: true,
                            autoCloseDelay: 5000
                        });
                    }
                });
            },
            error: function (error) {
                app.alert.show('error-message', {
                    level: 'error',
                    messages: 'API-Fehler: ' + error,
                    autoClose: true,
                    autoCloseDelay: 5000
                });
            }
        });
    },

   /* saveLenswareKundennummer: function () {
        var self = this;
        var valueToSave = this.$('#lensware-kundennummer-field').val();

        if (!valueToSave) {
            app.alert.show('error-message', {
                level: 'error',
                messages: 'Bitte geben Sie einen Wert ein',
                autoClose: true,
                autoCloseDelay: 5000
            });
            return;
        }

        // Überprüfen Sie zuerst, ob die Nummer bereits existiert
        uri = App.api.buildURL('isc_lenswaresettings', 'check');
        app.api.call('create', uri, {lensware_kundennummer_value: valueToSave}, {
            success: function (data) {
                if (data.exists) {
                    app.alert.show('error-message', {
                        level: 'error',
                        messages: 'Die Nummer ist bereits vorhanden!',
                        autoClose: true,
                        autoCloseDelay: 5000
                    });
                } else {
                    // Wenn die Nummer nicht existiert, speichern Sie sie
                    uri = App.api.buildURL('isc_lenswaresettings', 'save');
                    app.api.call('create', uri, {lensware_kundennummer_value: valueToSave}, {
                        success: function (data) {
                            if (data.success) {
                                self.lensware_kundennummer = valueToSave;
                                app.alert.show('success-message', {
                                    level: 'success',
                                    messages: 'Erfolgreich gespeichert!',
                                    autoClose: true
                                });
                            } else {
                                app.alert.show('error-message', {
                                    level: 'error',
                                    messages: 'Fehler beim Speichern: ' + data.error,
                                    autoClose: true,
                                    autoCloseDelay: 5000
                                });
                            }
                        },
                        error: function (error) {
                            app.alert.show('error-message', {
                                level: 'error',
                                messages: 'API-Fehler: ' + error,
                                autoClose: true,
                                autoCloseDelay: 5000
                            });
                        }
                    });
                }
            },
            error: function (error) {
                app.alert.show('error-message', {
                    level: 'error',
                    messages: 'API-Fehler: ' + error,
                    autoClose: true,
                    autoCloseDelay: 5000
                });
            }
        });
    }
*/

    cancelDrawer: function () {
        app.drawer.close();
    }
})
