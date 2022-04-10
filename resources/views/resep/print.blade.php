<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print</title>
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
</head>
<body>
    <div>
        <h4 class="text-center">{{$nama_resep}}</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Obat</th>
                    <th>Aturan Minum</th>
                </tr>
            </thead>
            <tbody>
                @foreach($detail as $row)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$row->obat_nama}}</td>
                    <td>{{$row->signa_nama}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="{{asset('assets/bootstrap/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
</body>
</html>

<script>

        window.print();

    
</script>