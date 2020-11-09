<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <h3>Selamat, {{$name}}</h3>
    <p>Akun anda telah teregistrasi</p>
    <hr>
    <p>masukkan OTP ini untuk verifikasi akun</p>
    <h2>{{$otpCode}}</h2>
    <p>OTP ini berlaku 5 menit, jika terjadi kendala silahkan generate ulang</p>
</body>
</html>