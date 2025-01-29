<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-SOP BAPPERIDA Kota Pontianak</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            background-image: url('img/pkl.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: scroll;
            font-family: 'Arial', sans-serif;
        }

        .overlay-container {
            position: absolute;
            top: 30%;
            left: 20px;
            color: white;
            font-family: 'Arial', sans-serif;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }


        .top-rectangle {
            background-color: rgba(255, 255, 255, 0.83);
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1000;
            border-bottom-left-radius: 35px;
            border-bottom-right-radius: 35px;
            height: 50px;
        }

        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
        }

        .logo {
            width: 100px;
            height: 100px;
            object-fit: contain;
            display: block;
            vertical-align: middle;
        }

        .rectangle {
            background-color: rgb(255, 255, 255);
            padding: 15px 25px;
            border-radius: 5px;
            text-align: right;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 10px;
            max-width: 100%;
            max-height: 100px;
            height: 65px;
        }

        .rectangle div {
            font-size: 2rem;
            font-weight: bold;
            color: #000;
        }

        .rectangle .logo {
            width: 200px;
            height: auto;
        }

        .overlay-text.bottom-text {
            position: absolute;
            bottom: 50%;
            left: 20px;
            transform: translateY(50%);
            font-size: 3rem;
            font-weight: bold;
            text-align: left;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
            font-family: 'Open Sans', sans-serif;
            top: 45%;
        }

        .login-container {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            min-height: 100vh;
            padding-right: 2rem;
            position: relative;
            z-index: 1;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-card h1 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #000;
            margin-bottom: 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-control {
            height: 45px;
            font-size: 1rem;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            height: 45px;
            font-size: 1rem;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            .top-rectangle {
                height: 40px;
            }

            .logo {
                width: 80px;
                height: 80px;
            }

            .overlay-text.bottom-text {
                font-size: 2rem;
            }

            .login-card {
                width: 90%;
                padding: 1rem;
            }

            .login-card h1 {
                font-size: 1.2rem;
            }

            .form-control {
                font-size: 0.9rem;
            }

            .btn-primary {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .top-rectangle {
                height: 35px;
            }

            .logo {
                width: 60px;
                height: 60px;
            }

            .overlay-text.bottom-text {
                font-size: 1.5rem;
            }

            .login-card {
                width: 100%;
                padding: 1rem;
            }

            .login-card h1 {
                font-size: 1rem;
            }

            .form-control {
                font-size: 0.9rem;
            }

            .btn-primary {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <div class="top-rectangle">
        <div class="logo-container">
            <img src="img/bppeda2.png" alt="Logo 1" class="logo">
            <img src="img/bpeda.png" alt="Logo 2" class="logo">
            <img src="img/bpeda3.png" alt="Logo 3" class="logo">
            <img src="img/bpeda4.png" alt="Logo 4" class="logo">
        </div>
        <div class="title"></div>
    </div>

    <!-- Overlay Text -->
    <div class="overlay-container">
        <div class="rectangle">
            <img src="img/bappeda.png" alt="Logo Pemerintah" class="logo">
            <div>PEMERINTAH KOTA PONTIANAK</div>
        </div>
    </div>

    <div class="overlay-text bottom-text" style="text-align: left; left: 20px;">E-SOP BAPPERIDA Kota Pontianak</div>

    <!-- Login Container -->
    <div class="login-container">
        <div class="login-card">
            <h1>User login</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan Username">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan Password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">Enter</button>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
