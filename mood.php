 <?php
session_start();
include 'includes/db.php';

if(!isset($_SESSION['username']) || !isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$username=$_SESSION['username'];
$user_id=$_SESSION['user_id'];

$latest_stmt=$conn->prepare("SELECT mood, note, entry_date FROM mood_log WHERE user_id=? ORDER BY entry_date DESC LIMIT 1");
$latest_stmt->bind_param("i",$user_id);
$latest_stmt->execute();
$latest_stmt->store_result();

$latest_mood = "";
$latest_note = "";
$latest_entryDate = "";

if($latest_stmt->num_rows==1){
    $latest_stmt->bind_result($latest_mood,$latest_note,$latest_entryDate);
    $latest_stmt->fetch();
}
else{
    echo"<p>No results found!</p>";
}
//filter data
$filter_mood=$_GET['filter_mood']??"";
$from_date=$_GET['from_date']??"";
$to_date_raw=$_GET['to_date']??"";
$to_date=$to_date_raw? $to_date_raw." 23:59:59":"";

$sql="SELECT mood,note,entry_date FROM mood_log WHERE user_id=?";
$params=[$user_id];
$types="i";

if($filter_mood){
    $sql.=" AND mood=?";
    $params[]=$filter_mood;
    $types.="s";
}
if($from_date){
    $sql.=" AND entry_date>=?";
    $params[]=$from_date;
    $types.="s";
}
if($to_date){
    $sql.=" AND entry_date<=?";
    $params[]=$to_date;
    $types.="s";
}

$sql.=" ORDER BY entry_date DESC";
$stmt=$conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result=$stmt->get_result();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mood Timeline</title>
    <link rel="icon" type="image/jpeg" href="images/mindmirror-logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <style>
        body{
                margin:0;
                padding:0;
                font-family:'Montserrat',sans-serif;
                background-color: rgb(255, 232, 224);
                text-align:center;
                color: #4E3D42;
        }
        .filter-box{
            background-color:  #F7C1B2;
            width:50%;
            margin:auto;
            padding: 50px;
        }
        .recent-mood{
            background-color:rgb(252, 214, 196);
            padding: 30px;
			border-radius: 30px;
			box-shadow: 5px 5px 3px 0.5px rgb(251, 172, 150);
            width:50%;
            margin:auto;
            margin-top: 20px;
            text-align:left;
        }
        .timeline-box{
            text-align:left;
            width:50%;
            margin:auto;
            padding: 30px;
        }
        .timeline{
            border-left: 4px solid  #4E3D42; 
        }
        .circle{
            position:absolute;
            background-color: #F7C1B2;
            border-radius:50%; 
            width:32px;
            height:32px;
            left: -18px;
            top: 18px;
        }
        .entry-card{
            padding: 9px 30px;   
            position: relative;
        }
        select,input{
            font-family:'Montserrat',sans-serif;
            color: #4E3D42;
            width: 120px;
            height: 30px;
            border-radius: 4px;
            border: none;
            
        }
        select:focus, input:focus{
            outline:none;
        }
        a,button{
            font-family:'Montserrat',sans-serif;
            margin: 10px;
            cursor: pointer;
            padding: 8px 10px;
            border-radius: 5px;
            border:none;
            background-color: rgb(59, 59, 237);
            color: aliceblue;
            text-decoration: none;
        }
        button:hover, a:hover{
            background-color: rgb(106, 106, 211);
            transform: scale(1.07);
            transition: transform 0.3s;
            transition-timing-function: ease-in-out;
        }
        .mood{
            font-size: 18px;
            font-weight: 900;
        }
        .note{
            font-style:italic;
            color:rgb(123, 109, 109);
            line-height: 25px;
            width: 90%;
        }
        .date{
            font-size: 14px;
            color:rgb(123, 109, 109);   
        }
        h1,h2{
            color:rgb(127, 127, 191);
        }
        @media screen and (max-width:970px){
            h1{
                font-size: 20px;
            }
            h2{
                font-size: 17px;
            }
            a,p,label{
                font-size: 12px;
            }
            .filter-box{
                width: 430px;
                padding: 15px;
            }
            .filter-box label{
                font-size: 9px;
            }
            .mood{
                font-size: 11px;
                font-weight: 900;
            }
            .note{
                font-style:italic;
                line-height: 15px;    
            }
            .date{
                font-size: 11px;
            }
            select,input,button{
                width: 100px;
                font-size: 10px;
                padding: 5px;
                height: 20px;
                
            }
            a,button{
                width: 50px;
            }
            .recent-mood{
                width: 400px;
                padding: 20px;
                border-radius: 15px;
            }
            .timeline-box{
                width:60%;
                margin:auto;
                padding-left: 20%;
            } 
            .timeline{
                border-left: 3px solid  #4E3D42; 
            }
            .circle{
                width:25px;
                height:25px;
                left: -14px;
            } 
         }
        @media screen and (max-width:680px){
            h1{
                font-size: 15px;
            }
            h2{
                font-size: 10px;
            }
            a,p,label{
                font-size: 10px;
            }
            .filter-box{
                width: 65%;
                padding: 5px;
            }
            .filter-box label{
                font-size: 9px;
            }
            .mood{
                font-size: 11px;
                font-weight: 900;
            }
            .note{
                font-style:italic;
                line-height: 11px;
                font-size: 10px;
            }
            .date{
                font-size: 9px;
            }
            select,input,button{
                width: 50px;
                font-size: 9px;
                padding: 1px;
                height: 15px;
                
            }
            a,button{
                width: 30px;
            }
            .recent-mood{
                width: 200px;
                padding: 15px;
                border-radius: 15px;
            }
            .timeline-box{
                width:60%;
                margin:auto;
                padding-left: 20%;
            } 
            .timeline{
                border-left: 3px solid  #4E3D42; 
            }
            .circle{
                width:22px;
                height:22px;
                left: -13px;
            } 
         }
         
    </style>
</head>
<body>
    <h1><?php echo htmlspecialchars(ucwords($username)); ?>'s Mood Timeline</h1>
    <form method="get">
        <div class="filter-box">
            <label for="filter_mood">Mood: </label>
            <select name="filter_mood">
                <option value="">All</option>
                <?php
                foreach($moods_quotes as $mood=>$quote){
                    echo "<option value=\"$mood\"".($filter_mood==$mood?" selected":"").">".htmlspecialchars(ucwords($mood))."</option>";
                }
                ?>
            </select>
            <label for="from_date">From:</label>
            <input type="date" name="from_date" value="<?= htmlspecialchars($from_date) ?>">
            <label for="to_date">To:</label>
            <input type="date" name="to_date" value="<?= htmlspecialchars($to_date_raw) ?>">               

            <button>Filter</button>
        </div>
    </form>

    <?php if($latest_entryDate && $latest_mood):?>
        <div class="recent-mood">
            <h2>Recently Logged Mood</h2>
            <p class="date"><?= date("M d, Y h:i A", strtotime($latest_entryDate));?></p>
            <p class="mood">Mood: <?= htmlspecialchars(ucwords($latest_mood));?></p>
            <p class="note" >"<?= htmlspecialchars(ucfirst($latest_note));?>"</p>
        </div>
    <?php endif;?>

    <div class="timeline-box">
        <?php if($result->num_rows>0): ?>
        <div class="timeline">
                <?php while($row=$result->fetch_assoc()):?>
                    <div class="entry-card">
                        <div class="circle"></div>
                        <div>
                            <p class="date"><?= date("M d, Y h:i A", strtotime($row['entry_date']));?></p>
                            <p class="mood">Mood: <?= htmlspecialchars(ucwords($row['mood']));?></p>
                            <p class="note" style="text-align:justify;">"<?= htmlspecialchars(ucfirst($row['note']));?>"</p>  
                        </div>
                    </div>
                <?php endwhile; ?>
        </div>
        <?php else: ?>
                <p style="text-align:center;">No mood entries for the selected filter.</p>
        <?php endif; ?>
    </div>
    <a href="dashboard.php">← Back to Dashboard</a>

</body>
</html>  
