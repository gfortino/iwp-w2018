<?php
    // INCLUDE
    include("connexion_bd.php");
    $bsCont = new beautyShopController();
    session_start();

    if (!empty($_POST["pseudoUser"]) && (!empty($_POST["passwordUser"]))) 
    {
        $pseudo = $_POST["pseudoUser"];
        $mdp = md5($_POST["passwordUser"]);
        $mdpNonCode = ($_POST["passwordUser"]);

        $requete="SELECT pseudo, mdp FROM user WHERE pseudo='".$pseudo."' AND mdp='".$mdp."'";
        $test = $bsCont->numRows($requete);
        

			$rqtUser = "SELECT idUser FROM user WHERE pseudo = '".$pseudo."'";
         	$idUser = $bsCont->queryGetEl($rqtUser);
         	$id = $idUser['idUser'];
         	$_SESSION["idUser"]= $id;
			
			
    	//si existe et mdp OK
       if ($test != 0)
        {
                  
                //get the status (user/admin)
                $checkFonction = ( "SELECT status FROM user WHERE idUser = '".$id."'");
                $fonction = $bsCont->queryGetEl( $checkFonction);
                $nomStatus = $fonction["status"];
                $_SESSION["status"]= $nomStatus;
                
                //get info 
                $checkNomPrenom = ("SELECT firstName,lastName,pseudo,email,birthday,numTel FROM user WHERE idUser = '".$id."'");
                $info = $bsCont->queryGetEl($checkNomPrenom);
                $nom = $info["firstName"];
                $prenom = $info["lastName"];
                
                $_SESSION["firstName"]= $nom;
                $_SESSION["lastName"]= $prenom;
                $_SESSION["mdp"]= $mdpNonCode;
                $_SESSION["mdpCode"]= $mdp;
                $_SESSION["pseudo"]=$info["pseudo"];
                $_SESSION["email"]=$info["email"];
                $_SESSION["birthday"]=$info["birthday"];
                $_SESSION["numTel"]=$info["numTel"];
                $_SESSION["idUser"]=$id;
                
                $check="SELECT street, city, region, postalCode, idUser FROM address a,user u  WHERE idUser='".$id."'AND a.idAd=u.address";
       			$addr = $bsCont->queryGetEl($check);
					$_SESSION["street"]=$addr["street"];
					$_SESSION["city"]=$addr["city"];
					$_SESSION["region"]=$addr["region"];
					$_SESSION["postalCode"]=$addr["postalCode"];
					
					$_SESSION['cart'] = array();
					
       			
                 session_save_path('C:');

                switch($nomStatus)
                {
                    case 'user' : 
                            header("Location: userSession.php");
                            //echo "user session" . $nom ." ".$prenom;
                            exit();
                        break;

                    case 'admin' :
                            header("Location: adminSession.php");

                            exit();
                        break;
                    default : break;
                }
        }
        else 
        {
 			?>
    			<script language="JavaScript">
        				alert("Erreur d'identication. Merci de recommencer.");
        				window.location.replace("formSignIn.php");
    			</script>
    <?php
        }
    }
  

?>