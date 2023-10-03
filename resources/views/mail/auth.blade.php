<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600;700;800;900&display=swap');

    * {
      font-family: 'Poppins', sans-serif;
      padding: 0;
      margin: 0;
    }
  </style>
</head>

<body>
  <table style="width: 100%; margin-top: 20px;" border="0" cellpadding="0" cellspacing=0>
    <tr>
      <th style="text-align:center">
        <h2 style="color: rgb(111, 111, 255); font-weight: 600;">PosMarket.id</h4>
      </th>
    </tr>
    <tr>
      <td style="padding: 50px 20px;">
        <p style="text-align: center;  font-weight: 600;">Verifikasi akun anda:</p>
        <p style="text-align: center;">Halo {{ $data_email['name'] }}, silahkan pencet tombol dibawah ini untuk mengaktifkan akun anda sekarang</p>
        <br><br>
        <center>
          <a href="{{ $data_email['link'] }}" style="background-color: rgb(71, 85, 238); color: white; padding: 10px 30px; text-decoration: none;">Verifikasi Sekarang</a>
        </center>
      </td>
    </tr>
    <tr>
      <td>
        <p style="text-align: center;">Jika tombol diatas tidak berfungsi anda bisa klik link <a href="#">disini</a> untuk mengaktifkan akun anda.</p>
      </td>
    </tr>
  </table>
</body>

</html>