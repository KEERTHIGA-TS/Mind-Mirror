<?php
date_default_timezone_set('Asia/Kolkata');

session_start();
include 'includes/db.php';


if(!isset($_SESSION['username'])|| !isset($_SESSION['user_id'])){
	header("Location: login.php");
	exit();
}

$username=$_SESSION['username'];
$user_id=$_SESSION['user_id'];

$moods_quotes = [
    "clouded" => [
        "When your thoughts feel tangled and the world is a blur, pause — even fog lifts when the sun is patient enough to wait.",
        "Not every moment needs clarity; some days are meant to be slow and unsure, like rain that softens the earth quietly.",
        "You are not lost — you are simply in a chapter where the sky hasn’t cleared yet, but peace is on the next page.",
        "Even the most beautiful sunrises begin in darkness and mist. Trust that light knows how to find its way back to you.",
        "Confusion is not the end — it’s the pause before understanding. Give yourself the grace to not have all the answers right now."
    ],
    "socially numb" => [
        "When connection feels distant and you retreat within, know that your silence is not a failure — it's a form of self-preservation.",
        "You’re not broken for needing space. Some hearts heal best in quiet, away from the noise of expectation.",
        "There’s no shame in not feeling much — numbness is how the soul sometimes says, ‘I’ve felt too much for now.’",
        "Even if the world feels far away, you still belong to it. Let yourself return slowly, in your own time and terms.",
        "You’re not disconnected — you’re resting. Even winter trees seem lifeless, yet they are quietly preparing to bloom again."
    ],
    "emotionally archived" => [
        "You’ve stored feelings away not because they don’t matter, but because they mattered so deeply they needed space to breathe.",
        "Some emotions aren’t gone — they’re simply shelved gently, waiting for you to have the strength to revisit them one day.",
        "Even unspoken emotions have weight, and what’s tucked away still shapes who you’re becoming, silently and patiently.",
        "There’s a quiet kind of strength in not sharing everything — your stillness is a sanctuary, not a void.",
        "You haven’t forgotten what you felt — you’ve honored it by placing it in a drawer your soul can return to when ready."
    ],
    "muted presence" => [
        "You don’t need to be loud to be real — your quiet existence still echoes meaning in every room you enter.",
        "Even when you're unnoticed, you are still unfolding — softly, silently, and in your own sacred rhythm.",
        "Your voice may rest today, but your being still speaks — through stillness, through breath, through quiet strength.",
        "You’re not fading — you’re simply choosing peace over noise, softness over spectacle, truth over attention.",
        "A muted presence is not emptiness — it’s a sanctuary where your soul whispers instead of shouts."
    ],
    "withdrawing" => [
        "Sometimes, retreating inward is the soul’s way of recalibrating, preparing for the next step in your journey.",
        "It’s okay to pull back when the world feels too loud — in your silence, you can hear your heart’s quiet guidance.",
        "Retreat is not defeat — it’s the strength to honor your limits and come back whole when the time is right.",
        "Withdrawal is not a sign of weakness, but a moment of self-care, a chance to gather your energy for what lies ahead.",
        "In the quiet of your withdrawal, you are rediscovering the power of your own presence, ready to return when you’re ready."
    ],
    "cocooned" => [
        "In your cocoon, you are not stuck — you are in a process of transformation, emerging as something stronger and more beautiful.",
        "Though the world outside may seem unchanged, within, you are quietly becoming who you were always meant to be.",
        "The cocoon may feel like confinement, but it is the safety you need to grow and prepare for your next flight.",
        "Your solitude is not isolation; it’s a time of healing, of shedding what no longer serves you, and becoming anew.",
        "Embrace your cocooned state, for it is the space where your true wings are taking shape, ready to soar in time."
    ],
    "detaching" => [
        "Detaching isn’t giving up — it’s the wisdom to release what you can’t control and make room for peace.",
        "Sometimes, the most loving thing you can do is detach from what drains you, making space for what nourishes your soul.",
        "To detach is to honor your emotional boundaries — a necessary step to protect your well-being and regain clarity.",
        "In detaching, you are not abandoning; you are setting healthy distance to find your own inner balance and peace.",
        "Letting go isn’t about forgetting — it’s about freeing yourself from the grip of what no longer serves you."
    ],
    "overstimulated" => [
        "When your senses are overwhelmed, find quiet moments to breathe — reset your mind and body in the stillness.",
        "Overstimulation can cloud your clarity, but remember that even in chaos, you can find moments of calm within.",
        "It’s okay to step away from the noise, to find refuge in silence — your peace is just as important as your productivity.",
        "Sometimes the world moves too fast; give yourself permission to slow down, to restore your energy and peace.",
        "Amidst the overwhelming, remember that you are in control of how you respond — pause, breathe, and reset."
    ],
    "dispersed" => [
        "When your energy is scattered, bring it back gently, piece by piece, until your focus is clear and your mind calm.",
        "In moments of dispersion, it’s important to pause and center yourself, to bring all parts of you back into alignment.",
        "Your energy may feel fragmented now, but each piece is finding its way back to you, becoming whole once more.",
        "Like pieces of a puzzle, your scattered thoughts will eventually come together — trust that they will form a clear picture.",
        "Dispersed doesn’t mean lost — it’s simply a sign that you are learning to prioritize and bring balance to your focus."
    ],
    "unanchored" => [
        "When you feel unanchored, remember that the tides will settle — you don’t need to be firmly rooted to find peace.",
        "In moments of uncertainty, find solace in knowing that stillness, even in motion, is a form of grounding.",
        "Not being anchored doesn’t mean you’re lost — it’s an invitation to explore, to let the winds guide you to new horizons.",
        "The feeling of being unanchored is temporary — trust that in time, you will find your center again.",
        "Sometimes, being unanchored is necessary to experience the freedom to float, to explore, to reinvent yourself."
    ],
    "dimmed" => [
        "Even in the dimmest light, there’s beauty to be found. Trust that your glow is simply waiting for the right moment to shine again.",
        "Your light may feel soft, but it is still present — like stars that flicker quietly in the vast, dark sky.",
        "Dimmed doesn’t mean diminished — it’s just the quiet before your brightness bursts forth again.",
        "Sometimes, a dimmed light is a reminder that rest is necessary before your energy can fully return.",
        "When you feel dim, remember — even the smallest glow can guide you out of darkness."
    ],
    "Quietly Craving" => [
        "There’s a quiet hunger in your heart, a longing for something deeper than the noise around you — listen, and it will find you.",
        "Craving doesn’t always scream; sometimes, it whispers softly, waiting patiently for the right moment to be fulfilled.",
        "In the stillness of your craving, know that there is wisdom in waiting — your desires will be met when you are ready.",
        "What you crave is already on its way to you — trust the timing, for it is as perfect as your patience.",
        "Your cravings are not signs of lack; they are the soul’s quiet reminders of what you are meant to embrace next."
    ],
    "Lightly Buoyant" => [
        "You float through life with grace, your heart lightly lifted by the joy of simple moments.",
        "There’s a quiet joy in your buoyancy — light as air, yet firmly grounded in your own peace.",
        "Being buoyant is not about ignoring the weight of the world — it’s about finding moments where your spirit can rise above.",
        "In your buoyancy, you remind others that there is always lightness to be found, even when the world feels heavy.",
        "Lightly buoyant, you dance on the surface of life’s waters, knowing that joy is often found in the simplest of things."
    ],
    "Wholehearted" => [
        "To live wholeheartedly is to embrace all of life’s ups and downs, knowing that your heart is strong enough for both.",
        "A wholehearted life is a rich one, where every experience is met with authenticity, love, and an open heart.",
        "Living wholeheartedly means you give all that you are to what truly matters, trusting that the return will be just as abundant.",
        "Wholeheartedness is the courage to be vulnerable, to give without fear, and to love without hesitation.",
        "In a world that often asks for half-heartedness, your wholeheartedness is a beautiful act of rebellion, grounded in truth."
    ],
    "Still Blooming" => [
        "Even when it seems like nothing is changing, trust that you are still blooming, quietly, in your own time.",
        "Your growth isn’t always visible, but beneath the surface, you’re unfolding into something magnificent.",
        "Blooming doesn’t always happen in a rush — sometimes, it’s the quiet, steady growth that leads to the most beautiful flowers.",
        "In stillness, you are blossoming — each moment is shaping you into the person you are becoming.",
        "Like a flower that opens in its own time, you are blooming, no matter how slowly the process may seem."
    ],
    "Gently Elated" => [
        "Your joy is soft, quiet, and ever-present — a gentle elation that brings warmth to everything you touch.",
        "In your gentle elation, you find peace in the smallest of moments, grateful for the simple pleasures life has to offer.",
        "To be gently elated is to know that joy doesn’t need to be loud to be felt deeply — it’s felt in the heart’s quiet beat.",
        "There’s a softness to your happiness, a calm contentment that flows through you without force or effort.",
        "Gently elated, you carry joy as a quiet gift, sharing it without needing to be noticed, yet it lights up the world around you."
    ],
    "Quietly Radiant" => [
        "Your radiance doesn’t need to be loud — it is a quiet, steady light that grows stronger with time.",
        "Like the sun rising quietly over the horizon, your radiance brightens the world softly, but surely.",
        "You shine quietly, yet there’s no denying the strength of your light — gentle, but powerful in its warmth and beauty.",
        "In your quiet radiance, you offer the world a gift of peace, warmth, and steady presence.",
        "Radiance isn’t always about intensity — sometimes it’s the quiet glow that makes the greatest impact."
    ],
    "Weightless Joy" => [
        "Joy doesn’t always come with weight; sometimes, it’s a lightness, floating freely without restraint or worry.",
        "Your joy is weightless, lifting you higher with every breath, reminding you that happiness can be found in freedom.",
        "In moments of weightless joy, the world seems lighter, and your heart floats effortlessly on the currents of happiness.",
        "Weightless joy is the kind that doesn’t need to be anchored — it dances freely in the air, unburdened and pure.",
        "When joy feels weightless, it’s a reminder that happiness doesn’t need conditions — it simply exists in the now."
    ],
    "Unfolding Bright" => [
        "Like petals slowly opening to the sun, you are unfolding, revealing your brightest self to the world.",
        "In the unfolding, you discover new layers of yourself — each moment a chance to grow into something even brighter.",
        "The brightness within you is waiting to unfold, one step at a time, each moment a new opportunity to shine.",
        "As you unfold, the world will see your light more clearly, and you’ll begin to understand just how much brilliance resides within.",
        "You are unfolding, and with each new chapter, you reveal more of your unique and radiant light."
    ],
    "Serenely Charged" => [
        "You are charged not by noise or chaos, but by a quiet, serene energy that sustains you through life’s challenges.",
        "Serene energy flows through you — strong and steady, grounded in peace, yet ready to take on whatever comes next.",
        "Being serenely charged is finding power in stillness, energy in tranquility, and momentum in calm reflection.",
        "Your energy is not frantic or rushed — it’s an undercurrent of strength that calmly pushes you toward what’s next.",
        "Charged with serenity, you carry a quiet strength that inspires those around you without a single word."
    ],
    "overwhelmed" => [
    "When the weight feels too much, pause — you don’t have to carry everything at once to be strong.",
    "You are not failing; you are just feeling — deeply, all at once. Let yourself rest between the waves.",
    "Some days ask too much — it’s okay to answer with stillness, with breath, with boundaries.",
    "You are allowed to take up space gently, even if your world feels like it's spinning too fast.",
    "Overwhelm is not weakness. It’s your heart asking for gentler rhythm, and softer care."
     ],

    "anxious" => [
    "Your worry is not who you are — it's just a visitor. Let it pass through, not take root.",
    "You don’t need to fix everything right now. Breathe. One safe moment is enough to begin.",
    "Even trembling hearts can still be brave. Your courage isn’t loud — it’s steady, quiet, breathing.",
    "It’s okay if your thoughts run fast — anchor yourself in one breath, one truth, one tiny now.",
    "Anxiety is a storm, not the sky. The blue will return, even if it hides for a while."
    ],
    "burnt out" => [
    "You are not lazy — you are simply carrying more than anyone can see. Rest isn’t a reward, it’s a right.",
    "When your fire feels gone, remember: even embers hold warmth. You are allowed to dim and still be whole.",
    "You’ve given so much for so long — it’s okay to stop, to soften, to start tending to yourself again.",
    "Burnout doesn’t mean you’re broken. It means you’ve been too strong for too long without pause.",
    "Step back, breathe deep — healing begins not in doing more, but in finally letting go."
     ]
];
$selected_mood="";
$note="";
$quote_to_show="";

