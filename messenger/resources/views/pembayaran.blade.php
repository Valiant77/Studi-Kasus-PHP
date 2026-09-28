<!DOCTYPE html>
<html>
    <head>
        <title>Pembayaran Pesanan</title>
        <style>
            body {
                font-family: Arial;
                background: #f5f5f5;
                padding: 40px;
            }
            .container {
                max-width: 700px;
                margin: auto;
                background: white;
                padding: 30px;
                border-radius: 10px;
            }
            .notifikasi {
                padding: 15px;
                margin-top: 10px;
                background: #e8f5e9;
                border-radius: 8px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Sistem Pembayaran</h1>
            <p>Pesanan <strong>#001</strong> berhasil terbayarkan.</p>
            @foreach ($hasil as $pesan)
                <div class="notifikasi">
                    {{ $pesan }}
                </div>
            @endforeach
        </div>
    </body>
</html>