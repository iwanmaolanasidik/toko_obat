<!-- card resep -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Resep</h3>

        <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="">Kode Resep</label>
            <input type="text" name="kode_resep" id="kode_resep" class="form-control">
        </div>
        <div class="form-group">
            <label for="">Nama Resep</label>
            <input type="text" name="nama_resep" id="nama_resep" class="form-control">
        </div>
        <div class="form-group">
            <button class="btn btn-primary" onClick="javascript:simpanResep()">Tambahkan</button>
        </div>
    </div>
</div>
<!-- /.card resep -->

<!-- card tabel -->
<div class="card">
    <div class="card-body">
        <table class="table table-bordered" id="tabel-resep">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Resep</th>
                    <th>Nama Resep</th>
                    <th>#</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<!-- /.card tabel -->

<div class="modal fade" id="modal-resep">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
        
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
    ubah_signa_racikan();
    datatable();
    $(document).ready(function() {
        $('#obat').select2({
            theme: 'bootstrap4'
        });

        $('#obat_racikan').select2({
            theme: 'bootstrap4'
        });

        $('#obat_signa').select2({
            theme: 'bootstrap4'
        });
    });

    function datatable(){
        $('#tabel-resep').DataTable({
            processing: false,
            serverSide: true,
            searching: false,
            stateSave: true,
            lengthChange: false,
            info: false,
            ajax: {
              url: "{{url('/data-tabel-resep')}}",
              data: function(d){
                
              },
            },
            columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, serachable: false,},
              {data: 'kode_resep', name: 'kode_resep', serachable: true},
              {data: 'nama_resep', name: 'nama_resep', serachable: true},
              {data: '', name: '', serachable: true, orderable: false}
            ],
            columnDefs: [
            {
                "targets": 3,
                "render": function(data, type, row, meta) {
                    return ('<a href="javascript:editResep(`'+row['kode_resep']+'`)" class="btn btn-sm btn-primary text-white"><i class="fas fa-plus"></i> Obat</a> | <a href="javascript:hapusResep(`'+row['kode_resep']+'`)" class="btn btn-sm btn-danger text-white"><i class="fas fa-trash"></i> Hapus</a> | <a href="javascript:print(`'+row['kode_resep']+'`)" class="btn btn-sm btn-success text-white"><i class="fas fa-print"></i> Cetak</a>');
                }

            }
          ],
        });
    }

    function reload_tabel(){
        $('#tabel-resep').DataTable().ajax.reload();
    }

    function print(kode_resep){
        var url = "{{url('/print-resep?')}}"+"kode_resep="+kode_resep;
        window.open(url, '_blank');
    }

    function editResep(kode_resep){
        var url = '{{url("/edit-resep")}}';
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data: {kode_resep: kode_resep},
            success:function(val){
                $("#modal-resep").modal("show");
                $(".modal-content").html(val['data']);
            }
        })
    }

    function simpanResep(){
        var kode_resep = $('#kode_resep').val();
        var nama_resep = $('#nama_resep').val();

        var url = "{{url('/simpan-resep')}}";
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {kode_resep: kode_resep, nama_resep: nama_resep, _token: '{{csrf_token()}}'},
            success: function(data){
                $('#kode_resep').val('');
                $('#nama_resep').val('');
                reload_tabel();
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
                toastr.success('Berhasil Menyimpan','sucess');
            }
        });
    }

    function hapusResep(kode_resep){
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
                    url: "{{url('/hapus-resep')}}",
                    data: {kode_resep: kode_resep, _token: '{{csrf_token()}}'},
                    success: function(val){
                        if(val == 1){
                            Swal.fire(
                            'Deleted!',
                            'Berhasil dihapus.',
                            'success'
                            )
                            reload_tabel();
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

    function ubah_signa_racikan(){
        var kode_racikan = $('#obat_racikan').val();
        var url = "{{url('/get-signa-racikan')}}";
        $.ajax({
            type:'GET',
            dataType: 'json',
            data: {rako: kode_racikan},
            url: url,
            success: function(val){
                $('input[name=signa_obat_racikan_dummy]').val(val['sina']);
                $('input[name=signa_obat_racikan]').val(val['siko']);
                $('input[name=signa_obat_racikan_nama]').val(val['sina']);
            }
        });
    }

    function simpanDetailResep(){
        var kode_resep = $('#kode_resep_baru').val();

        var obat = $('#obat').val();
        var obat_nama = $('#obat option:selected').text();
        var obat_signa = $('#obat_signa').val();
        var obat_signa_nama = $('#obat_signa option:selected').text();
        var qty_obat = $('input[name=qty_obat]').val();

        var obat_racikan = $('#obat_racikan').val();
        var obat_racikan_nama = $('#obat_racikan option:selected').text();
        var signa_obat_racikan = $('input[name=signa_obat_racikan]').val();
        var signa_obat_racikan_nama = $('input[name=signa_obat_racikan_nama]').val();
        var qty_obat_racikan = $('input[name=qty_obat_racikan]').val();

        var url = "{{url('/simpan-detail-resep')}}";
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {kode_resep: kode_resep, obat:obat, obat_nama: obat_nama, obat_signa:obat_signa, obat_signa_nama:obat_signa_nama,qty_obat:qty_obat, obat_racikan:obat_racikan, obat_racikan_nama: obat_racikan_nama, signa_obat_racikan:signa_obat_racikan, signa_obat_racikan_nama:signa_obat_racikan_nama,qty_obat_racikan:qty_obat_racikan, _token: '{{csrf_token()}}'},
            success: function(){
                reload_tabel_resep_detail();
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
                toastr.success('Berhasil Menyimpan', 'success');
                $('#obat').val('');
                $('#obat_signa').val('');
                $('input[name=qty_obat]').val('');
                $('#obat_racikan').val('');
                $('input[name=qty_obat_racikan]').val('');
                $('input[name=signa_obat_racikan_dummy]').val('');
                $('input[name=qty_obat_racikan]').val('');
            },
            error: function(data){
                alert('Error : ', data);
            }
        })
    }

    function datatableResepDetail(){
        $('#tabel-resep-detail').DataTable({
            processing: false,
            serverSide: true,
            searching: false,
            stateSave: true,
            lengthChange: false,
            info: false,
            ajax: {
              url: "{{url('/data-tabel-resep-detail')}}",
              data: function(d){
                d.kode_resep= $('#kode_resep_baru').val();
              },
            },
            columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, serachable: false,},
              {data: 'obat_nama', name: 'obat_nama', serachable: true},
              {data: 'qty', name: 'qty', serachable: true},
              {data: '', name: '', serachable: true, orderable: false}
            ],
            columnDefs: [
            {
                "targets": 3,
                "render": function(data, type, row, meta) {
                    return ('<a href="javascript:hapusResepDetail(`'+row['kode_resep']+'`,`'+row['obat_kode']+'`)" class="btn btn-sm btn-danger text-white"><i class="fas fa-trash"></i></a>');
                }

            }
          ],
        });
    }

    function reload_tabel_resep_detail(){
        $('#tabel-resep-detail').DataTable().ajax.reload();
    }

    function hapusResepDetail(kode_resep, obat_kode){
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
                    url: "{{url('/hapus-resep-detail')}}",
                    data: {kode_resep: kode_resep, obat_kode: obat_kode, _token: '{{csrf_token()}}'},
                    success: function(val){
                        if(val == 1){
                            Swal.fire(
                            'Deleted!',
                            'Berhasil dihapus.',
                            'success'
                            )
                            reload_tabel_resep_detail();
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