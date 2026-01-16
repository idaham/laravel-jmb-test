<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login · JMB selfservice portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            margin: 0;
            font-family: system-ui, sans-serif;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .card {
            background: #fff;
            padding: 36px;
            border-radius: 12px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 40px rgba(0,0,0,.08);
        }
        h1 {
            margin: 0 0 8px;
        }
        p {
            margin: 0 0 24px;
            color: #6b7280;
        }
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border-radius: 6px;
            border: 1px solid #d1d5db;
        }
        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #111827;
            color: #fff;
            font-weight: 600;
            cursor: pointer;
        }
        .error {
            color: #dc2626;
            font-size: 14px;
            margin-bottom: 12px;
        }
        .footer {
            margin-top: 16px;
            font-size: 13px;
            color: #9ca3af;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="card">
    <h1>Resident Sign in</h1>
    <p>Access the JMB selfservice portal</p>

    @if ($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="/login">
        @csrf

        <label>Email</label>
        <input type="email" name="email" required autofocus value="{{ old('email') }}">

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">
            Login
        </button>
    </form>

    <div class="footer">
        © {{ date('Y') }} JMB selfservice portal
    </div>
</div>

</body>
</html>
