<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ChronoPass";

$conn = new mysqli($servername, $username, $password, $dbname);

$error = "";

// Handle Password Login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = $_POST['password']; // In a real app, verify hash here
      
    $sql = "SELECT id FROM users WHERE username = '$user' AND password = '$pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user;
        header("Location: Home.html"); // Redirect to your vault
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - ChronoPass</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f0f2f5; }
        .login-container { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); text-align: center; width: 350px; }
        input { width: 90%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; }
        .btn-main { width: 100%; padding: 10px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .biometric-section { margin-top: 20px; display: flex; justify-content: space-around; }
        .bio-btn { background: none; border: 1px solid #ddd; padding: 10px; border-radius: 50%; cursor: pointer; font-size: 24px; transition: 0.3s; }
        .bio-btn:hover { background: #f0f0f0; }
        
        /* Camera Feed Styling */
        #video-container { display: none; margin-bottom: 10px; }
        video { width: 100%; border-radius: 10px; transform: scaleX(-1); }
        .error { color: red; font-size: 14px; }
    </style>
</head>
<body>

<div class="login-container">
    <div class="logo">
        <img src="images/Frame 24.svg" alt="Logo" width="50">
        <h2>Welcome Back</h2>
    </div>

    <div id="video-container">
        <p>Looking for face...</p>
        <video id="video" autoplay></video>
    </div>

    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="btn-main">Login</button>
        <p class="error"><?php echo $error; ?></p>
    </form>

    <div class="biometric-section">
        <button class="bio-btn" onclick="startFaceID()" title="Face ID">👤</button>
        <button class="bio-btn" onclick="startFingerprint()" title="Fingerprint">Fingerprint</button>
    </div>
</div>

<script>
    // 1. FACE DETECTION (Visual Only)
    function startFaceID() {
        const videoContainer = document.getElementById('video-container');
        const video = document.getElementById('video');
        
        videoContainer.style.display = "block";
        
        if (navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function (stream) {
                    video.srcObject = stream;
                    // Mocking the "Success" after 3 seconds
                    setTimeout(() => {
                        alert("Face Detected! (Logic requires advanced API)");
                        // In a real app, you'd send the image to Python/JS backend here
                    }, 3000);
                })
                .catch(function (error) {
                    console.log("Something went wrong!");
                });
        }
    }

    // 2. FINGERPRINT (Browser Native)
    async function startFingerprint() {
        if (!window.PublicKeyCredential) {
            alert("Your browser does not support WebAuthn (Fingerprint).");
            return;
        }
        
        try {
            // This triggers the Windows Hello / TouchID prompt
            // Note: To make this actually *log you in*, you need a complex backend.
            // This just proves the sensor works.
            const publicKey = {
                challenge: new Uint8Array(32), // Random challenge
                rp: { name: "ChronoPass" },
                user: {
                    id: new Uint8Array(16),
                    name: "admin",
                    displayName: "Admin User"
                },
                pubKeyCredParams: [{ type: "public-key", alg: -7 }]
            };

            await navigator.credentials.create({ publicKey });
            alert("Fingerprint Sensor Activated!");
        } catch (e) {
            alert("Fingerprint cancelled or not setup on this device.");
        }
    }
</script>

</body>
</html>