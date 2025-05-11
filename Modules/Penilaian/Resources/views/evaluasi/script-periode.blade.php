<script>
    // $(document).ready(function() {
    //     $('#table-periode').Datatable({
    //         responsive: true,
    //         scrollX: true,
    //         processing: true,
    //         serverSide: true,
    //         ajax: {
    //             url: '',
    //             type: 'GET',
    //             dataSrc: function (response) {

    //             },
    //         },
    //     })
    // })
    $('#nama-unit').on('change', function () {
        var selectedValue = $(this).val();
        $('#peran').val(selectedValue);
    });
    $('#peran').on('change', function () {
        var selectedValue = $(this).val();
        $('#nama-unit').val(selectedValue);
    });
</script>
