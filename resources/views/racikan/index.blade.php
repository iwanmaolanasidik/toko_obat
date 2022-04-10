<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Obat Racikan</h3>
    </div>
    <div class="card-body">
            <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="racikan_kode">Kode Racikan</label>
                            <input type="text" name="racikan_kode" class="form-control" id="racikan_kode" placeholder="Masukan kode racikan">
                        </div>
                        <div class="form-group">
                            <label for="racikan_nama">Nama Racikan</label>
                            <input type="text" name="racikan_nama" class="form-control" id="racikan_nama" placeholder="Masukan nama racikan">
                        </div>
                        <div class="form-group">
                            <label for="">Aturan minum</label>
                            <select name="signa" id="signa" class="form-control">
                                <option value="">-- Pilih Signa --</option>
                                <?php
                                    $signa = $data['signa'] ?? '';
                                    foreach($signa as $row) :
                                ?>
                                    <option value="{{$row->signa_kode}}">{{$row->signa_nama}}</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-primary" id="simpan_resep">Simpan Racikan</button>
                        </div>
                    </div>
                <div class="col-6">
                    <!-- tabel racikan -->
                    <table class="table table-bordered" id="tabel-racikan">
                        <thead>
                            <tr>
                                <td class="td-no">No</td>
                                <td>Kode</td>
                                <td>Nama</td>
                                <td>#</td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
    </div>
</div>
<!-- /.card -->

<div class="modal fade" id="modal-komposisi">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
    tabelracikan();
    datatable();
    
    function datatable(){
        $('#tabel-racikan').DataTable({
            processing: false,
            serverSide: true,
            searching: false,
            stateSave: true,
            lengthChange: false,
            info: false,
            ajax: {
              url: "{{url('/data-tabel-racikan')}}",
              data: function(d){
                
              },
            },
            columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, serachable: false,},
              {data: 'racikan_kode', name: 'racikan_kode', serachable: true},
              {data: 'racikan_nama', name: 'racikan_nama', serachable: true},
              {data: '', name: '', serachable: true, orderable: false}
            ],
            columnDefs: [
            {
                "targets": 3,
                "render": function(data, type, row, meta) {
                    return ('<a href="javascript:komposisi(`'+row['racikan_kode']+'`)" class="btn btn-sm btn-primary text-white">Komposisi</a> | <a href="javascript:hapusRacikan(`'+row['racikan_kode']+'`)" class="btn btn-sm btn-danger text-white"><i class="fas fa-trash"></i></a>');
                }

            }
          ],
        });
    }

    function reload_table(){
        $('#tabel-racikan').DataTable().ajax.reload();
    }

    function hapusRacikan(racikan_kode){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type:"DELETE",
                    url: "{{url('/racikan-delete')}}",
                    data: {rako: racikan_kode, _token: '{{csrf_token()}}'},
                    success: function(val){
                        if(val == 1){
                            Swal.fire(
                            'Deleted!',
                            'Berhasil dihapus.',
                            'success'
                            )
                            reload_table();
                        }else{
                            Swal.fire(
                            'Gagal!',
                            'Gagal menghapus.',
                            'error'
                            )
                        }
                    }
                })
            }
        })
    }

    function komposisi(racikan_kode){
        var url = '{{url("/komposisi-racikan")}}';
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data: {rako: racikan_kode},
            success:function(val){
                $("#modal-komposisi").modal("show");
                $(".modal-content").html(val['data']);
            }
        })
    }

    function tabelracikan(){
        var url = '{{url("/tabel-racikan")}}';
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success:function(val){
                $('#konten-racikan').html(val['data']);
            }
        })
    }

    $('#simpan_resep').on('click', function(){
        var racikan_kode = $('input[name=racikan_kode]').val();
        var racikan_nama = $('input[name=racikan_nama]').val();
        var signa_kode = $('#signa').val();
        var signa_nama = $('#signa option:selected').text();

        var url = '{{url("/obat-racikan-create")}}';
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {rako: racikan_kode, rana: racikan_nama, siko: signa_kode, sina: signa_nama, _token: '{{csrf_token()}}'},
            beforeSend: function(){

            },
            success: function(data){
                $('input[name=racikan_kode]').val('');
                $('input[name=racikan_nama]').val('');
                $('#signa').val('');
                reload_table();
                toastr.options= {
                    "progressBar":true,
                    "positionClass":"toast-top-right",
                    "onclick":null,
                    "showDuration":"300",
                    "hideDuration":"1000",
                    "timeOut":"3000",
                    "extendedTimeOut":"1000",
                    "showEasing":"swing",
                    "hideEasing":"linear",
                    "showMethod":"fadeIn",
                    "hideMethod":"fadeOut"
                }
                toastr.success('Berhasil Menyimpan', data['info']);
            },
            error: function(data){
                console.log('Error : ', data);
            }
        })
    })


    
</script>