<?php
require_once "db.php";
$result = $conn->query("SELECT id, name, email, message, created_at FROM messages ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Messages | Mukila M</title><link rel="stylesheet" href="style.css"></head>
<body>
<header class="navbar"><div class="container nav-wrap"><a class="brand" href="index.php">Mukila.</a><nav><a href="index.php">Back to Portfolio</a></nav></div></header>
<section class="section"><div class="container">
<div class="section-heading"><p class="eyebrow">DATABASE</p><h2>Contact Messages</h2></div>
<div class="table-wrap"><table><thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Message</th><th>Date</th></tr></thead><tbody>
<?php while($row = $result->fetch_assoc()): ?>
<tr><td><?= htmlspecialchars($row["id"]) ?></td><td><?= htmlspecialchars($row["name"]) ?></td><td><?= htmlspecialchars($row["email"]) ?></td><td><?= htmlspecialchars($row["message"]) ?></td><td><?= htmlspecialchars($row["created_at"]) ?></td></tr>
<?php endwhile; ?>
</tbody></table></div>
</div></section>
</body></html>