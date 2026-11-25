<?php
require_once 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $user_password = $_POST["password"] ?? "";

    // Деректерді тексеру
    if ($name === "" || $email === "" || $user_password === "") {

        $error = "Барлық өрістерді толтырыңыз!";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Электрондық пошта дұрыс емес!";

    } elseif (strlen($user_password) < 6) {

        $error = "Құпиясөз кемінде 6 таңбадан тұруы керек!";

    } else {

        // Email бұрын тіркелген бе?
        $check = $pdo->prepare(
            "SELECT id FROM users WHERE email = ?"
        );

        $check->execute([$email]);

        if ($check->fetch()) {

            $error = "Бұл электрондық пошта бұрын тіркелген!";

        } else {

            // Құпиясөзді хэштеу
            $hashed_password = password_hash(
                $user_password,
                PASSWORD_DEFAULT
            );

            // Жаңа пайдаланушыны сақтау
            $sql = "INSERT INTO users (name, email, password)
                    VALUES (?, ?, ?)";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                $name,
                $email,
                $hashed_password
            ]);

            session_regenerate_id(true);

            $_SESSION["user_id"] = $pdo->lastInsertId();
            $_SESSION["user_name"] = $name;

            header("Location: index.php");
            exit;
        }
    }
}
?>

<?php include 'header.php'; ?>

<main class="section">
    <div class="container">

        <h2>JumysTapS — тіркелу</h2>
        <p>Өзіңе лайықты жұмысты табу үшін тіркел!</p>

        <?php if ($error): ?>
            <p style="color:red;">
                <?= htmlspecialchars($error) ?>
            </p>
        <?php endif; ?>

        <form method="POST" class="auth-form">

            <label>Атыңыз:</label>
            <input
                type="text"
                name="name"
                placeholder="Атыңызды енгізіңіз"
                value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                required
            >

            <label>Электрондық пошта:</label>
            <input
                type="email"
                name="email"
                placeholder="example@mail.com"
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                required
            >

            <label>Құпиясөз:</label>
            <input
                type="password"
                name="password"
                placeholder="Кемінде 6 таңба"
                minlength="6"
                required
            >

            <button type="submit" class="btn btn-primary">
                Тіркелу
            </button>

        </form>

        <p>Аккаунтыңыз бар ма?
            <a href="login.php">Жүйеге кіру</a>
        </p>

    </div>
</main>

<?php include 'footer.php'; ?>
