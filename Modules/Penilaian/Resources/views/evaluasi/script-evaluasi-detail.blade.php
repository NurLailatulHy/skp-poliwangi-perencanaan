<script>
    const umpanBalikBox = document.querySelector('#proses-umpan-balik-box')
    const displayProsesUmpanBalik = () => {
        umpanBalikBox.style.display = 'block'
    }
    $(document).ready(() => {
        $('#form-umpan-balik').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: '/penilaian/predikat-kinerja',
                type: 'GET',
                data: $(this).serialize(),
                success: (response) => {
                    console.log(response)
                },
                error: (response) => {
                    console.log(response.responseJSON.message)
                }
            });
        });
    })
</script>
