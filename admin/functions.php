<?php

function confirmQuery($result){
    global $connection;
    if(!$result){
    die("QUERY FAILED.".mysqli_error($connection));
    }
}


function insertCategories(){
    
    global $connection;
    
    if(isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];

        //SQL injection escape
        $cat_title = mysqli_real_escape_string($connection, $cat_title);

        if($cat_title == "" || empty($cat_title)) {

            echo "This field should not be empty";

        } else {

            //Insert category query
            $query = "INSERT INTO categories(cat_title) ";
            $query .= "VALUES('{$cat_title}')";

            $add_category_query = mysqli_query($connection, $query);

            confirmQuery($add_category_query);
        }
    }
}

function categoryEditForm(){
    
    if(isset($_GET['update'])){
    ?>
<form action="" method="post">
    <div class="form-group">
        <label for="cat_title">Edit Category</label>
        <input class="form-control" type="text" name="cat_title" value="<?php 
                                                                        if(isset($_GET['update'])){
                                                                            $update_string = $_GET['update_string'];
                                                                            echo $update_string;
                                                                        } 
                                                                            ?>">
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_category" value="Edit Category">
    </div>
</form>
<?php
    }
}


function findAllCategories(){
    
    global $connection;
    
     //FIND ALL CATEGORIES query
    $query = "SELECT * FROM categories";
    $selected_categories_query = mysqli_query($connection, $query);
    
    confirmQuery($selected_categories_query);

    while($row = mysqli_fetch_array($selected_categories_query)){
        $cat_name = $row['cat_title'];
        $cat_id = $row['cat_id'];

?>
<tr>
    <?php echo "<td>{$cat_id}</td>"; ?>
    <?php echo "<td>{$cat_name}</td>"; ?>
    <?php echo "<td><a href='categories.php?delete={$cat_id}&show={$cat_name}'>Delete<a/></td>"; ?>
    <?php echo "<td><a href='categories.php?update={$cat_id}&update_string={$cat_name}'>Update<a/></td>"; ?>
</tr>

<?php       
    }    
}

function deleteCategories(){
    
    global $connection;
    
        //DELETE query
    if(isset($_GET['delete'])){
        $the_cat_id = $_GET['delete'];
        $the_cat_name = $_GET['show'];

        $query = "DELETE FROM categories WHERE cat_id = '{$the_cat_id}'";

        $delete_category_query = mysqli_query($connection, $query);


        if(!$delete_category_query){
            die("QUERY FAILED").mysqli_error($connection);
        } else {
            header("Location: categories.php");
        }
    }
                                    
}

function updateCategories(){
    
    global $connection;
    
    //UPDATE query
    if(isset($_POST['update_category'])){
        $update_cat_id = $_GET['update'];
        $update_cat_name = $_POST['cat_title'];

        //SQL injection escape
        $update_cat_name = mysqli_real_escape_string($connection, $update_cat_name);


        $query = "UPDATE categories SET cat_title = '{$update_cat_name}'";
        $query .= " WHERE cat_id = '{$update_cat_id}'";

        $update_category_query = mysqli_query($connection, $query);


        if(!$update_category_query){
            die("QUERY FAILED").mysqli_error($connection);
        } else {
            header("Location: categories.php");
        }
    }

}

?>