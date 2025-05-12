<?php
session_start();

// Step 1: Handle POST from JavaScript to verify Google token
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $token = $data['credential'];

    // Optional: verify token here with Google API (recommended for production)
    // For demo purposes, we'll just decode it
    $parts = explode('.', $token);
    $payload = base64_decode(strtr($parts[1], '-_', '+/'));
    $userData = json_decode($payload, true);

    $_SESSION['email'] = $userData['email'] ?? 'Unknown';
    echo json_encode(['status' => 'ok']);
    exit;
}

// Step 2: Show user page if logged in
if (isset($_SESSION['email'])) {
    $email = htmlspecialchars($_SESSION['email']);
    echo "<h2>Welcome</h2>";
    echo "<p>Your email: $email</p>";
    echo "<a href='logout.php'>Log out</a>";
    exit;
}

// Step 3: If no session, show loader and send token from JS
?>
<!DOCTYPE html>
<html>
<head>
  <title>Landing</title>
</head>
<body>
  <p>Loading...</p>
  <script>
    const token = localStorage.getItem("google_token");
    if (!token) {
      window.location.href = "index.php";
    } else {
      fetch("landing.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ credential: token })
      })
      .then(res => res.json())
      .then(data => {
        if (data.status === "ok") {
          localStorage.removeItem("google_token"); // Optional cleanup
          window.location.reload();
        } else {
          alert("Login failed");
          window.location.href = "index.php";
        }
      });
    }
  </script>
</body>
</html>
