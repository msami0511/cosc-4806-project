<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Movie Details</title>
</head>
<body>
    <?php if (isset($data['error'])): ?>
        <p><?= htmlspecialchars($data['error']) ?></p>
        <a href="/movie">Back to Search</a>
    <?php elseif (isset($data['movie'])): ?>
        <h1><?= htmlspecialchars($data['movie']['Title'] ?? 'N/A') ?> (<?= htmlspecialchars($data['movie']['Year'] ?? '') ?>)</h1>
        <p><strong>Genre:</strong> <?= htmlspecialchars($data['movie']['Genre'] ?? 'N/A') ?></p>
        <p><strong>Director:</strong> <?= htmlspecialchars($data['movie']['Director'] ?? 'N/A') ?></p>
        <p><strong>Actors:</strong> <?= htmlspecialchars($data['movie']['Actors'] ?? 'N/A') ?></p>
        <p><strong>Plot:</strong> <?= htmlspecialchars($data['movie']['Plot'] ?? 'N/A') ?></p>
        <br>
        <a href="/movie">Back to Search</a>
    <?php else: ?>
        <p>No movie data to show.</p>
        <a href="/movie">Back to Search</a>
    <?php endif; ?>
</body>
</html>
