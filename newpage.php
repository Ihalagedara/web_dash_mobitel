<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KPI Analytics Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>  
    
    
    

    </head>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg,rgb(233, 233, 255) 0%,rgb(228, 234, 255) 100%);
            min-height: 100vh;
            color: #333;
        }


        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: rgba(255, 255, 255, 0.1);
            background-color: white;
            backdrop-filter: blur(5px);
            border-radius: 20px;
            padding: 10px;
            margin-bottom: 10px;
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
            color: black;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header-small {
            max-width: 50px;
            background: rgba(255, 255, 255, 0.1);
            background-color: white;
            backdrop-filter: blur(5px);
            border-radius: 20px;
            padding: 10px;
            margin-bottom: 10px;
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
            color: black;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .basic-text{
            font-family: 'Times New Roman', Times, serif;
            font-size: 2px;
            text-align: center;
            color: black;
        }
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
            padding: 20px;
        }

        .metrics-grid-small {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(600px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
            padding: 10px;
        }

        .metrics-grid-small-dis {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(600px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
            padding: 10px;
        }

        .metric-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 5px;
            padding: 20px;
            
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: transform 0.3s ease;
        }

        .metric-card:hover {
            transform: translateY(-3px);
        }

        .metric-value {
            font-size: 2rem;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
        }

        .metric-label {
            color: #666;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .comparison-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            background: white;
            border-radius: 10px;
            margin-bottom: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .comparison-card:hover {
            transform: translateY(-3px);
        }

        .header h4 {
            color: white;
            font-size: 2.5rem;
            font-weight: 300;
            margin-bottom: 10px;
        }

        .header p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1rem;
        }

        .change-positive { color: #6bcf7f; }
        .change-negative { color: #ff6b6b; }
        .change-neutral { color: #000000; }

        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 2;
            top: 0;
            left: 0;
            background-color: #c3ccf9;
            overflow-x: hidden;
            transition: 0.3s;
            padding-top: 60px;
        }

        .sidenav a {
            padding: 10px 20px;
            text-decoration: none;
            font-size: 20px;
            color: hsl(0, 0%, 0%);
            display: block;
            transition: 0.2s;
        }

        .sidenav a:hover {
            color: #ffffff;
            background-color: #3b66bba7;
        }

        .sidenav .closebtn {
            position: absolute;
            top: 5px;
            right: 10px;
            font-size: 36px;
            color: hsl(0, 0%, 0%);
        }

    </style>
    <body>
        
    <?php
    // === Connect to MySQL ===
    $host = '';
    $db = '';
    $user = '';
    $pass = '';

    $kpi1 = $_GET['kpi'];
    $dis1 = $_GET['dis'];
    $band1 = $_GET['band'];

    echo "<script>console.log(" . json_encode($kpi1) . ");</script>";
    
    echo "<script>console.log(" . json_encode($dis1) . ");</script>";

    echo "<script>console.log(" . json_encode($band1) . ");</script>";

    $col_num = $kpi1 . '_NUM';
    $col_den = $kpi1 . '_DEN';


    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query_data = [];

    if ($dis1 == "All" && $band1 == "All") {
        //echo "<script>console.log(" . json_encode("sql ALL ALL") . ");</script>";
        $sql1 = "SELECT * FROM (
                    SELECT Date, SUM($col_num) / SUM($col_den) AS total_kpi
                    FROM RNO_LTE_KPI_TRENDS_BH
                    GROUP BY Date
                    ORDER BY Date DESC
                    LIMIT 30
                ) AS sub
                ORDER BY Date ASC";
        $stmt = $conn->prepare($sql1);
    }
    elseif ($band1 == "All") {
        //echo "<script>console.log(" . json_encode("sql band") . ");</script>";
        $sql1 = "SELECT * FROM (
                    SELECT Date, SUM($col_num) / SUM($col_den) AS total_kpi
                    FROM RNO_LTE_KPI_TRENDS_BH
                    WHERE Cell_Name LIKE ?
                    GROUP BY Date
                    ORDER BY Date DESC
                    LIMIT 30
                ) AS sub
                ORDER BY Date ASC";
        $stmt = $conn->prepare($sql1);
        $searchParam = $dis1 . '%';
        $stmt->bind_param("s", $searchParam);
    }
    elseif ($dis1 == "All") {
        //echo "<script>console.log(" . json_encode("sql dis") . ");</script>";
        $sql1 = "SELECT * FROM (
                    SELECT Date, SUM($col_num) / SUM($col_den) AS total_kpi
                    FROM RNO_LTE_KPI_TRENDS_BH
                    WHERE Frequency_band = ?
                    GROUP BY Date
                    ORDER BY Date DESC
                    LIMIT 30
                ) AS sub
                ORDER BY Date ASC";
        $stmt = $conn->prepare($sql1);
        $stmt->bind_param("i", $band1);
    }
    else {
        //echo "<script>console.log(" . json_encode("sql dis, band") . ");</script>";
        $sql1 = "SELECT * FROM (
                    SELECT Date, SUM($col_num) / SUM($col_den) AS total_kpi
                    FROM RNO_LTE_KPI_TRENDS_BH
                    WHERE Cell_Name LIKE ? AND Frequency_band = ?
                    GROUP BY Date
                    ORDER BY Date DESC
                    LIMIT 30
                ) AS sub
                ORDER BY Date ASC";
        $stmt = $conn->prepare($sql1);
        $searchParam = $dis1 . '%';
        $stmt->bind_param("si", $searchParam, $band1);  // "s" for string, "i" for integer
    }

    // Only execute if statement is prepared
    if ($stmt) {
        //echo "<script>console.log(" . json_encode("ok") . ");</script>";
        $stmt->execute();
        $result1 = $stmt->get_result();
        //echo "<script>console.log(" . json_encode($result1) . ");</script>";

        if ($result1 && $result1->num_rows > 0) {
            //echo "<script>console.log(" . json_encode("ok") . ");</script>";
            while ($row = $result1->fetch_assoc()) {
                $query_data[] = $row;
            }
        }
    } else {
        //echo "<script>console.log(" . json_encode("failed") . ");</script>";
        die("Statement preparation failed: " . $conn->error);
    }

    $sql = "SELECT * FROM your_table LIMIT 10";
    $result = $conn->query($sql);

    $table_data = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $table_data[] = $row;
        }
    }

    $conn->close();
    ?>

        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="#">Home</a>
            <a href="#">KPI Trend</a>
            <a href="#">Cell wise trend</a>
        </div>

        <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>

        <div class="dashboard-container">

            
            <div class="header"><h1>RNO KPI Trend</h1></div>
        
            <div class="dashboard-container">
                <div class="metrics-grid-small">
                    <select id="myDropdown" class="metrics-grid-small-dis">
                    <option value="All" <?php if ($dis1 == "All") echo "selected"; ?>>All</option>
                    <option value="AM" <?php if ($dis1 == "AM") echo "selected"; ?>>AM</option>
                    <option value="AN" <?php if ($dis1 == "AN") echo "selected"; ?>>AN</option>
                    <option value="BD" <?php if ($dis1 == "BD") echo "selected"; ?>>BD</option>
                    <option value="BT" <?php if ($dis1 == "BT") echo "selected"; ?>>BT</option>
                    <option value="CB" <?php if ($dis1 == "CB") echo "selected"; ?>>CB</option>
                    <option value="CO" <?php if ($dis1 == "CO") echo "selected"; ?>>CO</option>
                    <option value="GL" <?php if ($dis1 == "GL") echo "selected"; ?>>GL</option>
                    <option value="GM" <?php if ($dis1 == "GM") echo "selected"; ?>>GM</option>
                    <option value="HM" <?php if ($dis1 == "HM") echo "selected"; ?>>HM</option>
                    <option value="JF" <?php if ($dis1 == "JF") echo "selected"; ?>>JF</option>
                    <option value="KG" <?php if ($dis1 == "KG") echo "selected"; ?>>KG</option>
                    <option value="KL" <?php if ($dis1 == "KL") echo "selected"; ?>>KL</option>
                    <option value="KN" <?php if ($dis1 == "KN") echo "selected"; ?>>KN</option>
                    <option value="KU" <?php if ($dis1 == "KU") echo "selected"; ?>>KU</option>
                    <option value="KY" <?php if ($dis1 == "KY") echo "selected"; ?>>KY</option>
                    <option value="LAN" <?php if ($dis1 == "LAN") echo "selected"; ?>>LAN</option>
                    <option value="LBD" <?php if ($dis1 == "LBD") echo "selected"; ?>>LBD</option>
                    <option value="LCB" <?php if ($dis1 == "LCB") echo "selected"; ?>>LCB</option>
                    <option value="LCC" <?php if ($dis1 == "LCC") echo "selected"; ?>>LCC</option>
                    <option value="LCZ" <?php if ($dis1 == "LCZ") echo "selected"; ?>>LCZ</option>
                    <option value="LGL" <?php if ($dis1 == "LGL") echo "selected"; ?>>LGL</option>
                    <option value="LGM" <?php if ($dis1 == "LGM") echo "selected"; ?>>LGM</option>
                    <option value="LGZ" <?php if ($dis1 == "LGZ") echo "selected"; ?>>LGZ</option>
                    <option value="LJF" <?php if ($dis1 == "LJF") echo "selected"; ?>>LJF</option>
                    <option value="LKL" <?php if ($dis1 == "LKL") echo "selected"; ?>>LKL</option>
                    <option value="LKU" <?php if ($dis1 == "LKU") echo "selected"; ?>>LKU</option>
                    <option value="LKY" <?php if ($dis1 == "LKY") echo "selected"; ?>>LKY</option>
                    <option value="LML" <?php if ($dis1 == "LML") echo "selected"; ?>>LML</option>
                    <option value="LMR" <?php if ($dis1 == "LMR") echo "selected"; ?>>LMR</option>
                    <option value="LMT" <?php if ($dis1 == "LMT") echo "selected"; ?>>LMT</option>
                    <option value="LPO" <?php if ($dis1 == "LPO") echo "selected"; ?>>LPO</option>
                    <option value="LPT" <?php if ($dis1 == "LPT") echo "selected"; ?>>LPT</option>
                    <option value="LRT" <?php if ($dis1 == "LRT") echo "selected"; ?>>LRT</option>
                    <option value="LTR" <?php if ($dis1 == "LTR") echo "selected"; ?>>LTR</option>
                    <option value="LVU" <?php if ($dis1 == "LVU") echo "selected"; ?>>LVU</option>
                    <option value="ML" <?php if ($dis1 == "ML") echo "selected"; ?>>ML</option>
                    <option value="MO" <?php if ($dis1 == "MO") echo "selected"; ?>>MO</option>
                    <option value="MR" <?php if ($dis1 == "MR") echo "selected"; ?>>MR</option>
                    <option value="MT" <?php if ($dis1 == "MT") echo "selected"; ?>>MT</option>
                    <option value="MU" <?php if ($dis1 == "MU") echo "selected"; ?>>MU</option>
                    <option value="NU" <?php if ($dis1 == "NU") echo "selected"; ?>>NU</option>
                    <option value="PO" <?php if ($dis1 == "PO") echo "selected"; ?>>PO</option>
                    <option value="PT" <?php if ($dis1 == "PT") echo "selected"; ?>>PT</option>
                    <option value="RT" <?php if ($dis1 == "RT") echo "selected"; ?>>RT</option>
                    <option value="TR" <?php if ($dis1 == "TR") echo "selected"; ?>>TR</option>
                    <option value="VU" <?php if ($dis1 == "VU") echo "selected"; ?>>VU</option>
                    <option value="ZBAT" <?php if ($dis1 == "ZBAT") echo "selected"; ?>>ZBAT</option>
                    <option value="ZBIY" <?php if ($dis1 == "ZBIY") echo "selected"; ?>>ZBIY</option>
                    <option value="ZDEH" <?php if ($dis1 == "ZDEH") echo "selected"; ?>>ZDEH</option>
                    <option value="ZDOM" <?php if ($dis1 == "ZDOM") echo "selected"; ?>>ZDOM</option>
                    <option value="ZHOM" <?php if ($dis1 == "ZHOM") echo "selected"; ?>>ZHOM</option>
                    <option value="ZJAL" <?php if ($dis1 == "ZJAL") echo "selected"; ?>>ZJAL</option>
                    <option value="ZKAD" <?php if ($dis1 == "ZKAD") echo "selected"; ?>>ZKAD</option>
                    <option value="ZKDU" <?php if ($dis1 == "ZKDU") echo "selected"; ?>>ZKDU</option>
                    <option value="ZKEL" <?php if ($dis1 == "ZKEL") echo "selected"; ?>>ZKEL</option>
                    <option value="ZKOT" <?php if ($dis1 == "ZKOT") echo "selected"; ?>>ZKOT</option>
                    <option value="ZKSB" <?php if ($dis1 == "ZKSB") echo "selected"; ?>>ZKSB</option>
                    <option value="ZMAH" <?php if ($dis1 == "ZMAH") echo "selected"; ?>>ZMAH</option>
                    <option value="ZMRT" <?php if ($dis1 == "ZMRT") echo "selected"; ?>>ZMRT</option>
                    <option value="ZNUG" <?php if ($dis1 == "ZNUG") echo "selected"; ?>>ZNUG</option>
                    <option value="ZWAT" <?php if ($dis1 == "ZWAT") echo "selected"; ?>>ZWAT</option>
                    </select>

                    <select id="myDropdown_band" class="metrics-grid-small-dis">
                    <option value="All" <?php if ($band1 == All) echo "selected"; ?>>All</option>
                    <option value="1" <?php if ($band1 == 1) echo "selected"; ?>>1</option>
                    <option value="3" <?php if ($band1 == 3) echo "selected"; ?>>3</option>
                    <option value="5" <?php if ($band1 == 5) echo "selected"; ?>>5</option>
                    <option value="40" <?php if ($band1 == 40) echo "selected"; ?>>40</option>

                    </select>


                    

                </div>
                <div>
                        <button id="myButton">Query</button>
                    </div>
                <div class="metrics-grid-small">
                    <canvas id="kpiChart" width="600" height="200"></canvas>
                </div>

                
                
            </div>
        </div>

            

    </body>

    <script>
        const kpi = new URLSearchParams(window.location.search).get('kpi');
        console.log("KPI selected:", kpi);

        $(document).ready(function() {

            // Open Side Nav
            $('#openNavBtn').on('click', function() {
                $('#mySidenav').css('width', '300px');
            });
        });

        $(document).ready(function() {
            // Close Side Nav
            $('#closeNavBtn').on('click', function() {
                $('#mySidenav').css('width', '0');
            });
        });
        
        
        
        $(document).ready(function() {
            $('#myDropdown').select2({
            placeholder: "Select a District",
            
            });
        });

        $(document).ready(function() {
            $('#myDropdown_band').select2({
            placeholder: "Select a Band",
            
            });
        });

        let dis = new URLSearchParams(window.location.search).get('dis');
        $('#myDropdown').on('change', function() {
            dis = $(this).val();
            console.log("District selected:", dis);
            
        });

        let band = new URLSearchParams(window.location.search).get('band');
        $('#myDropdown_band').on('change', function() {
            band = $(this).val();
            console.log("Band selected:", band);
            
        });

        $(document).ready(function() {
            $('#myButton').on('click', function() {
                window.location.href = `newpage.php?kpi=${encodeURIComponent(kpi)}&dis=${encodeURIComponent(dis)}&band=${encodeURIComponent(band)}`;
            });
        });

        



        

        

        

        

    </script>



    <script>

        
        const kpin = new URLSearchParams(window.location.search).get('kpi');
        const query_data1 = <?php echo json_encode($query_data); ?>;

        const dates = query_data1.map(item => item.Date);
        const kpiValues = query_data1.map(item => parseFloat(item.total_kpi));

        const ctx = document.getElementById('kpiChart').getContext('2d');
        const kpiChart = new Chart(ctx, {
            type: 'line', // or 'bar'
            data: {
                labels: dates,
                datasets: [{
                    label: kpin,
                    data: kpiValues,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    fill: false,
                    tension: 0.2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: { display: true, text: 'Date' }
                    },
                    y: {
                        
                        title: { display: true, text: kpin }
                    }
                }
            }
             
        });

        

        
    </script>


</html>