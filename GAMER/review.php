<?php
    require_once "config.php";
    
    if(isset($_POST["review"]),isset($_POST["rating"]),isset($_POST["uid"]))
    {
        $data = array(
            ':uid'	        =>	$_POST["uid"],
            ':postcode'		=>	$_POST["postcode"],
            ':rating'		=>	$_POST["rating"],
            ':review'		=>	$_POST["review"],
            ':time'			=>	time()
        );
        
        $query = "
        INSERT INTO review_table 
        (uid, postcode, rating, review, time) 
        VALUES (:uid, :postcode, :rating, :review, :time)
        ";
        $stmt = $pdo->prepare('SELECT * FROM review');
        $statement = $connect->prepare($query);
        $statement->execute($data);

        echo "Your Review & Rating Successfully Submitted";
    }
    /*
    $sql = "SELECT uid,postcode,rating,review,time from review";
    $result = $pdo->query($sql);

    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
    }
    */
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="project.css">
</head>
<body>
<?php 
    // Initialize the session
    session_start();
    require_once "config.php";
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    include 'notloggedin.inc';
    }
    else{
    include 'loggedin.inc';
    }
?>
<div class="comment_area neonbox">
    <h2 class="neonText">Comments Here!</h2>
    <div class="rating">
        <span id="submit_star_1" rating="1">☆</span><span id="submit_star_2" rating="2">☆</span><span id="submit_star_3" rating="3">☆</span><span id="submit_star_4" rating="4">☆</span><span id="submit_star_5" rating="5">☆</span>
    </div>
    <div>
        <textarea class="form-control" rows="5" placeholder="Write your review here..." name="review" id="review" required name="comments" id="comments" style="width:96%;height:90px;padding:2%;font-size:1.2em;font-family:BB;">
        </textarea >
    </div>
    <p><input type="submit" class="button2" value="Submit"></p>
</div>
<?php include 'footer.inc'; ?>
</body>
</html>