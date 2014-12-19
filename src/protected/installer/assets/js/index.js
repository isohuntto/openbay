$(document).ready(function() {
    $(".db-settings-switcher").bootstrapSwitch();
    $(".db-settings-switcher").on('switchChange.bootstrapSwitch', function(event, state) {
        console.log(event, state);

        if (!state) {
            $('.database-settings').fadeIn(500)
        } else {
            $('.database-settings').fadeOut(500)
        }
    });

    $(".sphinx-settings-switcher").bootstrapSwitch();
    $(".sphinx-settings-switcher").on('switchChange.bootstrapSwitch', function(event, state) {
        console.log(event, state);

        if (!state) {
            $('.sphinx-settings').fadeIn(500)
        } else {
            $('.sphinx-settings').fadeOut(500)
        }
    });

    $(".cache-switcher").bootstrapSwitch();
    $(".log-switcher").bootstrapSwitch();
})