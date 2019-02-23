<table class="table table-bordered table-hover">
<thead>
    <tr>
        <th>Id</th>
        <th>Author</th>
        <th>Comment</th>
        <th>Email</th>
        <th>Status</th>
        <th>In Response To</th>
        <th>Date</th>  
        <th>Approve</th> 
        <th>Unapprove</th>
        <th>Delete</th>
         
                                 
    </tr>
</thead>
<tbody>
   

    <?php

        global $connection;
        $query = "SELECT * FROM comments";

        $select_all_comments_query = mysqli_query($connection, $query);

        confirmQuery($select_all_comments_query);

        while($row = mysqli_fetch_array($select_all_comments_query)){
            $comment_id = $row['comment_id'];
            $comment_post_id = $row['comment_post_id'];
            $comment_author = $row['comment_author'];
            $comment_email = $row['comment_email'];
            $comment_content = $row['comment_content'];
            $comment_date = $row['comment_date'];
            $comment_status = $row['comment_status'];         
            ?>
            <tr>
                <?php 
                    echo "<td>{$comment_id}</td>";
                    echo "<td>{$comment_author}</td>"; 
                    echo "<td>{$comment_content}</td>"; 
                    echo "<td>{$comment_email}</td>"; 
                    echo "<td>{$comment_status}</td>";

                
                     //FIND Post by id query
                    $query = "SELECT post_title FROM posts WHERE post_id = {$comment_post_id}";
                    $select_post_query = mysqli_query($connection, $query);

                    confirmQuery($select_post_query);

                    while($row = mysqli_fetch_array($select_post_query)){
                        $the_post_title = $row['post_title'];      
                    }
                    echo "<td><a href='../post.php?p_id=$comment_post_id'>{$the_post_title}</a></td>"; 
                    echo "<td>{$comment_date}</td>";
                    echo "<td><a href='comments.php?approve={$comment_id}'>Approve<a/></td>";
                    echo "<td><a href='comments.php?unapprove={$comment_id}'>Unapprove<a/></td>"; 
                    echo "<td><a href='comments.php?delete={$comment_id}'>Delete<a/></td>";
                ?>

            </tr>
    <?php
        }
    
    ?>
    
    <?php
        if(isset($_GET['delete'])){
            
            $the_comment_id = $_GET['delete'];
            
            //delete comment query
            $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id}";
            
            $delete_comment_query = mysqli_query($connection, $query);
            
            if(!$delete_comment_query){
                die("QUERY FAILED".mysqli_error($connection));
            } else {
                header("Location: comments.php");
            }        
        }
    
    ?>
    <?php
        if(isset($_GET['approve'])){
            
            $comment_id = $_GET['approve'];
            
            //UPDATE comment query
            $query = "UPDATE comments SET comment_status = 'approved' ";
            $query .= "WHERE comment_id = {$comment_id}";
            $approve_status_query = mysqli_query($connection, $query);
            
            if(!$approve_status_query){
                die("QUERY FAILED".mysqli_error($connection));
            } else {
                header("Location: comments.php");
            }    
            
        } elseif(isset($_GET['unapprove'])){
            
            $comment_id = $_GET['unapprove'];
                
            $query = "UPDATE comments SET comment_status = 'unapproved' ";
            $query .= "WHERE comment_id = {$comment_id}";
            $unapprove_status_query = mysqli_query($connection, $query);
            
            if(!$unapprove_status_query){
                die("QUERY FAILED".mysqli_error($connection));
            } else {
                header("Location: comments.php");
            }        
        }
    ?>
</tbody>
</table>