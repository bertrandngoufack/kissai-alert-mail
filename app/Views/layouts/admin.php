<!DOCTYPE html>
<html lang="fr">
<head>
\t<meta charset="utf-8">
\t<meta name="viewport" content="width=device-width, initial-scale=1">
\t<title>Kissai Alert - Admin</title>
\t<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
</head>
<body>
\t<section class="section">
\t\t<div class="container">
\t\t\t<h1 class="title">Kissai Alert</h1>
\t\t\t<p class="subtitle">Plate-forme CPaaS</p>
\t\t\t<?= isset($this->renderSection) ? $this->renderSection('content') : '' ?>
\t\t</div>
\t</section>
</body>
</html>

