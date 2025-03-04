<?php
session_start();
include "db.php";

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['add_category'])) {
        $id = $_POST['category_id']; // Admin enters ID manually
        $name = $_POST['category_name'];

        $stmt = $conn->prepare("INSERT INTO categories (id, name) VALUES (?, ?)");
        $stmt->bind_param("ss", $id, $name);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Category added successfully!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Error adding category!";
            $_SESSION['message_type'] = "error";
        }
    }

    if (isset($_POST['add_subcategory'])) {
        $id = $_POST['subcategory_id'];
        $category_id = $_POST['category_id'];
        $name = $_POST['subcategory_name'];

        $stmt = $conn->prepare("INSERT INTO subcategories (id, category_id, name) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $id, $category_id, $name);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Subcategory added successfully!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Error adding subcategory!";
            $_SESSION['message_type'] = "error";
        }
    }

    if (isset($_POST['add_option'])) {
        $id = $_POST['option_id'];
        $subcategory_id = $_POST['subcategory_id'];
        $name = $_POST['option_name'];

        $stmt = $conn->prepare("INSERT INTO options (id, subcategory_id, name) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $id, $subcategory_id, $name);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Option added successfully!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Error adding option!";
            $_SESSION['message_type'] = "error";
        }
    }

    if (isset($_POST['add_answer'])) {
        $id = $_POST['answer_id'];
        $option_id = $_POST['option_id'];
        $answer_text = $_POST['answer_text'];

        $stmt = $conn->prepare("INSERT INTO answers (id, option_id, answer_text) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $id, $option_id, $answer_text);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Answer added successfully!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Error adding answer!";
            $_SESSION['message_type'] = "error";
        }
    }

    header("Location: index.php");
    exit();
}

// Fetch data from tables
$categories = $conn->query("SELECT * FROM categories")->fetch_all(MYSQLI_ASSOC);
$subcategories = $conn->query("SELECT * FROM subcategories")->fetch_all(MYSQLI_ASSOC);
$options = $conn->query("SELECT * FROM options")->fetch_all(MYSQLI_ASSOC);
?>

<!-- Display Success/Error Message -->
<?php if (isset($_SESSION['message'])): ?>
    <script>
        alert("<?php echo $_SESSION['message']; ?>");
    </script>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
      /* General Styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    text-align: center;
}

/* Header Styling */
.header {
    background-color: #2d7d2d;
    color: white;
    padding: 20px;
    font-size: 24px;
    font-weight: bold;
}

/* Centered Container */
.container {
    background: white;
    width: 50%;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    margin: 20px auto;
    text-align: center;
}

/* Input Fields */
input, select, textarea {
    width: 90%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

/* Button Styling */
button {
    background-color: #2d7d2d;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    width: 100%;
}

button:hover {
    background-color: #236623;
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}

th {
    background-color: #2d7d2d;
    color: white;
}

    </style>
</head>
<body>
  <div class="header">DEPARTMENT OF COMPUTER SCIENCE<BR>St.JOSEPH'S COLLEGE AUTONOMOUS<BR>TRICHY-620 002<br></div>
  <h3>Admin Panel</h3>

  <div class="container">
    <!-- Add Category -->
    <form method="POST">
        <h3>Add Category</h3>
        <input type="text" name="category_id" required placeholder="Enter Category ID">
        <input type="text" name="category_name" required placeholder="Enter Category Name">
        <button type="submit" name="add_category">Add</button>
    </form>

    <!-- Add Subcategory -->
    <form method="POST">
        <h3>Add Subcategory</h3>
        <input type="text" name="subcategory_id" required placeholder="Enter Subcategory ID">
        <select name="category_id" required>
            <?php foreach ($categories as $cat) echo "<option value='{$cat['id']}'>{$cat['id']} - {$cat['name']}</option>"; ?>
        </select>
        <input type="text" name="subcategory_name" required placeholder="Enter Subcategory Name">
        <button type="submit" name="add_subcategory">Add</button>
    </form>

    <!-- Add Option -->
    <form method="POST">
        <h3>Add Option</h3>
        <input type="text" name="option_id" required placeholder="Enter Option ID">
        <select name="subcategory_id" required>
            <?php foreach ($subcategories as $sub) echo "<option value='{$sub['id']}'>{$sub['id']} - {$sub['name']}</option>"; ?>
        </select>
        <input type="text" name="option_name" required placeholder="Enter Option Name">
        <button type="submit" name="add_option">Add</button>
    </form>

    <!-- Add Answer -->
    <form method="POST">
        <h3>Add Answer</h3>
        <input type="text" name="answer_id" required placeholder="Enter Answer ID">
        <select name="option_id" required>
            <?php foreach ($options as $opt) echo "<option value='{$opt['id']}'>{$opt['id']} - {$opt['name']}</option>"; ?>
        </select>
        <textarea name="answer_text" required placeholder="Enter Answer"></textarea>
        <button type="submit" name="add_answer">Add</button>
    </form>

    <!-- Display Existing Data -->
    <h3>Existing Data</h3>

    <table>
        <tr>
            <th>Category ID</th>
            <th>Category Name</th>
        </tr>
        <?php foreach ($categories as $cat) echo "<tr><td>{$cat['id']}</td><td>{$cat['name']}</td></tr>"; ?>
    </table>

    <table>
        <tr>
            <th>Subcategory ID</th>
            <th>Category ID</th>
            <th>Subcategory Name</th>
        </tr>
        <?php foreach ($subcategories as $sub) echo "<tr><td>{$sub['id']}</td><td>{$sub['category_id']}</td><td>{$sub['name']}</td></tr>"; ?>
    </table>

    <table>
        <tr>
            <th>Option ID</th>
            <th>Subcategory ID</th>
            <th>Option Name</th>
        </tr>
        <?php foreach ($options as $opt) echo "<tr><td>{$opt['id']}</td><td>{$opt['subcategory_id']}</td><td>{$opt['name']}</td></tr>"; ?>
    </table>

  </div>
</body>
</html>
