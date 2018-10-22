@section ('javascript')
    <script>
        function userAutocomplete(userId, userName) {
            userName.autocomplete({
                source: '/autocomplete/user',
                minLength: 1,
                delay: 200,
                change: function (event, ui) {
                    userId.val(ui.item.id);
                },
                select: function (event, ui) {
                    userId.val(ui.item.id);
                }
            });
            userName.change(function (event) {
                userId.val(0);
            });
        }
    </script>
@append
