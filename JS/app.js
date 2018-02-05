  $(function () {
            $('#entrada').clockface({
                format: 'HH:mm',
                trigger: 'manual'
            });

            $('#toggle-btn').click(function (e) {
                e.stopPropagation();
                $('#entrada').clockface('toggle');
            });
        });
        $(function () {
            $('#saida').clockface({
                format: 'HH:mm',
                trigger: 'manual'
            });

            $('#toggle-btn2').click(function (e) {
                e.stopPropagation();
                $('#saida').clockface('toggle');
            });
        });