<?php
// Include database connection
include "db.php";

// Fetch categories
$categories = [];
$result = $conn->query("SELECT * FROM categories");
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}

// Fetch subcategories
$subcategories = [];
$result = $conn->query("SELECT * FROM subcategories");
while ($row = $result->fetch_assoc()) {
    $subcategories[] = $row;
}

// Fetch options (Fix: changed table from 'choices' to 'options' if needed)
$options = [];
$result = $conn->query("SELECT * FROM options"); // Ensure correct table name
while ($row = $result->fetch_assoc()) {
    $options[] = $row;
}

// Fetch answers
$answers = [];
$result = $conn->query("SELECT * FROM answers");
while ($row = $result->fetch_assoc()) {
    $answers[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission Chatbot</title>
    <link rel="stylesheet" href="styles.css"> <!-- External CSS for cleaner code -->
    <style>
      /* General Styles */
body {
    font-family: 'Times New Roman', Times, serif;
    background: #e9e9e9;
    margin: 0;
    padding: 0;
}

header {
    background-color: #4CAF50;
    color: white;
    padding: 20px;
    text-align: center;
    font-size: 24px;
}

/* Chat Container */
.chat-container {
    width: 500px;
    background-color: #fff;
    border-radius: 10px;
    margin: 50px auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    overflow: hidden;
}

.chat-header {
    background-color: #4CAF50;
    color: white;
    padding: 15px;
    font-size: 20px;
    text-align: center;
}

.directory {
    font-size: 14px;
    color: #555;
    background-color: #e9e9e9;
    padding: 10px;
}

/* Menus */
.menu, .submenu, .optionMenu {
    display: flex;
    flex-direction: column;
    padding: 15px;
    background-color: #f1f1f1;
    margin: 10px;
    border-radius: 10px;
}

.menu a, .submenu a, .optionMenu a {
    font-size: 18px;
    font-weight: bold;
    color: #198754;
    padding: 12px;
    text-decoration: none;
    border-radius: 5px;
    text-align: center;
    transition: 0.3s;
}

.menu a:hover, .submenu a:hover, .optionMenu a:hover {
    background-color: #d4edda;
    cursor: pointer;
}

/* Chat Box */
.chat {
    padding: 15px;
    max-height: 400px;
    overflow-y: auto;
}

.info-box {
    font-style: italic;
    font-weight: bold;
    font-family: 'Times New Roman', Times, serif;
    padding: 15px;
    background:rgb(154, 218, 154);
    border-radius: 10px;
    margin: 10px;
}

/* Input Area */
.input-area {
    display: flex;
    padding: 10px;
    background-color: white;
}

.input-area input {
    width: 80%;
    padding: 12px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 5px;
    outline: none;
}

.input-area button {
    width: 50px;
    height: 50px;
    background-color: #4CAF50;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    margin-left: 10px;
}

.input-area button:hover {
    transform: scale(1.1);
}
#menu, #submenu, #optionMenu {
      background: ; /* Removes any background color */
      border: none; /* Removes borders */
      padding: 0px; /* Minimal padding */
      margin: 0; /* Removes margin */
      
  }

  /* Ensure they appear inline */
  #menu span, #submenu span, #optionMenu span {
      display: inline-block;
      margin-right: 10px;
      font-size: 18px;
      color:rgb(12, 21, 17);
      cursor: pointer;
      transition: 0.3s;
      
  }

  #menu span:hover, #submenu span:hover, #optionMenu span:hover {
      text-decoration: underline;
      color: #155724;
  }
  .user-message {
    background-color: #d1e7dd; color: #155724; text-align: right;
    padding: 10px 15px; border-radius: 15px 15px 0 15px;
    max-width: 70%; word-wrap: break-word; display: inline-block;
    font-size: 16px; font-family: Arial, sans-serif;
    margin: 5px 10px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
    align-self: flex-end;
}

.bot-message {
    background-color: #f8d7da; color: #721c24; text-align: left;
    padding: 10px 15px; border-radius: 15px 15px 15px 0;
    max-width: 70%; word-wrap: break-word; display: inline-block;
    font-size: 16px; font-family: Arial, sans-serif;
    margin: 5px 10px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
    align-self: flex-start;
}
.refresh-button {
    display: block;
    margin: 15px auto;
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    color: white;
    background-color:rgb(40, 44, 40);
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: fit-content;
    text-align: center;
}

.refresh-button:hover {
    background-color:rgb(154, 218, 154);
}





    </style>
