<?php
    if(isset($_GET['update'])){
        
        $the_user_id = $_GET['update'];
        
        $query = "SELECT * FROM users WHERE user_id = {$the_user_id} ";

        $select_user_by_id = mysqli_query($connection, $query);

        confirmQuery($select_user_by_id);
       

        while($row = mysqli_fetch_array($select_user_by_id, MYSQLI_ASSOC)){
          
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $username = $row['username'];
            $user_email = $row['user_email'];
            $user_password = $row['user_password'];        
        }
    }
?>
<?php

    global $connection;   

    if(isset($_POST['update_user'])){
        $the_user_id = $_GET['update'];
        $user_firstname =  $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_role = $_POST['user_role'];
        $username = $_POST['username'];
        
//        $post_image = $_FILES['post_image']['name'];
//        $post_image_temp = $_FILES['post_image']['tmp_name'];
        
        
        $user_email =  $_POST['user_email'];
        $user_password =  $_POST['user_password'];
        $date = date('d-m-y');
        
        
//        //Image Upload
//        move_uploaded_file($post_image_temp, "../images/$post_image");
//        
//        if(empty($post_image)) {
//            $query = "SELECT * FROM posts WHERE post_id = {$the_post_id}";
//            
//            $select_posts_query = mysqli_query($connection, $query);
//            
//            while($row = mysqli_fetch_array($select_posts_query)){
//                $post_image = $row['post_image'];
//            }
//        }
        
         //SQL Injection Escape
        $user_firstname = mysqli_real_escape_string($connection, $user_firstname);
        $user_lastname = mysqli_real_escape_string($connection, $user_lastname);
        $user_email = mysqli_real_escape_string($connection, $user_email);
        $username = mysqli_real_escape_string($connection, $username);
        $user_password = mysqli_real_escape_string($connection, $user_password);

        //Update Posts Query
        $query = "UPDATE users SET user_firstname = '{$user_firstname}', user_lastname";
        $query .= "= '{$user_lastname}', username = '{$username}', user_email";
        $query .= "= '{$user_email}', user_password = '{$user_password}', date = now(),";
        $query .= "user_role = '{$user_role}' WHERE user_id = {$the_user_id}"; 


        $update_user_query = mysqli_query($connection, $query);

        if(!$update_user_query){
            echo "ERROR! ".mysqli_error($connection);
        };
    }

?>


<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="user_firstname">Firstname</label>
        <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname; ?>">
    </div>
    <div class="form-group">
        <label for="user_lastname">Lastname</label>
        <input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname; ?>">
    </div>
    <div class="form-group">
        <label for="post_cat_id">Role</label>
        <br />
        <select name="user_role" id="" class="form-control">
           <option value="<?php 
               
                //FIND user role query
                $query = "SELECT user_role FROM users WHERE user_id = {$the_user_id}";
                $select_user_role_query = mysqli_query($connection, $query);

                if(!$select_user_role_query){
                    echo mysqli_error($connection);
                }

                while($row = mysqli_fetch_array($select_user_role_query)){
                    $the_user_role = $row['user_role'];
                  
                    echo "$the_user_role";
                }
                
               ?>"><?php echo "$the_user_role"; ?>
               
            </option>
            <?php
//                //FIND other roles query
//                $query = "SELECT user_role FROM users WHERE user_role != {$the_user_role}";
//                $select_user_roles_query = mysqli_query($connection, $query);
//
//                confirmQuery($select_user_roles_query);
//
//                while($row = mysqli_fetch_array($select_user_roles_query)){
//                    $user_id = $row['user_id'];
//                    $user_role = $row['user_role'];
//                    
//                    echo "<option value='{$user_role}'>{$user_role}</option>";
//                }
            ?>
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
        <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email" value="<?php echo $user_email; ?>">
    </div>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class="form-control" name="user_password" value="<?php echo $user_password; ?>">
    </div>

    <div class="form-group">
        <input type="submit" value="Update User" class="btn btn-primary" name="update_user">
    </div>
</form>
