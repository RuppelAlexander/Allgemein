function convertTask(ProjectTask_id) {

    var app = window.parent.SUGAR.App;
    var url = app.api.buildURL("ProjectTask", "convertProjectTask2Ticket", {id: ProjectTask_id});
    var cb = {
        success: function (data) {
            app.alert.show('Anlage-info' + data.id, {
                level: 'success',
                messages: 'Erledigt.',
                autoClose: true
            });
            var ticket_id = data['ticket_id'];
            if (typeof ticket_id !== "undefined") {
                app.router.navigate('Cases/' + data['ticket_id'], {trigger: true});
            }
        },
        error: function (x) {

            app.alert.show('Anlage-info', {
                level: 'error',
                messages: 'Es ist ein Fehler aufgetreten bitte wiederholen Sie die Aktion.',
                autoClose: true
            });
        },
    };
    app.api.call('GET', url, null, cb);

    /*
        var url = "index.php?action=convertTask&module=ProjectTask&record=" + id;
        window.open(url);
     */
}                
