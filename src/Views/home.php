<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio - Politeknik Negeri Batam</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
    <style>
        /* Add some basic styles for the portfolio grid on home page */
        .home {height: 90vh; display: flex; justify-content: center; align-items: center; text-align: center; background: linear-gradient(rgba(12,53,106,0.7), rgba(12,53,106,0.7)), url('../public/image/poltek.jpg') no-repeat center center; background-size: cover; background-attachment: fixed; color: white;}
        .portfolio-section { padding: 50px 10%; background: #f9f9f9; }
        .portfolio-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-top: 30px; }
        .portfolio-card { background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1); transition: transform 0.3s; }
        .portfolio-card:hover { transform: translateY(-5px); }
        .portfolio-card img { width: 100%; height: 200px; object-fit: cover; }
        .portfolio-content { padding: 20px; }
        .portfolio-content h3 { font-size: 1.2rem; margin-bottom: 10px; color: #333; }
        .portfolio-content p { font-size: 0.9rem; color: #666; line-height: 1.5; }
        .btn-detail { display: inline-block; margin-top: 15px; padding: 8px 15px; background: #333; color: white; text-decoration: none; border-radius: 5px; font-size: 0.9rem; }
    </style>
</head>
<body>

    <!-- Header -->
    <?php include __DIR__ . '/partials/header.php'; ?>

    <!-- Home Section -->
    <section class="home" id="home">
        <div class="home-content">
            <h3>Selamat Datang di</h3>
            <h1>Web Portofolio</h1>
            <h3>Temukan <span class="typing"></span></h3>
        </div>
    </section>

    <!-- Portfolio Section (New) -->
    <section class="portfolio-section" id="portfolio">
        <div class="container">
            <h2 style="text-align: center; margin-bottom: 10px;">Portofolio Terbaru</h2>
            <p style="text-align: center; color: #666;">Karya terbaik mahasiswa Politeknik Negeri Batam</p>
            
            <div class="portfolio-grid">
                <?php if (empty($portfolios)): ?>
                    <p style="text-align: center; width: 100%;">Belum ada portofolio yang diunggah.</p>
                <?php else: ?>
                    <?php foreach ($portfolios as $p): ?>
                        <div class="portfolio-card">
                            <?php if ($p['gambar']): ?>
                                <img src="../public/<?php echo htmlspecialchars($p['gambar']); ?>" alt="Project Image">
                            <?php else: ?>
                                <div style="height: 200px; background: #eee; display: flex; align-items: center; justify-content: center;">No Image</div>
                            <?php endif; ?>
                            <div class="portfolio-content">
                                <h3><?php echo htmlspecialchars($p['judul']); ?></h3>
                                <p>Oleh: <?php echo htmlspecialchars($p['student_name']); ?></p>
                                <p><?php echo htmlspecialchars(substr($p['deskripsi'], 0, 80)) . '...'; ?></p>
                                <a href="index.php?page=view_portfolio&id=<?php echo $p['id']; ?>" class="btn-detail">Lihat Detail</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section" id="about">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2>Tentang</h2>
                    <p>
                        Politeknik Negeri Batam (Polibatam) merupakan satu-satunya Perguruan Tinggi Negeri (PTN) Vokasi di kawasan perdagangan dan pelabuhan bebas Batam, Bintan, dan Karimun Provinsi Kepulauan Riau.
                        <strong>Selain terletak di salah satu kawasan pusat pertumbuhan ekonomi nasional, 
                            Polibatam juga terletak di wilayah terdepan dan terluar wilayah Negara Kesatuan republik Indonesia yang berbatasan langsung dengan perairan internasional.</strong> 
                    </p>
                    <h2><p><strong>Visi</strong></p></h2>  
                    <P>Visi Menjadi politeknik generasi batu yang bermutu, unggul, adaptif, inovatif, berdaya saing global serta bermitra erat dengan industri dan masyarakat untuk mendukung indonesia maju dan sejahtera.</P>
                    
                    <h2><p><strong>Misi</strong></p></h2>
                    <P>Misi dari Polibatam adalah Aktif dalam proses kreasi, penyebaran dan penerapan sains dan teknologi melalui layanan pendidikan tinggi vokasi dan penelitian terapan yang bermutu, terbuka, relevan, dan berkolaborasi erat dengan masyarakat dan industri dengan penerapan tata kelola institusi yang baik untuk kehidupan bangsa yang lebih baik.</P>
                </div>
                <div class="about-cards">
                    <div class="card">
                        <div class="icon"><i class='bx bxs-building-house'></i></div>
                        <h3>Politeknik Negeri Batam</h3>
                        <p>Metode pembelajaran menggunakan project-based learning setiap semesternya.</p>
                    </div>
                    <div class="card">
                        <div class="icon"><i class='bx bxs-graduation'></i></div>
                        <h3>Jurusan</h3>
                        <p>Melihat profil mahasiswa berdasarkan jurusan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team-section" id="team">
        <div class="container">
            <h2 style="text-align: center;">Anggota Tim</h2>
            <p class="subtitle" style="text-align: center;">Cek Tim Kami</p>
            <div class="team-grid">
                <div class="team-card">
                    <img src="../public/image/poltek.jpg" alt="Andi">
                    <div class="team-info">
                        <h3>Andi Muhammad</h3>
                        <h4> TEKNIK INFORMATIKA </h4>
                        <p>Ketua Tim & Front-End Developer</p>
                    </div>
                </div>
                <div class="team-card">
                    <img src="../public/image/poltek.jpg" alt="Rista">
                    <div class="team-info">
                        <h3>Rista Christy Nainggolan</h3>
                        <h4> TEKNIK INFORMATIKA </h4>
                        <p>Analyst</p>
                    </div>
                </div>
                <div class="team-card">
                    <img src="../public/image/poltek.jpg" alt="Vivi">
                    <div class="team-info">
                        <h3>Vivi Regina</h3>
                        <h4> TEKNIK INFORMATIKA</h4>
                        <p>UI/UX Designer</p>
                    </div>
                </div>
                <div class="team-card">
                    <img src="../public/image/public/upload/Andre" alt="Andre">
                    <div class="team-info">
                        <h3>Andre Stanley Tambunan</h3>
                        <h4> TEKNIK INFORMATIKA </h4>
                        <p>Back-End Developer</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        var typed = new Typed(".typing", {
            strings: ["Proyek Menarik", "Inovasi Baru", "Karya Mahasiswa"],
            typeSpeed: 80,
            backSpeed: 40,
            loop: true
        });
    </script>
</body>
</html>
