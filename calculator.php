<?php require 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aqualyze - Detail Calculator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Quicksand', sans-serif; overflow-x: hidden; }
        .gauge-wrapper {
            position: relative;
            width: 280px;
            height: 140px;
            background: #e2e8f0;
            border-radius: 150px 150px 0 0;
            overflow: hidden;
            margin: 20px auto;
        }
        #gauge-fill {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: #22c55e;
            transform-origin: bottom center;
            transform: rotate(0deg);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .gauge-center {
            position: absolute;
            bottom: 0; left: 50%;
            transform: translateX(-50%);
            width: 80%; height: 80%;
            background: white;
            border-radius: 150px 150px 0 0;
            z-index: 10;
        }

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
<body class="bg-blue-50">

    <div id="overlay" class="overlay-bg" onclick="toggleMenu()"></div>

    <nav class="flex justify-between items-center px-6 md:px-20 py-6 bg-blue-900 text-white shadow-lg sticky top-0 z-50">
        <div class="text-2xl font-bold tracking-widest flex items-center gap-2">
            <span class="text-blue-400">💧</span> AQUALYZE
        </div>
        
        <div class="hidden md:flex space-x-8 font-semibold">
            <a href="index.php" class="hover:text-blue-400">Home</a>
            <a href="about.php" class="hover:text-blue-400">About</a>
            <a href="challenge.php" class="hover:text-blue-400">Challenge</a>
            <a href="tips.php" class="hover:text-blue-400">Tips</a>
        </div>

        <div class="flex items-center gap-4">
            <?php if(isset($_SESSION['username'])): ?>
                <div class="text-right hidden md:block border-r border-blue-700 pr-4">
                    <p class="text-[10px] font-bold text-blue-300 uppercase leading-none italic">Player</p>
                    <p class="font-bold text-white text-sm"><?php echo htmlspecialchars($_SESSION['username']); ?></p>
                </div>
                <a href="index.php" class="hidden md:block text-xs border border-blue-400 px-4 py-1.5 rounded-xl hover:bg-blue-800 transition">Kembali</a>
            <?php else: ?>
                <a href="login.php" class="hidden md:block bg-blue-500 text-white px-6 py-2 rounded-xl font-bold text-sm">Login</a>
            <?php endif; ?>

            <button onclick="toggleMenu()" class="md:hidden text-white z-[2500] p-2 bg-blue-800 rounded-xl">
                <svg id="hamb-icon" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>
    </nav>

    <div id="menu-mobile">
        <div class="flex flex-col space-y-6">
            <a href="index.php" class="text-white text-xl font-bold border-b border-white/5 pb-2">HOME</a>
            <a href="about.php" class="text-white text-xl font-bold border-b border-white/5 pb-2">ABOUT</a>
            <a href="calculator.php" class="text-blue-400 text-xl font-bold border-b border-white/5 pb-2">CALCULATOR</a>
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

    <main class="max-w-5xl mx-auto py-12 px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            
            <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-blue-100">
                <h2 class="text-2xl font-bold text-slate-800 mb-8 border-b pb-4">Water Usage Calculator</h2>
                
                <div class="space-y-8">
                    <div class="p-4 bg-slate-50 rounded-2xl">
                        <label class="block text-blue-900 font-bold mb-3 italic">1. Aktivitas Mandi</label>
                        <select id="mandi_method" class="w-full p-3 rounded-xl border-2 border-blue-100 mb-4 font-semibold text-slate-700 focus:outline-blue-400" onchange="hitungTotal()">
                            <option value="10">Shower (Standar 10L/menit)</option>
                            <option value="8">Shower Hemat (8L/menit)</option>
                            <option value="15">Shower Biasa (15L/menit)</option>
                            <option value="20">Ember (±20L per mandi)</option>
                        </select>
                        <div class="flex items-center gap-4">
                            <span class="text-sm text-slate-500 font-bold w-24">Durasi/Jumlah:</span>
                            <button onclick="changeVal('mandi_qty', -1)" class="w-10 h-10 bg-white shadow text-blue-600 rounded-xl font-bold border border-blue-100">-</button>
                            <input type="number" id="mandi_qty" value="10" class="w-16 text-center font-bold text-xl bg-transparent border-none">
                            <button onclick="changeVal('mandi_qty', 1)" class="w-10 h-10 bg-white shadow text-blue-600 rounded-xl font-bold border border-blue-100">+</button>
                            <span class="text-xs text-slate-400" id="unit_mandi">Menit</span>
                        </div>
                    </div>

                    <div class="p-4 bg-slate-50 rounded-2xl">
                        <label class="block text-blue-900 font-bold mb-3 italic">2. Cuci Tangan (2L/sekali)</label>
                        <div class="flex items-center gap-4">
                            <button onclick="changeVal('tangan', -1)" class="w-10 h-10 bg-white shadow text-blue-600 rounded-xl font-bold border border-blue-100">-</button>
                            <input type="number" id="tangan" value="5" class="w-16 text-center font-bold text-xl bg-transparent border-none">
                            <button onclick="changeVal('tangan', 1)" class="w-10 h-10 bg-white shadow text-blue-600 rounded-xl font-bold border border-blue-100">+</button>
                            <span class="text-xs text-slate-400">Kali cuci</span>
                        </div>
                    </div>

                    <div class="p-4 bg-slate-50 rounded-2xl">
                        <label class="block text-blue-900 font-bold mb-3 italic">3. Cuci Baju</label>
                        <select id="baju_method" class="w-full p-3 rounded-xl border-2 border-blue-100 mb-4 font-semibold text-slate-700" onchange="hitungTotal()">
                            <option value="0">Tidak cuci baju hari ini</option>
                            <option value="70">Mesin Cuci (Standar 70L)</option>
                            <option value="50">Mesin Cuci Hemat (50L)</option>
                            <option value="100">Mesin Cuci Biasa (100L)</option>
                            <option value="20">Manual (20L)</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-slate-50 rounded-2xl">
                            <label class="block text-blue-900 font-bold mb-3 text-sm italic">4. Cuci Piring (15L)</label>
                            <div class="flex items-center gap-2">
                                <button onclick="changeVal('piring', -1)" class="w-8 h-8 bg-white shadow rounded-lg font-bold border border-blue-100">-</button>
                                <input type="number" id="piring" value="2" class="w-10 text-center font-bold bg-transparent">
                                <button onclick="changeVal('piring', 1)" class="w-8 h-8 bg-white shadow rounded-lg font-bold border border-blue-100">+</button>
                            </div>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl">
                            <label class="block text-blue-900 font-bold mb-3 text-sm italic">5. Flush Toilet (6L)</label>
                            <div class="flex items-center gap-2">
                                <button onclick="changeVal('flush', -1)" class="w-8 h-8 bg-white shadow rounded-lg font-bold border border-blue-100">-</button>
                                <input type="number" id="flush" value="3" class="w-10 text-center font-bold bg-transparent">
                                <button onclick="changeVal('flush', 1)" class="w-8 h-8 bg-white shadow rounded-lg font-bold border border-blue-100">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="result-box" class="sticky top-24">
                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-blue-100 text-center">
                    <h3 class="text-slate-500 font-bold uppercase tracking-wider mb-2">Total Penggunaan Air</h3>
                    <div class="text-7xl font-black text-blue-600 mb-2"><span id="totalText">0</span> <small class="text-2xl text-slate-400 font-bold">L</small></div>
                    
                    <div class="gauge-wrapper">
                        <div id="gauge-fill"></div>
                        <div class="gauge-center flex flex-col items-center justify-end pb-2">
                            <span id="statusLabel" class="font-bold text-lg leading-none">Input Data</span>
                        </div>
                    </div>

                    <div id="feedback" class="mt-6 text-slate-600 font-medium px-4 min-h-[60px] italic">
                        Ubah data di samping untuk melihat hasil penggunaan air harianmu.
                    </div>

                    <div class="mt-6 grid grid-cols-3 gap-2 text-[10px] font-bold uppercase tracking-tighter">
                        <div class="text-green-600 bg-green-50 p-3 rounded-2xl border border-green-100">Hemat<br>< 100L</div>
                        <div class="text-orange-500 bg-orange-50 p-3 rounded-2xl border border-orange-100">Normal<br>100-200L</div>
                        <div class="text-red-600 bg-red-50 p-3 rounded-2xl border border-red-100">Boros<br>> 200L</div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <script>
        // FUNGSI SIDEBAR
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

        // FUNGSI KALKULATOR
        function changeVal(id, delta) {
            let input = document.getElementById(id);
            let val = parseInt(input.value) + delta;
            if(val < 0) val = 0;
            input.value = val;
            hitungTotal();
        }

        function hitungTotal() {
            const mandiMethod = parseInt(document.getElementById('mandi_method').value);
            const mandiQty = parseInt(document.getElementById('mandi_qty').value);
            const unitMandi = document.getElementById('unit_mandi');
            
            unitMandi.innerText = (mandiMethod === 20) ? "Kali Mandi" : "Menit";
            const totalMandi = mandiMethod * mandiQty;

            const tangan = parseInt(document.getElementById('tangan').value) * 2;
            const baju = parseInt(document.getElementById('baju_method').value);
            const piring = parseInt(document.getElementById('piring').value) * 15;
            const flush = parseInt(document.getElementById('flush').value) * 6;

            const total = totalMandi + tangan + baju + piring + flush;
            document.getElementById('totalText').innerText = total;

            const gauge = document.getElementById('gauge-fill');
            const statusLabel = document.getElementById('statusLabel');
            const feedback = document.getElementById('feedback');
            
            let rotation = (total / 300) * 180;
            if(rotation > 180) rotation = 180;
            gauge.style.transform = `rotate(${rotation}deg)`;

            if (total < 100) {
                gauge.style.background = "#22c55e";
                statusLabel.innerText = "HEMAT";
                statusLabel.style.color = "#22c55e";
                feedback.innerText = "Hebat! Kamu pahlawan air. Pertahankan konsumsi di bawah 100 liter.";
            } else if (total <= 200) {
                gauge.style.background = "#f59e0b";
                statusLabel.innerText = "NORMAL";
                statusLabel.style.color = "#f59e0b";
                feedback.innerText = "Penggunaan airmu masuk kategori wajar. Yuk, coba kurangi durasi mandi agar lebih hemat!";
            } else {
                gauge.style.background = "#ef4444";
                statusLabel.innerText = "BOROS";
                statusLabel.style.color = "#ef4444";
                feedback.innerText = "Peringatan! Konsumsimu melebihi 200 liter. Cek tips hemat air di halaman Tips.";
            }
        }
        window.onload = hitungTotal;
    </script>
</body>
</html>
