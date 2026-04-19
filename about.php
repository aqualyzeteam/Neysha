<?php require 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Aqualyze - Our Mission</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Quicksand', sans-serif; overflow-x: hidden; }
        .bg-water {
            background: linear-gradient(rgba(30, 58, 138, 0.8), rgba(30, 58, 138, 0.9)), 
                        url('https://images.unsplash.com/photo-1527067829737-402993088e8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
        }

        /* --- CSS SIDEBAR (Sama dengan Index) --- */
        #menu-mobile {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            width: 280px;
            background: #0f172a;
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
            z-index: 1500;
            display: none;
        }
        .overlay-bg.active { display: block; }
    </style>
</head>
<body class="bg-white text-slate-800">

    <div id="overlay" class="overlay-bg" onclick="toggleMenu()"></div>

    <nav class="flex justify-between items-center px-6 md:px-20 py-6 sticky top-0 bg-white/90 backdrop-blur-md z-50 border-b border-slate-100">
        <div class="text-2xl font-bold text-blue-900 tracking-widest flex items-center gap-2">
            <span class="text-blue-500 text-3xl">💧</span> AQUALYZE
        </div>
        
        <div class="hidden md:flex space-x-8 font-semibold text-slate-600">
            <a href="index.php" class="hover:text-blue-500">Home</a>
            <a href="calculator.php" class="hover:text-blue-500">Calculator</a>
            <a href="challenge.php" class="hover:text-blue-500">Challenge</a>
            <a href="tips.php" class="hover:text-blue-500">Tips</a>
        </div>

        <div class="flex items-center gap-4">
            <?php if(isset($_SESSION['username'])): ?>
                <div class="text-right hidden md:block border-l-2 border-blue-100 pl-4">
                    <p class="text-[10px] font-bold text-slate-400 uppercase leading-none">Online</p>
                    <p class="font-bold text-blue-600 text-sm"><?php echo htmlspecialchars($_SESSION['username']); ?></p>
                </div>
                <a href="logout.php" class="hidden md:block text-xs font-bold text-red-400 hover:text-red-600">Logout</a>
            <?php else: ?>
                <a href="login.php" class="hidden md:block bg-blue-600 text-white px-6 py-2 rounded-xl font-bold text-sm shadow-md hover:bg-blue-700 transition">Login</a>
            <?php endif; ?>

            <button onclick="toggleMenu()" class="md:hidden text-blue-900 z-[2500] p-2 bg-blue-50 rounded-xl">
                <svg id="hamb-icon" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>
    </nav>

    <div id="menu-mobile">
        <div class="flex flex-col space-y-6">
            <a href="index.php" class="text-white text-xl font-bold border-b border-white/5 pb-2">HOME</a>
            <a href="about.php" class="text-blue-400 text-xl font-bold border-b border-white/5 pb-2">ABOUT</a>
            <a href="calculator.php" class="text-white text-xl font-bold border-b border-white/5 pb-2">CALCULATOR</a>
            <a href="challenge.php" class="text-white text-xl font-bold border-b border-white/5 pb-2">CHALLENGE</a>
            <a href="tips.php" class="text-white text-xl font-bold border-b border-white/5 pb-2">TIPS</a>
            
            <div class="pt-4">
                <?php if(isset($_SESSION['username'])): ?>
                    <p class="text-blue-300 font-bold mb-4 uppercase text-xs tracking-widest"><?php echo htmlspecialchars($_SESSION['username']); ?></p>
                    <a href="logout.php" class="block w-full bg-red-500 text-white text-center py-3 rounded-xl font-black">LOGOUT</a>
                <?php else: ?>
                    <a href="login.php" class="block w-full bg-blue-600 text-white text-center py-4 rounded-xl font-black">LOGIN</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <section class="bg-water py-24 px-6 text-center text-white">
        <h1 class="text-4xl md:text-6xl font-bold mb-6">Misi Kami untuk Bumi</h1>
        <p class="text-blue-100 max-w-2xl mx-auto text-lg leading-relaxed">
            Menumbuhkan kesadaran dan mengubah kebiasaan kecil menjadi dampak besar bagi ketersediaan air bersih di masa depan.
        </p>
    </section>

    <section class="max-w-6xl mx-auto py-20 px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            <div class="order-2 md:order-1">
                <span class="text-blue-500 font-bold uppercase tracking-widest text-sm">Realita Saat Ini</span>
                <h2 class="text-3xl md:text-4xl font-bold mt-2 mb-6 text-slate-900">Kenapa Kita Harus Khawatir?</h2>
                <p class="text-slate-600 leading-relaxed mb-6">
                    Air adalah sumber daya paling vital, namun seringkali kita tidak bijak menggunakannya. Tanpa disadari, kebiasaan seperti membiarkan keran menyala saat sikat gigi atau mandi terlalu lama membuang ribuan liter air bersih secara cuma-cuma.
                </p>
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-100 text-red-600 rounded-full flex items-center justify-center font-bold">!</div>
                        <span class="text-slate-700 font-medium">Rendahnya kesadaran pengelolaan air efisien.</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-100 text-red-600 rounded-full flex items-center justify-center font-bold">!</div>
                        <span class="text-slate-700 font-medium">Potensi krisis air bersih bagi generasi mendatang.</span>
                    </div>
                </div>
            </div>
            <div class="order-1 md:order-2 bg-blue-50 p-10 rounded-[3rem] text-center">
                <div class="text-8xl mb-4">🚱</div>
                <blockquote class="italic text-slate-500 border-l-4 border-blue-200 pl-4 text-left">
                    "Kebiasaan kecil yang dilakukan terus-menerus akan menyebabkan pemborosan air dalam jumlah besar."
                </blockquote>
            </div>
        </div>
    </section>

    <section class="bg-blue-900 py-24 px-6">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-white text-3xl md:text-5xl font-bold mb-8 text-center">Hadir Sebagai Solusi</h2>
            <p class="text-blue-200 text-lg leading-relaxed mb-12">
                <strong>Aqualyze</strong> dikembangkan bukan hanya sebagai penyedia informasi, tapi sebagai alat interaktif yang membantu masyarakat mengontrol penggunaan air secara efektif dan berkelanjutan.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white/10 backdrop-blur-md p-8 rounded-3xl border border-white/10 hover:bg-white/20 transition">
                    <div class="text-4xl mb-4">🧮</div>
                    <h4 class="text-white font-bold mb-2">Edukasi</h4>
                    <p class="text-blue-200 text-xs">Menyediakan data akurat mengenai konsumsi air harian.</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md p-8 rounded-3xl border border-white/10 hover:bg-white/20 transition">
                    <div class="text-4xl mb-4">🎮</div>
                    <h4 class="text-white font-bold mb-2">Interaksi</h4>
                    <p class="text-blue-200 text-xs">Melibatkan pengguna lewat tantangan harian.</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md p-8 rounded-3xl border border-white/10 hover:bg-white/20 transition">
                    <div class="text-4xl mb-4">♻️</div>
                    <h4 class="text-white font-bold mb-2">Perubahan</h4>
                    <p class="text-blue-200 text-xs">Mendorong perubahan kebiasaan secara bertahap.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto py-24 px-6 text-center">
        <h2 class="text-3xl font-bold mb-16">Apa yang Bisa Kamu Lakukan?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <a href="calculator.php" class="group block p-6 rounded-3xl hover:bg-slate-50 transition-all">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center text-3xl mx-auto mb-6 group-hover:bg-blue-500 group-hover:text-white transition-all">🧮</div>
                <h3 class="font-bold text-xl mb-3 text-slate-800 tracking-tight">Usage Calculator</h3>
                <p class="text-slate-500 text-sm italic">Cari tahu apakah penggunaan airmu termasuk Hemat, Normal, atau Boros secara instan.</p>
            </a>
            <a href="tips.php" class="group block p-6 rounded-3xl hover:bg-slate-50 transition-all">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center text-3xl mx-auto mb-6 group-hover:bg-green-500 group-hover:text-white transition-all">💡</div>
                <h3 class="font-bold text-xl mb-3 text-slate-800 tracking-tight">Saving Tips</h3>
                <p class="text-slate-500 text-sm italic">Panduan praktis dan sederhana yang bisa langsung kamu terapkan di rumah hari ini.</p>
            </a>
            <a href="challenge.php" class="group block p-6 rounded-3xl hover:bg-slate-50 transition-all">
                <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center text-3xl mx-auto mb-6 group-hover:bg-yellow-500 group-hover:text-white transition-all">🚩</div>
                <h3 class="font-bold text-xl mb-3 text-slate-800 tracking-tight">Challenge Section</h3>
                <p class="text-slate-500 text-sm italic">Selesaikan tantangan bertahap untuk membangun komitmen menjaga air bersih.</p>
            </a>
        </div>
    </section>

    <section class="py-20 px-6 text-center bg-slate-50">
        <div class="max-w-2xl mx-auto">
            <h2 class="text-2xl font-bold mb-6 italic text-slate-700">"Bersama Aqualyze, mari jaga setiap tetesnya untuk masa depan."</h2>
            <a href="calculator.php" class="inline-block bg-blue-600 text-white font-bold py-4 px-10 rounded-2xl shadow-lg hover:bg-blue-700 transition">Coba Kalkulator Sekarang</a>
        </div>
    </section>

    <footer class="py-10 text-center border-t border-slate-100 text-slate-400 text-sm">
        &copy; 2026 Aqualyze Project - Education for Sustainability
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
