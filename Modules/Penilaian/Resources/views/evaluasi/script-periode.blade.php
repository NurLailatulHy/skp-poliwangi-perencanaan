<script>
    $(document).ready(function() {
        $('#table-periode').Datatable({
            responsive: true,
            scrollX: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: '',
                type: 'GET',
                dataSrc: function (response) {

                },
            },
        })
    })
</script>
