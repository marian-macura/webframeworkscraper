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
           
$bsql="select count(*) as boot from frm where framework='bootstrap'";
$bresult=mysqli_query($conn,$bsql);
$data=mysqli_fetch_assoc($bresult);
$prom2=$data['boot'];
           
$fousql="select count(*) as found from frm where framework='foundation'";
$fouresult=mysqli_query($conn,$fousql);
$data=mysqli_fetch_assoc($fouresult);
$prom3=$data['found'];
           
$masql="select count(*) as mater from frm where framework='materialize'";
$maresult=mysqli_query($conn,$masql);
$data=mysqli_fetch_assoc($maresult);
$prom4=$data['mater'];

$bulsql="select count(*) as bulma from frm where framework='bulma'";
$bulresult=mysqli_query($conn,$bulsql);
$data=mysqli_fetch_assoc($bulresult);
$prom5=$data['bulma'];



$nosql="select count(*) as nooo from frm where framework='N/A'";
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
                ['Framework', 'Využití'],
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
                        color: 'black',
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
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
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
            <div class="col-6 l-minus">
                <div class="statistiky">
                    <h3 class="center">Statistiky frameworků</h3>
                    <hr>
                    <p>Celkem testovaných webů: <?php echo "$prom1"?></p>
                    <p>Weby používající Boostrap: <?php echo "$prom2"?><br>
                        Weby používající Foundation: <?php echo "$prom3"?><br>
                        Weby používající Materialize: <?php echo "$prom4"?><br>
                        Weby používající Bulma: <?php echo "$prom5"?><br></p>
                    <p>Weby, které neobsahují tyto frameworky: <?php echo "$prom6"?></p>
                </div>
            </div>




            <div class="col-6 r-minus">
                <div class="statistiky">
                    <h3 class="center">Graf rozdělení</h3>
                    <hr>
                    <div id="piechart_3d"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="container statistiky-table">
        <h3 class="center">Tabulka záznamů v databázi</h3>
        <hr>
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
    <div class="push"></div>
    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" class="init">
        $(document).ready(function() {
            $('#example').DataTable();
        });

    </script>
</body>

</html>