if($_SERVER["REQUEST_METHOD"]=="POST"){
	$selected_mood=$_POST['mood']?? "";
	$note= trim($_POST['note'])?? "";

	if(array_key_exists("$selected_mood", $moods_quotes)){
		$quotes = $moods_quotes[$selected_mood];
		$quote_to_show=$quotes[array_rand($quotes)];

        $entry_date = date('Y-m-d H:i:s');
		$stmt=$conn->prepare("INSERT INTO mood_log(user_id,mood,note,entry_date) VALUES(?,?,?,?)");
		$stmt->bind_param("isss",  $user_id, $selected_mood, $note, $entry_date);
		$stmt->execute();
	}

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<title>Your Mood</title>
        <link rel="icon" type="image/jpeg" href="images/mindmirror-logo.png">
    	<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    	<style>
            body,a{
                margin:0;
                padding:0;
                font-family:'Montserrat',sans-serif;
                background-color: rgb(255, 232, 224);
                text-align:center;
            }
            select,textarea{
                padding: 10px;
                resize:vertical;
                width:70%;
                border: none;
                margin: auto;
                font-family:'Montserrat',sans-serif;
            }
            select{
                height: 40px;
                display: block;
                margin-bottom: 40px;
            }
            select:focus, textarea:focus{
                outline:none;
            }
            label{
                display: block;
                margin-bottom: 15px;
            }
            
            header{
                color:rgb(127, 127, 191);
            }
            form{
                background-color:rgb(252, 214, 196);
                color: #4E3D42;
                padding: 40px;
                border-radius: 30px;
                text-align: center;
                width:35%;
                margin:auto;
                box-shadow: 5px 5px 3px 0.5px rgb(251, 172, 150);
            }
        
            button,a{
                font-family:'Montserrat',sans-serif;
                display:inline-block;
                text-align: center;
                padding: 12px 5px;
                font-size: 15px;
                background-color: rgb(59, 59, 237);
                color: aliceblue;
                border:none;
                border-radius: 10px;
                text-decoration: none;
                width: 150px;
                margin: 15px 5px;
            }
            button:hover, a:hover{
                background-color: rgb(106, 106, 211);
                transform: scale(1.07);
                transition: transform 0.3s;
                transition-timing-function: ease-in-out;
            }
            .quote-box{
                background-color: rgb(251, 172, 150);
                padding: 25px;
                border-left: 5px solid rgb(59, 59, 237);
                text-align:justify;
                width: 450px;
                font-style:italic;
                border-radius: 10px;
                width:70%;
                margin:auto;
            }
            h2{
                font-weight: 50;
            }
            @media screen and (max-width:970px){
                form select, form textarea{
                    padding: 5px;
                    width:230px;
                    font-size: 13px;
                }
                h1{
                    font-size: 26px;
                }
                h2{
                    font-size: 16px;
                }
                label{
                    font-size: 13px;
                }
                button,a{
                    padding: 10px 3px;
                    font-size: 10px;
                    width: 100px;
                }
                .quote-box{
                    background-color: rgb(251, 172, 150);
                    padding: 25px;
                    border-left: 5px solid rgb(59, 59, 237);
                    width: 450px;
                    font-style:italic;
                    border-radius: 10px;
                    width:70%;
                    margin:auto;
                }
            }
            @media screen and (max-width:680px){
                form select, form textarea{
                    padding: 3px;
                    width: 75%;
                    font-size: 10px;
                }
                form select{
                    padding: 1px;
                    height: 25px;
                    margin-bottom: 10px;
                }
                h1{
                    font-size: 20px;
                }
                h2{
                    font-size: 15px;
                }
                label{
                    font-size: 10px;
                    margin-bottom: 6px;
                }
                button,a{
                    padding: 5px 1px;
                    font-size: 11px;
                    width: 110px;
                    border-radius: 5px;
                    margin: 8px 1px;
                }
                form{
                    width: 75%;
                    padding: 10px;
                    border-radius: 10px;
                    box-shadow: 3px 3px 3px 0.5px rgb(251, 172, 150);
                }
                .quote-box{                   
                    padding: 10px;
                    font-size: 4px;
                    width: 50%;
                    border-radius: 10px;                   
                    margin:auto;
                    border-left: 3px solid rgb(59, 59, 237);
                }
            }
    	</style>
</head>
<body>
    <header>
        <h1>Hello <?php echo htmlspecialchars(ucwords($username))?>!</h1>
        <h2>Breathe in. What emotion lingers?</h2>
    </header>
	<form method="post">
	<label for="mood">Pick your current state of being</label>
	<select name="mood" required>
		<option value="" disabled selected>-- choose your mood --</option>
		<?php
		foreach($moods_quotes as $mood=>$quotes){
			echo"<option value=\"$mood\"".($selected_mood==$mood?" selected":"").">".ucwords($mood)."</option>";
		}
		?>
	</select>
	<label for="note">Write something if you'd like: (Optional)</label>
	<textarea name="note" rows="8"><?php echo htmlspecialchars($note);?></textarea><br>
	<button>Get Inspired</button>

	<?php if($quote_to_show):?>
		<div class="quote-box">
			"<?php echo htmlspecialchars($quote_to_show);?>"
		</div>
    <?php endif;?>
	<a href="mood_history.php">View Mood History</a>
    </form>
    <a style="width: 250px; background-color: rgb(255, 232, 224); color:rgb(59, 59, 237); " href="dashboard.php">← Back to Dashboard</a>
</body>
</html>










