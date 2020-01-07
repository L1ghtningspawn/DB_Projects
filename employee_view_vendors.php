<?php
    define("IN_CODE", 1);
    include 'dbconfig2.php';

    if (count($_COOKIE['Elogin']) > 0){
        echo "<TABLE border=1>\n";
        echo "<TR><TD><b>ID<TD><b>Name<TD><b>Address<TD><b>City<TD><b>State<TD><b>Zipcode<TD><b>Location(Latitude,Lognitude)\n";
    
        $query = "select vendor_id, name, address, city, state, zipcode, concat(latitude,',', Longitude) as location  from VENDOR;";
        $result = mysqli_query($con , $query);
        if($result){
            if(mysqli_num_rows($result)>0){			
                while($row = mysqli_fetch_array($result))
                {
                    echo "<TR><TD>" . $row['vendor_id'] . "<TD>" . $row['name'] . "<TD>" . $row['address'] . "<TD>" . $row['city'] . "<TD>" . $row['state'] . "<TD>" . $row['zipcode']
                    . "<TD>" . $row['location'];

                }
            }
        }
        else{
            echo "db error";
        }
        echo '</table>';
        //google maps
        print <<<_HTML_
        <html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['table']});
      google.charts.setOnLoadCallback(drawTable);

      function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('number', 'ID');
        data.addColumn('string', 'Name');
        data.addColumn('string', 'Address');
        data.addColumn('string', 'City');
        data.addColumn('string', 'State');
        data.addColumn('string', 'Zipcode');
        data.addColumn('string', 'Location(Latitude,Lognitude)');
        data.addRows([
_HTML_;

echo "[{v: 10}, 'Mike', 'home', 'city', 'state', 'zip', 'place']";
/*$query = "select vendor_id, name, address, city, state, zipcode, concat(latitude,',', Longitude) as location  from VENDOR;";
$result = mysqli_query($con , $query);
if($result){
    if(mysqli_num_rows($result)>0){			
        while($row = mysqli_fetch_array($result))
        {
            echo "[{v: " . $row['vendor_id'] . "}, '". $row['name'] . "', '". $row['address'] . "','" . $row['city'] . "','" . $row['state'] 
            . "','" . $row['zipcode']
            . "','" . $row['location'] . "],";

        }
    }
}
else{
    echo "db error";
}*/
print <<<_HTML_
        ]);

        var table = new google.visualization.Table(document.getElementById('table_div'));

        table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
      }
    </script>
  </head>
  <body>
    <div id="table_div"></div>
  </body>
</html>
_HTML_;
    }
    else{
        echo "You must login first to view this page!";
        echo '<br><a href="employee_login_p2.php"> Employee Login Page </a>';
}  
?>