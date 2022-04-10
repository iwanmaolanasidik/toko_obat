@extends('layout.master')

@section('content')
<?php if(isset($konten)){ ?>
    
        <?php echo view($konten,['data' => $data ?? '']); ?>
        
<?php }else{  ?>
    
        <?php echo "File Konten Tidak Ada"; ?>
    
<?php } ?>
@endsection