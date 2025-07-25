<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($data['movie']['Title']) ?> - Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2 class="mb-4"><?= htmlspecialchars($data['movie']['Title']) ?> (<?= htmlspecialchars($data['movie']['Year']) ?>)</h2>



<p><strong>Genre:</strong> <?= htmlspecialchars($data['movie']['Genre']) ?></p>
<p><strong>Plot:</strong> <?= htmlspecialchars($data['movie']['Plot']) ?></p>

<h5 class="mt-4">
    Average Rating: <?= $data['rating']['average'] ?>/5
    <small class="text-muted">(<?= $data['rating']['count'] ?> vote<?= $data['rating']['count'] == 1 ? '' : 's' ?>)</small>
</h5>

<h4 class="mt-4">Rate this movie:</h4>
<div class="btn-group" role="group" aria-label="Rating buttons">
    <?php for ($i = 1; $i <= 5; $i++): ?>
        <a href="/movie/review/<?= urlencode($data['movie']['Title']) ?>/<?= $i ?>" class="btn btn-outline-warning"><?= $i ?> ⭐</a>
    <?php endfor; ?>
</div>

</body>
</html>
