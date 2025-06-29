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
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Quota Active Dashboard</title>
  <link rel="stylesheet" href="../css/student-dashboard.css" />

  <div class="dashboard-container">
  <!-- Sidebar -->
  <aside class="sidebar">
    <h2 class="logo">QuotaActive</h2>
    <nav>
      <ul class="nav-list">
        <li class="nav-item"><a href="dashboard.php" class="nav-link">🏠 Dashboard</a></li>
        <li class="nav-item"><a href="apply.php" class="nav-link">📝 Apply</a></li>
        <li class="nav-item"><a href="status.php" class="nav-link">📈 Status</a></li>
        <li class="nav-item">💬 Chatbot</li>
        <li class="nav-item active"> <a href="profile.php" class="nav-link">👤Profile</a></li> 
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
        <h3>📋 Student Profile</h3>
 <p><strong>Full Name:</strong> <?= htmlspecialchars($student['fullname']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($student['email']) ?></p>
    <p><strong>Gender:</strong> <?= htmlspecialchars($student['gender']) ?></p>
    <p><strong>Year:</strong> <?= htmlspecialchars($student['year']) ?></p>
      </div>