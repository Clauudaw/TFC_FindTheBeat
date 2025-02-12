<?php
session_start();
require_once './db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    $_SESSION['error'] = "❌ ID de reseña no válido.";
    header('Location: user_dashboard.php');
    exit();
}

$review_id = $_GET['id'];

$stmt = $db->prepare("SELECT * FROM reviews WHERE id = ? AND user_id = ?");
$stmt->execute([$review_id, $user_id]);
$review = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$review) {
    $_SESSION['error'] = "❌ No tienes permiso para editar esta reseña.";
    header('Location: user_dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = trim($_POST['comment']);
    $rating = $_POST['rating'];

    if (empty($comment) || empty($rating)) {
        $_SESSION['error'] = "❌ Todos los campos son obligatorios.";
        header("Location: edit_review.php?id=$review_id");
        exit();
    }

    try {
        $stmt = $db->prepare("UPDATE reviews SET comment = ?, rating = ? WHERE id = ? AND user_id = ?");
        $stmt->execute([$comment, $rating, $review_id, $user_id]);

        $_SESSION['success'] = "✅ Reseña actualizada correctamente.";
        header('Location: user_dashboard.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = "❌ Error al actualizar: " . $e->getMessage();
        header("Location: edit_review.php?id=$review_id");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Reseña</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body class="bg-light">
    <?php include './components/header.php'; ?><br>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="user_dashboard.php" class="breadcrumb-link">Panel de Usuario</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#" class="breadcrumb-link">Editar Reseña</a></li>
        </ol>
    </nav>

    <div class="container d-flex justify-content-center align-items-center my-5">
        <div class="col-md-6">
            <div class="card shadow-sm rounded p-4">
                <h3 class="mb-4 text-center">Editar Reseña</h3>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger"><?= $_SESSION['error'];
                                                    unset($_SESSION['error']); ?></div>
                <?php endif; ?>

                <form action="edit_review.php?id=<?= $review_id; ?>" method="POST">
                    <div class="mb-3">
                        <label for="comment" class="form-label">Comentario</label>
                        <textarea class="form-control" id="comment" name="comment" required><?= htmlspecialchars($review['comment']); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="rating" class="form-label">Calificación</label>
                        <select class="form-select" id="rating" name="rating" required>
                            <option value="1" <?= $review['rating'] == 1 ? 'selected' : ''; ?>>1 - Muy Malo</option>
                            <option value="2" <?= $review['rating'] == 2 ? 'selected' : ''; ?>>2 - Malo</option>
                            <option value="3" <?= $review['rating'] == 3 ? 'selected' : ''; ?>>3 - Regular</option>
                            <option value="4" <?= $review['rating'] == 4 ? 'selected' : ''; ?>>4 - Bueno</option>
                            <option value="5" <?= $review['rating'] == 5 ? 'selected' : ''; ?>>5 - Excelente</option>
                        </select>
                    </div>

                    <button type="submit" class="btn w-100 text-white" style="background-color: #3D8168; padding: 10px 20px; border: none; cursor: pointer;"
                        onmouseover="this.style.backgroundColor='#2C614E'"
                        onmouseout="this.style.backgroundColor='#3D8168'">Actualizar Reseña</button>
                </form>
            </div>
        </div>
    </div>

    <div id="footer"></div>

    <!-- Bootstrap JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>

</html>