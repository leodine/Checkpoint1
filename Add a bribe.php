<?php

require_once 'connec.php';

$pdo = new \PDO(DSN, USER, PASS);

$query1 = "SELECT name,payment FROM bribe ORDER BY name";
$statement1 = $pdo->query($query1);


$query2 = "SELECT SUM(payment) AS TotalPayment FROM bribe";
$statement2 = $pdo->query($query2);

?>

<?
    // submit.php

    $name = $nickname = $email = $password = "";
    $error = "";    
    $message = "";
    
?>

<!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Formulaire Bribe</title>
        </head>
        <style>
            
            form{ 
                font-family: Arial, Helvetica, sans-serif;
                display:flex;
                max-width: 340px;
                flex-direction:column;
                align-items:end;
                background:#eee;
                padding:20px;
                margin:10px auto;
                border-radius:4px;
                border:1px solid #ccc;
            }
            input, button{
                margin:5px 20px; 
            }
            .message{
                background:MediumSeaGreen;
                margin:10px auto;
                max-width: 340px;
                padding:20px;
                border-radius:4px;
                border:1px solid #ccc;
            }
            .error{
                margin:10px auto;
                max-width: 340px;
                padding:20px;
                border-radius:4px;
                border:1px solid #ccc;
                background:Tomato;
            }
        </style>
        <body>

            <?php 
                if($error !== ''){
                    echo "<div class=\"error\">" . $error . "</div>";
                } 
                elseif ($message !== '') {
                    echo "<div class=\"message\">" .$message . "</div>";
                }
            ?>

            <?
            	function test_input ( $data ) : string
	        {
			$data = trim ( $data );
			$data = stripslashes ( $data );
			$data = htmlspecialchars ( $data );
			return $data;
	        }
            	
            	// Validations
		if( isset( $_POST['submit'] ) )
		{
		    if ( empty ( $_POST["name"] ) ) 
		    {
		        $error .= "Name is required";
		    } else if ( !preg_match ( "/^[a-zA-Z0-9]*$/",$name ) ) 
		    {
		        $error .= "Only letters and white spaces please";
		    } else 
		    {
		        $name = test_input ( $_POST["name"] );
		    }
		    if ( empty ( $_POST["payment"] ) ) 
		    {
		        $error .= "Payment is required";
		    } 
		    else 
		    {		    	
		        $payment = trim ( $_POST["payment"] );		        
		    }
		}
            
            ?>
            
            <form method="post" action="pdo.php">
                
                <div>
                    <label for="name">Name :</label>
                    <input name="name" type="text" id="name" required placeholder="Name" pattern="^[a-zA-Z0-9][a-zA-Z0-9]{1,80}$">
                </div>
                <div>
                    <label for="payment">Payment:</label>
                    <input type="text" name="payment" id="payment" required placeholder="Payment">
                </div> 
                <div>
                    <input type="submit" name="submit" value="Submit">
                </div>
            </form>
            
            
            <?php
            
            
		$query = "INSERT INTO bribe (name, payment) VALUES ('$name','$payment')";

		$statement = $pdo->prepare($query);

		$statement->bindValue(':lastname', $name, \PDO::PARAM_STR);
		$statement->bindValue(':firstname', $payment, \PDO::PARAM_INT);

		$statement->execute();
		
		echo $name . " " . $payment . PHP_EOL;
		
		$header('pdo.php');
		die;
		
		
            ?>
            
        </body>
    </html>
