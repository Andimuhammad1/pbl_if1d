<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .portfolio-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; margin-top: 20px; }
        .portfolio-card { background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); overflow: hidden; }
        .portfolio-card img { width: 100%; height: 200px; object-fit: cover; }
        .portfolio-content { padding: 15px; }
        .btn { display: inline-block; padding: 10px 15px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px; }
        .btn-danger { background: #f44336; }
        .btn-warning { background: #ff9800; }
    </style>
</head>
<body>

    <?php include __DIR__ . '/../partials/header.php'; ?>

    <div class="container">
        <h1>Portofolio Saya</h1>
        <a href="index.php?page=create_portfolio" class="btn"> + Tambah Portofolio</a>

        <div class="portfolio-grid">
            <?php if (empty($portfolios)): ?>
                <p>Belum ada portofolio. Silakan tambahkan.</p>
            <?php else: ?>
                <?php foreach ($portfolios as $p): ?>
                    <div class="portfolio-card">
                        <?php if ($p['gambar']): ?>
                            <img src="../public/<?php echo htmlspecialchars($p['gambar']); ?>" alt="Portfolio Image">
                        <?php else: ?>
                            <div style="height: 200px; background: #eee; display: flex; align-items: center; justify-content: center;">No Image</div>
                        <?php endif; ?>
                        
                        <div class="portfolio-content">
                            <h3><?php echo htmlspecialchars($p['judul']); ?></h3>
                            <p><?php echo htmlspecialchars(substr($p['deskripsi'], 0, 100)) . '...'; ?></p>
                            <div style="margin-top: 10px;">
                                <a href="<?php echo htmlspecialchars($p['tautan']); ?>" target="_blank" style="color: blue;">Repo Link</a>
                            </div>
                            <div style="margin-top: 15px;">
                                <a href="index.php?page=view_portfolio&id=<?php echo $p['id']; ?>" class="btn" style="background-color: #2196F3; font-size: 0.9em; margin-right: 5px;">Lihat Detail</a>
                                <!--<a href="#" class="btn btn-warning">Edit</a>-->
                                <a href="index.php?action=delete_portfolio&id=<?php echo $p['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus?');" style="font-size: 0.9em;">Hapus</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
