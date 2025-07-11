
(function(app) {
    app.events.on('router:init', function() {
        // Registrieren Sie die benutzerdefinierte Route
        app.router.route('Administration/lensware_kundennummer', 'lensware_kundennummer', function() {           //  diese Route Administration/lenswareKundennummer ist oben in URL
            debugger;
            app.drawer.open({
                layout: 'lensware-kundennummer-drawer',

                context: {
                    //kann man auch ohne versuchen
                    module: 'Home',
                    create: true,
                    fromRouter: true,
                    labelText: app.lang.get('LBL_LENSWARE_KUNDENNUMMER_ESTABLISH')
                }

            });
        });
    });
})(SUGAR.App);