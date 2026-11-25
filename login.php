<?php
require_once 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");
    $user_password = $_POST["password"] ?? "";

    if ($email === "" || $user_password === "") {

        $error = "Барлық өрістерді толтырыңыз!";

    } else {

        // Пайдаланушыны дерекқордан іздеу
        $sql = "SELECT * FROM users WHERE email = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Құпиясөзді тексеру
        if ($user && password_verify(
            $user_password,
            $user["password"]
        )) {

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

<?php include 'header.php'; ?>

<main class="section">
    <div class="container">

        <h2>Жүйеге кіру</h2>
        <p>JumysTapS аккаунтыңызға кіріңіз.</p>

        <?php if ($error): ?>
            <p style="color:red;">
                <?= htmlspecialchars($error) ?>
            </p>
        <?php endif; ?>

        <form method="POST" class="auth-form">

            <label>Электрондық пошта:</label>
            <input
                type="email"
                name="email"
                placeholder="example@mail.com"
                required
            >

            <label>Құпиясөз:</label>
            <input
                type="password"
                name="password"
                placeholder="Құпиясөзіңізді енгізіңіз"
                required
            >

            <button type="submit" class="btn btn-primary">
                Кіру
            </button>

        </form>

        <p>Аккаунтыңыз жоқ па?
            <a href="register.php">Тіркелу</a>
        </p>

    </div>
</main>

<?php include 'footer.php'; ?>
