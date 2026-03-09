<?php require "db.php"; ?>

<?php
if(isset($_GET['delete'])){
    $stmt = $pdo->prepare("DELETE FROM user WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    header("Location:/");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Users - Midterm</title>
<link rel="stylesheet" href="<?= base_url()?>public/css/tailwind.css">
<link rel="stylesheet" href="<?= base_url()?>public/css/global.css">
</head>

<body class="p-6 md:p-10">

<div class="max-w-4xl mx-auto">

<!-- Header -->
<div class="section-header">
    <div>
        <h1 class="section-title">Guests</h1>
        <p class="section-subtitle">Manage your student guests</p>
    </div>
<a href="/form" class="midterm-btn">
        + Add User
    </a>
</div>

<!-- Dark Mode Toggle (Fixed Bottom Right) -->
<button id="darkModeToggle" class="dark-mode-toggle" title="Toggle dark mode">
    <!-- Sun icon (shown in dark mode) -->
    <svg class="hidden dark:block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
    </svg>
    <!-- Moon icon (shown in light mode) -->
    <svg class="block dark:hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
    </svg>
</button>

<!-- Users Grid -->
<?php
$stmt = $pdo->query("SELECT * FROM user");
$users = $stmt->fetchAll();
?>

<?php if (count($users) === 0): ?>
    <div class="empty-state">
        <span class="empty-state-icon">🏠</span>
        <h2 class="empty-state-title">No guests yet</h2>
        <p class="empty-state-text">Start by adding your first guest</p>
        <a href="/form" class="midterm-btn px-6 py-3 text-base">
            Add User
        </a>
    </div>
<?php else: ?>

<div class="user-grid space-y-5">
<?php foreach($users as $row): ?>
<div class="midterm-card user-card">
    
    <!-- User Info -->
    <div class="user-info">
        <div class="avatar-circle avatar-gradient">
            <?= strtoupper(substr($row['first_name'], 0, 1) . substr($row['last_name'], 0, 1)) ?>
        </div>
        <div>
            <h3 class="user-name"><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></h3>
            <p class="user-details">Section <?= htmlspecialchars($row['section']) ?> • Year <?= htmlspecialchars($row['year']) ?></p>
        </div>
    </div>
    
    <!-- Actions -->
    <div class="action-buttons">
        <a href="/form?id=<?= $row['id'] ?>" class="midterm-edit">
        Edit
        </a>
        
        <a href="?delete=<?= $row['id'] ?>" class="midterm-delete"
        onclick="return confirm('Are you sure you want to remove this guest?')">
        Remove
        </a>
    </div>

</div>
<?php endforeach; ?>
</div>

<?php endif; ?>

</div>

<!-- Dark Mode Script -->
<script>
    const toggleButton = document.getElementById('darkModeToggle');
    const html = document.documentElement;
    
    // Check for saved preference
    if (localStorage.getItem('darkMode') === 'true' || 
        (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        html.classList.add('dark');
    }
    
    toggleButton.addEventListener('click', () => {
        html.classList.toggle('dark');
        localStorage.setItem('darkMode', html.classList.contains('dark'));
    });
</script>

</body>
</html>

