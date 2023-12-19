<!DOCTYPE html>
<html>
<head>
    <title>Status Pengiriman</title>
</head>
<body>
    <h1>Status Pengiriman</h1>
    <ul>
        <?php foreach ($status_pengantaran as $status_pengantaran): ?>
            <li>
                ID Pengantaran: <?= $status_pengantaran->id_pengantaran ?>
                Status: <?= $status_pengantaran->status ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>