<?php
session_start();
include 'includes/db.php';

if(!isset($_SESSION['username'])||!isset($_SESSION['user_id'])){
	header("Location:login.php");
	exit();
}
$username=$_SESSION['username'];
$user_id=$_SESSION['user_id'];

$last_date="No entries yet.";
$last_content="Start your journaling journey today.";

$stmt=$conn->prepare("SELECT entry_date, content FROM entries WHERE user_id=? ORDER BY entry_date DESC LIMIT 1");
$stmt->bind_param("i",$user_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($entry_date, $content);

if($stmt->fetch()){
	$last_date=date("F j, Y",strtotime($entry_date));
	$last_content=htmlspecialchars($content);
}
$is_first_time= ($last_date=="No entries yet." && $last_content=="Start your journaling journey today.");
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

    <style>
        body{
            margin:0;
            padding:0;
            font-family:'Montserrat',sans-serif;
            background-color: rgb(255, 232, 224);
        }
        header{
            display:flex;
            background-color: #F7C1B2;
			text-align:center;
			padding:40px;
			color:rgb(127, 127, 191);
            align-items:center;
            justify-content:center;
            opacity:0;
            animation: fadeDown 1s ease-in-out forwards;
            box-shadow: 0px 2px 10px 2px rgba(158, 149, 149, 0.7);
		}	
        @keyframes fadeDown{
            from{opacity: 0; transform:translateY(-20px);}
            to{opacity: 1; transform:translateY(0px);}
        }
        img{
            width:80px;
            height:110px;
        }
        .container{
            background-color: rgb(255, 232, 224);
            padding: 30px;
            display:flex;
            flex-direction:column;
            align-items:center;
        }
        .card{
            background-color:rgb(252, 214, 196);
			color: #4E3D42;
			padding: 30px;
			border-radius: 30px;
			width: 800px;
			box-shadow: 5px 5px 3px 0.5px rgb(251, 172, 150);
            margin-bottom: 30px;
            opacity:0;
            transform: translateY(50px);
            animation: fadeSlide 1s ease-in-out forwards;
        }
        @keyframes fadeSlide{
            to{opacity:1; transform: translateY(0px);}
        }
        .card:nth-child(1){animation-delay:0.2s;}
        .card:nth-child(2){animation-delay:0.4s;}
        .card:nth-child(3){animation-delay:0.6s;}

        .card p{
            font-size: 14px; 
        }
        a{
			display:inline-block;
			text-align: center;
			padding: 12px;
			font-size: 1.1rem;
			background-color: rgb(59, 59, 237);
			color: aliceblue;
			border:none;
			border-radius: 10px;
			text-decoration: none;
			margin-top:20px;
		}
		a:hover{
			background-color: rgb(106, 106, 211);
			transform: scale(1.07);
			transition: transform 0.3s;
			transition-timing-function: ease-in-out;
		}
        .quote{
            background-color: rgb(251, 172, 150);
            padding: 20px;
            border-left: 5px solid rgb(59, 59, 237);
            margin:40px;
            font-style:italic;
            border-radius: 10px;
            opacity:0;
            transform: translateY(50px);
            animation: fadeSlide 1s ease-in-out forwards;
            animation-delay: 0.8s;
        }
        .content{
            font-style:italic;
            color:rgb(123, 109, 109);
            line-height: 20px; 
            text-align: justify;
            margin-right: 50px;   
        }
        
        @media screen and (max-width:768px) {
            img{
                width:40px;
                height:50px;
            }
            header{
                padding: 25px;
            }
            .container{
                padding: 30px;
            }
            .card{
                width: 470px;
                padding: 15px;
            }
            p{
                font-size: 10px;
            }
            .card{
                border-radius: 20px;
            }
            .card p{
                
                font-size: 10px;
            }
            h2{
                font-size:14px;
            }
            a{
                font-size:12px;
            }
            h1{
                font-size:16px;
            }
            .quote{
                
                font-size: 10px;
                padding:15px;
            }
            .content{
                margin-right: 25px; 
            }
        }
        @media screen and (max-width:426px) {
            img{
                width:40px;
                height:50px;
            }
            header{
                padding: 15px;
            }
            .container{
                padding: 30px;
            }
            .card{
                width: 220px;
                padding: 15px;
            }
            p{
                font-size: 8px;
            }
            .card{
                border-radius: 20px;
            }
            .card p{
                
                font-size: 8px;
            }
            h2{
                font-size:12px;
            }
            a{
                font-size:10px;
            }
            h1{
                font-size:14px;
            }
            .quote{
                
                font-size: 8px;
                padding:15px;
            }
            .content{
                line-height: 14px;    
            }
            
        }
       
    </style>
</head>
<body>
	<header>
        <div>
            <?php
                if($is_first_time){
                    echo"<h1>Welcome, ".htmlspecialchars(ucwords($username))." !</h1>";
                    echo "<p>Let's begin your journey of self-discovery.</p>";
                    } 
                else {
                    echo"<h1>Welcome back, " . htmlspecialchars(ucwords($username))." !</h1>";
                    echo "<p>Your sanctuary of thoughts awaits.</p>";
                }
            ?>
        </div>
        <img src="./images/mirror.jpg">
	</header>
	<div class="container">
        <div class="card">
            <h2>How are you feeling today?</h2>
            <p>Take a breath and check in with your feelings. Every mood matters, and this is your space to explore them. Your emotions are worth exploring.</p>
            <a href="mood.php" class="button">Log Mood</a>
        </div>

        <div class="card">
            <h2>Last Journal Entry</h2>
            <p>You last wrote on <strong><?php echo $last_date; ?></strong>:</p>
            <p class="content" style="opacity: 0.8;">“<?php echo $last_content; ?>”</p>
            <a href="journal.php" class="button">View Journal</a>
        </div>

        <div class="card">
            <h2>Mood Analytics</h2>
            <p>Visualize your emotional trends and see how your journey unfolds over time.</p>
            <a href="analytics.php" class="button">View Insights</a>
        </div>

        <div class="quote" id="quoteBox"></div>
    </div>

    <script>
        const quotes = [
            "“You don’t have to control your thoughts. You just have to stop letting them control you.” — Dan Millman",
            "“Almost everything will work again if you unplug it for a few minutes, including you.” — Anne Lamott",
            "“Within you is a stillness and a sanctuary to which you can retreat at any time.” — Hermann Hesse",
            "“Your mind is a garden. Your thoughts are the seeds. You can grow flowers or weeds.”",
            "“This too shall pass. It always does.”",
            "“Mental health is not a destination, but a process. It's about how you drive, not where you're going.” — Noam Shpancer",
            "“What mental health needs is more sunlight, more candor, and more unashamed conversation.” — Glenn Close",
            "“You can't heal what you don't feel.” — Oprah Winfrey",
            "“Sometimes, opening up isn't a sign of weakness — it's the first step to strength.” — Michelle Obama",
            "“Feelings are meant to be felt, not buried. Expression is a form of healing.” — Brené Brown",
            "“Your emotions are valid. They are not inconvenient. They are your compass.” — Susan David",
            "“Taking care of your mental health is just as important as caring for your physical health.” — Demi Lovato",
            "“Talking about how you feel doesn't make you fragile — it makes you real.” — Unknown",
            "“Silencing your emotions only amplifies their weight.” — Lori Gottlieb",
            "“Mental wellness begins when self-expression feels safe and judgment-free.” — Nedra Glover Tawwab"
        ];

        let current=0;
        function showQuote() {
            document.getElementById('quoteBox').innerText=quotes[current];
            current=(current+1) % quotes.length;
        }

        showQuote();
        setInterval(showQuote,10000)
    </script>	
</body>
</html>