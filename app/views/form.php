<?php require "db.php"; ?>

<?php

$first = "";
$last = "";
$section = "";
$year = "";

if(isset($_GET['id'])){
    $stmt = $pdo->prepare("SELECT * FROM user WHERE id=?");
    $stmt->execute([$_GET['id']]);
    $user = $stmt->fetch();

    $first = $user['first_name'];
    $last = $user['last_name'];
    $section = $user['section'];
    $year = $user['year'];
}

if(isset($_POST['save'])){

$first = $_POST['first'];
$last = $_POST['last'];
$section = $_POST['section'];
$year = $_POST['year'];

if(isset($_GET['id'])){
$stmt = $pdo->prepare("UPDATE user SET first_name=?, last_name=?, section=?, year=? WHERE id=?");
$stmt->execute([$first,$last,$section,$year,$_GET['id']]);
}else{
$stmt = $pdo->prepare("INSERT INTO user(first_name,last_name,section,year) VALUES(?,?,?,?)");
$stmt->execute([$first,$last,$section,$year]);
}

header("Location:/");
exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= isset($_GET['id']) ? 'Edit Guest' : 'Add Guest' ?> - Midterm</title>
<link rel="stylesheet" href="<?= base_url()?>public/css/tailwind.css">
<link rel="stylesheet" href="<?= base_url()?>public/css/global.css">
</head>

<body class="layout-full">

<!-- Header -->
<header class="form-page-header">
    <div class="max-w-4xl mx-auto px-6 flex justify-between items-center">
        <a href="/" class="midterm-logo">midterm</a>
        <a href="/" class="midterm-link">← Back to Guests</a>
    </div>
</header>

<!-- Main Content -->
<main class="form-page-main">
    
<div class="w-full max-w-md px-4">
<div class="midterm-form-card">
<form method="POST">

<?php csrf_field(); ?>

<h2 class="form-title">
    <?= isset($_GET['id']) ? 'Edit guest details' : 'Tell us about your guest' ?>
</h2>

<!-- Two Column Layout -->
<div class="form-grid">

<!-- Left Column: First Name & Last Name -->
<div class="form-column">
    <!-- First Name -->
    <div class="form-group">
        <label class="form-label">First Name</label>
        <input
        name="first"
        value="<?= htmlspecialchars($first) ?>"
        placeholder="Enter first name"
        class="midterm-input"
        required
        >
    </div>

    <!-- Last Name -->
    <div class="form-group">
        <label class="form-label">Last Name</label>
        <input
        name="last"
        value="<?= htmlspecialchars($last) ?>"
        placeholder="Enter last name"
        class="midterm-input"
        required
        >
    </div>
</div>

<!-- Right Column: Section & Year -->
<div class="form-column">
    <!-- Section -->
    <div class="form-group">
        <label class="form-label">Section</label>
        <select name="section" class="midterm-select">

        <option value="" disabled <?= $section==""?"selected":"" ?>>Select section</option>
        <option value="F1" <?= $section=="F1"?"selected":"" ?>>F1</option>
        <option value="F2" <?= $section=="F2"?"selected":"" ?>>F2</option>
        <option value="F3" <?= $section=="F3"?"selected":"" ?>>F3</option>
        <option value="F4" <?= $section=="F4"?"selected":"" ?>>F4</option>
        <option value="F5" <?= $section=="F5"?"selected":"" ?>>F5</option>
        <option value="F6" <?= $section=="F6"?"selected":"" ?>>F6</option>

        </select>
    </div>

    <!-- Year -->
    <div class="form-group">
        <label class="form-label">Year</label>
        <select name="year" class="midterm-select">

        <option value="" disabled <?= $year==""?"selected":"" ?>>Select year</option>
        <option value="1" <?= $year=="1"?"selected":"" ?>>1st Year</option>
        <option value="2" <?= $year=="2"?"selected":"" ?>>2nd Year</option>
        <option value="3" <?= $year=="3"?"selected":"" ?>>3rd Year</option>
        <option value="4" <?= $year=="4"?"selected":"" ?>>4th Year</option>

        </select>
    </div>
</div>

</div>

<!-- Submit Button -->
<button
name="save"
class="midterm-btn w-full py-3 text-base mt-8">
<?= isset($_GET['id']) ? 'Save Changes' : 'Add Guest' ?>
</button>

<!-- Back Link -->
<a href="/" class="midterm-link block text-center mt-5">
    Cancel
</a>

</form>
</div>
</div>

</main>

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

