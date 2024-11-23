<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($data['title'] ?? 'No Title') ?></title>
</head>
<body>
    <h1><?= htmlspecialchars($data['title'] ?? 'No Title') ?></h1>

    <?php if (!empty($data['users']) && is_array($data['users'])): ?>
        <ul>
            <?php foreach ($data['users'] as $user): ?>
                <li>
                    <strong>Name:</strong> <?= htmlspecialchars($user['name'] ?? 'Unknown Name') ?><br>
                    <strong>Author:</strong> <?= htmlspecialchars($user['email'] ?? 'Unknown Email') ?><br>
                    <strong>ID:</strong> <?= htmlspecialchars($user['id'] ?? 'N/A') ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No users available to display.</p>
    <?php endif; ?>
</body>
</html>