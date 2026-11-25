
<?php
require_once __DIR__ . '/db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email === "" || $password === "") {
        $error = "Барлық өрістерді толтырыңыз!";
    } else {
        $stmt = $pdo->prepare(
            "SELECT * FROM users WHERE email = ?"
        );
        $stmt->execute([$email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["password"])) {

            session_regenerate_id(true);

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];

            header("Location: index.php");
            exit;

        } else {
            $error = "Email немесе құпиясөз қате!";
        }
    }
}
?>

<?php include __DIR__ . '/header.php'; ?>

<main class="section">
    <div class="container">
        <h2>Жүйеге кіру</h2>

        <?php if ($error): ?>
            <p style="color:red;">
                <?= htmlspecialchars($error) ?>
            </p>
        <?php endif; ?>

        <form method="POST" class="auth-form">
            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Құпиясөз:</label>
            <input type="password" name="password" required>

            <button type="submit" class="btn btn-primary">
                Кіру
            </button>
        </form>

        <p>Аккаунтыңыз жоқ па?
            <a href="register.php">Тіркелу</a>
        </p>
    </div>
</main>

<?php include __DIR__ . '/footer.php'; ?>