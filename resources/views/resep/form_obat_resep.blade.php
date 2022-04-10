<div class="modal-header">
    <h4 class="modal-title">Resep : <b class="text-danger">{{$nama_resep}}</b></h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body" id="modal-konten">
    <div class="row">
        <div class="col-6">
            <input type="hidden" id="kode_resep_baru" value="{{$kode_resep}}">
            <div class="form-group">
                <label>Pilih Obat</label>
                <select class="form-control select2" name="obat" id="obat">
                    <option value="">-- Pilih Obat --</option>
                    <?php
                        $obat = $data['obat'] ?? '';
                        foreach($obat as $row) :
                    ?>
                        <option value="{{$row->obatalkes_kode}}">{{$row->obatalkes_nama}}</option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group">
                <label for="">Signa Obat</label>
                <select class="form-control" name="obat_signa" id="obat_signa">
                    <option value="">-- Pilih Signa --</option>
                    <?php
                        $obat = $data['signa'] ?? '';
                        foreach($obat as $row) :
                    ?>
                        <option value="{{$row->signa_kode}}">{{$row->signa_nama}}</option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group">
                <label for="">Qty Obat</label>
                <input type="text" name="qty_obat" id="qty_obat" class="form-control">
            </div>
            <div class="form-group">
                <label>Pilih Obat Racikan</label>
                <select class="form-control" id="obat_racikan" onChange="javascript:ubah_signa_racikan()">
                    <option value="">-- Pilih Obat --</option>
                    <?php
                        $obatRacik = $data['obatRacik'] ?? '';
                        foreach($obatRacik as $row) :
                    ?>
                        <option value="{{$row->racikan_kode}}">{{$row->racikan_nama}}</option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group">
                <label for="">Signa Obat Racikan</label>
                <input type="text" name="signa_obat_racikan_dummy" class="form-control" disabled>
                <input type="hidden" name="signa_obat_racikan" id="signa_obat_racikan" class="form-control">
                <input type="hidden" name="signa_obat_racikan_nama" id="signa_obat_racikan_nama" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Qty Obat Racikan</label>
                <input type="text" name="qty_obat_racikan" id="qty_obat_racikan" class="form-control">
            </div>
            <div class="form-group text-right">
                <button class="btn btn-primary" onClick="javascript:simpanDetailResep()">Tambahkan</button>
            </div>
        </div>
        <div class="col-6">
            <table class="table table-bordered" id="tabel-resep-detail" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Obat</th>
                        <th>Qty</th>
                        <th>#</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
<!-- /.card obat-->
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

<script>
    datatableResepDetail();

    
</script>