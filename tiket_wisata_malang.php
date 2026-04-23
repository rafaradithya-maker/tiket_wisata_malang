<?php
session_start();
// Jika belum login atau rolenya bukan user, lempar ke login
if (!isset($_SESSION['role']) || $_SESSION['role'] != "user") {
    header("location: ../admin_index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Malangans Travel - Pesan Tiket Wisata</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #020617; color: white; margin: 0; overflow-x: hidden; }
        
        /* Animasi Bintang */
        .star-container { position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: -2; }
        .star { position: absolute; background-color: white; border-radius: 50%; opacity: 0.3; animation: moveStar linear infinite; }
        @keyframes moveStar { from { transform: translateY(-100vh); } to { transform: translateY(100vh); } }
        
        /* Glassmorphism UI */
        .glass-panel { background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.1); }
        .ticket-card { background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.05); transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .ticket-card:hover { border-color: #3b82f6; background: rgba(59, 130, 246, 0.05); transform: translateY(-8px); }

        .input-travel { background: rgba(0, 0, 0, 0.4); border: 1px solid rgba(255, 255, 255, 0.1); color: white; transition: 0.3s; }
        .input-travel:focus { border-color: #3b82f6; outline: none; box-shadow: 0 0 15px rgba(59, 130, 246, 0.3); }
        
        .hidden-page { display: none !important; }
        .btn-primary { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); transition: 0.3s; }
        .btn-primary:hover { transform: scale(1.02); box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3); }
    </style>
</head>
<body class="min-h-screen relative flex flex-col">

    <div class="star-container" id="stars"></div>

    <section id="page-login" class="min-h-screen flex items-center justify-center p-6 transition-opacity duration-500">
        <div class="w-full max-w-md relative z-10 text-center">
            <div class="mb-10">
                <div class="inline-block bg-blue-600 p-4 rounded-2xl mb-6 shadow-2xl shadow-blue-500/20">
                    <i class="fas fa-map-marked-alt text-3xl text-white"></i>
                </div>
                <h1 class="text-4xl font-extrabold tracking-tighter uppercase">Malangans<span class="text-blue-500">Tickets</span></h1>
                <p class="text-gray-400 text-sm mt-3 font-medium">E-Ticketing Jatim Park, Museum Angkut & Kayutangan</p>
            </div>

            <div class="glass-panel rounded-3xl p-8 md:p-10 shadow-2xl">
                <div class="space-y-6 text-left">
                    <div>
                        <label class="text-[11px] font-bold text-blue-400 uppercase tracking-widest ml-1">Nama Lengkap Visitor</label>
                        <input type="text" id="username-input" class="input-travel w-full rounded-xl px-5 py-4 mt-2 text-sm" placeholder="Masukkan nama Anda...">
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-blue-400 uppercase tracking-widest ml-1">Nomor WhatsApp</label>
                        <input type="tel" class="input-travel w-full rounded-xl px-5 py-4 mt-2 text-sm" placeholder="0812xxxx">
                    </div>
                    <button onclick="handleLogin()" class="btn-primary w-full text-white font-bold py-5 rounded-xl mt-6 flex items-center justify-center gap-3 text-sm uppercase tracking-widest group shadow-lg shadow-blue-900/40">
                        Lihat Destinasi <i class="fas fa-chevron-right group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>
            </div>
            <p class="text-gray-500 text-[10px] mt-8 uppercase tracking-widest">Wonderful Indonesia • East Java</p>
        </div>
    </section>

    <section id="page-inventaris" class="hidden-page min-h-screen flex flex-col transition-opacity duration-500">
        <nav class="p-5 flex justify-between items-center bg-slate-950/90 backdrop-blur-xl border-b border-white/5 sticky top-0 z-50">
            <div class="flex items-center gap-3">
                <i class="fas fa-ticket-alt text-blue-500 text-2xl"></i>
                <h1 class="text-xl font-black italic tracking-tighter uppercase">Malangans<span class="text-blue-500">Tickets</span></h1>
            </div>
            
            <div class="flex items-center gap-6">
                <div class="text-right hidden sm:block border-r border-white/10 pr-6">
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Traveler Profile</p>
                    <p id="display-name" class="text-sm font-bold text-blue-400">User</p>
                </div>
                <button onclick="handleLogout()" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-red-500 hover:bg-red-500 hover:text-white transition shadow-lg">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </div>
        </nav>

        <main class="container mx-auto px-6 py-12 flex-grow">
            <div class="mb-12">
                <h2 class="text-5xl font-extrabold uppercase italic tracking-tighter">Halo, <span id="welcome-name" class="text-blue-500">Traveler</span>!</h2>
                <p class="text-gray-400 text-sm mt-3 font-medium max-w-xl">Pilih destinasi impianmu di Malang dan Batu. Nikmati kemudahan memesan tiket dalam satu klik.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="ticket-card rounded-3xl p-6 group">
                    <div class="aspect-[4/3] rounded-2xl bg-slate-800 overflow-hidden mb-6 relative shadow-2xl">
                        <img src="C:\Users\Thinkpad T14\Downloads\jpk1.jpeg" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute top-4 left-4 bg-blue-600 text-[10px] font-black px-4 py-1.5 uppercase rounded-full shadow-lg">Popular</div>
                    </div>
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-white mb-2">Jatim Park 1,2&3</h3>
                        <p class="text-gray-400 text-xs leading-relaxed">Wisata edukasi dan taman bermain paling ikonik di Kota Batu.</p>
                        <div class="flex items-center gap-2 mt-4 text-blue-400 font-black text-2xl">
                            <span class="text-xs text-gray-500 font-medium">mulai</span> Rp 85.000/orang
                        </div>
                    </div>
                    <button class="w-full btn-primary text-white py-4 rounded-xl font-bold text-xs uppercase tracking-widest">Pesan Sekarang</button>
                </div>

                <div class="ticket-card rounded-3xl p-6 group">
                    <div class="aspect-[4/3] rounded-2xl bg-slate-800 overflow-hidden mb-6 relative shadow-2xl">
                        <img src="c:\Users\Thinkpad T14\Downloads\angk.jpeg" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute top-4 left-4 bg-orange-600 text-[10px] font-black px-4 py-1.5 uppercase rounded-full shadow-lg">Best View</div>
                    </div>
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-white mb-2">Museum Angkut</h3>
                        <p class="text-gray-400 text-xs leading-relaxed">Koleksi alat transportasi dunia dengan zona film Hollywood.</p>
                        <div class="flex items-center gap-2 mt-4 text-blue-400 font-black text-2xl">
                            <span class="text-xs text-gray-500 font-medium">mulai</span> Rp 86.000/orang
                        </div>
                    </div>
                    <button class="w-full btn-primary text-white py-4 rounded-xl font-bold text-xs uppercase tracking-widest">Pesan Sekarang</button>
                </div>

                <div class="ticket-card rounded-3xl p-6 group">
                    <div class="aspect-[4/3] rounded-2xl bg-slate-800 overflow-hidden mb-6 relative shadow-2xl">
                        <img src="c:\Users\Thinkpad T14\Downloads\kjo.jpeg" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute top-4 left-4 bg-emerald-600 text-[10px] font-black px-4 py-1.5 uppercase rounded-full shadow-lg">Heritage</div>
                    </div>
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-white mb-2">wisata kampung Kajoetangan</h3>
                        <p class="text-gray-400 text-xs leading-relaxed">Wisata sejarah dengan nuansa kolonial dan spot foto estetik.</p>
                        <div class="flex items-center gap-2 mt-4 text-blue-400 font-black text-2xl">
                            <span class="text-xs text-gray-500 font-medium">mulai</span> Rp 5.000/orang
                        </div>
                    </div>
                    <button class="w-full btn-primary text-white py-4 rounded-xl font-bold text-xs uppercase tracking-widest">Pesan Sekarang</button>
                </div>

            </div>
        </main>

        <footer class="p-10 text-center border-t border-white/5 bg-slate-950/50 mt-12">
            <p class="text-[10px] text-gray-600 font-bold tracking-[0.4em] uppercase">Wonderful Malang - <span class="text-blue-500">Tourism Portal</span></p>
            <div class="flex justify-center gap-6 mt-6 text-gray-500">
                <i class="fab fa-instagram hover:text-blue-400 cursor-pointer transition"></i>
                <i class="fab fa-facebook-f hover:text-blue-400 cursor-pointer transition"></i>
                <i class="fab fa-whatsapp hover:text-blue-400 cursor-pointer transition"></i>
            </div>
        </footer>
    </section>

    <script>
        function handleLogin() {
            const nameInput = document.getElementById('username-input').value;
            const finalName = nameInput.trim() === "" ? "Traveler" : nameInput;

            document.getElementById('display-name').innerText = finalName;
            document.getElementById('welcome-name').innerText = finalName;

            const loginPage = document.getElementById('page-login');
            const inventarisPage = document.getElementById('page-inventaris');

            loginPage.style.opacity = '0';
            
            setTimeout(() => {
                loginPage.classList.add('hidden-page');
                inventarisPage.classList.remove('hidden-page');
                inventarisPage.style.opacity = '1';
                window.scrollTo(0,0);
            }, 300);
        }

        function handleLogout() {
            const loginPage = document.getElementById('page-login');
            const inventarisPage = document.getElementById('page-inventaris');

            inventarisPage.style.opacity = '0';

            setTimeout(() => {
                inventarisPage.classList.add('hidden-page');
                loginPage.classList.remove('hidden-page');
                loginPage.style.opacity = '1';
                window.scrollTo(0,0);
            }, 300);
        }

        const starContainer = document.getElementById('stars');
        for (let i = 0; i < 150; i++) {
            const star = document.createElement('div');
            star.className = 'star';
            const size = Math.random() * 2 + 1 + 'px';
            star.style.width = size;
            star.style.height = size;
            star.style.left = `${Math.random() * 100}vw`;
            star.style.top = `${Math.random() * 100}vh`;
            star.style.animationDuration = `${Math.random() * 10 + 5}s`;
            starContainer.appendChild(star);
        }
    </script>
</body>
</html>