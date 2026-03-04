<!DOCTYPE html>
<html>
<head>
    <title>JTISpot - Welcome</title>
</head>
<body>
    <h2>Welcome to JTISpot</h2>
    <p>Scraping Successful!</p>

    <!-- Why use dd()? It's the fastest way to verify the exact structure of your scraped array during testing -->
    <div style="background: #222; color: #0f0; padding: 15px;">
        @php
            dump($studentBio);
        @endphp
    </div>

    <br>
    <a href="{{ url('/login') }}">Back to Login</a>
</body>
</html>