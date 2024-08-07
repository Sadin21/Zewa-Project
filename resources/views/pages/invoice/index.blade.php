<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>INVOICE {{ $data->tanggal }}</title>
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/pdf.css') }}"> --}}
    <style>
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: black;
            text-decoration: underline;
        }

        body {
            position: relative;
            width: 18cm;
            height: 29.7cm;
            margin: 0 auto;
            color: #001028;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 12px;
            font-family: Arial;
        }

        header {
            padding: 10px 0;
            margin-bottom: 30px;
        }

        #logo {
            text-align: center;
            margin-bottom: 10px;
        }

        #logo img {
            width: 90px;
        }

        h1 {
            border-top: 1px solid  black;
            border-bottom: 1px solid  black;
            color: black;
            font-size: 2.4em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: center;
            margin: 0 0 20px 0;
            background: url(dimension.png);
        }

        #project {
            float: left;
        }

        #project span {
            color: black;
            text-align: right;
            width: 52px;
            margin-right: 10px;
            display: inline-block;
            font-size: 0.8em;
        }

        #company {
            float: right;
            text-align: right;
        }

        #project div,
        #company div {
            white-space: nowrap;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table tr:nth-child(2n-1) td {
            background: #F5F5F5;
        }

        table th,
        table td {
            text-align: left;
        }

        table th {
            padding: 5px 20px;
            color: black;
            border-bottom: 1px solid #C1CED9;
            white-space: nowrap;
            font-weight: normal;
        }

        table .service,
        table .desc {
            text-align: left;
        }

        table td {
            padding: 20px;
            text-align: left;
        }

        table td.service,
        table td.desc {
            vertical-align: top;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
        }

        table td.grand {
            border-top: 1px solid black;;
        }

        #notices .notice {
            color: black;
            font-size: 1.2em;
        }

        footer {
            color: black;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #C1CED9;
            padding: 8px 0;
            text-align: center;
        }

    </style>
  </head>
  <body>
    <header class="clearfix">
      {{-- <div id="logo">
        <img src="logo.png">
      </div> --}}
      <h1>STRUK PENYEWAAN</h1>
      {{-- <div id="company" class="clearfix">
        <div>Company Name</div>
        <div>455 Foggy Heights,<br /> AZ 85004, US</div>
        <div>(602) 519-0450</div>
        <div><a href="mailto:company@example.com">company@example.com</a></div>
      </div> --}}
      <div id="project">
        <div><span>COSTUMER</span> {{ $data->customer }}</div>
        <div><span>ALAMAT</span> {{ $data->alamat }}</div>
        <div><span>EMAIL</span> <a href="mailto:{{ $data->email }}">{{ $data->email }}</a></div>
        <div><span>ID TRX</span>{{ $data->no_transaksi }}</div>
        <div><span>TANGGAL</span>{{ $data->tanggal }}</div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class="service">PRODUK</th>
            <th>KODE</th>
            {{-- <th class="desc">DESCRIPTION</th> --}}
            <th>TANGGAL SEWA</th>
            <th>TANGGAL KEMBALI</th>
            <th>HARGA</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($transaksi_detail as $detail)
            <tr>
                <td class="service">{{ $detail->nama_barang }}</td>
                <td class="service">{{ $detail->kode }}</td>
                <td class="unit">{{ $detail->waktu_sewa }}</td>
                <td class="unit">{{ $detail->waktu_pengembalian }}</td>
                <td class="total">{{ $detail->harga }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="4" class="grand total">GRAND TOTAL</td>
                <td class="grand total">{{ $data->grand_total }}</td>
            </tr>
        </tbody>
      </table>
      {{-- <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
      </div> --}}
    </main>
    <footer>
      ZEWA @2024
    </footer>
  </body>
</html>
