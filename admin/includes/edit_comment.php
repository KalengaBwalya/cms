<?php
    if(isset($_GET['edit'])){
        
        $the_comment_id = $_GET['edit'];
        
        //SELECT comment by Id
        $query = "SELECT * FROM comments WHERE comment_id = {$the_comment_id} ";

        $select_comment_by_id = mysqli_query($connection, $query);

        confirmQuery($select_comment_by_id);
       

        while($row = mysqli_fetch_array($select_comment_by_id, MYSQLI_ASSOC)){
          
            $comment_id = $row['comment_id'];
            $comment_post_id = $row['comment_post_id'];
            $comment_author = $row['comment_author'];
            $comment_date = $row['comment_date'];
            $comment_content = $row['comment_content'];
            $comment_status = $row['comment_status']; 
            $comment_email = $row['comment_email'];
        }
    }
?>
<?php

    global $connection;   

    if(isset($_POST['update_comment'])){
       
        $comment_post_id =  $_POST['comment_post_id'];
        $comment_author =  $_POST['comment_author'];
        $comment_email = $_POST['comment_email'];
        $comment_status = $_POST['comment_status'];  
        $comment_content =  $_POST['comment_content'];
        
        
        
         //SQL Injection Escape
        $comment_author = mysqli_real_escape_string($connection, $comment_author);
        $comment_email = mysqli_real_escape_string($connection, $comment_email);
        $comment_status = mysqli_real_escape_string($connection, $comment_status);
        $comment_content = mysqli_real_escape_string($connection, $comment_content);
        

        //Update Comment Query
        $query = "UPDATE comments SET comment_post_id = '{$comment_post_id}', comment_author";
        $query .= "= {$comment_author}, comment_email = '{$comment_email}', comment_status";
        $query .= "= '{$comment_status}', comment_content = '{$comment_content}'"; 


        $update_post_query = mysqli_query($connection, $query);

        confirmQuery($update_post_query);
    }

?>


<form action="" method="post">
    <div class="form-group">
        <label for="post_cat_id">In Response To:</label>
        <br />
        <select class="form-control" id="" name="comment_post_id">
            <?php
            
                //selected post

                $query = "SELECT post_title FROM posts WHERE post_id = {$comment_post_id}";
                $selected_post_query = mysqli_query($connection, $query);

                confirmQuery($selected_post_query);

                while($row = mysqli_fetch_array($selected_post_query)){
                    $selected_post_title = $row['post_title'];
                    $post_id = $row['post_id'];
                    
                    echo "<option value='{$post_id}'>{$selected_post_title}</option>";
                }
            
            
                //FIND all Posts query
                $query = "SELECT * FROM posts WHERE post_id != {$comment_post_id}";
                $select_posts_query = mysqli_query($connection, $query);

                confirmQuery($select_posts_query);

                while($row = mysqli_fetch_array($select_posts_query)){
                    $post_title = $row['post_title'];
                    $post_id = $row['post_id'];
                    
                    echo "<option value='{$post_id}'>{$post_title}</option>";
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_author">Author</label>
        <input type="text" class="form-control" name="comment_author" value="<?php echo $comment_author; ?>">
    </div>
    <div class="form-group">
        <label for="post_status">Status</label>
        <input type="text" class="form-control" name="comment_status" value="<?php echo $comment_status; ?>">
    </div>
    <div class="form-group">
        <label for="post_tags">Email</label>
        <input type="text" class="form-control" name="comment_email" value="<?php echo $comment_email; ?>">
    </div>
    <div class="form-group">
        <label for="post_content">Content</label>
        <textarea type="text" class="form-control" cols="10" rows="8" name="comment_content"><?php echo $comment_content; ?>
        </textarea>
    </div>
    <div class="form-group">
        <input type="submit" value="Update Comment" class="btn btn-primary" name="update_comment">
    </div>
</form>
