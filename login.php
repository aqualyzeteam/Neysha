<?php
require 'config.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$user]);
    $user_data = $stmt->fetch();

    if ($user_data && password_verify($pass, $user_data['password'])) {
        $_SESSION['user_id'] = $user_data['id'];
        $_SESSION['username'] = $user_data['username'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Aqualyze - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Quicksand', sans-serif; background-color: #0f172a; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen text-white">
    <div class="bg-slate-800 p-10 rounded-[2.5rem] shadow-2xl w-full max-w-md border border-white/10">
        <div class="text-center mb-8">
            <span class="text-4xl text-blue-500">💧</span>
            <h1 class="text-3xl font-black italic uppercase mt-4">Welcome Back</h1>
            <p class="text-slate-400 text-sm">Masuk untuk lanjut menghemat air</p>
        </div>

        <?php if($error): ?>
            <div class="bg-red-500/20 text-red-400 p-4 rounded-xl mb-6 text-center font-bold text-sm border border-red-500/30">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <input type="text" name="username" placeholder="USERNAME" required class="w-full bg-slate-900 border border-slate-700 rounded-2xl px-5 py-4 focus:border-blue-500 transition-all outline-none uppercase font-bold text-sm tracking-widest">
            <input type="password" name="password" placeholder="PASSWORD" required class="w-full bg-slate-900 border border-slate-700 rounded-2xl px-5 py-4 focus:border-blue-500 transition-all outline-none font-bold text-sm tracking-widest">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-black py-4 rounded-2xl uppercase tracking-widest transition-all shadow-lg shadow-blue-600/30 transform hover:-translate-y-1">Login</button>
        </form>

        <p class="text-center mt-8 text-slate-500 text-sm font-bold">
            Belum ikut tantangan? <a href="register.php" class="text-blue-400 hover:underline">Daftar Gratis</a>
        </p>
    </div>
</body>
</html>
