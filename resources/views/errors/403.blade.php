<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak | Rentify</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #f97316;
            --primary-glow: rgba(249, 115, 22, 0.15);
            --bg-dark: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.7);
            --text-light: #f8fafc;
            --text-muted: #94a3b8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-light);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Decorative glowing orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            z-index: 1;
            opacity: 0.5;
            animation: float 10s infinite alternate ease-in-out;
        }

        .orb-1 {
            width: 350px;
            height: 350px;
            background: linear-gradient(to right, #f97316, #ea580c);
            top: -50px;
            left: -50px;
        }

        .orb-2 {
            width: 450px;
            height: 450px;
            background: linear-gradient(to right, #3b82f6, #1d4ed8);
            bottom: -100px;
            right: -100px;
            animation-delay: -5s;
        }

        @keyframes float {
            0% { transform: translateY(0px) scale(1); }
            100% { transform: translateY(30px) scale(1.1); }
        }

        /* Glassmorphism Card */
        .error-container {
            position: relative;
            z-index: 10;
            width: 90%;
            max-width: 550px;
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 50px 40px;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .error-code {
            font-size: 120px;
            font-weight: 800;
            line-height: 1;
            background: linear-gradient(135deg, #fff 30%, #94a3b8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
            letter-spacing: -2px;
            position: relative;
            display: inline-block;
        }

        .error-code::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 15px;
            background: #ef4444;
            bottom: 15px;
            left: 0;
            border-radius: 10px;
            z-index: -1;
            opacity: 0.3;
            filter: blur(8px);
        }

        h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        p {
            color: var(--text-muted);
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 35px;
        }

        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: #fff;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 14px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px -5px rgba(249, 115, 22, 0.4);
        }

        .btn-home:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px -5px rgba(249, 115, 22, 0.6);
        }

        .btn-home:active {
            transform: translateY(-1px);
        }

        .logo-text {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 30px;
        }

        .logo-icon {
            width: 28px;
            height: 28px;
            background: var(--primary);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: #fff;
            font-size: 16px;
        }

        .logo-name {
            font-weight: 800;
            font-size: 20px;
            letter-spacing: -0.5px;
        }
    </style>
</head>
<body>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>

    <div class="error-container">
        <div class="logo-text">
            <div class="logo-icon">R</div>
            <div class="logo-name">Rentify</div>
        </div>
        
        <div class="error-code" style="background: linear-gradient(135deg, #ff8a8a 30%, #f43f5e 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">403</div>
        <h1>Akses Ditolak</h1>
        <p>Maaf, Anda tidak memiliki izin atau otorisasi untuk mengakses halaman ini. Hubungi administrator jika Anda merasa ini adalah sebuah kesalahan.</p>
        
        <a href="{{ url('/') }}" class="btn-home">
            <i class="fa fa-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>
</body>
</html>
