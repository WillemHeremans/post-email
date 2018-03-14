 <?php
include 'back-submit-mail.php';

function debug($var){
		echo "<pre>";
		print_r($var);
		echo "</pre>";
	}

	function dd($var)
	{
		debug($var);
		die();
	}


	$bdd_config = array(
		"db_host" => "localhost",
		"db_user" => "root",
		"db_pass" => "",
		"db_name" => "post_mail",
	);

try {
    $bdd = new PDO(
    	"mysql:host=".$bdd_config['db_host'].";dbname=".$bdd_config['db_name'].";charset=utf8;",
    	$bdd_config['db_user'],
    	$bdd_config['db_pass']
    );
    // set the PDO error mode to exception
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }

catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

    // define variables and set to empty values
    $firstname_mailErr = $lastname_mailErr = $mail_adressErr = $mail_genderErr = "";
    $firstname_mail = $lastname_mail = $mail_adress = $subject = $mail_gender = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["mail_gender"])) {
        $mail_genderErr = "Veuillez choisir une option";
      } else {
        $mail_gender = test_input($_POST["mail_gender"]);
      }

      if (empty($_POST["firstname_mail"])) {
        $firstname_mailErr = "Votre prénom est requis!";
      } else {
        $firstname_mail = test_input($_POST["firstname_mail"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$firstname_mail)) {
          $firstname_mailErr = "Only letters and white space allowed";
        }
      }

        if (empty($_POST["lastname_mail"])) {
          $lastname_mailErr = "Votre nom est requis!";
        } else {
          $lastname_mail = test_input($_POST["lastname_mail"]);
          // check if name only contains letters and whitespace
          if (!preg_match("/^[a-zA-Z ]*$/",$lastname_mail)) {
            $lastname_mailErr = "Only letters and white space allowed";
          }
        }

      if (empty($_POST["mail_adress"])) {
        $mail_adressErr = "Votre adresse mail est requise!";
      } else {
        $mail_adress = test_input($_POST["mail_adress"]);
        // check if e-mail address is well-formed
        if (!filter_var($mail_adress, FILTER_VALIDATE_EMAIL)) {
          $mail_adressErr = "Format invalide";
        }
      }

      if (empty($_POST["subject"])) {
        $subject = "";
      } else {
        $subject = test_input($_POST["subject"]);
      }

    }

    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

if (!empty($_POST)&&isset($_POST['add'])) {
	add();
}

function add(){
	global $bdd;

	$sql = "INSERT INTO mail (firstname_mail, lastname_mail, mail_gender, mail_adress, subject_mail, content_mail)
    VALUES (:firstname_mail, :lastname_mail, :mail_gender, :mail_adress, :subject_mail, :content_mail)";
	$preparation = $bdd->prepare($sql);

	$preparation->bindParam(':firstname_mail',$_POST['firstname_mail'],PDO::PARAM_STR);
	$preparation->bindParam(':lastname_mail',$_POST['lastname_mail'],PDO::PARAM_STR);
	$preparation->bindParam(':mail_adress',$_POST['mail_adress'],PDO::PARAM_STR);
	$preparation->bindParam(':mail_gender',$_POST['mail_gender'],PDO::PARAM_STR);
  $preparation->bindParam(':subject_mail',$_POST['subject_mail'],PDO::PARAM_STR);
	$preparation->bindParam(':content_mail',$_POST['content_mail'],PDO::PARAM_STR);

	if ($preparation->execute()) {
		header('Location: OK.php');
	} else {
		echo "OOOPS!";
	}
}

?>
<!DOCTYPE html>
<html lang="fr">


<head>
  <meta charset="UTF-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <link rel="stylesheet" href="./assets/css/mail.css"/>
<link rel="stylesheet" href="./assets/css/index.css"/>
</head>

<body bgcolor="#E6E6FA">


<h1 class="first">&nbsp;</h1>


<!-- Form content -->

	<form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

	<span class="error">*<?php echo $mail_genderErr;?></span>
	<label for="mail_gender">Genre</label><br>
<input type="radio" name="mail_gender" value="female"> Madame<br>
   	<input type="radio" name="mail_gender" value="male"> Monsieur<br>
  <input type="radio" name="mail_gender" value="other"> Autre<br><br>

   <span class="error">*<?php echo $firstname_mailErr;?></span>
   <label for="firstname_mail">Prénom</label>
   <input type="text" id="firstname_mail" name="firstname_mail" placeholder="Votre prénom...">

   <span class="error">*<?php echo $lastname_mailErr;?></span>
   <label for="lastname_mail">Nom</label>
   <input type="text" id="lastname_mail" name="lastname_mail" placeholder="Votre nom...">

   <span class="error">*<?php echo $mail_adressErr;?></span>
   <label for="mail_adress">Email</label>
   <input type="text" id="mail_adress" name="mail_adress" placeholder="Votre email...">

   <label for="mail_adress">Sujet</label>
   <input type="text" id="subject_mail" name="subject_mail" placeholder="Sujet de l'email...">

   <label for="subject">Contenu</label>

   <textarea id="content_mail" name="content_mail" placeholder="Ecrivez quelque chose..." style="height:200px"></textarea>

 </form>

<?php
echo $firstname_mail;
echo "<br>";
echo $lastname_mail;
echo "<br>";
echo $mail_adress;
echo "<br>";
echo $subject;
echo "<br>";
?>


</body>
</html>
