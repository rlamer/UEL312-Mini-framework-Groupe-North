<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($data['title'] ?? 'No Title') ?></title>
</head>
<body>
    <h1><?= htmlspecialchars($data['title'] ?? 'No Title') ?></h1>

    <?php if (!empty($data['books']) && is_array($data['books'])): ?>
        <ul>
            <?php foreach ($data['books'] as $book): ?>
                <li>
                    <strong>Title:</strong> <?= htmlspecialchars($book['title'] ?? 'Unknown Title') ?><br>
                    <strong>Author:</strong> <?= htmlspecialchars($book['author'] ?? 'Unknown Author') ?><br>
                    <strong>ID:</strong> <?= htmlspecialchars($book['id'] ?? 'N/A') ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No books available to display.</p>
    <?php endif; ?>
</body>
</html>
