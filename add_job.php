
<?php
require_once __DIR__ . '/db.php';

// Тек жүйеге кірген пайдаланушы вакансия қоса алады
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
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

        $error = 'Барлық міндетті өрістерді толтырыңыз!';

    } else {

        try {
            $sql = "INSERT INTO jobs
                    (title, company, location, salary, description)
                    VALUES (?, ?, ?, ?, ?)";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                $title,
                $company,
                $location,
                $salary,
                $description
            ]);

            header('Location: index.php');
            exit;

        } catch (PDOException $e) {
            $error = 'Вакансияны сақтау кезінде қате пайда болды.';
        }
    }
}

include __DIR__ . '/header.php';
?>

<div class="container" style="max-width:650px; margin:50px auto;">

    <h2>Жаңа вакансия қосу</h2>

    <?php if ($error): ?>
        <p style="color:red;">
            <?= htmlspecialchars($error) ?>
        </p>
    <?php endif; ?>

    <form method="POST">

        <label>Жұмыс атауы *</label>
        <input type="text" name="title"
               placeholder="Мысалы: PHP Developer" required>

        <label>Компания *</label>
        <input type="text" name="company"
               placeholder="Компания атауы" required>

        <label>Қала *</label>
        <select name="location" required>
            <option value="">Қаланы таңдаңыз</option>
            <option value="Алматы">Алматы</option>
            <option value="Астана">Астана</option>
            <option value="Шымкент">Шымкент</option>
            <option value="Қарағанды">Қарағанды</option>
            <option value="Ақтөбе">Ақтөбе</option>
        </select>

        <label>Жалақы</label>
        <input type="text" name="salary"
               placeholder="250 000 ₸">

        <label>Жұмыс сипаттамасы *</label>
        <textarea name="description" rows="5"
                  placeholder="Жұмыс туралы ақпарат..."
                  required></textarea>

        <button type="submit" class="btn btn-primary">
            Вакансияны жариялау
        </button>

        <a href="index.php" class="btn btn-outline">
            Артқа қайту
        </a>

    </form>

</div>

<?php include __DIR__ . '/footer.php'; ?>
