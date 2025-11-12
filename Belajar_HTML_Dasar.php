<?php
// php_dasar.php — versi modifikasi

date_default_timezone_set('Asia/Jakarta');

// --- Data & Helper ---
$nim = "0411500400";
$nama_static = "Abdullah";

// Data tanggal dan hari sekarang
$tanggal_sekarang = date("d");
$bulan_sekarang   = date("F");
$tahun_sekarang   = date("Y");
$hari_sekarang    = date("l");

$nama_hari_id = [
    "Sunday" => "Minggu",
    "Monday" => "Senin",
    "Tuesday" => "Selasa",
    "Wednesday" => "Rabu",
    "Thursday" => "Kamis",
    "Friday" => "Jumat",
    "Saturday" => "Sabtu"
][$hari_sekarang] ?? $hari_sekarang;

// Daftar pekerjaan
$jobs = [
    "programmer" => 8000000,
    "designer"   => 6000000,
    "manager"    => 12000000,
    "Software Engineer"     => 6000000,
    "magang"     => 1500000,
];

$input = [
    "nama" => "",
    "dob" => "",
    "umur" => "",
    "status_umur" => "",
    "job" => "",
    "variabel_get" => "",
    "if_data" => "",
    "switch_data" => "",
    "for_data" => "",
    "while_data" => "",
    "dowhile_data" => ""
];

$messages = [];
$hasil = null;

