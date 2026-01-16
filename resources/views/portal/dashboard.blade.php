<!DOCTYPE html>
<html>
<head>
    <title>Resident Portal</title>
</head>
<body>
    <h1>Welcome, {{ auth()->user()->name }}</h1>

    <p>You are logged in as a resident.</p>

    <ul>
        <li>View Unit Info (coming soon)</li>
        <li>View Outstanding Fees (coming soon)</li>
        <li>Payment History (coming soon)</li>
    </ul>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
