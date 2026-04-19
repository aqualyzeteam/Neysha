<?php 
require 'config.php'; 

// Ambil poin terbaru jika sudah login
$points = 0;
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT points FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user_data = $stmt->fetch();
    if ($user_data) {
        $points = $user_data['points'];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aqualyze - Save Water, Save Life</title>
    
    <link rel="icon" type="image/png" href="favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Quicksand', sans-serif; scroll-behavior: smooth; overflow-x: hidden; }

        /* Background Hero - TETAP SAMA */
        .hero-bg {
            background: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.8)), 
                        url('bg-hero.png'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* --- PERBAIKAN SIDEBAR --- */
        #menu-mobile {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            width: 280px; /* Lebar sidebar */
            background: #0f172a; /* Biru Gelap Solid */
            z-index: 2000;
            transform: translateX(100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            padding: 80px 2rem 2rem 2rem;
            box-shadow: -10px 0 25px rgba(0,0,0,0.5);
        }
        #menu-mobile.active { transform: translateX(0); }

        .overlay-bg {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            backdrop-blur: sm;
            z-index: 1500;
            display: none;
        }
        .overlay-bg.active { display: block; }
        /* ----------------------- */

        .transition-all { transition: all 0.3s ease; }
        .btn-glow:hover { box-shadow: 0 0 20px rgba(59, 130, 246, 0.6); }
    </style>
</head>
<body class="bg-white">

    <div id="overlay" class="overlay-bg" onclick="toggleMenu()"></div>

    <nav class="flex justify-between items-center px-6 md:px-20 py-6 bg-transparent absolute w-full z-[100]">
        <div class="text-2xl font-bold text-white tracking-widest flex items-center gap-2">
            <span class="text-blue-400 text-3xl">💧</span> AQUALYZE
        </div>

        <button onclick="toggleMenu()" class="md:hidden text-white z-[2500] p-2 bg-blue-900/40 rounded-xl border border-white/10">
            <svg id="hamb-icon" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>

        <div class="hidden md:flex space-x-8 text-white text-sm font-semibold">
            <a href="index.php" class="text-blue-400">HOME</a>
            <a href="about.php" class="hover:text-blue-400 transition-all">ABOUT</a>
            <a href="tips.php" class="hover:text-blue-400 transition-all">TIPS</a>
            <a href="challenge.php" class="hover:text-blue-400 transition-all">CHALLENGE</a>
            
            <?php if(isset($_SESSION['username'])): ?>
                <div class="flex items-center gap-6 border-l border-white/20 pl-6">
                    <div class="text-right">
                        <p class="text-[9px] text-blue-300 uppercase font-black">✨ <?php echo $points; ?> PTS</p>
                        <p class="text-sm text-white font-bold"><?php echo htmlspecialchars($_SESSION['username']); ?></p>
                    </div>
                    <a href="logout.php" class="bg-red-500 px-4 py-1.5 rounded-lg text-[10px] font-black uppercase">Logout</a>
                </div>
            <?php else: ?>
                <a href="login.php" class="border border-white/50 px-6 py-1.5 rounded-full hover:bg-white hover:text-blue-900 transition-all">LOGIN</a>
            <?php endif; ?>
        </div>
    </nav>

    <div id="menu-mobile">
        <div class="flex flex-col space-y-6">
            <a href="index.php" class="text-blue-400 text-xl font-bold border-b border-white/5 pb-2">HOME</a>
            <a href="about.php" class="text-white text-xl font-bold border-b border-white/5 pb-2">ABOUT</a>
            <a href="tips.php" class="text-white text-xl font-bold border-b border-white/5 pb-2">TIPS</a>
            <a href="challenge.php" class="text-white text-xl font-bold border-b border-white/5 pb-2">CHALLENGE</a>
            
            <div class="pt-4">
                <?php if(isset($_SESSION['username'])): ?>
                    <div class="bg-blue-900/30 p-4 rounded-2xl border border-blue-500/20 mb-6">
                        <p class="text-xs text-blue-300 uppercase font-bold">Player</p>
                        <p class="text-white font-black"><?php echo htmlspecialchars($_SESSION['username']); ?></p>
                        <p class="text-sm text-yellow-400 mt-2">✨ <?php echo $points; ?> Points</p>
                    </div>
                    <a href="logout.php" class="block w-full bg-red-500 text-white text-center py-3 rounded-xl font-black">LOGOUT</a>
                <?php else: ?>
                    <a href="login.php" class="block w-full bg-blue-600 text-white text-center py-4 rounded-xl font-black">LOGIN</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <header class="hero-bg h-screen flex flex-col justify-center px-6 md:px-24 relative">
        <div class="max-w-4xl text-white z-10">
            <div class="inline-block px-4 py-1 mb-6 text-xs font-bold tracking-widest text-blue-400 uppercase bg-blue-900/40 border border-blue-500/30 rounded-full">
                Water Conservation Project
            </div>
            <h1 class="text-6xl md:text-9xl font-black leading-none uppercase tracking-tighter italic">
                Save Water,<br><span class="text-blue-500">Save Life</span>
            </h1>
            <p class="text-lg md:text-2xl mt-8 text-slate-300 max-w-xl leading-relaxed">
                Lacak penggunaan air harianmu dan mulailah membangun kebiasaan yang lebih cerdas untuk masa depan bumi.
            </p>
            <div class="mt-10 flex flex-wrap gap-4">
                <?php if(!isset($_SESSION['username'])): ?>
                    <a href="login.php" class="bg-blue-600 hover:bg-blue-700 text-white font-black py-4 px-12 rounded-2xl shadow-2xl transition-all transform hover:-translate-y-1 btn-glow text-center w-full md:w-auto uppercase tracking-wider">
                        Gabung Sekarang
                    </a>
                <?php else: ?>
                    <a href="challenge.php" class="bg-blue-600 hover:bg-blue-700 text-white font-black py-4 px-12 rounded-2xl shadow-2xl transition-all transform hover:-translate-y-1 btn-glow text-center w-full md:w-auto uppercase tracking-wider">
                        Mulailah Challenge
                    </a>
                <?php endif; ?>
                
                <a href="calculator.php" class="bg-white/10 backdrop-blur-md hover:bg-white/20 text-white font-bold py-4 px-10 rounded-2xl border border-white/20 transition-all text-center w-full md:w-auto">
                    Cek Penggunaan Air 📊
                </a>
            </div>
        </div>
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 text-white/30 animate-bounce hidden md:block">
            <span class="text-sm font-bold tracking-widest uppercase">Scroll Down</span>
        </div>
    </header>

    <section class="bg-slate-900 py-24 px-6 md:px-24">
        <div class="max-w-5xl mx-auto text-center">
            <p class="text-blue-100 text-xl md:text-4xl font-semibold leading-tight italic">
                "Setiap tetes yang kamu hemat hari ini adalah napas bagi kehidupan di masa depan."
            </p>
            <div class="h-1.5 w-24 bg-blue-500 mx-auto mt-10 rounded-full"></div>
        </div>
    </section>

    <section class="bg-blue-50 py-24 px-6 md:px-24">
        <div class="max-w-6xl mx-auto text-center md:text-left">
            <h2 class="text-5xl font-black text-slate-800 tracking-tight uppercase italic mb-16">Mulai Perjalananmu</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <a href="calculator.php" class="bg-white p-10 rounded-[2.5rem] shadow-xl border-b-8 border-transparent hover:border-blue-500 transition-all group transform hover:-translate-y-2">
                    <div class="bg-blue-100 w-20 h-20 rounded-3xl flex items-center justify-center text-4xl mb-8 group-hover:bg-blue-600 group-hover:text-white transition-all">🧮</div>
                    <h3 class="text-2xl font-black text-slate-800 mb-3 uppercase">Calculator</h3>
                    <p class="text-slate-500 leading-relaxed">Hitung pemakaian air harianmu berdasarkan aktivitas mandi secara detail.</p>
                </a>
                <a href="tips.php" class="bg-white p-10 rounded-[2.5rem] shadow-xl border-b-8 border-transparent hover:border-yellow-500 transition-all group transform hover:-translate-y-2">
                    <div class="bg-yellow-100 w-20 h-20 rounded-3xl flex items-center justify-center text-4xl mb-8 group-hover:bg-yellow-500 group-hover:text-white transition-all">💡</div>
                    <h3 class="text-2xl font-black text-slate-800 mb-3 uppercase">Tips & Trick</h3>
                    <p class="text-slate-500 leading-relaxed">Pelajari cara praktis untuk menghemat air di rumah tanpa mengurangi kenyamanan.</p>
                </a>
                <a href="challenge.php" class="bg-white p-10 rounded-[2.5rem] shadow-xl border-b-8 border-transparent hover:border-red-500 transition-all group transform hover:-translate-y-2">
                    <div class="bg-red-100 w-20 h-20 rounded-3xl flex items-center justify-center text-4xl mb-8 group-hover:bg-red-500 group-hover:text-white transition-all">🚩</div>
                    <h3 class="text-2xl font-black text-slate-800 mb-3 uppercase">Daily Challenge</h3>
                    <p class="text-slate-500 leading-relaxed">Ikuti tantangan harian dan kumpulkan poin sebagai bukti kepedulianmu!</p>
                </a>
            </div>
        </div>
    </section>

    <footer class="bg-white py-12 text-center border-t border-slate-100">
        <p class="text-slate-400 font-bold text-[10px] uppercase tracking-[0.3em]">&copy; 2026 Aqualyze Project.</p>
    </footer>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('menu-mobile');
            const overlay = document.getElementById('overlay');
            const icon = document.getElementById('hamb-icon');

            menu.classList.toggle('active');
            overlay.classList.toggle('active');

            if (menu.classList.contains('active')) {
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
            } else {
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>';
            }
        }
    </script>
</body>
</html>
