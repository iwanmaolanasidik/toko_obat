<div class="modal-header">
    <h4 class="modal-title">Tambah Komposisi Obat</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body" id="modal-konten">
    <p>Tambah Komposisi : <b class="text-danger">{{$rana}}</b></p>
    <div class="card collapsed-card">
        <div class="card-header">
            <h3 class="card-title">Obat</h3>

            <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-plus"></i></button>
            </div>
        </div>
        <div class="card-body">
            <!-- racikan kode & nama-->
            <input type="hidden" value="{{$rako}}" id="racikan_kode_form">
            <input type="hidden" value="{{$rana}}" id="racikan_nama_form">

            <div class="form-group">
                <label for="obat">Pilih Obat</label>
                <select name="obat" id="obat" class="form-control">
                    <?php
                        $obat = $obat ?? '';
                        foreach($obat as $row) :
                    ?>
                        <option value="{{$row->obatalkes_kode}}">{{$row->obatalkes_nama}}</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="obat_qty">Qty</label>
                <input type="text" name="obat_qty" class="form-control" id="obat_qty" placeholder="Masukan jumlah">
            </div>
            <button class="btn btn-success" onClick="javascript:tambahKomposisi()">Tambah</button>
        </div>
    </div>
        <table class="table table-bordered" id="tabel-komposisi" style="width:100%">
            <thead>
                <tr>
                    <td class="td-no">No</td>
                    <td>Nama</td>
                    <td>Qty</td>
                    <td>#</td>
                </tr>
            </thead>
        </table>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

<script>
    datatable_komposisi();
    // TAMBAH KOMPOSISI
    function tambahKomposisi(){
        var obat_kode = $('#obat').val();
        var obat_nama = $('#obat option:selected').text();
        var qtyObat = $('input[name=obat_qty]').val();
        var racikanKode = $('#racikan_kode_form').val();
        var racikanNama = $('#racikan_nama_form').val();

        var url = '{{url("/komposisi-racikan-create")}}';
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {obat_kode: obat_kode, obat_nama: obat_nama,  obat_qty: qtyObat, rako: racikanKode, rana: racikanNama, _token: '{{csrf_token()}}' },
            success: function(data){
                    $('input[name=obat_qty]').val('');
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
                    reload_table_komposisi();
            },
            error: function(data){
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
                toastr.success('Obat sudah masuk komposisi', data['info']); 
            }
        })
    }

    function datatable_komposisi(){
        $('#tabel-komposisi').DataTable({
            processing: false,
            serverSide: true,
            searching: false,
            stateSave: true,
            lengthChange: false,
            info: false,
            ajax: {
              url: "{{url('/data-tabel-komposisi')}}",
              data: function(d){
                
              },
            },
            columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, serachable: false,},
              {data: 'obat_nama', name: 'obat_nama', serachable: true},
              {data: 'obat_qty', name: 'obat_qty', serachable: true},
              {data: '', name: '', serachable: true, orderable: false}
            ],
            columnDefs: [
            {
                "targets": 3,
                "render": function(data, type, row, meta) {
                    return ('<a href="javascript:hapusKomposisi(`'+row['racikan_kode']+'`,`'+row['obatalkes_kode']+'`)" class="btn btn-sm btn-danger text-white"><i class="fas fa-trash"></i></a>');
                }

            }
          ],
        });
    }

    function reload_table_komposisi(){
        $('#tabel-komposisi').DataTable().ajax.reload();
    }

    function hapusKomposisi(rako, okesko){
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
                    url: "{{url('/racikan-komposisi-delete')}}",
                    data: {rako: rako, okesko: okesko, _token: '{{csrf_token()}}'},
                    success: function(val){
                        reload_table_komposisi();
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
</script>