<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Category</th>
            <th>Title</th>
            <th>Author</th>
            <th>Content</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Date</th>
            <th>Status</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>Unpublish</th>
            <th>Publish</th>

        </tr>
    </thead>
    <tbody>


        <?php

        global $connection;
        $query = "SELECT * FROM posts";

        $select_all_posts_query = mysqli_query($connection, $query);

        if(!$select_all_posts_query){
            die("QUERY FAILED".mysqli_error($connection));
        }

        while($row = mysqli_fetch_assoc($select_all_posts_query)){
            $post_id = $row['post_id'];
            $post_category_id = $row['post_category_id'];
            $post_title = $row['post_title'];
            $post_author = $row['post_author'];
            $post_date = $row['post_date'];
            $post_image = $row['post_image'];
            $post_content = $row['post_content'];
            $post_tags = $row['post_tags'];
            $post_comment_count = $row['post_comment_count'];
            $post_status = $row['post_status'];         
            ?>
        <tr>
            <?php 
            
                    echo "<td>{$post_id}</td>";
            
                     //FIND CATEGORY by id query
                    $query = "SELECT cat_title FROM categories WHERE cat_id = {$post_category_id}";
                    $select_category_query = mysqli_query($connection, $query);

                    confirmQuery($select_category_query);

                    while($row = mysqli_fetch_array($select_category_query)){
                        $the_cat_title = $row['cat_title'];      
                    }
                    echo "<td>{$the_cat_title}</td>"; 
                    echo "<td>{$post_title}</td>"; 
                    echo "<td>{$post_author}</td>"; 
                    echo "<td>{$post_content}</td>"; 
                    echo "<td><img width='200px' class='img-responsive' src='../images/{$post_image}'></td>"; 
                    echo "<td>{$post_tags}</td>"; 
                    echo "<td>{$post_comment_count}</td>";
                    echo "<td>{$post_date}</td>";
                    echo "<td>{$post_status}</td>";          
                    echo "<td><a href='posts.php?source=edit_post&edit={$post_id}'>Edit<a/></td>";
                    echo "<td><a href='posts.php?delete={$post_id}'>Delete<a/></td>"; 
                    echo "<td><a href='posts.php?unpublish={$post_id}'>Unpublish<a/></td>";
                    echo "<td><a href='posts.php?publish={$post_id}'>Publish<a/></td>";
                ?>

        </tr>
        <?php
        }
    
    ?>

        <?php
        if(isset($_GET['delete'])){
            
            $the_post_id = $_GET['delete'];
            
            $query = "DELETE FROM posts WHERE post_id = {$the_post_id}";
            
            $delete_post_query = mysqli_query($connection, $query);
            
            if(!$delete_post_query){
                die("QUERY FAILED".mysqli_error($connection));
            } else {
                header("Location: posts.php");
            }        
        } elseif (isset($_GET['publish'])){
            $the_post_id = $_GET['publish'];
            
            $query = "UPDATE posts SET post_status ='published' ";
            $query .= "WHERE post_id = {$the_post_id}";
            
            $publish_post_query = mysqli_query($connection, $query);
            
            if(!$publish_post_query){
                die("QUERY FAILED".mysqli_error($connection));
            } else {
                header("Location: posts.php");
            }        
        } elseif (isset($_GET['unpublish'])){
            $the_post_id = $_GET['unpublish'];
            
            $query = "UPDATE posts SET post_status = 'draft' ";
            $query .= "WHERE post_id = {$the_post_id}";
            
            $unpublish_post_query = mysqli_query($connection, $query);
            
            if(!$unpublish_post_query){
                die("QUERY FAILED".mysqli_error($connection));
            } else {
                header("Location: posts.php");
            }        
        }
    ?>
    </tbody>
</table>
