
<?php
require_once __DIR__ . '/db.php';

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($name === "" || $email === "" || $password === "") {
        $error = "Барлық өрістерді толтырыңыз!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email дұрыс емес!";
    } elseif (strlen($password) < 8) {
        $error = "Құпиясөз кемінде 8 таңбадан тұруы керек!";
    } else {
        $check = $pdo->prepare(
            "SELECT id FROM users WHERE email = ?"
        );
        $check->execute([$email]);

        if ($check->fetch()) {
            $error = "Бұл email бұрын тіркелген!";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare(
                "INSERT INTO users (name, email, password)
                 VALUES (?, ?, ?)"
            );

            $stmt->execute([$name, $email, $hashedPassword]);

            $success = "Тіркелу сәтті аяқталды! Енді жүйеге кіре аласыз.";
        }
    }
}
?>

<?php include __DIR__ . '/header.php'; ?>

<main class="section">
    <div class="container">
        <h2>Тіркелу</h2>

        <?php if ($error): ?>
            <p style="color:red;">
                <?= htmlspecialchars($error) ?>
            </p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p style="color:green;">
                <?= htmlspecialchars($success) ?>
            </p>
        <?php endif; ?>

        <form method="POST" class="auth-form">
            <label>Аты-жөніңіз:</label>
            <input type="text" name="name" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Құпиясөз:</label>
            <input type="password" name="password"
                   minlength="8" required>

            <button type="submit" class="btn btn-primary">
                Тіркелу
            </button>
        </form>

        <p>Аккаунтыңыз бар ма?
            <a href="login.php">Кіру</a>
        </p>
    </div>
</main>

<?php include __DIR__ . '/footer.php'; ?>