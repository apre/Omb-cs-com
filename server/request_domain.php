<?php

$domain= $_GET["domain"];

include 'check_identity.php';
echo $domain."\n";

include 'db_user.php';

//**********************************************
//Check that the customer has no omb domain yet.
//**********************************************

$link =  mysql_connect('localhost', $db_user, $db_passphrase);
  if (!$link) {die("conection à la base de donnée impossible");}
  
  $db_selected = mysql_select_db("omb",$link);
  

  $query=sprintf(" SELECT LENGTH(domain_omb) FROM Customers WHERE ID=".mysql_real_escape_string (strip_tags($_COOKIE['ID'])));
  $reponse= mysql_query($query,$link);   
      
  if (!$reponse) {
	    $message  = 'Invalid query: ' . mysql_error() . "\n";
	    $message .= 'Whole query: ' . $query;
	    die($message);
	  }
	  
 // On affiche chaque entrée une à une
	
 if ($donnees = mysql_fetch_assoc($reponse))
	{
	  if ($donnees['LENGTH(domain_omb)']>0)
	    {
	    echo "This account allready has a domain.\n".$donnees['LENGTH(domain_omb)'];
	    die();
	    }
	}	    
	
//*********************************************
//Check that the domain is not allready in use.
//*********************************************

  $query=sprintf(" SELECT COUNT(ID) as NB FROM Customers WHERE domain_omb=\"".mysql_real_escape_string (strip_tags($domain))."\"");
  $reponse= mysql_query($query,$link);   
      
  if (!$reponse) {
	    $message  = 'Invalid query: ' . mysql_error() . "\n";
	    $message .= 'Whole query: ' . $query;
	    die($message);
	  }
	  
 // On affiche chaque entrée une à une
	
 if ($donnees = mysql_fetch_assoc($reponse))
	{
	  if ($donnees['NB']>0)
	    {
	    echo "This domain is allready used by another user.\n";
	    die();
	    }
	}	    

//*********************************************
//Update entry for TLS proxy
//*********************************************

//*********************************************
//Update entry for SMTP proxy
//*********************************************

//*********************************************
//Add domain in 
//*********************************************

?>