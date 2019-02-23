<table class="table table-bordered table-hover">
<thead>
    <tr>
        <th>Id</th>
        <th>Username</th>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
        <th>Role</th>
        <th>Date</th>
        <th>Admin</th>
        <th>Subscriber</th>
        <th>Update</th>
        <th>Delete</th>                            
    </tr>
</thead>
<tbody>
   

    <?php

        global $connection;
        $query = "SELECT * FROM users";

        $select_all_users_query = mysqli_query($connection, $query);

        confirmQuery($select_all_users_query);

        while($row = mysqli_fetch_array($select_all_users_query)){
            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_password = $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_role = $row['user_role'];
            $user_image = $row['user_image'];
            $date = $row['date'];
                   
            ?>
            <tr>
                <?php 
                    echo "<td>{$user_id}</td>";
                    echo "<td>{$username}</td>"; 
                    echo "<td>{$user_firstname}</td>"; 
                    echo "<td>{$user_lastname}</td>"; 
                    echo "<td>{$user_email}</td>";
                    echo "<td>{$user_role}</td>";
                    echo "<td>{$date}</td>";
                    echo "<td><a href='users.php?change_to_admin={$user_id}'>Admin<a/></td>";
                    echo "<td><a href='users.php?change_to_subscriber={$user_id}'>Subscriber<a/></td>";
                    echo "<td><a href='users.php?source=edit_user&update={$user_id}'>Update<a/></td>";
                    echo "<td><a href='users.php?delete={$user_id}'>Delete<a/></td>";
                ?>

            </tr>
    <?php
        }
    
    ?>
    
    <?php
        if(isset($_GET['delete'])){
            
            $the_user_id = $_GET['delete'];
            
            //delete user query
            $query = "DELETE FROM users WHERE user_id = {$the_user_id}";
            
            $delete_user_query = mysqli_query($connection, $query);
            
            if(!$delete_user_query){
                die("QUERY FAILED".mysqli_error($connection));
            } else {
                header("Location: users.php");
            }  
            
        } elseif(isset($_GET['change_to_admin'])){
            $the_user_id = $_GET['change_to_admin'];
            
            //Change to admin query
            $query = "UPDATE users SET user_role = 'admin' WHERE user_id = {$the_user_id}";
            
            $change_to_admin_query = mysqli_query($connection, $query);
            
            if(!$change_to_admin_query){
                die("QUERY FAILED".mysqli_error($connection));
            } else {
                header("Location: users.php");
            }        
            
            
        } elseif(isset($_GET['change_to_subscriber'])){
            $the_user_id = $_GET['change_to_subscriber'];
            
            //Change to subscriber query
            $query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = {$the_user_id}";
            
            $change_to_subscriber_query = mysqli_query($connection, $query);
            
            if(!$change_to_subscriber_query){
                die("QUERY FAILED".mysqli_error($connection));
            } else {
                header("Location: users.php");
            }        
        }
    
    ?>
   
</tbody>
</table>