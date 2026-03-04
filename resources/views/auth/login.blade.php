<!DOCTYPE html>
<html>
<head>
    <title>JTISpot - Test Login</title>
</head>
<body>
    <h2>Login SIAKAD</h2>

    @if(session('error'))
        <div style="color: red;">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ url('/login') }}">
        @csrf <!-- Why? Prevents Cross-Site Request Forgery. Laravel requires this on all POST forms. -->
        
        <div>
            <label>NIM / Username:</label>
            <input type="text" name="username" required>
        </div>
        <br>
        <div>
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        <br>
        <button type="submit">Login & Scrape</button>
    </form>
</body>
</html>