<?php
$name = "";
$character = "";
$email = "";
$birth_year = 1969;
$validation_error = "";
$existing_users = ["admin", "guest"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Raw name
  $raw_name = trim(htmlspecialchars($_POST["name"]));
  if (in_array($raw_name, $existing_users)) {
    $validation_error .= "This name is taken. <br>";
  } else {
    $name = $raw_name;
  }

  // Raw Character
  $raw_character = $_POST["character"];
  if (in_array($raw_character, ["wizard", "mage", "orc"])) {
    $character = $raw_character;
  } else {
    $validation_error .= "You must pick a wizard, mage, or orc. <br>";
  }

  // Email validation
  $raw_email = trim(htmlspecialchars($_POST["email"]));
  if (filter_var($raw_email, FILTER_VALIDATE_EMAIL)) {
    $email = $raw_email;
  } else {
    $validation_error .= "Invalid email. <br>";
  }
  
  // Birth year validation (assuming you want an integer here)
  $raw_birth_year = $_POST["birth_year"];
  $options = ["options"=> ["min_range"=> 1900, "max_range"=> date("Y")]];
  if (filter_var($raw_birth_year, FILTER_VALIDATE_INT, $options)) {
    $birth_year = $raw_birth_year;
  } else {
    $validation_error .= "That can't be your birth year. <br>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Profile</title>
<style>
body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f9;
  color: #333;
  margin: 0;
  padding: 20px;
}

h1 {
  color: #4a90e2;
}

form {
  background: #fff;
  padding: 20px;
  margin-top: 20px;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

form p {
  margin: 0 0 15px 0;
}

input[type="text"], input[type="radio"] {
  margin-right: 10px;
}

input[type="text"] {
  padding: 8px;
  width: calc(100% - 16px);
  border: 1px solid #ccc;
  border-radius: 3px;
  box-sizing: border-box;
}

input[type="submit"] {
  background-color: #4a90e2;
  color: white;
  padding: 10px 15px;
  border: none;
  border-radius: 3px;
  cursor: pointer;
}

input[type="submit"]:hover {
  background-color: #357ab8;
}

span {
  color: red;
  font-weight: bold;
}

h2 {
  color: #4a90e2;
  margin-top: 30px;
}

p {
  margin: 10px 0;
}

#preview {
  background: #fff;
  padding: 20px;
  margin-top: 20px;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
</style>
</head>
<body>

<h1>Greetings Player!</h1>
<h1>Create your profile</h1>
<form method="post" action="">
<p>
Select a name: <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" >
</p>
<p>
Select a character:
  <input type="radio" name="character" value="wizard" <?php echo ($character == 'wizard') ? 'checked' : ''; ?>> Wizard
  <input type="radio" name="character" value="mage" <?php echo ($character == 'mage') ? 'checked' : ''; ?>> Mage
  <input type="radio" name="character" value="orc" <?php echo ($character == 'orc') ? 'checked' : ''; ?>> Orc
</p>
<p>
Enter an email:
<input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>" >
</p>
<p>
Enter your birth year:
<input type="text" name="birth_year" value="<?php echo htmlspecialchars($birth_year); ?>">
</p>
<p>
  <span style="color:red;"><?= $validation_error; ?></span>
</p>
<input type="submit" value="Submit">
</form>
  
<h2>Preview:</h2>
<div id="preview">
<p>
  Name: <?= htmlspecialchars($name); ?>
</p>
<p>
  Character Type: <?= htmlspecialchars($character); ?>
</p>
<p>
  Email: <?= htmlspecialchars($email); ?>
</p>
<p>
  Age: <?= date("Y") - $birth_year; ?>
</p>
</div>

</body>
</html>
