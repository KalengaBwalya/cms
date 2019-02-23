<?php
    if(isset($_POST['create_post'])){
        
        //Input To Variable Assignment
        $post_title = $_POST['post_title'];
        $post_category_id = $_POST['post_category_id'];
        $post_author = $_POST['post_author'];
        $post_status = "published";
        
        $post_image = $_FILES['post_image']['name'];
        $post_image_temp = $_FILES['post_image']['tmp_name'];
        
        
        $post_tags = $_POST['post_tags'];
        $post_content = $_POST['post_content'];  
        $post_date = date('d-m-y');
        $post_comment_count = 0;
        
        
        //Image Upload
        move_uploaded_file($post_image_temp, "../images/$post_image");
        

        //SQL Injection Escape
        $post_title = mysqli_real_escape_string($connection, $post_title);
        $post_author = mysqli_real_escape_string($connection, $post_author);
        $post_tags = mysqli_real_escape_string($connection, $post_tags);
        $post_content = mysqli_real_escape_string($connection, $post_content);

        
        //INSERT Query
        $query = "INSERT INTO posts(post_title, post_category_id, post_author,";
        $query .= "post_status, post_image, post_tags, post_content, post_date,";
        $query .= " post_comment_count) VALUES('{$post_title}', {$post_category_id},";
        $query .= "'{$post_author}', '{$post_status}', '{$post_image}', '{$post_tags}',";
        $query .= "'{$post_content}', now(), '{$post_comment_count}')";
     
        
        $create_post_query = mysqli_query($connection, $query);
        
        
        confirmQuery($create_post_query);
    }
?>


<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" class="form-control" name="post_title">
    </div>
    <div class="form-group">
        <label for="post_cat_id">Post Category</label>
        <br />
        <select name="post_category_id" id="" class="form-control">
           <option value="">--- Select ---</option>
            <?php
                //FIND CATEGORIES query
                $query = "SELECT * FROM categories";
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
        <input type="text" class="form-control" name="post_author">
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="post_image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea type="text" class="form-control" cols="10" rows="8" name="post_content"></textarea>
    </div>
    <div class="form-group">
        <input type="submit" value="Publish Post" class="btn btn-primary" name="create_post">
    </div>
</form>
