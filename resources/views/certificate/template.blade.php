<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
 
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f7f7f7;
        }

        .certificate {
            width: 297mm;
            height: 210mm;
            padding: 40px;
            box-sizing: border-box;
            border: 10px solid #1e2a78;
            background-color: #fff;
            text-align: center;
            position: relative;
            background-image: url('https://img.freepik.com/free-photo/nice-christmas-background-white-background-with-copy-space_24972-1722.jpg?t=st=1734265956~exp=1734269556~hmac=d4a67e8659d4f602ff9f047779670e4e7fb5bfd9d756f5d7a1ba6f7547cdfb40&w=1380');
            background-size: cover;
            background-position: center;
        } 

        .certificate-header {
            font-size: 40px;
            font-weight: bold;
            color: #1e2a78;
            margin-bottom: 20px;
        }

        .certificate-title {
            font-size: 32px;
            font-weight: bold;
            text-transform: uppercase;
            color: #222;
            margin-bottom: 100px;
        }

        .certificate-number {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .recipient-name {
            font-size: 36px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .recipient-org {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        
        .description {
            font-size: 20px;
            color: #555;
            margin-bottom: 40px;
            max-width: 80%;
            margin-left: auto;
            margin-right: auto;
        }

        .details {
            font-size: 18px;
            color: #444;
            margin-bottom: 20px;
        }

        .signature {
            position: absolute;           /* Posisi absolut dari halaman */
            bottom: 50px;                 /* 50px dari bawah halaman */
            left: 50%;                    /* Posisi horizontal di tengah */
            transform: translateX(-50%);  /* Menyesuaikan posisi agar benar-benar di tengah */
            display: flex;                /* Gunakan Flexbox untuk tata letak */
            flex-direction: column;       /* Menyusun elemen secara vertikal */
            align-items: center;          /* Pusatkan elemen di dalam secara horizontal */
            text-align: center;
        }
        

        .signature img {
            height: 60px;
            margin-bottom: 10px;
        }

        .signature p {
            margin: 0;
            font-weight: bold;
        }

        .qr-code {
            position: absolute;
            bottom: 40px;
            right: 80px;
        }

        .qr-code img {
            width: 100px;
            height: 100px;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FitText.js/1.2.0/jquery.fittext.min.js"></script>
</head>
<body>
    <div class="certificate">
        <div class="certificate-header">{{ JENIS_SERTIFIKAT }}</div>
        <div class="certificate-number">NO: {{ NOMOR_SERTIFIKAT }}</div>
        <div class="certificate-title">Diberikan Kepada</div>
        <div class="recipient-name" id="recipientName">{{ NAMA_PENERIMA }}</div>
        <div class="recipient-org">{{ ASAL_PENERIMA }}</div>
        <div class="description">
            {{ DESKRIPSI_SERTIFIKAT}}</strong>.
        </div>
        

        <div class="signature">
            <div class="details">{{ LOKASI }}, {{ TANGGAL_PENERBITAN }}</div>
            <img src="{{ TANDA_TANGAN_PATH }}" alt="Tanda Tangan">
            <p>{{ NAMA_PENANDATANGAN }}</p>
            <p>{{ JABATAN_PENANDATANGAN }}</p>
        </div>

        <div class="qr-code">
            <img src="{{ QR_CODE_PATH }}" alt="QR Code">
        </div>
    </div>
    <script>
        $('#recipientName').fitText(0.8); 
    </script>
</body>
</html>