<?php
/* CLC Project version 1.0
 * UserDataService version 1.0
 * Adam Bender and Jim Nguyen
 * January 19th, 2020
 * UserDataService handle methods through MySQL Statement
 */
namespace App\Services\Data;

use \PDO;
use PDOException;
use Illuminate\Support\Facades\Log;
use App\Model\User;
use App\Model\Credential;
use App\Services\Utility\DatabaseException;

class UserDataService{
    
    private $connection = NULL;
    
    //BEST PRACTICE Do not create Database Connection in a Data Service
    public function __construct($connection){
        $this->connection = $connection;
    }
    
    //create function connect database and add new user using MySQL statemen
    function createUser(User $user){
        
        Log::info("Entering SecurityDAO::createUser()");
        try{
            $statement = $this->connection->prepare("INSERT INTO USER ( USERNAME, PASSWORD, FIRSTNAME, LASTNAME, EMAIL, ROLE) VALUES (?,?,?,?,?,?)");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            $un = $user->getUsername();
            $pw = $user->getPassword();
            $fn = $user->getFirstname();
            $ln = $user->getLastname();
            $email = $user->getEmail();
            $role = $user->getRole();
            
            /* Execute prepared statement with question mark placedholder
             * code retrieved from php.net PDO Documentation
             * URL: https://www.php.net/manual/en/pdostatement.bindparam.php
             */ 
            $statement->bindParam(1,  $un, PDO::PARAM_STR) ;
            $statement->bindParam(2, $pw, PDO::PARAM_STR);
            $statement->bindParam(3,$fn, PDO::PARAM_STR);
            $statement->bindParam(4, $ln, PDO::PARAM_STR);
            $statement->bindParam(5, $email, PDO::PARAM_STR);
            $statement->bindParam(6, $role, PDO::PARAM_STR);
            $statement->execute();
            
            if($statement->rowCount() > 0){
                Log::info("Exit SecurityDAO.createUser with true");
                return true;
                
            }else{
                Log::info("Exit SecurityDAO.createUser with true");
                return false;
            }
        }catch(PDOException $e)
        {
            //BEST PRATICE: Catch a;; the exception (do not swallow exception)
            //log the exception, do not throw away the technology exception, and throw a custom exception
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }
    }
    
    /* authenticate function use getConnection() to connect database
     * and authenticate user using MySQL statement
     */
    function findUser(Credential $credential){
        
        Log::info("Entering SecurityDAO::findUser()");
        
        try{
            $username = $credential->getUsername();
            $password = $credential->getPassword();
            $statement = $this->connection->prepare("SELECT * FROM USER WHERE USERNAME = :username AND PASSWORD = :password LIMIT 1");
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            $statement->bindParam(':username', $username);
            $statement->bindParam(':password', $password);
            $statement->execute();
            
            //see if user exits and return true if found else return flase if not found
            if($statement->rowCount() == 1){
                Log::info("Exit SecurityDAO.findByUser with true");
                return true;
            }else{
                Log::info("Exit SecurityDAO.findByUser with false");
                return false;
            }
        }catch(PDOException $e)
        {
            //BEST PRATICE: Catch a;; the exception (do not swallow exception)
            //log the exception, do not throw away the technology exception, and throw a custom exception
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }   
    }
    
    /*
      function showAll(User $user){
       Log::info("Entering SecurityDAO::showAll()");
       
       try{
            $statement = $this->db->prepare("SELECT * FROM USER);
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            $statement->execute();
            
            if($statement->rowCount() == 1){
                Log::info("Exit SecurityDAO.showAll with true");
                return true;
            }else{
                Log::info("Exit SecurityDAO.showAll with false");
                return false;
            }
       
       }catch(PDOException $e)
       {
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
       }
    }
       
     */
    
    /*
     function findByFirstName(User $user){
     Log::info("Entering SecurityDAO::findByFirstName()");
     
     try{
     $firstname = $user->getFirstname();
     $statement = $this->db->prepare("SELECT ID, USERNAME, FIRSTNAME, LASTNAME, EMAIL, ROLE FROM USER WHERE FIRSTNAME = :firstname );
     
     if(!$statement){
     echo "Something wrong in the binding process.sql error?";
     exit;
     }
     $statement->bindParam(':firstname', $firstname);
     $statement->execute();
     
     if($statement->rowCount() == 1){
     Log::info("Exit SecurityDAO.findByFirstName with true");
     return true;
     }else{
     Log::info("Exit SecurityDAO.findByFirstName with false");
     return false;
     }
     
     }catch(PDOException $e)
     {
     Log::error("Exception: ", array("message " => $e->getMessage()));
     throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
     }
     }
     
     */
    
    /*
     function findByLastName(User $user){
     Log::info("Entering SecurityDAO::findByFirstName()");
     
     try{
     $firstname = $user->getFirstname();
     $statement = $this->db->prepare("SELECT ID, USERNAME, FIRSTNAME, LASTNAME, EMAIL, ROLE FROM USER WHERE LASTNAME = :lastname );
     
     if(!$statement){
     echo "Something wrong in the binding process.sql error?";
     exit;
     }
     
     $statement->bindParam(':lastname', $lastname);
     $statement->execute();
     
     if($statement->rowCount() == 1){
     Log::info("Exit SecurityDAO.findByFirstName with true");
     return true;
     }else{
     Log::info("Exit SecurityDAO.findByFirstName with false");
     return false;
     }
     
     }catch(PDOException $e)
     {
     Log::error("Exception: ", array("message " => $e->getMessage()));
     throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
     }
     }
     
     */
    
}