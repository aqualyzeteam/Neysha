<?php require 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aqualyze - Tips Bijak Air</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Quicksand', sans-serif; scroll-behavior: smooth; overflow-x: hidden; }
        
        .gradient-dark { 
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); 
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(59, 130, 246, 0.1), 0 10px 10px -5px rgba(59, 130, 246, 0.04);
        }
        
        .transition-all { transition: all 0.3s ease; }

        /* --- SIDEBAR SYSTEM --- */
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
            border-left: 1px solid rgba(255,255,255,0.1);
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
<body class="bg-slate-50">

    <div id="overlay" class="overlay-bg" onclick="toggleMenu()"></div>

    <nav class="flex justify-between items-center px-6 md:px-20 py-6 bg-slate-900 shadow-xl sticky top-0 z-50">
        <div class="text-2xl font-bold text-white tracking-widest flex items-center gap-2">
            <span class="text-blue-400 text-3xl">💧</span> AQUALYZE
        </div>
        
        <div class="hidden md:flex space-x-8 font-bold text-slate-300">
            <a href="index.php" class="hover:text-blue-400 transition-all">Home</a>
            <a href="calculator.php" class="hover:text-blue-400 transition-all">Calculator</a>
            <a href="challenge.php" class="hover:text-blue-400 transition-all">Challenge</a>
            <a href="tips.php" class="text-blue-400 transition-all">Tips</a>
        </div>

        <div class="flex items-center gap-4">
            <div class="hidden md:block">
                 <?php if(isset($_SESSION['username'])): ?>
                    <span class="text-blue-400 font-bold bg-blue-900/30 px-4 py-1.5 rounded-lg border border-blue-500/30">
                        HI, <?php echo strtoupper(htmlspecialchars($_SESSION['username'])); ?>
                    </span>
                <?php else: ?>
                    <a href="login.php" class="bg-blue-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-blue-700 transition-all text-sm uppercase">Login</a>
                <?php endif; ?>
            </div>

            <button onclick="toggleMenu()" class="md:hidden text-white z-[2500] p-2 bg-slate-800 rounded-xl">
                <svg id="hamb-icon" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>
    </nav>

    <div id="menu-mobile">
        <div class="flex flex-col space-y-6">
            <a href="index.php" class="text-white text-xl font-bold border-b border-white/5 pb-2">HOME</a>
            <a href="calculator.php" class="text-white text-xl font-bold border-b border-white/5 pb-2">CALCULATOR</a>
            <a href="challenge.php" class="text-white text-xl font-bold border-b border-white/5 pb-2">CHALLENGE</a>
            <a href="tips.php" class="text-blue-400 text-xl font-bold border-b border-white/5 pb-2">TIPS</a>
            
            <div class="pt-4">
                <?php if(isset($_SESSION['username'])): ?>
                    <p class="text-blue-300 font-bold mb-4 uppercase text-xs tracking-widest">Player: <?php echo htmlspecialchars($_SESSION['username']); ?></p>
                    <a href="logout.php" class="block w-full bg-red-500 text-white text-center py-3 rounded-xl font-black italic">LOGOUT</a>
                <?php else: ?>
                    <a href="login.php" class="block w-full bg-blue-600 text-white text-center py-4 rounded-xl font-black">LOGIN</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <header class="gradient-dark py-24 px-6 text-center text-white relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/></pattern></defs>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
        </div>
        <div class="relative z-10">
            <span class="text-blue-400 font-black tracking-[0.3em] uppercase text-sm">Save Water Save Earth</span>
            <h1 class="text-5xl md:text-7xl font-black mb-6 mt-2 italic uppercase tracking-tighter">Kenapa <span class="text-blue-500">Setiap Tetesan</span> Berarti?</h1>
            <p class="text-slate-400 max-w-2xl mx-auto text-lg md:text-xl leading-relaxed">Hanya 3% air di bumi yang bisa dikonsumsi. Satu langkah kecil darimu adalah harapan besar bagi masa depan.</p>
        </div>
    </header>

    <section class="max-w-6xl mx-auto px-6 -mt-12 relative z-20">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-left">
            <div class="bg-white p-8 rounded-[2rem] shadow-2xl border-t-4 border-blue-500 card-hover transition-all">
                <div class="text-4xl mb-4">🛡️</div>
                <h3 class="font-black text-slate-800 text-lg mb-2 uppercase">Cadangan</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Mencegah krisis air bersih saat populasi terus bertambah pesat.</p>
            </div>
            <div class="bg-white p-8 rounded-[2rem] shadow-2xl border-t-4 border-cyan-400 card-hover transition-all">
                <div class="text-4xl mb-4">⚖️</div>
                <h3 class="font-black text-slate-800 text-lg mb-2 uppercase">Keseimbangan</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Menjaga agar produksi dan kebutuhan air tetap stabil terkendali.</p>
            </div>
            <div class="bg-white p-8 rounded-[2rem] shadow-2xl border-t-4 border-green-400 card-hover transition-all">
                <div class="text-4xl mb-4">🌿</div>
                <h3 class="font-black text-slate-800 text-lg mb-2 uppercase">Ekosistem</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Memberi ruang hidup bagi hewan dan tumbuhan di seluruh bumi.</p>
            </div>
            <div class="bg-white p-8 rounded-[2rem] shadow-2xl border-t-4 border-yellow-400 card-hover transition-all">
                <div class="text-4xl mb-4">💰</div>
                <h3 class="font-black text-slate-800 text-lg mb-2 uppercase">Hemat Biaya</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Tagihan air dan listrik menurun drastis setiap bulan secara nyata.</p>
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-6 py-20">
        <div class="bg-slate-900 border-2 border-red-500/30 p-10 rounded-[2.5rem] flex flex-col md:flex-row items-center gap-10">
            <div class="bg-red-500/20 text-red-500 w-24 h-24 rounded-full flex items-center justify-center text-5xl animate-pulse">⚠️</div>
            <div class="text-center md:text-left">
                <h2 class="text-3xl font-black text-white mb-4 uppercase italic">Risiko Jika Kita Abaikan!</h2>
                <p class="text-slate-400 text-lg leading-relaxed max-w-3xl">
                    Tanpa penghematan, generasi mendatang mungkin kehilangan akses air bersih. Ekosistem akan rusak, dan energi berkelanjutan seperti PLTA tidak akan bisa beroperasi secara maksimal.
                </p>
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-6 py-10">
        <h2 class="text-5xl font-black text-slate-800 text-center mb-16 italic uppercase tracking-tighter">Tips Menghemat Air</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-16">
            <div class="flex gap-8 group">
                <div class="bg-slate-900 text-blue-400 w-20 h-20 shrink-0 rounded-3xl flex items-center justify-center text-2xl font-black group-hover:bg-blue-600 group-hover:text-white transition-all shadow-xl">01</div>
                <div>
                    <h3 class="text-2xl font-black text-slate-800 mb-3 flex items-center gap-2 uppercase tracking-tight">🚿 Mandi Cerdas</h3>
                    <p class="text-slate-500 text-base leading-relaxed italic">Ganti bak dengan shower. Matikan kran saat memakai sabun agar air tidak terbuang sia-sia.</p>
                </div>
            </div>

            <div class="flex gap-8 group">
                <div class="bg-slate-900 text-blue-400 w-20 h-20 shrink-0 rounded-3xl flex items-center justify-center text-2xl font-black group-hover:bg-blue-600 group-hover:text-white transition-all shadow-xl">02</div>
                <div>
                    <h3 class="text-2xl font-black text-slate-800 mb-3 flex items-center gap-2 uppercase tracking-tight">🧺 Cuci Kolektif</h3>
                    <p class="text-slate-500 text-base leading-relaxed italic">Cuci baju dalam jumlah banyak sekaligus. Ini menghemat air mesin cuci dan tagihan listrik.</p>
                </div>
            </div>

            <div class="flex gap-8 group">
                <div class="bg-slate-900 text-blue-400 w-20 h-20 shrink-0 rounded-3xl flex items-center justify-center text-2xl font-black group-hover:bg-blue-600 group-hover:text-white transition-all shadow-xl">03</div>
                <div>
                    <h3 class="text-2xl font-black text-slate-800 mb-3 flex items-center gap-2 uppercase tracking-tight">🔧 Cek Kebocoran</h3>
                    <p class="text-slate-500 text-base leading-relaxed italic">Jangan abaikan tetesan kecil. Tampung tetesan dengan ember untuk menyiram tanaman rumah.</p>
                </div>
            </div>

            <div class="flex gap-8 group">
                <div class="bg-slate-900 text-blue-400 w-20 h-20 shrink-0 rounded-3xl flex items-center justify-center text-2xl font-black group-hover:bg-blue-600 group-hover:text-white transition-all shadow-xl">04</div>
                <div>
                    <h3 class="text-2xl font-black text-slate-800 mb-3 flex items-center gap-2 uppercase tracking-tight">🚗 Jadwal Siram</h3>
                    <p class="text-slate-500 text-base leading-relaxed italic">Siram tanaman di pagi/sore hari. Gunakan semprotan selang dengan fitur auto-off.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-slate-900 py-24 px-6 mt-20 text-white overflow-hidden relative">
        <div class="max-w-6xl mx-auto relative z-10">
            <h2 class="text-5xl font-black mb-16 text-center italic uppercase tracking-tighter">Investasi <span class="text-blue-500">Hijau</span></h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white/5 p-10 rounded-[2.5rem] border border-white/10 backdrop-blur-sm hover:bg-white/10 transition-all">
                    <h4 class="font-black text-blue-400 text-xl mb-4 uppercase tracking-widest">Aerator Keran</h4>
                    <p class="text-slate-400 leading-relaxed">Alat kecil pembatas aliran agar penggunaan air lebih efektif tanpa mengurangi tekanan.</p>
                </div>
                <div class="bg-white/5 p-10 rounded-[2.5rem] border border-white/10 backdrop-blur-sm hover:bg-white/10 transition-all">
                    <h4 class="font-black text-blue-400 text-xl mb-4 uppercase tracking-widest">Sistem Filter</h4>
                    <p class="text-slate-400 leading-relaxed">Manfaatkan air rumah untuk konsumsi. Jauh lebih hemat daripada beli air galon mingguan.</p>
                </div>
                <div class="bg-white/5 p-10 rounded-[2.5rem] border border-white/10 backdrop-blur-sm hover:bg-white/10 transition-all">
                    <h4 class="font-black text-blue-400 text-xl mb-4 uppercase tracking-widest">Eco Tumblr</h4>
                    <p class="text-slate-400 leading-relaxed">Kurangi botol plastik sekali pakai yang seringkali merusak kualitas sumber air tanah.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-white py-12 text-center text-slate-400 font-bold uppercase tracking-widest text-xs border-t">
        &copy; 2026 Aqualyze Project - Made with 💙 for the Earth.
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
