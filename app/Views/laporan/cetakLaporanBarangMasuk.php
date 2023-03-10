<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang Masuk</title>
</head>

<body onload="window.print()">
    <table style="width: 100%;border-collapse: collapse; text-align: center;" border="1">
        <tr>
            <td>
                <table style="width: 100%; text-align: center;" border="0">
                    <tr style="text-align: center;">
                        <h1>Toko Lutfi</th>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table style="width: 100%; text-align: center;" border="0">
                    <tr style="text-align: center;">
                        <h3 style="margin-bottom: 0px;">Laporan Barang Masuk</h3> <br>
                        Periode : <?= $tglawal . " s/d " . $tglakhir; ?>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td><br>
                <center>
                    <table border="1" cellpadding="5" style="border-collapse: collapse; border: 1px solid #000; width: 80%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No. Faktur</th>
                                <th>Tanggal</th>
                                <th>Total Harga (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $nomor = 1;
                            $totalSeluruhHarga = 0;
                            foreach ($datalaporan->getResultArray() as $row) : $totalSeluruhHarga += $row['totalharga'] ?>
                                <tr>
                                    <td><?= $nomor++; ?></td>
                                    <td><?= $row['faktur']; ?></td>
                                    <td><?= $row['tglfaktur']; ?></td>
                                    <td style="text-align: center;"><?= number_format($row['totalharga'], 0, ",", ".") ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">Total Harga Seluruh</th>
                                <td style="text-align: center;"><?= number_format($totalSeluruhHarga, 0, ",", ".") ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </center>
                <br>
            </td>
        </tr>
    </table>
</body>

</html>