</head>
<body>
    <header>
        <div class="header-title">DEPARTMENT OF COMPUTER SCIENCE<br>ST. JOSEPH'S COLLEGE (AUTONOMOUS)<br>TIRUCHIRAPALLI-620 002</div>
    </header>
    <div class="chat-container">
        <div class="chat-header">
            <h2>Welcome! How can I assist you today?</h2>
        </div>
        <div class="directory" id="directory">Directory: <span>Home</span></div>
        <div id="content-container">
          <div class="menu" id="menu">
            <?php foreach ($categories as $category): ?>
                <a onclick="loadSubcategories('<?php echo $category['id']; ?>')"><?php echo htmlspecialchars($category['name']); ?></a>
            <?php endforeach; ?>
            <div>
              
            </div>
          </div>
          <section class="submenu" id="submenu"></section>
          <div class="optionMenu" id="optionMenu"></div>
          <div class="info-box" id="chatbox"></div>
        </div>
        <div class="chat" id="chat"></div>
        <div class="input-area">
            <input type="text" id="userInput" placeholder="Type your question...">
            <button onclick="sendMessage()">
            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
            <path d="M120-160v-240l320-80-320-80v-240l720 320-720 320Z" fill="white"/>
            </svg>
            </button>
            <!-- Add this inside the .chat-container --><!-- Add this inside the .chat-container -->
        </div>
        <div>
            <button id="refreshBtn" class="refresh-button" style="display: none;" onclick="location.reload();"> Back to Main Screen
            </button>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>

    <script>
        const subcategories = <?php echo json_encode($subcategories); ?>;
const options = <?php echo json_encode($options); ?>;
const answers = <?php echo json_encode($answers); ?>;

// Function to display messages
function displayMessage(message, sender) {
    let chatBox = document.getElementById("chat");
    let messageElement = document.createElement("div");
    messageElement.classList.add(sender === "user" ? "user-message" : "bot-message");
    messageElement.innerHTML = message;
    chatBox.appendChild(messageElement);
    chatBox.scrollTop = chatBox.scrollHeight;
}

// Load subcategories when a category is selected
function loadSubcategories(categoryId) {
    let mainMenu = document.getElementById('menu');
    mainMenu.innerHTML = '';
    let submenu = document.getElementById('submenu');
    submenu.innerHTML = '';
    let found = false;

    subcategories.forEach(sub => {
        if (sub.category_id == categoryId) {
            submenu.innerHTML += `<a onclick="loadOptions('${sub.id}')">${sub.name}</a>`;
            found = true;
        }
    });


    if (!found) {
        submenu.innerHTML = `<p>No subcategories available.</p>`;
        displayMessage("No subcategories available.", "bot");
    }
}

// Load options when a subcategory is selected
function loadOptions(subcategoryId) {
    let submenu = document.getElementById('submenu');
    submenu.innerHTML = '';
    let optionMenu = document.getElementById('optionMenu');
    optionMenu.innerHTML = '';
    let found = false;

    options.forEach(opt => {
        if (opt.subcategory_id == subcategoryId) {
            optionMenu.innerHTML += `<a onclick="loadAnswer('${opt.id}')">${opt.name}</a>`;
            found = true;
        }
    });


    if (!found) {
        optionMenu.innerHTML = `<p>No options available.</p>`;
        displayMessage("No options available.", "bot");
    }
}

// Display answer when an option is selected
function loadAnswer(optionId) {
    let chatbox = document.getElementById('chatbox');
    chatbox.innerHTML = '';
    let found = false;

    answers.forEach(ans => {
        if (ans.option_id == optionId) {
            chatbox.innerHTML = `<h3>Answer</h3><p>${ans.answer_text}</p>`;
            found = true;
        }
    });

   

    if (!found) {
        chatbox.innerHTML = `<p>No answer available.</p>`;
        displayMessage("No answer available.", "bot");
    }
}

// Send user input message
function sendMessage() {
    const userInput = document.getElementById("userInput").value.trim();
    if (userInput === "hi" , "hello" , "hey"){
        displayMessage(userInput + "\n  MY FRIEND." + "\n PLEASE SELECT AN OPTIONS,",'bot')
    } return;
    displayMessage(userInput, 'user');
    document.getElementById("userInput").value = "";
    
    displayMessage("PLEASE SELECT AN OPTION...", 'bot');
}

// Function to Show Refresh Button
function showRefreshButton() {
    let refreshBtn = document.getElementById("refreshBtn");
    if (refreshBtn) {
        refreshBtn.style.display = "block"; // Show button
    }
}

// Modify loadSubcategories() to Show Refresh Button After Category is Clicked
function loadSubcategories(categoryId) {
    let mainMenu = document.getElementById('menu');
    let submenu = document.getElementById('submenu');
    mainMenu.innerHTML = ''; // Remove previous menu
    submenu.innerHTML = ''; // Clear submenu
    
    let found = false;
    subcategories.forEach(sub => {
        if (sub.category_id == categoryId) {
            submenu.innerHTML += `<a onclick="loadOptions('${sub.id}')">${sub.name}</a>`;
            found = true;
        }
    });

    if (!found) {
        submenu.innerHTML = `<p>No subcategories available.</p>`;
    }

    showRefreshButton(); // Show the refresh button when a category is selected
}



    </script>
</body>
</html>
