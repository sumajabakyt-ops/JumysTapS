
<?php
require_once __DIR__ . '/db.php';

// Кіруді тексеру
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Вакансия ID
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    die('Вакансия ID дұрыс емес!');
}

// Вакансияны алу
$stmt = $pdo->prepare("SELECT * FROM jobs WHERE id = ?");
$stmt->execute([$id]);
$job = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$job) {
    die('Вакансия табылмады!');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['title'] ?? '');
    $company = trim($_POST['company'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $salary = trim($_POST['salary'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($title === '' || $company === '' ||
        $location === '' || $description === '') {

        $error = 'Міндетті өрістерді толтырыңыз!';

    } else {

        $sql = "UPDATE jobs
                SET title = ?, company = ?, location = ?,
                    salary = ?, description = ?
                WHERE id = ?";

        $update = $pdo->prepare($sql);

        $update->execute([
            $title,
            $company,
            $location,
            $salary,
            $description,
            $id
        ]);

        header('Location: jobs.php');
        exit;
    }
}

include __DIR__ . '/header.php';
?>

<div class="container" style="max-width:650px; margin:50px auto;">

    <h2>Вакансияны өңдеу</h2>

    <?php if ($error): ?>
        <p style="color:red;">
            <?= htmlspecialchars($error) ?>
        </p>
    <?php endif; ?>

    <form method="POST">

        <label>Жұмыс атауы</label>
        <input type="text" name="title"
               value="<?= htmlspecialchars($job['title']) ?>"
               required>

        <label>Компания</label>
        <input type="text" name="company"
               value="<?= htmlspecialchars($job['company']) ?>"
               required>

        <label>Қала</label>
        <input type="text" name="location"
               value="<?= htmlspecialchars($job['location']) ?>"
               required>

        <label>Жалақы</label>
        <input type="text" name="salary"
               value="<?= htmlspecialchars($job['salary'] ?? '') ?>">

        <label>Сипаттамасы</label>
        <textarea name="description" rows="5" required><?= htmlspecialchars($job['description']) ?></textarea>

        <button type="submit" class="btn btn-primary">
            Өзгерістерді сақтау
        </button>

        <a href="jobs.php" class="btn btn-outline">
            Артқа
        </a>

    </form>

</div>

<?php include __DIR__ . '/footer.php'; ?>
