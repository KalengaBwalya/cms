<?php
    if(isset($_GET['edit'])){
        
        $the_post_id = $_GET['edit'];
        
        $query = "SELECT * FROM posts WHERE post_id = {$the_post_id} ";

        $select_post_by_id = mysqli_query($connection, $query);

        confirmQuery($select_post_by_id);
       

        while($row = mysqli_fetch_array($select_post_by_id, MYSQLI_ASSOC)){
          
            $post_category_id = $row['post_category_id'];
            $post_title = $row['post_title'];
            $post_author = $row['post_author'];
            $post_date = $row['post_date'];
            $post_image = $row['post_image'];
            $post_content = $row['post_content'];
            $post_tags = $row['post_tags'];
            $post_comment_count = $row['post_comment_count'];
            $post_status = $row['post_status'];         
        }
    }
?>
<?php

    global $connection;   

    if(isset($_POST['update_post'])){
       
        $post_title =  $_POST['post_title'];
        $post_category_id = $_POST['post_category_id'];
        $post_author = $_POST['post_author'];
        $post_status = $_POST['post_status'];
        
        $post_image = $_FILES['post_image']['name'];
        $post_image_temp = $_FILES['post_image']['tmp_name'];
        
        
        $post_tags =  $_POST['post_tags'];
        $post_content =  $_POST['post_content'];
        
        
        //Image Upload
        move_uploaded_file($post_image_temp, "../images/$post_image");
        
        if(empty($post_image)) {
            $query = "SELECT * FROM posts WHERE post_id = {$the_post_id}";
            
            $select_posts_query = mysqli_query($connection, $query);
            
            while($row = mysqli_fetch_array($select_posts_query)){
                $post_image = $row['post_image'];
            }
        }
        
         //SQL Injection Escape
        $post_title = mysqli_real_escape_string($connection, $post_title);
        $post_author = mysqli_real_escape_string($connection, $post_author);
        $post_status = mysqli_real_escape_string($connection, $post_status);
        $post_tags = mysqli_real_escape_string($connection, $post_tags);
        $post_content = mysqli_real_escape_string($connection, $post_content);

        //Update Posts Query
        $query = "UPDATE posts SET post_title = '{$post_title}', post_category_id";
        $query .= "= {$post_category_id}, post_author = '{$post_author}', post_status";
        $query .= "= '{$post_status}', post_image = '{$post_image}', post_tags = '{$post_tags}',";
        $query .= "post_date = now(), post_content = '{$post_content}' WHERE post_id = {$the_post_id}"; 


        $update_post_query = mysqli_query($connection, $query);

        confirmQuery($update_post_query);
    }

?>


<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" class="form-control" name="post_title" value="<?php echo $post_title; ?>">
    </div>
    <div class="form-group">
        <label for="post_cat_id">Post Category</label>
        <br />
        <select name="post_category_id" id="" class="form-control">
           <option value="<?php 
               
                //FIND Post CATEGORY query
                $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id}";
                $select_category_query = mysqli_query($connection, $query);

                confirmQuery($select_category_query);

                while($row = mysqli_fetch_array($select_category_query)){
                    $cat_name = $row['cat_title'];
                    $cat_id = $row['cat_id'];
                  
                    echo "$cat_id";
                }
               
               
               ?>"><?php echo "$cat_name"; ?>
             
            </option>
            <?php
            
                //FIND other CATEGORIES query
                $query = "SELECT * FROM categories WHERE cat_id != {$post_category_id}";
                $select_categories_query = mysqli_query($connection, $query);

                confirmQuery($select_categories_query);

                while($row = mysqli_fetch_array($select_categories_query)){
                    $cat_name = $row['cat_title'];
                    $cat_id = $row['cat_id'];
                    
                    echo "<option value='{$cat_id}'>{$cat_name}</option>";
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_author">Post Author</label>
        <input type="text" class="form-control" name="post_author" value="<?php echo $post_author; ?>">
    </div>
    <div class="form-group">
        <label for="post_status">Post Status</label>
        <input type="text" class="form-control" name="post_status" value="<?php echo $post_status; ?>">
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <br />
        <img width="100" src="../images/<?php echo $post_image; ?>" alt="image preview">
        <br />
        <br />
        <input type="file" name="post_image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags; ?>">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea type="text" class="form-control" cols="10" rows="8" name="post_content"><?php echo $post_content; ?>
        </textarea>
    </div>
    <div class="form-group">
        <input type="submit" value="Update Post" class="btn btn-primary" name="update_post">
    </div>
</form>
