<?php
session_start();

include '../includes/db_studentlocal.php';
if (!isset($_SESSION['student_id'])) {
  header("Location: login.php");
  exit();
}
$student_id = $_SESSION['student_id'];
$sql = "SELECT fullname, email, gender, year FROM student WHERE student_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Quota Active Dashboard</title>
  <link rel="stylesheet" href="../css/student-dashboard.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  
  <script src="https://cdn.botpress.cloud/webchat/v3.0/inject.js"></script>
  <script src="https://files.bpcontent.cloud/2025/06/27/07/20250627072905-7RCE1TQ0.js" defer></script>
  </head>



  <div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="sidebar-logo text-center my-4">
        <img src="../assets/webug2.png" alt="QAWS Logo" class="sidebar-logo-img">
      </div>

      <i class="fas fa-user-circle profile-avatar-icon"></i>

      <nav>
        <ul class="nav-list">
          <li class="nav-item"><a href="dashboard.php" class="nav-link"><i class="fas fa-home"></i> Dashboard</a></li>
          <li class="nav-item"><a href="apply.php" class="nav-link"><i class="fas fa-edit"></i> Apply</a></li>
          <li class="nav-item active"><i class="fas fa-user"></i> Profile</a></li>
          <li class="nav-item"><a class="nav-link text-danger" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <header class="main-header">
        <h1>Welcome, Student</h1>
        <p>Here is your profile.</p>
      </header>
      <br>

      <div class="profile">
        <h3>Student Profile</h3>
        <p><strong>Full Name:</strong> <?= htmlspecialchars($student['fullname']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($student['email']) ?></p>
        <p><strong>Gender:</strong> <?= htmlspecialchars($student['gender']) ?></p>
        <p><strong>Year:</strong> <?= htmlspecialchars($student['year']) ?></p>
      </div>