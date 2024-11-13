<?php

session_start();

if(!isset($_SESSION['total_balance'])){
    $_SESSION['total_balance'] = 100;
}

$is_user_win        = false;
$dice1_value        = '';
$dice2_value        = '';
$total              = '';
$play_button_status = 'enabled';



if(isset($_POST['submit'])){
    //roll the dice and get total of both dices
    $dice1 = [1,2,3,4,5,6];
    $dice1_value = $dice1[ array_rand($dice1)];
    $dice2 = [1,2,3,4,5,6];
    $dice2_value = $dice2[ array_rand($dice2)];
    $total = $dice1_value + $dice2_value;

    //deduct bet amount
    $_SESSION['total_balance'] = $_SESSION['total_balance'] - 10; 


    //calculate bet if user wins
    $selected_bet = $_POST['bet_type'];
    if($selected_bet == 'above_7' && $total > 7){
        $_SESSION['total_balance'] = $_SESSION['total_balance'] + 20;
    }elseif($selected_bet == 'below_7' && $total < 7){
        $_SESSION['total_balance'] = $_SESSION['total_balance'] + 20;
    }elseif($selected_bet == 'lucky_7' && $total == 7){
        $_SESSION['total_balance'] = $_SESSION['total_balance'] + 30;
    }

    //disble play
    $play_button_status = 'disabled';
   
}

//enable play button with previous values
if(isset($_POST['continue_playing'])){
    $play_button_status = 'enabled';
}

//reset total balance and enable play button
if(isset($_POST['reset'])){
    $_SESSION['total_balance'] = 100;
    $play_button_status = 'enabled';
}

?>




<html>
    <body>
        <h3>Welcome to lucky 7 Game</h3>
        <!--instructions-->
        <span><b>Your total balance is:</b> <?php echo $_SESSION['total_balance']; ?> Rs.</span>
        <h3>Place your bet (Rs 10):</h3>

        <!--buttons-->
        <form action="" method="POST">
            <input type="radio" name="bet_type" value="below_7" id="below_7" required>
            <label for="below_7">Below 7</label>
            
            <input type="radio" name="bet_type" value="lucky_7" id="lucky_7" required>
            <label for="lucky_7">7</label>
           

            <input type="radio" name="bet_type" value="above_7" id="above_7" required>
            <label for="above_7">Above 7</label>

            <input type="submit" name="submit" value="Play" <?php echo $play_button_status; ?>>
        </form>

        <h3>Game Results</h3>

        <span><b>Dice 1:</b> <?php echo $dice1_value; ?></span><br>
        <span><b>Dice 2: </b> <?php echo $dice2_value; ?></span><br>
        <span><b>Total:</b> <?php echo $total; ?> </span>

        <h3>Congratulations! you win! your balance is now  Rs. <?php echo $_SESSION['total_balance']; ?></h3>

        <div>
            <form action="" method="post">
                <button type="submit" name="reset">Reset & play again</button>
            </form>
            <form action="" method="post">
                <button type="submit" name="continue_playing">Continue Playing</button>
            </form>
            
        </div>
       
    </body>
</html>
