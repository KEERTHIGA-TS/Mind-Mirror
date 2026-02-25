<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width initial-scale=1.0">
	<title>Mind Mirror - Your Wellness Journal</title>
    <link rel="icon" type="image/jpeg" href="images/mindmirror-logo.png">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
	<style>
		body{
			margin:0;
			padding:0;
			font-family:'Montserrat',sans-serif;
		}
		img{
			width:250px;
			height:130px;
		}
		header{
			background-color: #F7C1B2;
			text-align:center;
			padding:50px;
			color:rgb(127, 127, 191);
		}	
		.content {
			background-color: #FFF3F0; /* a soft, warm off-white-pink base */
			color: #4E3D42; /* muted brownish-gray for text readability */
			padding: 80px;
			text-align: center;
		}
		a{
			display:inline-block;
			text-align: center;
			padding: 15px;
			font-size: 1.2rem;
			background-color: rgb(57, 57, 211);
			color: aliceblue;
			border:none;
			border-radius: 10px;
			text-decoration: none;
			margin-top:20px;
		}
		a:hover{
			background-color: rgb(106, 106, 211);
			transform: scale(1.1);
			transition: transform 0.3s;
			transition-timing-function: ease-in-out;
		}
		.features{
			text-align:center;
			padding: 50px;
			background-color:rgb(248, 219, 210);
		}
		.features .row-1, .row-2{
			display:grid;
			grid-template-columns:repeat(3,1fr);
			gap:70px;
			margin-top:4%;
		}
		.feature-card{
			background-color:rgb(252, 214, 196);
			color: #4E3D42;
			padding: 30px;
			border-radius: 30px;
			text-align:center;
			box-shadow: 5px 5px 3px 0.5px rgb(251, 172, 150);
		}
		.healing{
			padding:30px;
			display:flex;
			flex-direction:column;
			align-items:center;
			background-color: #FFF3F0;
			color: #4E3D42; 
		}
		ul{
			margin-top:0;
		}
		
		@media screen and (max-width: 768px) {
			img{
				width:220px;
				height:110px;
			}
			.features .row-1, .row-2{
				display:grid;
				grid-template-columns:repeat(3,1fr);
				gap:30px;
				margin-top:4%;
			}
			.feature-card{
				padding:25px;
				box-shadow: 5px 5px 0.8px 0.3px rgb(253, 159, 133);
			}
			.feature-card h3{
				font-size: 13px;
			}
			.feature-card p{
				font-size: 10px;
			}
		}
		@media screen and (max-width: 430px) {
			img{
				width:140px;
				height:70px;
			}
			header{
				padding:25px;
			}

			h1{
				font-size:16px;
			}
			h2{
				font-size:15px;
			}
			a,h3{
				font-size:12px;
				padding: 11px;
			}
			p{
				font-size:11px;
			}
			.content{
				padding: 50px;
			}
			.content p{
				line-height: 20px;
			}
			.features{
				padding: 20px;
			}
			.features .row-1, .row-2{
				display:grid;
				grid-template-columns:repeat(3,1fr);
				gap:20px;
				margin-top:4%;
			}
			.feature-card{
				display: flex;
				flex-direction: column;
				align-items: center;
				padding:5px;
				border-radius:20px;
				box-shadow: 4px 4px 0.8px 0.1px rgb(253, 159, 133);
			}
			.feature-card h3{
				font-size: 12px;
                margin-bottom: 0px;
			}
			.feature-card p{
				width:75%;
				font-size: 8px;
			}
		}
	</style>
</head>
<body>
	<header>
		<img src="./images/logo.jpg">
		<h1>Mind Mirror: A Personal Journal for Emotional Wellbeing</h1>
		<p>Your inner world, beautifully traced.</p>
	</header>

	<section class="content">
		<h2>Why MindMirror?</h2>
		<p style="max-width: 750px; margin: auto; text-align: justify;">Your mental space deserves a soft, safe environment. Whether you’re dealing with anxiety, overthinking, or emotional overload, we help you gently offload your thoughts and reflect.</p>
		<a href="register.php">Get Started</a>
	</section>

	<section class="features">
		<h2>Core Features for a Nuturing Mind</h2>
		<div class="row-1">
			<div class="feature-card">
				<h3>Mood Tracker</h3>
				<p>Effortlessly select your mood from a spectrum of emotions to record and understand how your feelings evolve.</p>
			</div>
			<div class="feature-card">
				<h3>Reflective Journaling</h3>
				<p>Share your thoughts, triumphs, and challenges in a safe space that promotes emotional release and mindfulness.</p>
			</div>
			<div class="feature-card">
				<h3>Personalized Quotes for Reflection</h3>
				<p>Let thoughtful, mood-appropriate quotes provide a sense of comfort, validation, or inspiration to uplift your spirit.</p>
			</div>
		</div>
		<div class="row-2">
		<div class="feature-card">
				<h3>Historical Insights</h3>
				<p>Reflect on your past entries, fostering mindfulness and enabling personal growth through deeper emotional understanding.</p>
			</div>
			<div class="feature-card">
				<h3>Mood Analytics Dashboard</h3>
				<p>Explore your emotional trajectory with graphical insights, powered by Chart.js, to track mood trends and patterns over time.</p>
			</div>
			<div class="feature-card">
				<h3>Secure User Authentication</h3>
				<p>Protect your journey with robust sign-up and login features that ensure a personalized and secure experience.</p>
			</div>
		</div>
	</section>
	<div class="healing">
		<h2>Healing Through Writing: A Proven Path to Mental Clarity</h2>
		<p>Journaling is a time-honored practice that nurtures mental wellness by:</p>
			<ul>
				<li><p>Alleviating stress and anxiety through emotional expression</p></li>
				<li><p>Fostering a deeper connection with one’s thoughts and feelings</p></li>
				<li><p>Cultivating gratitude, self-compassion, and mindfulness</p></li>
				<li><p>Supporting long-term emotional resilience and growth</p></li>
			</ul>
	</div>
</body>
</html>

