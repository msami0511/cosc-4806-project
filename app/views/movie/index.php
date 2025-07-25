<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Movie Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #00c6ff, #0072ff);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .search-box {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
        }
        h1 {
            font-size: 28px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }
    </style>
</head>
<body>

<div class="search-box">
    <h1>  Movie Search</h1>
    <form method="get" action="/movie/search">
        <input type="text" name="movie" class="form-control mb-3" placeholder="Enter movie title..." required>
        <button type="submit" class="btn btn-primary w-100">Search</button>
    </form>
    <p class="text-center text-muted mt-3">2025</p>
</div>

</body>
</html>
