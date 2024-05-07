How to Implement Ajax-Based Pagination?

Pagination in PHP can also be done using an Ajax-based method. Using Ajax, you don’t have to refresh the page every time you go to a different page. So, for example, if you have your data divided into 4 pages. Then you can visit any page without refreshing it. In this method, you need to create the following three files:

    index.php
    database.php
    pagination.php

Step 1: Create an index.php file

Create an index.php file to include AJAX which will allow you to visit a page without refreshing it. It will trigger the click event and load the page without refreshing it. This also makes the loading of the web pages faster. Insert the following code into the index.php file.

<?php

include('database.php'); 

$limit = 4;

$query = "SELECT COUNT(*) FROM items";  

$result = mysqli_query($conn, $query);  

$row = mysqli_fetch_row($result);  

$total_rows = $row[0];  

$total_pages = ceil($total_rows / $limit); 

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="utf-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>PHP Pagination AJAX</title>

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">

<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<link rel="stylesheet" href="css/style.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>

<body>

    <div class="container">

        <div class="table-wrapper">

            <div class="table-title">

                <div class="row">

                    <div class="col-sm-12">

                       <h2 align = "center">Pagination in PHP using AJAX</h2>               

                    </div>

                </div>

            </div>

            <div id="target-content">loading...</div>           

            <div class="clearfix">              

                    <ul class="pagination">

                    <?php 

                    if(!empty($total_pages)){

                        for($i=1; $i<=$total_pages; $i++){

                                if($i == 1){

                                    ?>

                                <li class="pageitem active" id="<?php echo $i;?>"><a href="JavaScript:Void(0);" data-id="<?php echo $i;?>" class="page-link" ><?php echo $i;?></a></li>                                                           

                                <?php 

                                }

                                else{

                                    ?>

                                <li class="pageitem" id="<?php echo $i;?>"><a href="JavaScript:Void(0);" class="page-link" data-id="<?php echo $i;?>"><?php echo $i;?></a></li>

                                <?php

                                }

                        }

                    }

                                ?>

                    </ul>

               

            </div>

        </div>

    </div>

    <script>

    $(document).ready(function() {

        $("#target-content").load("pagination.php?page=1");

        $(".page-link").click(function(){

            var id = $(this).attr("data-id");

            var select_id = $(this).parent().attr("id");

            $.ajax({

                url: "pagination.php",

                type: "GET",

                data: {

                    page : id

                },

                cache: false,

                success: function(dataResult){

                    $("#target-content").html(dataResult);

                    $(".pageitem").removeClass("active");

                    $("#"+select_id).addClass("active");                  

                }

            });

        });

    });

</script>

</body>

</html>
Step 2: Create a database.php file

Create a file to connect your PHP files to the database “myDatabase”. It creates a separate file, to simply import it into all other files instead of inserting the connection code in each file. Insert the following code into this file and save it.

<?php

    $server_name = "localhost";

    $user_name = "root";

    $password = "";

    $db="myDatabase";

    $conn = mysqli_connect($server_name, $user_name, $password,$db);

    if (!$conn) {

        die("Connection failed: " . mysqli_connect_error());

    }

?>
Step 3: Create a pagination.php file

Create a pagination.php file which will contain the code to fetch the table records and paginate them to display the data into multiple pages. Insert the following code into this file:

<?php

include('database.php');

$limit = 5;  

if (isset($_GET["page"])) { $page_number  = $_GET["page"]; } else { $page_number=1; };  

$initial_page = ($page_number-1) * $limit;  

$sql = "SELECT * FROM items LIMIT $initial_page, $limit";  

$result = mysqli_query($conn, $sql);  

?>

<table class="table table-bordered table-striped">  

<thead>  

<tr>  

<th>ID</th>  

<th>Name</th>  

<th>Category</th>  

<th>Price</th>  

</tr>  

</thead>  

<tbody>  

<?php  

while ($row = mysqli_fetch_array($result)) {  

?>  

            <tr>  

            <td><?php echo $row["ID"]; ?></td>  

            <td><?php echo $row["Name"]; ?></td>

            <td><?php echo $row["Category"]; ?></td>

            <td><?php echo $row["Price"]; ?></td>

            </tr>  

<?php  

};  

?>  

</tbody>  

</table>      

To display the output in a webpage, save all these files in a project folder and run the “index.php” file in a localhost server. 
Output
