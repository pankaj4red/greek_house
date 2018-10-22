@section ('javascript')
    <script>
        var schoolSelectorGlobal = '';
        var chapterSelectorGlobal = '';
        function schoolAndChapter(schoolSelector, chapterSelector) {
            schoolSelectorGlobal = schoolSelector;
            chapterSelectorGlobal = chapterSelector;
            $(schoolSelectorGlobal).autocomplete({
                source: '/autocomplete/school',
                minLength: 1,
                delay: 200,
                change: chapterAutocomplete,
                select: chapterAutocomplete
            });
            $(chapterSelectorGlobal).autocomplete({
                source: '/autocomplete/chapter/' + $(schoolSelectorGlobal).val(),
                minLength: 1,
                delay: 200
            });
            $(schoolSelectorGlobal).change(chapterAutocomplete);
            $(schoolSelectorGlobal).keydown(chapterAutocomplete);
            $(schoolSelectorGlobal).keyup(chapterAutocomplete);
        }
        function chapterAutocomplete() {
            $(chapterSelectorGlobal).autocomplete('option', 'source', '/autocomplete/chapter/' + $(schoolSelectorGlobal).val());
        }
    </script>
@append
