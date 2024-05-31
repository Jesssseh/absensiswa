<?php
// Pastikan variabel $_GET['kelas'] dan $_GET['pelajaran'] telah di-set dan aman untuk digunakan dalam query
$kelas_id = isset($_GET['kelas']) ? $_GET['kelas'] : '';
$pelajaran_id = isset($_GET['pelajaran']) ? $_GET['pelajaran'] : '';

// Tampilkan data mengajar
$query_kelasMengajar = "SELECT * FROM tb_mengajar 
    INNER JOIN tb_guru ON tb_mengajar.id_guru=tb_guru.id_guru
    INNER JOIN tb_master_mapel ON tb_mengajar.id_mapel=tb_master_mapel.id_mapel
    INNER JOIN tb_mkelas ON tb_mengajar.id_mkelas=tb_mkelas.id_mkelas
    INNER JOIN tb_semester ON tb_mengajar.id_semester=tb_semester.id_semester
    INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran=tb_thajaran.id_thajaran
    WHERE tb_mengajar.id_mengajar='$pelajaran_id' AND tb_mengajar.id_mkelas='$kelas_id' AND tb_thajaran.status=1 AND tb_semester.status=1";

$kelasMengajar = mysqli_query($con, $query_kelasMengajar);

?>

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title"><?= strtoupper($d['mapel']) ?> </h4> 
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="#">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">KELAS (<?= strtoupper($d['nama_kelas']) ?> )</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <table width="100%">
                        <tr>
                            <td>
                                <img src="../assets/img/sd.png" width="130">
                            </td>
                            <td>
                                <h1>ABSESNSI SISWA <br><small>SD Negeri Ciater 03</small></h1>
                            </td>
                            <td>
                                <table width="100%">
                                    <tr>
                                        <td colspan="2"><b style="border: 2px solid;padding: 7px;">KELAS ( <?= strtoupper($d['nama_kelas']) ?> )</b></td>
                                        <td><b style="border: 2px solid;padding: 7px;"><?= $d['semester'] ?> | <?= $d['tahun_ajaran'] ?></b></td>
                                        <td rowspan="5">
                                            <p class="text-info"> H = Hadir</p>
                                            <p class="text-success"> I = Izin</p>
                                            <p class="text-warning"> S = Sakit</p>
                                            <p class="text-danger"> A = Absen</p>
                                        </td>
                                    </tr>
                                    <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                    <tr><td>Nama Guru </td><td>:</td><td><?= $d['nama_guru'] ?></td></tr>
                                    <tr><td>Bidang Studi </td><td>:</td><td><?= $d['mapel'] ?></td></tr>
                                    
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="card-body">
                    <a target="_blank" href="../guru/modul/rekap/rekap_persemester.php?pelajaran=<?= $pelajaran_id ?>&bulan=<?= $bulan ?>&kelas=<?= $kelas_id ?>" class="btn btn-default">
                        <span class="btn-label"><i class="fas fa-print"></i></span> REKAP (<?= strtoupper($d['semester']) ?> - <?= strtoupper($d['tahun_ajaran']) ?>)
                    </a>
                    <?php 
                    // Tampilkan data absen setiap bulan, berdasarkan tahun ajaran yang aktif
                    $qryAbsen = mysqli_query($con, "SELECT * FROM _logabsensi
                        INNER JOIN tb_mengajar ON _logabsensi.id_mengajar=tb_mengajar.id_mengajar
                        INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran=tb_thajaran.id_thajaran
                        INNER JOIN tb_semester ON tb_mengajar.id_semester=tb_semester.id_semester
                        WHERE _logabsensi.id_mengajar='$pelajaran_id' AND tb_thajaran.status=1 AND tb_semester.status=1
                        GROUP BY MONTH(_logabsensi.tgl_absen) ORDER BY MONTH(_logabsensi.tgl_absen) DESC");

                    while ($bulan = mysqli_fetch_assoc($qryAbsen)) {
                        $bulan = date('m', strtotime($bulan['tgl_absen']));
                        $tglTerakhir = date('t', strtotime($bulan['tgl_absen']));
                    ?>
                    <div class="alert alert-warning alert-dismissible mt-2" role="alert">
                        <b class="text-warning" style="text-transform: uppercase;">BULAN <?= namaBulan($bulan) ?> <?= date('Y') ?></b>
                        <hr>
                        <p>
                            <a target="_blank" href="../guru/modul/rekap/rekap_bulanxl.php?pelajaran=<?= $pelajaran_id ?>&bulan=<?= $bulan ?>&kelas=<?= $kelas_id ?>" class="btn btn-success">
                                <span class="btn-label"><i class="far fa-file-excel"></i></span> Export Excel
                            </a>
                            <a target="_blank" href="../guru/modul/rekap/rekap_bulan.php?pelajaran=<?= $pelajaran_id ?>&bulan=<?= $bulan ?>&kelas=<?= $kelas_id ?>" class="btn btn-default">
                                <span class="btn-label"><i class="fas fa-print"></i></span> CETAK BULAN (<?= strtoupper(namaBulan($bulan)) ?>)
                            </a>
                        </p>
                        <table width="100%" border="1" cellpadding="2" style="border-collapse: collapse;">
                            <tr>
                                <td rowspan="2" bgcolor="#EFEBE9" align="center">NO</td>
                                <td rowspan="2" bgcolor="#EFEBE9">NAMA SISWA</td>
                                <td rowspan="2" bgcolor="#EFEBE9" align="center">L/P</td>
                                <td colspan="<?= $tglTerakhir ?>" style="padding: 8px;">PERTEMUAN KE- DAN BULAN : <b style="text-transform: uppercase;"><?= namaBulan($bulan) ?> <?= date('Y', strtotime($tglBulan)) ?></b></td>
                                <td colspan="3" align="center" bgcolor="#EFEBE9">JUMLAH</td>
                            </tr>
                            <tr>
                                <?php 
                                for ($i = 1; $i <= $tglTerakhir; $i++) {
                                    echo "<td bgcolor='#EFEBE9' align='center'>" . $i . "</td>";
                                }
                                ?> 
                                <td bgcolor="#FFC107" align="center">S</td>
                                <td bgcolor="#4CAF50" align="center">I</td>
                                <td bgcolor="#D50000" align="center">A</td>
                            </tr>
                            <?php 
                            // Tampilkan absen siswa
                            $no = 1;
                            $qrySiswa = mysqli_query($con, "SELECT * FROM _logabsensi 
                                INNER JOIN tb_siswa ON _logabsensi.id_siswa=tb_siswa.id_siswa
                                WHERE MONTH(_logabsensi.tgl_absen)='$bulan' AND _logabsensi.id_mengajar='$pelajaran_id'
                                GROUP BY _logabsensi.id_siswa ORDER BY _logabsensi.id_siswa ASC");
                            while ($d = mysqli_fetch_assoc($qrySiswa)) {
                                $warna = ($no % 2 == 1) ? "#ffffff" : "#f0f0f0";
                            ?>
                            <tr bgcolor="<?= $warna ?>">
                                <td align="center"><?= $no++ ?></td>
                                <td><?= $d['nama_siswa'] ?></td>
                                <td align="center"><?= $d['jk'] ?></td>
                                <?php 
                                for ($i = 1; $i <= $tglTerakhir; $i++) {
                                    $ket = mysqli_query($con, "SELECT * FROM _logabsensi WHERE DAY(tgl_absen)='$i' AND id_siswa='{$d['id_siswa']}' AND id_mengajar='$pelajaran_id' AND MONTH(tgl_absen)='$bulan' GROUP BY DAY(tgl_absen)");
                                    $h = mysqli_fetch_assoc($ket);
                                    if ($h['ket'] == 'H') {
                                        echo "<td align='center' bgcolor='white'><b style='color:#2196F3;'>H</b></td>";
                                    } elseif ($h['ket'] == 'I') {
                                        echo "<td align='center' bgcolor='white'><b style='color:#4CAF50;'>I</b></td>";
                                    } elseif ($h['ket'] == 'S') {
                                        echo "<td align='center' bgcolor='white'><b style='color:#FFC107;'>S</b></td>";
                                    } elseif ($h['ket'] == 'A') {
                                        echo "<td align='center' bgcolor='white'><b style='color:#D50000;'>A</b></td>";
                                    } else {
                                        echo "<td align='center' bgcolor='white'><b style='color:#D50000;'>L</b></td>";
                                    }
                                }
                                ?>
                                <td align="center" style="font-weight: bold;"><?= $sakit['sakit'] ?></td>
                                <td align="center" style="font-weight: bold;"><?= $izin['izin'] ?></td>
                                <td align="center" style="font-weight: bold;"><?= $alfa['alfa'] ?></td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
