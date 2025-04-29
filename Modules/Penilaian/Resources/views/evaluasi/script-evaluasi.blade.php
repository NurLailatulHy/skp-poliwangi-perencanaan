<script>
    $(document).ready(function() {
        $('#table-pegawai').DataTable({
            responsive: true,
            scrollX: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: '/penilaian/data-pegawai',
                type: 'GET',
                dataSrc: function (response) {
                    try {
                        return response.data.map((pegawai) => {
                            return {
                                id: pegawai.id,
                                nama: pegawai.nama,
                            }
                        })
                    } catch (error) {
                        console.log(response)
                    }
                },
            },
            columns: [
                {
                    data: 'id',
                    name: 'id',
                    orderable: true
                },
                {
                    data: 'nama',
                    name: 'nama',
                    orderable: true
                },
                {
                    data: null,
                    name: 'jabatan',
                    orderable: true
                },
                {
                    data: null,
                    name: 'status',
                    orderable: true
                },
                {
                    data: null,
                    name: 'predikatKinerja',
                    orderable: true
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `
                            <button onclick="window.location.href='/penilaian/evaluasi/${row.id}/detail'" type="button" class="btn btn-primary"><i class="nav-icon fas fa-pencil-alt "></i></button>
                        `;
                    }
                },
            ],
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            processing: true,
            serverSide: true,
            stateSave: true,
        });
    });

    // const colorStatus = (status) => {
    //     if(status == 'Belum Dievaluasi') {
    //         return `<span class="">${status}</span>`
    //     }else if (status == 'Belum Ajukan Realisasi') {
    //         return `<span class="badge badge-danger">${status}</span>`
    //     } else {
    //         return `<span class="badge badge-success">${status}</span>`
    //     }
    // }

</script>
