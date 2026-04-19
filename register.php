<?php
require 'config.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        if ($stmt->execute([$user, $pass])) {
            $message = "Registrasi berhasil! Silakan login.";
        }
    } catch (PDOException $e) {
        $message = "Username sudah terdaftar!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Aqualyze - Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Quicksand', sans-serif; background-color: #0f172a; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="bg-slate-800 p-10 rounded-[2.5rem] shadow-2xl w-full max-w-md border border-white/10">
        <div class="text-center mb-8">
            <span class="text-4xl">💧</span>
            <h1 class="text-3xl font-black text-white italic uppercase mt-4">Join Aqualyze</h1>
            <p class="text-slate-400 text-sm">Mulai langkah kecilmu hari ini</p>
        </div>

        <?php if($message): ?>
            <div class="bg-blue-600/20 text-blue-400 p-4 rounded-xl mb-6 text-center font-bold text-sm border border-blue-500/30">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div>
                <label class="block text-slate-400 text-xs font-bold uppercase mb-2 ml-1">Username</label>
                <input type="text" name="username" required class="w-full bg-slate-900 border border-slate-700 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-blue-500 transition-all">
            </div>
            <div>
                <label class="block text-slate-400 text-xs font-bold uppercase mb-2 ml-1">Password</label>
                <input type="password" name="password" required class="w-full bg-slate-900 border border-slate-700 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-blue-500 transition-all">
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-black py-4 rounded-2xl uppercase tracking-widest transition-all shadow-lg shadow-blue-600/20">Daftar Sekarang</button>
        </form>
        
        <p class="text-center mt-8 text-slate-500 text-sm">
            Sudah punya akun? <a href="login.php" class="text-blue-400 font-bold hover:underline">Login di sini</a>
        </p>
    </div>
</body>
</html>