// --- Proses form POST ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($input as $key => $val) {
        $input[$key] = isset($_POST[$key]) ? trim($_POST[$key]) : "";
    }

    if ($input['nama'] === "") $messages[] = "Nama wajib diisi.";
    if ($input['dob'] === "") $messages[] = "Tanggal lahir wajib diisi.";
    if ($input['job'] === "" || !array_key_exists($input['job'], $jobs))
        $messages[] = "Silakan pilih pekerjaan.";

    if (empty($messages)) {
        // Hitung umur otomatis
        $dobObj = new DateTime($input['dob']);
        $today = new DateTime();
        $umur_auto = $today->diff($dobObj)->y;

        // Gaji
        $gaji = $jobs[$input['job']];
        $pajak = 0.1;
        $take_home = $gaji - ($gaji * $pajak);

        $hasil = [
            "nama" => $input['nama'],
            "dob" => $input['dob'],
            "umur_auto" => $umur_auto,
            "umur_input" => $input['umur'],
            "status_umur" => $input['status_umur'],
            "job" => $input['job'],
            "gaji" => $gaji,
            "take_home" => $take_home
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
    <title>Belajar PHP Dasar</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
    :root{
     --accent:#6c63ff;
     --bg:#f6f8ff;
     --card:#fff;
     --muted:#6b6b7a;
     --success:#2ebf91;
        }
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            margin: 0;
            padding: 40px;
            background: linear-gradient(180deg, #eef2ff 0%, #f8fbff 100%);
        }
        .container {
            max-width: 960px;
            margin: auto;
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 20px;
        }
        .header {
            grid-column: 1 / -1;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        h1 {
            margin: 0;
            color: var(--accent);
        }
        .card {
            background: var(--card);
            padding: 18px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        }
        label {
            display: block;
            margin: 6px 0;
            font-weight: 600;
        }
        input, select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .btn {
            background: var(--accent);
            color: #fff;
            border: none;
            padding: 10px 14px;
            border-radius: 8px;
            margin-top: 10px;
            cursor: pointer;
        }
        .result-row {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px dashed #eee;
            padding: 4px 0;
        }
        .kecil {
            font-size: 0.85rem;
            color: var(--muted);
        }
        .errors {
            background: #fff1f1;
            padding: 10px;
            border-radius: 8px;
            color: #a33;
            margin-bottom: 10px;
        }
        .loops {
            background: #f9f9ff;
            padding: 6px;
            border-radius: 8px;
            margin-top: 4px;
            font-family: monospace;
        }
    </style>
</head>

<div class="container">
    <div class="header">
        <h1>Belajar PHP Dasar</h1>
        <div class="kecil">
            Hari ini: <strong><?php echo "$nama_hari_id, $tanggal_sekarang $bulan_sekarang $tahun_sekarang"; ?></strong>
        </div>
    </div>

    <!-- KIRI: Form utama -->
    <div>
        <div class="card">
            <h3>Form Input</h3>
            <form method="post">
                <label>Nama:</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($input['nama']); ?>" placeholder="Contoh: Doni Alvero">

                <label>Tanggal Lahir:</label>
                <input type="date" name="dob" value="<?= htmlspecialchars($input['dob']); ?>">

                <label>Umur:</label>
                <input type="text" name="umur" value="<?= htmlspecialchars($input['umur']); ?>" placeholder="Contoh: 25">

                <label>Status Umur:</label>
                <input type="text" name="status_umur" value="<?= htmlspecialchars($input['status_umur']); ?>" placeholder="Contoh: Dewasa">

                <label>Pekerjaan:</label>
                <select name="job">
                    <option value="">-- Pilih Pekerjaan --</option>
                    <?php foreach($jobs as $k=>$v): ?>
                        <option value="<?= $k; ?>" <?= ($input['job']==$k)?'selected':''; ?>>
                            <?= ucfirst($k)." — Rp ".number_format($v,0,',','.'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button class="btn" type="submit">Kirim</button>
            </form>

            <?php if(!empty($messages)): ?>
                <div class="errors">
                    <ul>
                        <?php foreach($messages as $m): ?>
                            <li><?= htmlspecialchars($m); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if($hasil): ?>
                <div class="result-row"><div>Nama</div><div><?= $hasil['nama']; ?></div></div>
                <div class="result-row"><div>Tanggal Lahir</div><div><?= $hasil['dob']; ?></div></div>
                <div class="result-row"><div>Umur (Input)</div><div><?= $hasil['umur_input']; ?></div></div>
                <div class="result-row"><div>Status Umur</div><div><?= $hasil['status_umur']; ?></div></div>
                <div class="result-row"><div>Pekerjaan</div><div><?= ucfirst($hasil['job']); ?></div></div>
                <div class="result-row"><div>Gaji</div><div>Rp <?= number_format($hasil['gaji'],0,',','.'); ?></div></div>
                <div class="result-row"><div>Take Home Pay</div><div style="color:var(--success)">Rp <?= number_format($hasil['take_home'],0,',','.'); ?></div></div>
            <?php endif; ?>
        </div>

        <!-- Contoh Variabel & GET -->
        <div class="card" style="margin-top:16px;">
            <h3>Variabel & GET</h3>
            <form method="post">
                <label>Masukkan Nama (GET/Variabel):</label>
                <input type="text" name="variabel_get" value="<?= htmlspecialchars($input['variabel_get']); ?>" placeholder="Contoh: Abdullah">
                <button class="btn" type="submit">Tampilkan</button>
            </form>
            <?php if($input['variabel_get']): ?>
                <p class="kecil">Output: Selamat Datang, <strong><?= htmlspecialchars($input['variabel_get']); ?></strong></p>
            <?php endif; ?>
        </div>
    </div>

    <!-- KANAN -->
    <aside>
        <div class="card">
            <h4>Kondisi IF</h4>
            <form method="post">
                <label>Masukkan data IF:</label>
                <input type="text" name="if_data" value="<?= htmlspecialchars($input['if_data']); ?>" placeholder="Contoh: Senin / Minggu">
                <button class="btn" type="submit">Cek IF</button>
            </form>
            <?php if($input['if_data']): ?>
                <div class="kecil">Hasil:
                <?php
                    if(strtolower($input['if_data'])=="minggu") echo "Hari libur 😄";
                    elseif(strtolower($input['if_data'])=="senin") echo "Semangat bekerja 💪";
                    else echo "Hari biasa ☀️";
                ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="card">
            <h4>Kondisi Switch</h4>
            <form method="post">
                <label>Masukkan hari (Switch):</label>
                <input type="text" name="switch_data" value="<?= htmlspecialchars($input['switch_data']); ?>" placeholder="Contoh: Tuesday">
                <button class="btn" type="submit">Cek Switch</button>
            </form>
            <?php if($input['switch_data']): ?>
                <div class="kecil">Hasil:
        <?php
            switch(strtolower($input['switch_data'])) {
                case "monday":
                    echo "Senin";
                    break;
                case "tuesday":
                    echo "Selasa";
                    break;
                 case "wednesday":
                    echo "Rabu";
                    break;
                case "thursday":
                    echo "Kamis";
                    break;
                case "friday":
                    echo "Jumat";
                    break;
                case "saturday":
                    echo "Sabtu";
                    break;
                case "sunday":
                    echo "Minggu";
                    break;
                default:
                    echo "Hari tidak dikenal";
                    break;
            }
        ?>

                </div>
            <?php endif; ?>
        </div>

        <div class="card">
            <h4>Perulangan For</h4>
            <form method="post">
                <label>Masukkan angka batas (For):</label>
                <input type="text" name="for_data" value="<?= htmlspecialchars($input['for_data']); ?>" placeholder="Contoh: 5">
                <button class="btn" type="submit">Jalankan</button>
            </form>
            <div class="loops">
                <?php
                if($input['for_data'] && is_numeric($input['for_data'])){
                    for($i=1;$i<=$input['for_data'];$i++){
                        echo "Ke-$i ";
                    }
                }
                ?>
            </div>
        </div>

        <div class="card">
            <h4>Perulangan While</h4>
            <form method="post">
                <label>Masukkan angka batas (While):</label>
                <input type="text" name="while_data" value="<?= htmlspecialchars($input['while_data']); ?>" placeholder="Contoh: 3">
                <button class="btn" type="submit">Jalankan</button>
            </form>
            <div class="loops">
                <?php
                if($input['while_data'] && is_numeric($input['while_data'])){
                    $i=1;
                    while($i<=$input['while_data']){
                        echo $i." ";
                        $i++;
                    }
                }
                ?>
            </div>
        </div>

        <div class="card">
            <h4>Perulangan Dowhile</h4>
            <form method="post">
                <label>Masukkan angka batas (DoWhile):</label>
                <input type="text" name="dowhile_data" value="<?= htmlspecialchars($input['dowhile_data']); ?>" placeholder="Contoh: 3">
                <button class="btn" type="submit">Jalankan</button>
            </form>
            <div class="loops">
                <?php
                if($input['dowhile_data'] && is_numeric($input['dowhile_data'])){
                    $j=1;
                    do{
                        echo $j." ";
                        $j++;
                    }while($j<=$input['dowhile_data']);
                }
                ?>
            </div>
        </div>
    </aside>
</div>
</body>
</html>
