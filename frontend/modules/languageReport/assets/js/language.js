$(document).ready(function() {
    var langWidget = {
        init: function() {
            var that = this;
            var langnames = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                prefetch: {
                    url: '/languageReport/default/languages',
                    filter: function(list) {
                        return $.map(list, function(cityname) {
                            return {name: cityname};
                        });
                    },
                    ttl: 60
                }
            });
            langnames.initialize();
            $('#language-input').tagsinput({
                typeaheadjs: {
                    name: 'langnames',
                    displayKey: 'name',
                    valueKey: 'name',
                    source: langnames.ttAdapter()
                }
            });

            $(document).on('click', 'div.fader', function() {
                that.close();
            });

            $('a.reportLanguage').click(function(event) {
                event.preventDefault();
                event.stopPropagation();
                that.open();
                return false;
            });

            $('#cancelReport').click(function() {
                that.close();
            });

            $('#sendReport').click(function() {
                that.save();
            });
        },
        open: function() {
            $('<div>')
                    .addClass('fader')
                    .hide()
                    .appendTo('body')
                    .fadeIn();
            $('.reporterForm').fadeIn();
        },
        save: function() {
            var data = {
                id: $('#sendReport').data('id'),
                language: $('#language-input').val()
            };
            $.get('/languageReport/default/report', data, function(r) {
                $('#recordLanguage').html(r.languages);
                alert(r.message);
                $('.reporterForm').fadeOut(function() {
                    $('.reporterArea').remove();
                });
            }).fail(function() {
                alert('Avast! Server is unreachable now like a far land, ya land lubber!');
                $('.reporterForm').fadeOut();
            });
            this.close();
        },
        close: function() {
            $('div.fader').fadeOut(function() {
                $('div.fader').remove();
            });
            $('.reporterForm').fadeOut();
        }
    };
    langWidget.init();
});
