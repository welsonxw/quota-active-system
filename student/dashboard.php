<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Dashboard</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <h2>QuotaActive</h2>
      <nav>
        <ul>
          <li class="active">Dashboard</li>
          <li>Apply</li>
          <li>Status</li>
          <li>Chatbot</li>
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="main">
      <!-- Header -->
      <header class="main-header">
        <h1>Welcome, Student</h1>
        <p>Here is your application overview.</p>
      </header>

      <!-- Content Grid -->
      <div class="grid">
        <!-- Info -->
        <div class="card info">
          <h3>📋 Application Criteria</h3>
          <ul>
            <li>Minimum 2 club activities</li>
            <li>Upload certificate or proof</li>
            <li>Apply to only one college</li>
            <li>Matrix number must be valid</li>
          </ul>
        </div>

        <!-- College Selection -->
        <div class="card colleges">
          <h3>🎓 Choose College</h3>
          <div class="college-buttons">
            <button>KTC</button>
            <button>KTDI</button>
            <button>KRP</button>
            <button>K9K10</button>
          </div>
        </div>

        <!-- Status -->
        <div class="card status">
          <h3>📊 Application Status</h3>
          <p>Status: <strong class="pending">Pending</strong></p>
          <p>College: <strong>KTDI</strong></p>
          <p>Submitted: <strong>Yes</strong></p>
        </div>
      </div>
    </main>
  </div>

</body>
</html>
