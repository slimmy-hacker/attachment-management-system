<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeKUT External Attachment Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1a202c;
        }

        header {
            background-color: #012970;
            color: white;
            padding: 1rem 2rem;
            text-align: center;
        }

        .hero {
            text-align: center;
            padding: 4rem 2rem;
            background-color: #e2e8f0;
        }

        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .hero p {
            font-size: 1.2rem;
            color: #4a5568;
        }

        .portals {
            margin-top: 2rem;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .portals a {
            background-color: #012970;
            color: white;
            padding: 1rem 2rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .portals a:hover {
            background-color: #023b8f;
        }

        footer {
            margin-top: 4rem;
            padding: 1rem;
            text-align: center;
            background-color: #012970;
            color: white;
        }
    </style>
</head>
<body>

<header>
    <h1>DeKUT External Attachment Management System</h1>
</header>

<section class="hero">
    <h1>Streamlining Industrial Attachment Processes</h1>
    <p>A digital platform for students, supervisors, and industries to collaborate during attachment.</p>

    <div class="portals">
         <a href="{{ route('login') }}" class="portal">Login</a>

    </div>

</section>

<footer>
    &copy; 2026 Dedan Kimathi University of Technology. All rights reserved.
</footer>

</body>
</html>
