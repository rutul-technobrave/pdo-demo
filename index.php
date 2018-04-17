<?php
require __DIR__.'/config/settings.php';
require __DIR__.'/config/dbConnection.php';

$dbh = new DBConnection($_config);
$dbh->dbc->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

$limit = 1;  
if (isset($_GET["page"]) && !empty($_GET['page'])) {
    $page  = $_GET["page"];     
} else { 
    $page=1;
    };  
$start_from = ($page-1) * $limit;  
$dbh->dbc->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
$sql = 'SELECT * FROM countries';
$stmt = $dbh->dbc->prepare($sql);
$stmt->execute([$start_from, $limit]);

  ?>
  
<!DOCTYPE html>
<html>
<head>
<style>
#customers {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

#customers td, #customers th {
    border: 1px solid #ddd;
    padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
}
.pagination {
    display: inline-block;
}

.pagination a {
    color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
}
</style>
</head>
<body>

<table id="customers">
    <div><a href="create.php">Create</a></div>
  <tr>
    <th>Country</th>
    <th>Country Code</th>
    <th>Country Currency</th>
  </tr>
  <?php
  foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row){
      echo '<tr>';
        echo '<td>';
        echo $row["country_name"];
        echo '</td>';
        echo '<td>';
        echo $row["country_code"];
        echo '</td>';
        echo '<td>';
        echo $row["country_currency"];
        echo '</td>';
      echo '</tr>';
  }?>
</table>
 
    <?php  
$sql = "SELECT COUNT(id) FROM posts";  
$rs_result = mysql_query($sql);  
$row = mysql_fetch_row($rs_result);  
$total_records = $row[0];  
$total_pages = ceil($total_records / $limit);  
$pagLink = "<div class='pagination'>";  
for ($i=1; $i<=$total_pages; $i++) {  
             $pagLink .= "<a href='index.php?page=".$i."'>".$i."</a>";  
};  
echo $pagLink . "</div>";  
?>
    
    
<div class="pagination">
  <a href="#">&laquo;</a>
  <a href="#">1</a>
  <a href="#">2</a>
  <a href="#">3</a>
  <a href="#">4</a>
  <a href="#">5</a>
  <a href="#">6</a>
  <a href="#">&raquo;</a>
</div>
</body>
</html>
