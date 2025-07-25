<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($data['movie']['Title']) ?> - Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h2 class="mb-4"><?= htmlspecialchars($data['movie']['Title']) ?> (<?= htmlspecialchars($data['movie']['Year']) ?>)</h2>

    <div class="row">
        <div class="col-md-12">
            <ul class="list-group mb-3">
                <li class="list-group-item"><strong>Genre:</strong> <?= htmlspecialchars($data['movie']['Genre']) ?></li>
                <li class="list-group-item"><strong>Released:</strong> <?= htmlspecialchars($data['movie']['Released']) ?></li>
                <li class="list-group-item"><strong>Rated:</strong> <?= htmlspecialchars($data['movie']['Rated']) ?></li>
                <li class="list-group-item"><strong>Runtime:</strong> <?= htmlspecialchars($data['movie']['Runtime']) ?></li>
                <li class="list-group-item"><strong>Director:</strong> <?= htmlspecialchars($data['movie']['Director']) ?></li>
                <li class="list-group-item"><strong>Writer:</strong> <?= htmlspecialchars($data['movie']['Writer']) ?></li>
                <li class="list-group-item"><strong>Actors:</strong> <?= htmlspecialchars($data['movie']['Actors']) ?></li>
                <li class="list-group-item"><strong>Language:</strong> <?= htmlspecialchars($data['movie']['Language']) ?></li>
                <li class="list-group-item"><strong>Country:</strong> <?= htmlspecialchars($data['movie']['Country']) ?></li>
                <li class="list-group-item"><strong>Awards:</strong> <?= htmlspecialchars($data['movie']['Awards']) ?></li>
                <li class="list-group-item"><strong>IMDB Rating:</strong> <?= htmlspecialchars($data['movie']['imdbRating']) ?>/10</li>
                <li class="list-group-item"><strong>Plot:</strong> <?= htmlspecialchars($data['movie']['Plot']) ?></li>
            </ul>
        </div>
    </div>

    <h5 class="mt-4">
        ⭐ Average Rating: <?= $data['rating']['average'] ?>/5
        <small class="text-muted">(<?= $data['rating']['count'] ?> vote<?= $data['rating']['count'] == 1 ? '' : 's' ?>)</small>
    </h5>

    <h4 class="mt-3">Rate this movie:</h4>
    <div class="btn-group mb-4" role="group" aria-label="Rating buttons">
        <?php for ($i = 1; $i <= 5; $i++): ?>
            <a href="/movie/review/<?= urlencode($data['movie']['Title']) ?>/<?= $i ?>" class="btn btn-outline-warning"><?= $i ?> ⭐</a>
        <?php endfor; ?>
    </div>

    <?php if (!empty($data['review'])): ?>
        <h4 class="mt-4">🤖 AI-Generated Review:</h4>
        <div class="alert alert-secondary" style="white-space: pre-wrap;">
            <?= htmlspecialchars($data['review']) ?>
        </div>
    <?php endif; ?>

    <a href="/movie" class="btn btn-outline-primary mt-4">🔙 Back to Search</a>

</body>
</html>
