<?php 
require 'config.php'; 

// Keamanan: Jika belum Day 7, tidak bisa akses halaman ini
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->prepare("SELECT username, streak FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if ($user['streak'] < 7) {
    echo "Selesaikan tantangan 7 hari dulu ya!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat Water Hero - <?php echo htmlspecialchars($user['username']); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@700&family=Playfair+Display:ital,wght@1,700&display=swap" rel="stylesheet">
    <style>
        body { background-color: #0f172a; font-family: 'Quicksand', sans-serif; }
        .cert-border {
            border: 20px solid #1e3a8a;
            border-image: linear-gradient(to bottom right, #1e40af, #60a5fa) 1;
        }
        @media print {
            .no-print { display: none; }
            body { background-color: white; }
            .cert-card { shadow: none; border: 10px solid #1e3a8a; }
        }
    </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen p-6">

    <div class="no-print mb-8 flex gap-4">
        <a href="challenge.php" class="bg-slate-700 text-white px-6 py-2 rounded-full font-bold text-sm hover:bg-slate-600 transition-all">← Kembali</a>
        <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-2 rounded-full font-bold text-sm hover:bg-blue-500 transition-all">Cetak Sertifikat 🖨️</button>
    </div>

    <div class="cert-card bg-white p-16 max-w-4xl w-full text-center relative shadow-[0_20px_50px_rgba(0,0,0,0.5)] cert-border">
        <div class="absolute inset-0 flex items-center justify-center opacity-[0.03] pointer-events-none">
            <span class="text-[250px]">💧</span>
        </div>

        <h3 class="text-blue-900 text-xl font-black tracking-[0.5em] uppercase mb-2">Aqualyze Project</h3>
        <div class="w-20 h-1 bg-blue-500 mx-auto mb-10"></div>

        <h1 class="text-6xl font-serif italic text-slate-800 mb-6" style="font-family: 'Playfair Display', serif;">Certificate of Achievement</h1>
        
        <p class="text-xl text-slate-500 mb-2">Dengan bangga mempersembahkan gelar **Water Hero** kepada:</p>
        
        <h2 class="text-5xl font-black text-blue-700 my-8 uppercase tracking-tight decoration-blue-200 underline underline-offset-8">
            <?php echo htmlspecialchars($user['username']); ?>
        </h2>

        <p class="text-lg text-slate-600 leading-relaxed max-w-2xl mx-auto">
            Atas dedikasi dan keberhasilannya menyelesaikan <strong>7 Hari Tantangan Konservasi Air</strong>. 
            Telah terbukti berkomitmen dalam menjaga kelestarian air demi masa depan bumi yang lebih hijau.
        </p>

        <div class="mt-20 flex justify-between items-end px-10">
            <div class="text-left">
                <p class="text-slate-400 text-xs uppercase font-bold tracking-widest">ID Sertifikat</p>
                <p class="text-slate-800 font-mono font-bold">AQZ-<?php echo strtoupper(substr(md5($user['username']), 0, 8)); ?></p>
            </div>
            
            <div class="text-center">
                <div class="text-blue-500 text-4xl mb-2">💧</div>
                <p class="text-slate-800 font-black uppercase text-sm tracking-tighter italic">Nesyha Fadhila S </p>
                <p class="text-slate-400 text-[10px] uppercase font-bold tracking-widest">Chief Aqualyze Project</p>
            </div>

            <div class="text-right">
                <p class="text-slate-400 text-xs uppercase font-bold tracking-widest">Diterbitkan Pada</p>
                <p class="text-slate-800 font-bold"><?php echo date('d F 2026'); ?></p>
            </div>
        </div>
    </div>

    <p class="no-print text-slate-500 text-xs mt-10 uppercase tracking-[0.3em] font-bold">Sertifikat ini divalidasi oleh sistem Aqualyze secara otomatis.</p>

</body>
</html>
