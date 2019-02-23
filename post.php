<?php include "includes/header.php"; ?>
    <!-- Navigation -->
<?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>
                <?php
                
                if(isset($_GET['p_id'])){
                    
                    $the_post_id = $_GET['p_id'];
                } 
                
                    //SELECT posts by Id query
                    $query = "SELECT * FROM posts WHERE post_id = {$the_post_id}";
                    
                    $select_all_posts_query = mysqli_query($connection, $query);
                    
                    while($row = mysqli_fetch_array($select_all_posts_query, MYSQLI_ASSOC)){
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_image = $row['post_image'];
                        $post_date = $row['post_date'];
                        $post_content = $row['post_content'];
                        
                ?>
                     <!-- Blog Post -->
                <h2>
                   <?php echo "<a href='#'>{$post_title}</a>"; ?>
                </h2>
                <p class="lead">
                    by <?php echo "<a href='index.php'>{$post_author}</a>"; ?>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo "{$post_date}"; ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                <hr>
                <p><?php echo "{$post_content}"; ?></p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
                
                <?php } ?>
                
                
                <hr>

                <!-- Blog Comments -->

               <?php
                if(isset($_POST['create_comment'])){
                    $the_post_id = $_GET['p_id'];
                    $comment_author = $_POST['comment_author'];
                    $comment_email = $_POST['comment_email'];
                    $comment_content = $_POST['comment'];
                   
                    
                    //SQL Injection escape
                    $comment_author = mysqli_real_escape_string($connection, $comment_author);
                    $comment_email = mysqli_real_escape_string($connection, $comment_email);
                    $comment_content = mysqli_real_escape_string($connection, $comment_content);
                    
                    
                    //INSERT comment query
                    $query = "INSERT INTO comments(comment_post_id, comment_author, comment_email,";
                    $query .= "comment_content, comment_status, comment_date) VALUES({$the_post_id}, '{$comment_author}',";
                    $query .= "'{$comment_email}', '{$comment_content}', 'not approved', now())";
                    
                    $create_comment_query = mysqli_query($connection, $query);
                    
                    if(!$create_comment_query){
                        die("QUERY FAILED".mysqli_error($connection, $query));
                    }
                    
                    
                    
                    $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
                    $query .= "WHERE post_id = {$the_post_id}";
                    
                    $update_comment_count = mysqli_query($connection, $query);
                }
                ?>
               
              
                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="post" role="form">
                         <div class="form-group">
                           <label for="author">Name</label>
                            <input type="text" class="form-control" name="comment_author">
                        </div>
                          <div class="form-group">
                           <label for="email">Email</label>
                            <input type="email" class="form-control" name="comment_email">
                        </div>
                        <div class="form-group">
                           <label for="comment">Comment</label>
                            <textarea class="form-control" rows="3" name="comment"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <!-- Comment -->
                <?php
                $query = "SELECT * FROM comments WHERE comment_status = 'approved' ";
                $query .= "AND comment_post_id = {$the_post_id}";
                
                $approved_comment_query = mysqli_query($connection, $query);
                
                if(!$approved_comment_query){
                    die("QUERY FAILED".mysqli_error($connection));
                } 
                
                while($row = mysqli_fetch_array($approved_comment_query)){
                    $the_comment_author = $row['comment_author'];
                    $the_comment_date = $row['comment_date'];
                    $the_comment_content = $row['comment_content'];
                                  
                ?>
                
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo "$the_comment_author"?>
                            <small><?php echo "$the_comment_date"?></small>
                        </h4>
                        <?php echo "$the_comment_content"?>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
 
                        
               
                    
            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>
        <!-- Footer -->
<?php include "includes/footer.php"; ?>