<?php
date_default_timezone_set('Asia/Kolkata');

session_start();
include("includes/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
$user_id=$_SESSION['user_id'];
$message="";

if(isset($_POST['submit'])){
    $content=trim($_POST['content']);
    if($content!==""){
        $entry_date=date('Y-m-d H:i:s');
        $stmt=$conn->prepare("INSERT INTO entries(user_id, content, entry_date) VALUES(?,?,?)");
        $stmt->bind_param("iss", $user_id, $content,$entry_date);
        $stmt->execute();
        $stmt->close();
        header("Location: journal.php");
        exit();
    }
    else
    $message="Content cannot be empty.";
}

if(isset($_POST['update'])){
    $id=$_POST['entry_id'];
    $updated=trim($_POST['updated_content']);
    if($updated!==""){
        
        $update_date = date('Y-m-d H:i:s');
        $stmt=$conn->prepare("UPDATE entries SET content=?, updated_at=? WHERE id=? AND user_id=?");
        $stmt->bind_param("ssii", $updated, $update_date, $id, $user_id);
        $stmt->execute();
        $stmt->close();
        header("Location: journal.php");
        exit();
    }
    else
    $message="Updated content cannot be empty.";   
}
if(isset($_GET['delete'])){
    $delete_id=$_GET['delete'];
    $stmt=$conn->prepare("DELETE FROM entries WHERE id=? AND user_id=?");
    $stmt->bind_param("ii", $delete_id, $user_id);
    $stmt->execute();
    $stmt->close();
    header("Location: journal.php");
    exit();   
}

//filter data
$search=$_POST['search']??"";
$date_filter=$_POST['date']??"";

$query="SELECT * FROM entries WHERE user_id=?";
$params=[$user_id];
$types="i";

if($search!==""){
    $query.=" AND content LIKE ?";
    $params[]="%". $search ."%";
    $types.="s";
}
if($date_filter!==""){
    $query.=" AND DATE(entry_date)=?";
    $params[]=$date_filter;
    $types.="s";
}
$query.=" ORDER BY entry_date DESC";

$stmt=$conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result=$stmt->get_result();
$entries=$result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpeg" href="images/mindmirror-logo.png">
    <title>Your Journal</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <style>
        body,a{
            margin:0;
            padding:0;
            font-family:'Montserrat',sans-serif;
            background-color: rgb(255, 232, 224);
            text-align:center;
            color: #4E3D42;
        
        }
        textarea{
            padding: 14px;
            resize:vertical;
            width:55%;
            border: none;
            margin: auto;
            font-family:'Montserrat',sans-serif;
        }
        input:focus, textarea:focus{
            outline:none;
        }
        .filter-journal-cont{
            width: 55%;
            margin:auto;
        }
        .filter-journal-cont .journal-form textarea{
            width: 100%;
            box-sizing: border-box;
        }
        .filter-box{
            background-color:  #F7C1B2;
            padding: 50px;
        }
        .entry{
            background-color:rgb(252, 214, 196);
            color: #4E3D42;
            padding: 40px;
            border-radius: 20px;
            width:45%;
            margin-top:25px;
            text-align:left;
            
        }
        .entries-container{
            display:flex;
            flex-direction:column;
            align-items:center;
        }
        .entry-time{
            display: flex;
            align-items: center;
            justify-content: space-between;
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
            font-size: 15px;
        }
        button:hover, a:hover{
            background-color: rgb(106, 106, 211);
            transform: scale(1.07);
            transition: transform 0.3s;
            transition-timing-function: ease-in-out;
        }
        input{
            font-family:'Montserrat',sans-serif;
            color: #4E3D42;
            padding: 5px;
            width: 230px;
            height: 35px;
            border-radius: 4px;
            border: none;
            margin-right: 23px;
            text-align: center;
        }
        header{
            color:rgb(127, 127, 191);
        }
        @media screen and (max-width: 1200px){
            h1{
                font-size: 22px;
                margin-bottom: 5px;
            }
            p{
                font-size: 13px;
                margin-top: 0;
            }
            .filter-box{                
                padding: 20px;
            }
            input{
                padding: 5px;
                width: 130px;
                height: 25px;
                font-size: 12px;
                margin-right: 12px;
            }
            textarea{
                padding: 17px;
                font-size: 12px;
            }
            a,button{
                font-size: 10px;
                padding: 5px 3px;
                border-radius: 3px;
                margin:0;
            }
            .filter-journal-cont{
                width: 60%;
                margin:auto;
            }
            .journal-form{
                height: 230px;
            }
            .entry{
                border-radius: 15px;
                width: 60%;
                padding: 16px;
            }
            .entry p{
                font-size: 12px;
            }
            .entry-time{
                margin: 9px 0px;
                font-size: 15px;
            }
            .entry-time p{
                font-size: 14px !important;
            }
            .entry textarea{
                width: 75% !important;
            }
        }
        @media screen and (max-width: 426px){
            h1{
                font-size: 19px;
                margin-bottom: 3px;
            }
            p{
                font-size: 10px;
                margin-top: 0;
            }
            .filter-box{                
                padding: 12px;
            }
            input{
                padding: 5px;
                width: 80px;
                height: 11px;
                font-size: 8px;
                margin-right: 3px;
            }
            textarea{
                padding: 10px;
                font-size: 10px;
            }
            a,button{
                font-size: 9px;
                padding: 3px 5px;
                border-radius: 3px;
                margin:0;
            }
            .filter-journal-cont{
                width: 75%;
                margin:auto;
            }
            .journal-form{
                height: 200px;
            }
            .entry{
                border-radius: 10px;
                width: 65%;
                padding: 16px;
            }
            .entry p{
                font-size: 10px;
            }
            .entry-time{
                margin: 7px 0px;
                font-size: 9px;
            }
            .entry-time p{
                font-size: 8px !important;
            }
            .entry textarea{
                width: 75% !important;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Your Daily Journal</h1>
        <p> Reflect. Record. Reconnect. </p>
    </header>    

    <?php if($message): ?>
        <p style="margin: 15px; text-align:center; color: red;"><?php echo $message; ?></p>
    <?php endif; ?>

    <div class="filter-journal-cont">
        <div class="filter-box">
            <form method="POST" action="journal.php">
                <input type="text" name="search" placeholder="Search by keyword" value= "<?php echo htmlspecialchars($search); ?>" >
                <input type="date" name="date" value="<?php echo htmlspecialchars($date_filter); ?>" >
                <button type="submit">Apply Filter</button>
            </form>
        </div>
    
        <div class="journal-form">
            <form method="POST">
                <textarea name="content" rows="10" placeholder="What's on your mind?"></textarea><br><br>
                <button type="submit" name="submit" >Save Entry</button>
            </form>
        </div>
    </div>

    <?php if (count($entries)===0): ?>
        <p>No entries found.</p>
    <?php else: ?>
        <div class="entries-container">
            <?php foreach ($entries as $entry): ?>

                <div class="entry">

                    <div class="entry-time">
                        <strong><?php echo date("M d, Y h:i A",strtotime($entry['entry_date'])); ?></strong>
                        <?php if(!empty($entry['updated_at'])):?>
                            <p style="font-style:italic; font-size: 14px; color:rgb(144, 132, 132);   " >Last updated: <?php echo date("M d, Y h:i A",strtotime($entry['updated_at'])); ?></p>
                        <?php endif; ?>
                    </div>

                    <form method="POST">
                        <input type="hidden" name="entry_id" value="<?php echo $entry['id'];?>">
    
                        <p id="text_<?php echo $entry['id']; ?>"><?php echo htmlspecialchars($entry['content']); ?></p>
                        <textarea style="display:none; width:94%; margin:12px;" rows="8" name="updated_content" id="textarea_<?php echo $entry['id']; ?>"><?php echo htmlspecialchars($entry['content']); ?></textarea>
    
                        <div id="actions_<?php echo $entry['id']?>">
                            <button type="button" onclick="edit(<?php echo $entry['id']; ?>)">Edit</button>
                            <a href="journal.php?delete=<?php echo $entry['id']?>" onclick="return confirm('Delete this entry?');">
                                Delete
                            </a>
                        </div>
    
                        <div style="display:none;" id="editActions_<?php echo $entry['id']?>">
                            <button name="update" >Update</button>
                            <button type="button" onclick="cancelEdit(<?php echo $entry['id']; ?>)" >Cancel</button>
                        </div>
    
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <a href="dashboard.php" style="margin: 20px; display:inline-block;">← Back to Dashboard</a>
    <script>
        function edit(id){
            document.getElementById('text_'+id).style.display="none";
            document.getElementById('textarea_'+id).style.display="block";
            document.getElementById('actions_'+id).style.display="none";
            document.getElementById('editActions_'+id).style.display="block";
        }
        function cancelEdit(id){
            document.getElementById('text_'+id).style.display="block";
            document.getElementById('textarea_'+id).style.display="none";
            document.getElementById('actions_'+id).style.display="block";
            document.getElementById('editActions_'+id).style.display="none";
        }
    </script>
</body>
</html>
