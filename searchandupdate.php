<?php
    define("IN_CODE", 1);
    include 'dbconfig2.php';
    
    
    if (count($_COOKIE['Elogin']) > 0){
        echo "<a href='logout.php'> Logout </a><br>";
        print<<<_HTML_
            <br> Search products(enter * for all):<br><form method="POST" action="$_SERVER[PHP_SELF]">
            <input type="text" name="search" required="required">
            <input type="submit" value="Search!">
            </form>
_HTML_;
        if($_POST['search']){
                //search terms are seperated by spaces
                //need a function to seperate each term into its own string
                //store in array?
        
            print<<<_HTML_
                <html>
                <head>
                <title>Google Charts Tutorial</title>
                <script type = "text/javascript" src = "https://www.gstatic.com/charts/loader.js">
                </script>
                <script type = "text/javascript">
                    google.charts.load('current', {packages: ['table']});     
                </script>
                </head>
            
                <body>
                <div id = "container" style = "width: 550px; height: 400px; margin: 0 auto">
                </div>
                <script language = "JavaScript">
                function drawChart() {
                // Define the chart to be drawn.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Name');
                data.addColumn('string', 'Description');
                data.addColumn('number', 'Price');
                data.addColumn('number', 'Quanity');
                data.addColumn('string', 'Vendor');
                data.addRows([
_HTML_;
            $query = "select id,name,description,cost,sell_price,quanity,vendor_id,employee_id from Product where name=&'";
                        //Query here['samsung', 'lmao' , {v: 200, f: '$20'}, 50 , 'ikea']
            
            print<<<_HTML_
                ]);
                var options = {
                showRowNumber: true,
                width: '100%', 
                height: '100%'
                };
                    
                // Instantiate and draw the chart.
                var chart = new google.visualization.Table(document.getElementById('container'));
                chart.draw(data, options);
                }
                google.charts.setOnLoadCallback(drawChart);
                </script>
                </body>
                </html>
_HTML_;
        }
    
    }
    else{
        echo "You must login first to view this page!";
        echo '<br><a href="employee_login_p2.php"> Employee Login Page </a>';
    }
?>