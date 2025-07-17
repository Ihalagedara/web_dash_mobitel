<!DOCTYPE html>
<html lang="eng">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KPI Analytics Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    
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

        
    .navbar {
      background-color: #333;
      overflow: hidden;
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 1000;
    }

    .navbar a {
      float: left;
      display: block;
      color: white;
      text-align: center;
      padding: 14px 20px;
      text-decoration: none;
    }

    .navbar a:hover {
      background-color: #575757;
    }

    .navbar .icon {
      display: none;
    }

    /* Responsive - hamburger new */
    @media screen and (max-width: 600px) {
      .navbar a:not(:first-child) {
        display: none;
      }

      .navbar a.icon {
        float: right;
        display: block;
      }
    }

    @media screen and (max-width: 600px) {
      .navbar.responsive {
        position: relative;
      }

      .navbar.responsive a.icon {
        position: absolute;
        right: 0;
        top: 0;
      }

      .navbar.responsive a {
        float: none;
        display: block;
        text-align: left;
      }
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
            height: 100%; /* 100% Full-height */
            width: 0; /* 0 width - change this with JavaScript */
            position: fixed; /* Stay in place */
            z-index: 1; /* Stay on top */
            top: 0; /* Stay at the top */
            left: 0;
            background-color: #111; /* Black*/
            overflow-x: hidden; /* Disable horizontal scroll */
            padding-top: 60px; /* Place content 60px from the top */
            transition: 0.5s; /* 0.5 second transition effect to slide in the sidenav */
            }

            /* The navigation menu links */
            .sidenav a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
            transition: 0.3s;
            }

            /* When you mouse over the navigation links, change their color */
            .sidenav a:hover {
            color: #f1f1f1;
            }

            /* Position and style the close button (top right corner) */
            .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
            }

            /* Style page content - use this if you want to push the page content to the right when you open the side navigation */
            #main {
            transition: margin-left .5s;
            padding: 20px;
            }

            /* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
            @media screen and (max-height: 450px) {
            .sidenav {padding-top: 15px;}
            .sidenav a {font-size: 18px;}
            }

    </style>
    <body>

        <div class="navbar" id="myNavbar">
        <a href="#home">Home</a>
        <a href="#services">Services</a>
        <a href="#contact">Contact</a>
        <a href="javascript:void(0);" class="icon" onclick="toggleNav()">
            &#9776; <!-- Hamburger icon -->
        </a>
        </div>

        <div class="dashboard-container">

            
            <div class="header"><h1>RNO KPI Trend</h1></div>
            
            
        
            <div class="metrics-grid">
                <div class="metric-card", id="container1"></div>
                <div class="metric-card", id="container2"></div>
                <div class="metric-card", id="container3"></div>
                <div class="metric-card", id="container4"></div>
                
            </div>
            <div class="metrics-grid">
                <div id="container" class="metrics-grid-small"></div>
            </div>
        </div>


    </body>

    <?php
    // === Connect to MySQL ===
    $host = '';
    $db = '';
    $user = '';
    $pass = '';

    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // === Fetch KPI Data ===
    $sql = "SELECT COUNT(DISTINCT Cell_Name), SUM(KEA_L_DL_Data_Volume_GB), SUM(L_Traffic_ActiveUser_Avg), SUM(VoLTE_Traffic_Erl) FROM RNO_LTE_KPI_TRENDS_BH WHERE (DATE(Date) = CURDATE() - INTERVAL 1 DAY) AND (Cell_active_state = 'CELL_ACTIVE');";
    $result = $conn->query($sql);

    $kpi_data = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $kpi_data[] = $row;
        }
    }

    $kpi_values = ['KEA_L_Average_CQI_DEN','KEA_L_Average_CQI_NUM', 'KEA_L_Call_Drop_Rate_P_DEN','KEA_L_Call_Drop_Rate_P_NUM', 'KEA_L_CCE_Avg_Utilization_P_DEN','KEA_L_CCE_Avg_Utilization_P_NUM', 
    'KEA_L_Cell_Availability_P_DEN','KEA_L_Cell_Availability_P_NUM', 'KEA_L_CSFB_Execution_Rate_P_DEN','KEA_L_CSFB_Execution_Rate_P_NUM', 'KEA_L_CSFB_Preparation_Succ_Rate_P_DEN','KEA_L_CSFB_Preparation_Succ_Rate_P_NUM',
    'KEA_L_DL_Cell_Avg_Throughput_Mbps_DEN','KEA_L_DL_Cell_Avg_Throughput_Mbps_NUM','KEA_L_DL_IBLER_P_DEN','KEA_L_DL_IBLER_P_NUM', 'KEA_L_DL_PRB_Usage_Rate_P_DEN','KEA_L_DL_PRB_Usage_Rate_P_NUM', 
    'KEA_L_DL_RBLER_P_DEN','KEA_L_DL_RBLER_P_NUM', 'KEA_L_DL_Retransmission_Rate_P_DEN','KEA_L_DL_Retransmission_Rate_P_NUM', 'KEA_L_DL_User_Avg_Throughput_Mbps_DEN','KEA_L_DL_User_Avg_Throughput_Mbps_NUM',
    'KEA_L_E_RAB_Congestion_Rate_P_DEN','KEA_L_E_RAB_Congestion_Rate_P_NUM', 'KEA_L_E_RAB_Setup_Success_Rate_P_DEN','KEA_L_E_RAB_Setup_Success_Rate_P_NUM', 'KEA_L_Inter_Freq_HO_Success_Rate_P_DEN','KEA_L_Inter_Freq_HO_Success_Rate_P_NUM',
    'KEA_L_Intra_Freq_HO_Success_Rate_P_DEN','KEA_L_Intra_Freq_HO_Success_Rate_P_NUM', 'KEA_L_RACH_Success_Rate_P_DEN','KEA_L_RACH_Success_Rate_P_NUM', 'KEA_L_RRC_Congestion_Rate_P_DEN','KEA_L_RRC_Congestion_Rate_P_NUM',
    'KEA_L_RRC_Setup_Success_Rate_all_P_DEN','KEA_L_RRC_Setup_Success_Rate_all_P_NUM', 'KEA_L_RRC_Setup_Success_Rate_service_P_DEN','KEA_L_RRC_Setup_Success_Rate_service_P_NUM', 'KEA_L_UL_Cell_Avg_Throughput_Mbps_DEN','KEA_L_UL_Cell_Avg_Throughput_Mbps_NUM',
    'KEA_L_UL_IBLER_P_DEN','KEA_L_UL_IBLER_P_NUM', 'KEA_L_UL_PRB_Usage_Rate_P_DEN','KEA_L_UL_PRB_Usage_Rate_P_NUM', 'KEA_L_UL_RBLER_P_DEN','KEA_L_UL_RBLER_P_NUM', 'KEA_L_UL_Retransmission_Rate_P_DEN','KEA_L_UL_Retransmission_Rate_P_NUM',
    'KEA_L_UL_User_Avg_Throughput_Mbps_DEN','KEA_L_UL_User_Avg_Throughput_Mbps_NUM'];


    $sum_columns = array_map(function($col) {
        return "SUM($col) AS sum_$col";
    }, $kpi_values);

    $sum_query = implode(',', $sum_columns);

    $sql1 = "SELECT $sum_query FROM RNO_LTE_KPI_TRENDS_BH WHERE (DATE(Date) = CURDATE() - INTERVAL 1 DAY) AND (Cell_active_state = 'CELL_ACTIVE');";
    $result1 = $conn->query($sql1);
    $kpi_data1 = [];
    if ($result1 && $result1->num_rows > 0) {
        while ($row = $result1->fetch_assoc()) {
            $kpi_data1[] = $row;
        }
    }
    $sql2 = "SELECT $sum_query FROM RNO_LTE_KPI_TRENDS_BH WHERE (DATE(Date) = CURDATE() - INTERVAL 2 DAY) AND (Cell_active_state = 'CELL_ACTIVE');";
    $result2 = $conn->query($sql2);
    $kpi_data2 = [];
    if ($result2 && $result2->num_rows > 0) {
        while ($row = $result2->fetch_assoc()) {
            $kpi_data2[] = $row;
        }
    }
    $conn->close();
    ?>

    <script>

        
        

        function toggleNav() {
            var navbar = document.getElementById("myNavbar");
            if (navbar.className === "navbar") {
                navbar.className += " responsive";
            } else {
                navbar.className = "navbar";
            }
            }
        const kpi_values = ['KEA_L_Average_CQI',	'KEA_L_Call_Drop_Rate_P',	'KEA_L_CCE_Avg_Utilization_P',	'KEA_L_Cell_Availability_P',	'KEA_L_CSFB_Execution_Rate_P',	'KEA_L_CSFB_Preparation_Succ_Rate_P',	'KEA_L_DL_Cell_Avg_Throughput_Mbps','KEA_L_DL_IBLER_P',	'KEA_L_DL_PRB_Usage_Rate_P',	'KEA_L_DL_RBLER_P',	'KEA_L_DL_Retransmission_Rate_P',	'KEA_L_DL_User_Avg_Throughput_Mbps',	'KEA_L_E_RAB_Congestion_Rate_P',	'KEA_L_E_RAB_Setup_Success_Rate_P',	'KEA_L_Inter_Freq_HO_Success_Rate_P',	'KEA_L_Intra_Freq_HO_Success_Rate_P',	'KEA_L_RACH_Success_Rate_P',	'KEA_L_RRC_Congestion_Rate_P',	'KEA_L_RRC_Setup_Success_Rate_all_P',	'KEA_L_RRC_Setup_Success_Rate_service_P',	'KEA_L_UL_Cell_Avg_Throughput_Mbps','KEA_L_UL_IBLER_P',	'KEA_L_UL_PRB_Usage_Rate_P',	'KEA_L_UL_RBLER_P',	'KEA_L_UL_Retransmission_Rate_P',	'KEA_L_UL_User_Avg_Throughput_Mbps'];
        const n = kpi_values.length
        function createDivs(count, containerId, className, changeClassNameP,changeClassNameN, changeClassNameNeg) {
            const container = document.getElementById(containerId);

            if (!container) {
                console.error("Container not found!");
                return;
            }

            

            // Clear previous content
            container.innerHTML = "";

            const kpi_day1 = <?php echo json_encode($kpi_data1); ?>;
            const kpi_day2 = <?php echo json_encode($kpi_data2); ?>;

            for (let i = 1; i <= count; i++) {

                const newDiv = document.createElement('div');

                newDiv.onclick = function () {
                    window.location.href = `newpage.php?kpi=${encodeURIComponent(kpi_values[i-1])}&dis=All&band=All`;
                };

                const heading = document.createElement('h4');
                heading.textContent = kpi_values[i-1];

                const paragraph = document.createElement('p');
                const temTextDen = 'sum_'+kpi_values[i-1]+'_DEN';
                const temTextNum = 'sum_'+kpi_values[i-1]+'_NUM';
                let currentValue = kpi_day1[0][temTextNum]/kpi_day1[0][temTextDen];
                let previousValue = kpi_day2[0][temTextNum]/kpi_day2[0][temTextDen];

                paragraph.textContent = parseFloat(currentValue).toFixed(3) + ' | ' + parseFloat(previousValue).toFixed(3);

                const strongDiv = document.createElement('div')
                let changeValue = (currentValue - previousValue)/previousValue;
                const strongNew = document.createElement('strong')
                strongDiv.textContent = parseFloat(changeValue).toFixed(2)

                strongDiv.appendChild(strongNew)

                if ((changeValue>0) && (changeValue!=0)){
                    strongDiv.classList.add(changeClassNameP)
                }
                else{
                    if (changeValue<0) {
                        strongDiv.classList.add(changeClassNameNeg)
                    } 
                    else {
                        strongDiv.classList.add(changeClassNameN)
                    }
                }
                
                newDiv.appendChild(heading)
                newDiv.appendChild(paragraph)
                newDiv.appendChild(strongDiv)
                newDiv.classList.add(className)
                container.appendChild(newDiv);
                
            }
        }
        createDivs(n, "container", "comparison-card","change-positive","change-neutral","change-negative")

        function cell_count(kpi_data,dashName,containerId, valueClass, cellClass){
            
            
            
            const container1 = document.getElementById(containerId);

            if (!container1) {
                console.error("Container not found!");
                return;
            }

            // Clear previous content
            container1.innerHTML = "";
            const valeDiv = document.createElement('div');
            valeDiv.classList.add(valueClass);
            valeDiv.textContent = kpi_data;
            const nameDiv = document.createElement('div');
            nameDiv.classList.add(cellClass);
            nameDiv.textContent = dashName;
            container1.appendChild(valeDiv); 
            container1.appendChild(nameDiv)
        }
        const kpiData = <?php echo json_encode($kpi_data); ?>;
        
        
        const count1 = kpiData[0]["COUNT(DISTINCT Cell_Name)"];
        const count2 = kpiData[0]["SUM(KEA_L_DL_Data_Volume_GB)"];
        const formatted = parseFloat(count2/1000).toFixed(4);
        const count3 = parseFloat(kpiData[0]["SUM(L_Traffic_ActiveUser_Avg)"]).toFixed(3);
        
        const count4 = kpiData[0]["SUM(VoLTE_Traffic_Erl)"];
        cell_count(count1,"Cell Count","container1","metric-value", "metric-label");
        cell_count(formatted,"Downlink Traffic (TB)","container2","metric-value", "metric-label");
        cell_count(count3,"User Count","container3","metric-value", "metric-label");
        cell_count(count4,"VoLTE traffic","container4","metric-value", "metric-label");
        
    </script>

    

</html>