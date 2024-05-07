<html>   

  <head>   

    <title>Pagination in PHP</title>   

    <link rel="stylesheet"  

    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">   

    <style>   

    table {  

        border-collapse: collapse;  

    }  

        .inline{   

            display: inline-block;   

            float: right;   

            margin: 20px 0px;   

        }            

        input, button{   

            height: 34px;   

        }    

    .items {   

        display: inline-block;   

    }   

    .items a {   

        font-weight:bold;   

        font-size:18px;   

        color: black;   

        float: left;   

        padding: 8px 16px;   

        text-decoration: none;   

        border:1px solid black;  

        margin: 2px; 

    }   

    .items a.active {   

            background-color: rgba(175, 201, 244, 0.97);   

    }   

    .items a:hover:not(.active) {   

        background-color: #87ceeb;   

    }   

        </style>   

  </head> 

  <body>   

  <center>  

    <?php      

        // Connect to the database

        $conn = mysqli_connect('localhost', 'root', '');  

        if (! $conn) {  

            die("Connection failed" . mysqli_connect_error());  

            }  

                else {  

            mysqli_select_db($conn, 'myDatabase');  

        }       

        // variable to store number of rows per page

        $limit = 5;    

        // update the active page number

        if (isset($_GET["page"])) {    

            $page_number  = $_GET["page"];    

        }    

        else {    

          $page_number=1;    

        }       

        // get the initial page number

        $initial_page = ($page_number-1) * $limit;       

        // get data of selected rows per page 

        $getQuery = "SELECT * FROM items LIMIT $initial_page, $limit";     

        $result = mysqli_query ($conn, $getQuery);    

    ?>     

    <div class="container">   

      <br>   

      <div>   

        <h1> Pagination in PHP </h1>    

        <table class="table table-striped table-condensed    

                                          table-bordered">   

          <thead>   

            <tr>   

              <th width="10%">ID</th>   

              <th>Name</th>   

              <th>Category</th>   

              <th>Price</th>   

            </tr>   

          </thead>   

          <tbody>   

    <?php     

            while ($row = mysqli_fetch_array($result)) {    

                  // Table head

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

     <div class="Items">    

      <?php  

        $getQuery = "SELECT COUNT(*) FROM Items";     

        $result = mysqli_query($conn, $getQuery);     

        $row = mysqli_fetch_row($result);     

        $total_rows = $row[0];              

    echo "</br>";            

        // get the required number of pages

        $total_pages = ceil($total_rows / $limit);     

        $pageURL = "";             

        if($page_number>=2){   

            echo "<a href='index.php?page=".($page_number-1)."'>  Prev </a>";   

        }                          

        for ($i=1; $i<=$total_pages; $i++) {   

          if ($i == $page_number) {   

              $pageURL .= "<a class = 'active' href='index.php?page="  

                                                .$i."'>".$i." </a>";   

          }               

          else  {   

              $pageURL .= "<a href='index.php?page=".$i."'>   

                                                ".$i." </a>";     

          }   

        };     

        echo $pageURL;    

        if($page_number<$total_pages){   

            echo "<a href='index.php?page=".($page_number+1)."'>  Next </a>";   

        }     

      ?>    

      </div>    

      <div class="inline">   

      <input id="page" type="number" min="1" max="<?php echo $total_pages?>"   

      placeholder="<?php echo $page_number."/".$total_pages; ?>" required>   

      <button onClick="go2Page();">Go</button>   

     </div>    

    </div>   

  </div>  

</center>   

  <script>   

    function go2Page()   

    {   

        var page = document.getElementById("page").value;   

        page = ((page><?php echo $total_pages; ?>)?<?php echo $total_pages; ?>:((page<1)?1:page));   

        window.location.href = 'index.php?page='+page;   

    }   

  </script>  

  </body>   

</html>  