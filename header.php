<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header class="header">
    <div class="container header-content">

        <a href="index.php" class="logo">
            JumysTapS<span>.</span>
        </a>

        <nav class="nav-menu">
            <a href="index.php">Басты бет</a>
            <a href="index.php#jobs">Вакансиялар</a>
            <a href="index.php#advantages">Біз туралы</a>
        </nav>

        <div class="header-buttons">

            <?php if (isset($_SESSION["user_id"])): ?>

                <span>
                    Сәлем, <?= htmlspecialchars($_SESSION["user_name"]) ?>!
                </span>

                <a href="logout.php" class="btn btn-outline">
                    Шығу
                </a>

            <?php else: ?>

                <a href="login.php" class="btn btn-outline">
                    Кіру
                </a>

                <a href="register.php" class="btn btn-primary">
                    Тіркелу
                </a>

            <?php endif; ?>

        </div>

    </div>
</header>
