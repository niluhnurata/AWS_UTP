<?php
session_start(); // Memulai sesi

$validKeys = [
    "ABC123", "TES123", "KEY456"
];

// Fungsi untuk memvalidasi key
function validateKey($key) {
    global $validKeys;
    return in_array($key, $validKeys);
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $inputKey = isset($_POST["key"]) ? trim($_POST["key"]) : "";

    if (validateKey($inputKey)) {
        $_SESSION['is_valid'] = true; // Menandai validasi berhasil
        header("Location: index.php");
        exit(); // Menghentikan eksekusi setelah redirect
    } else {
        $message = "<p class='error'>Key tidak valid. Silakan coba lagi.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Key Tiket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 400px;
            text-align: center;
        }
        h1 {
            font-size: 1.5em;
            margin-bottom: 20px;
        }
        label {
            font-size: 1em;
            display: block;
            margin-bottom: 8px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .success {
            color: #28a745;
        }
        .error {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Validasi untuk Pembelian Tiket</h1>
        <?php if (!empty($message)) echo $message; ?>
        <form method="POST">
            <label for="key">Masukkan Key Anda:</label>
            <input type="text" id="key" name="key" placeholder="Contoh: ABC123" required>
            <button type="submit">Validasi</button>
        </form>
    </div>
</body>
</html>