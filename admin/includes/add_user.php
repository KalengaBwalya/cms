<?php
    if(isset($_POST['add_user'])){
       
        
        //Input To Variable Assignment via POST super global
        
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_role = $_POST['user_role'];
        $username = $_POST['username'];
        $user_image = "to be added";
//        $post_image = $_FILES['post_image']['name'];
//        $post_image_temp = $_FILES['post_image']['tmp_name'];
        
        
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];  
        $date = date('d-m-y');
        
        
        
//        //Image Upload
//        move_uploaded_file($post_image_temp, "../images/$post_image");
        

        //SQL Injection Escape
        $user_firstname = mysqli_real_escape_string($connection, $user_firstname);
        $user_lastname = mysqli_real_escape_string($connection, $user_lastname);
        $username = mysqli_real_escape_string($connection, $username);
        $user_email = mysqli_real_escape_string($connection, $user_email);
        $user_password = mysqli_real_escape_string($connection, $user_password);
        
        
        //password encryption
        $hashFormat = "$2y$10$";
        $salt = "iusesomecrazystrings22";
        $hashF_and_salt = $hashFormat.$salt;
        
        $encrypted_user_password = crypt($user_password, $hashF_and_salt);

        
        //INSERT Query
        $query = "INSERT INTO users(user_firstname, user_lastname, user_role,";
        $query .= "username, user_image, user_email, user_password, randSalt, date) ";
        $query .= "VALUES('{$user_firstname}', '{$user_lastname}',";
        $query .= "'{$user_role}', '{$username}', '{$user_image}', '{$user_email}',";
        $query .= "'{$user_password}', '{$encrypted_user_password}', now())";
     
        
        $add_user_query = mysqli_query($connection, $query);
        

        
        confirmQuery($add_user_query);
    }
?>


<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="user_firstname">Firstname</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>
    <div class="form-group">
        <label for="user_lastname">Lastname</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>
    <div class="form-group">
        <label for="user_role">Role</label>
        <br />
        <select name="user_role" id="" class="form-control">
            <option value="subscriber">--- Select ---</option>
            <option value="subscriber">Subscriber</option>
            <option value="admin">Admin</option>

        </select>
    </div>

    <!--
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="post_image">
    </div>
-->
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email">
    </div>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>

    <div class="form-group">
        <input type="submit" value="Add User" class="btn btn-primary" name="add_user">
    </div>
</form>
