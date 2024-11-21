<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Book List') ?></title>
</head>
<body>
    <h1><?= htmlspecialchars($title ?? 'Book List') ?></h1>

    <?php if (!empty($books) && is_array($books)): ?>
        <ul>
            <?php foreach ($books as $book): ?>
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

    <?php if (!empty($message)): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
</body>
</html>
