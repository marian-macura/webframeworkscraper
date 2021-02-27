<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "framework";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {die("Connection failed: " . $conn->connect_error);}
$result = mysqli_query($conn,"SELECT * FROM frm ORDER BY id DESC");

$fsql="select count(*) as total from frm";
$wresult=mysqli_query($conn,$fsql);
$data=mysqli_fetch_assoc($wresult);
$prom1=$data['total'];
           
$bsql="select count(*) as boot from frm where framework='Bootstrap'";
$bresult=mysqli_query($conn,$bsql);
$data=mysqli_fetch_assoc($bresult);
$prom2=$data['boot'];
           
$fousql="select count(*) as found from frm where framework='Foundation'";
$fouresult=mysqli_query($conn,$fousql);
$data=mysqli_fetch_assoc($fouresult);
$prom3=$data['found'];
           
$masql="select count(*) as mater from frm where framework='Materialize'";
$maresult=mysqli_query($conn,$masql);
$data=mysqli_fetch_assoc($maresult);
$prom4=$data['mater'];

$bulsql="select count(*) as bulma from frm where framework='Bulma'";
$bulresult=mysqli_query($conn,$bulsql);
$data=mysqli_fetch_assoc($bulresult);
$prom5=$data['bulma'];



$nosql="select count(*) as nooo from frm where framework='Žádný nebo neznámý framework'";
$noresult=mysqli_query($conn,$nosql);
$data=mysqli_fetch_assoc($noresult);
$prom6=$data['nooo'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/092029466e.js" crossorigin="anonymous"></script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        var num = "<?php echo $prom2 ?>";
        var num2 = "<?php echo $prom3 ?>";
        var num3 = "<?php echo $prom4 ?>";
        var num4 = "<?php echo $prom5 ?>";
        var num5 = "<?php echo $prom6 ?>";
        google.charts.load("current", {
            packages: ["corechart"]
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                ['Bootstrap', parseInt(num)],
                ['Foundation', parseInt(num2)],
                ['Materialize', parseInt(num3)],
                ['Bulma', parseInt(num4)],
                ['Neznámý/žádný', parseInt(num5)]
            ]);

            var options = {
                width: 600,
                height: 340,
                backgroundColor: 'red',
                legend: {
                    position: 'right',
                    textStyle: {
                        color: 'white',
                        fontSize: 16
                    }
                },
                backgroundColor: '',
                colors: ['#d73851', '#c9596a', '#993a49', '#a81d33', '#f6c7b6'],
                is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
            chart.draw(data, options);
        }

    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">

    <meta charset="UTF-8">
    <title>Statistiky frameworků</title>


</head>

<body>
    <h1 class="text-form-framework pt-4">Frameworky</h1>
    <button class="back" onclick="window.location.href='test.php'"><i class="fas fa-caret-square-left"></i></button>




    <div class="container">
        <div class="row">
            <div class="col-6">


                
<p class="py-3">
<?php  
echo "<div class='statove'><span class='udaj-title'>"."Celkem testovaných webů: " . $prom1 ."<br>"."</span></div>";
echo "<div class='statove'><span class='udaj-title'>"."Weby používající Boostrap: " . $prom2 ."<br>"."</span></div>";
echo "<div class='statove'><span class='udaj-title'>"."Weby používající Foundation: " . $prom3 ."<br>"."</span></div>";        
echo "<div class='statove'><span class='udaj-title'>"."Weby používající Materialize: " . $prom4 ."<br>"."</span></div>";  
echo "<div class='statove'><span class='udaj-title'>"."Weby používající Bulma: " . $prom5 ."<br>"."</span></div>";          
echo "<div class='statove'><span class='udaj-title'>"."Weby, které neobsahují tyto frameworky: " . $prom6 ."<br>"."</span></div>";       
?>
</p>

            </div>
            <div class="col-6">
                <div id="piechart_3d"></div>
            </div>
        </div>
    </div>
    <div class="container white py-2">
        <table id="example" class="display table table-responsive table-sm">
            <thead class="table-light">
                <tr>
                    <th>Název stránky</th>
                    <th>URL adresa</th>
                    <th>Používaný framework</th>

                </tr>
            </thead>
            <tbody>

                <?php  
                while($rows=$result->fetch_assoc()) 
                { 
             ?>
                <tr>
                    <td><?php echo $rows['title'];?></td>
                    <td><?php echo $rows['url'];?></td>
                    <td><?php echo $rows['framework'];?></td>

                </tr>
                <?php 
                } 
             ?>
            </tbody>
            <tfoot>
                <tr class="table-light">
                    <th>Název stránky</th>
                    <th>URL adresa</th>
                    <th>Používaný framework</th>
                </tr>
            </tfoot>
        </table>

    </div>

    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" class="init">
        $(document).ready(function() {
            $('#example').DataTable();
        });

    </script>
</body>
</html>