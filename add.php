<?php
// imports
include('./config/db_connect.php');

$email = '';
$title = '';
$ingredients = '';

$errors = array('mail'=>'','title'=>'','ingredients'=>'');

if(isset($_POST['submit'])) {

    if(empty($_POST['mail'])) {
        $errors['mail'] = 'email required';
    } else {
        $email = $_POST['mail'];
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['mail'] =  "enter vaild e-mail";
        }
    }
    
    if(empty($_POST['title'])) {
        $errors['title'] =    'title required';
    } else {
        $title = $_POST['title'];
        if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $title)) {
            $errors['title'] =   "enter vaild title";
        }
    }

    if(empty($_POST['ingredients'])) {
        $errors['ingredients'] = 'ingredients required';
    } else {
        $ingredients = $_POST['ingredients'];
        if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)) {
            $errors['ingredients'] = "enter vaild ingredients";
        }
    }

    if(!array_filter($errors)) {
        $email = mysqli_real_escape_string($conn, $_POST['mail']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
        // create SQL
        $sql = "INSERT INTO pizzas(title, email, ingredients) VALUES('$title', '$email', '$ingredients')";
        // save to db
        if(mysqli_query($conn, $sql)) {
            // success
            header('location: database.php');
        } else {
            echo 'query error: ' . mysqli_error($conn);
        }
        
    } 
}

?>

<html>
<?php include('templates/header.php');  ?>

<style>
    form {
  max-width: 460px;
  margin: 20px auto;
  padding: 20px;
}
</style>
<body class="grey lighten-4">
    <?php include('templates/navbar.php');  ?>

    <section class="container grey-text">
        <h4 class="center">Add a Pizza</h4>
        <form class="white" action="add.php" method="POST" style="max-width: 460px">
            <label>Mail</label>
            <input type="text" name="mail" placeholder="mail" value="<?php echo htmlspecialchars($email) ?>">
            <div class="red-text"><?php echo $errors['mail'] ?></div>
            <label>Title</label>
            <input type="text" name="title" placeholder="title" value="<?php echo htmlspecialchars($title) ?>">
            <div class="red-text"><?php echo $errors['title'] ?></div>
            <label>Ingredients</label>
            <input type="text" name="ingredients" placeholder="ingredients" value="<?php echo htmlspecialchars($ingredients) ?>">
            <div class="red-text"><?php echo $errors['ingredients'] ?></div>
            <div class="center">
                <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
            </div>
        </form>

    </section>

    <?php include('templates/footer.php');  ?>

</body>
</html>

