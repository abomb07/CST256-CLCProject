<?php
/* CLC Project version 5.0
 * UserDataService version 5.0
 * Adam Bender and Jim Nguyen
 * March 15, 2020
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
    
    /**
     * Non default constructor handles db connection
     * @param $connection
     */
    public function __construct($connection){
        $this->connection = $connection;
    }
    
    /**
     * create function connect database and add new user using MySQL statement
     * @param User $user
     * @throws DatabaseException
     * @return boolean
     */
    function createUser(User $user)
    {    
        Log::info("Entering SecurityDAO::createUser()");
        try{
            /* Insert user information to User
             * STATUS is set to be active when registered
             */
            $statement = $this->connection->prepare("INSERT INTO USER ( USERNAME, PASSWORD, FIRSTNAME, LASTNAME, EMAIL, PHONENUMBER, CITY, ROLE, STATUS) VALUES (?,?,?,?,?,?,?,?, 'active')");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            $un = $user->getUsername();
            $pw = $user->getPassword();
            $fn = $user->getFirstname();
            $ln = $user->getLastname();
            $email = $user->getEmail();
            $phonenumber = $user->getPhonenumber();
            $city = $user->getCity();
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
            $statement->bindParam(6, $phonenumber, PDO::PARAM_STR);
            $statement->bindParam(7, $city, PDO::PARAM_STR);
            $statement->bindParam(8, $role, PDO::PARAM_STR);
            $statement->execute();
            
            // if statement succeses return true, else return false
            if($statement->rowCount() > 0){
                
                Log::info("Exit SecurityDAO.createUser with true");
                return true;
                
            }else{
                Log::info("Exit SecurityDAO.createUser with false");
                return false;
            }
        }catch(PDOException $e)
        {
            // catch exception and throw DatabaseException
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * findUsername check if username exists in Database
     * @param User $user
     * @throws DatabaseException
     * @return boolean
     */
    function findUsername(User $user){
        
        Log::info("Entering SecurityDAO::checkUsername()");
        
        try{
            // Select username from database
            $username = $user->getUsername();
            $statement = $this->connection->prepare("SELECT * FROM USER WHERE USERNAME = :username LIMIT 1");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            $statement->bindParam(':username', $username);
            $statement->execute();
            
            //if statement execute successfully
            if($statement->rowCount() == 1){
                //if result matches  username exists in database, return false, else return true
                    Log::info("Exit SecurityDAO.checkUsername() with false");
                    return false;
                    exit;
                }else{
                    Log::info("Exit SecurityDAO.checkUsername() with true");
                    return true;
                    exit;
                }
                
            
        }catch(PDOException $e)
        {
            // catch exception and throw DatabaseException
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * authenticate function use getConnection() to connect database
     * and authenticate user using MySQL statement
     * @param Credential $credential
     * @throws DatabaseException
     * @return \App\Model\User
     */
    function findUser(Credential $credential)
    {
        
        Log::info("Entering SecurityDAO::findUser()");
        
        try{
            // Select user with entered username and password
            $username = $credential->getUsername();
            $password = $credential->getPassword();
            $statement = $this->connection->prepare("SELECT * FROM USER WHERE USERNAME = :username AND PASSWORD = :password LIMIT 1");
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            //bindParam username and password
            //execute statement
            $statement->bindParam(':username', $username);
            $statement->bindParam(':password', $password);
            $statement->execute();
            
            //see statement execute successfully and return true if found else return false if not found
            if($statement->rowCount() == 1){
                Log::info("Exit SecurityDAO.findByUser with true");
                while($result = $statement->fetch(PDO::FETCH_ASSOC)){
                    $id = $result["ID"];
                    $username = $result["USERNAME"];
                    $password = $result["PASSWORD"];
                    $firstname = $result["FIRSTNAME"];
                    $lastname = $result["LASTNAME"];
                    $email = $result["EMAIL"];
                    $phonenumber = $result["PHONENUMBER"];
                    $city = $result["CITY"];
                    $role = $result["ROLE"];
                    $status = $result["STATUS"];
                    
                }
                
                //return $user object
                $user = new User($id, $username, $password, $firstname, $lastname, $email, $phonenumber, $city, $role, $status);
                
                return $user; 
                
            }
        }catch(PDOException $e)
        {
            // catch exception and throw DatabaseException
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }   
    }
    
    /**
     * findAllUser method returns all users exist in database
     * @throws DatabaseException
     * @return array
     */
    function findAllUser(){
        Log::info("Entering SecurityDAO::showAll()");
        
        try{
            // Select all user in database
            $statement = $this->connection->prepare("SELECT * FROM USER");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            //execute statement
            $statement->execute();
            
            //if statement execute successfully return $users
            if($statement->rowCount() > 0){
                
                Log::info("Exit SecurityDAO.showAll with true");
                
                $index = 0;
                $users = array();
                
                while($row = $statement->fetch(PDO::FETCH_ASSOC))
                {
                    $user = new User($row["ID"], $row["USERNAME"], $row["PASSWORD"], $row['FIRSTNAME'], $row['LASTNAME'], $row['EMAIL'], $row['PHONENUMBER'], $row['CITY'], $row['ROLE'], $row['STATUS']);
                    $users[$index++] = $user;
                }
                return $users;
            }
            
        }
        catch(PDOException $e)
        {
            // catch exception and throw DatabaseException
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * findById method find user with matched id in database
     * @param $id
     * @throws DatabaseException
     * @return \App\Model\User
     */
    function findById($id){
        Log::info("Entering SecurityDAO::findById()");
        
        try{
            $statement = $this->connection->prepare("SELECT ID, USERNAME, PASSWORD, FIRSTNAME, LASTNAME, EMAIL, PHONENUMBER, CITY, ROLE , STATUS FROM USER WHERE ID = :id ");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            //bindParam $id
            $statement->bindParam(':id', $id);
            $statement->execute();
            
            if($statement->rowCount() == 1){
                Log::info("Exit SecurityDAO.findById");
                
                //fetches user from database and returns $user
                $row = $statement->fetch(PDO::FETCH_ASSOC);
                $result = new User($row['ID'], $row['USERNAME'], $row['PASSWORD'], $row['FIRSTNAME'], $row['LASTNAME'], $row['EMAIL'], $row['PHONENUMBER'], $row['CITY'], $row['ROLE'], $row['STATUS']);
                
                return $result;
            }
            
        }catch(PDOException $e)
        {
            // catch exception and throw DatabaseException
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * findStatus method checks user status in database
     * @param User $user
     * @throws DatabaseException
     * @return boolean
     */
    function findStatus(User $user){
        Log::info("Entering SecurityDAO::checkStatus()");
        
        try{
            //Select status in database with matched id
            $id = $user->getId();
            $statement = $this->connection->prepare("SELECT STATUS FROM USER WHERE ID = :id ");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            //bindParam id
            $statement->bindParam(':id', $id);
            $statement->execute();
            
            //if statement execute successfully, fetches status value
            if($statement->rowCount() == 1){
                Log::info("Exit SecurityDAO.findById with user");
                
                //fetching user from database
                $row = $statement->fetch(PDO::FETCH_ASSOC);
                $result = $row['STATUS'];
                
                //if status is suspended, returns false, else return true
                if($result=="suspended"){
                    Log::info("Exit SecurityDAO.findStatus() with false");
                    return false;
                }else{
                    Log::info("Exit SecurityDAO.findStatus() with true");
                    return true;
                }
               
            }      
        }catch(PDOException $e)
        {
            // catch exception and throw DatabaseException
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * updateUser method render data and update user information in database
     * @param User $user
     * @throws DatabaseException
     * @return boolean
     */
    function updateUser(User $user)
    {
        Log::info("Entering SecurityDAO::updateUser()");
        
        try{
            //update user information in database 
            $statement = $this->connection->prepare("UPDATE USER SET USERNAME = :username, PASSWORD = :password, FIRSTNAME = :firstname, LASTNAME = :lastname,
                                                    EMAIL = :email, PHONENUMBER = :phonenumber, CITY = :city , ROLE = :role, STATUS = :status WHERE ID = :id");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            $id = $user->getId();
            $un = $user->getUsername();
            $pw = $user->getPassword();
            $fn = $user->getFirstname();
            $ln = $user->getLastname();
            $email = $user->getEmail();
            $phonenumber = $user->getPhonenumber();
            $city = $user->getCity();
            $role = $user->getRole();
            $status = $user->getStatus();
            
            /* Execute prepared statement with question mark placedholder
             * code retrieved from php.net PDO Documentation
             * URL: https://www.php.net/manual/en/pdostatement.bindparam.php
             */
            $statement->bindParam(':id',  $id, PDO::PARAM_INT);
            $statement->bindParam(':username',  $un, PDO::PARAM_STR);
            $statement->bindParam(':password', $pw, PDO::PARAM_STR);
            $statement->bindParam(':firstname',$fn, PDO::PARAM_STR);
            $statement->bindParam(':lastname', $ln, PDO::PARAM_STR);
            $statement->bindParam(':email', $email, PDO::PARAM_STR);
            $statement->bindParam(':phonenumber', $phonenumber, PDO::PARAM_STR);
            $statement->bindParam(':city', $city, PDO::PARAM_STR);
            $statement->bindParam(':role', $role, PDO::PARAM_STR);
            $statement->bindParam(':status', $status, PDO::PARAM_STR);
            $statement->execute();
            
            //if statement executes successfully returns true, else returns false
            if($statement->rowCount() > 0){
                Log::info("Exit SecurityDAO.updateUser with true");
                return true;
                
            }else{
                Log::info("Exit SecurityDAO.updateUser with false");
                return false;
            }
            
        }catch(PDOException $e)
        {
            // catch exception and throw DatabaseException
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }   
    }
    
    /**
     * delete function connect database and delete user using MySQL statement
     * @param User $user
     * @throws DatabaseException
     * @return boolean
     */
    function deleteUser(User $user)
    {
        Log::info("Entering SecurityDAO::deleteUser()");
        try{
            // delete user in database with mtach id 
            $statement = $this->connection->prepare("DELETE FROM USER WHERE ID = :id");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            $id = $user->getId();
            
            /* Execute prepared statement with question mark placedholder
             * code retrieved from php.net PDO Documentation
             * URL: https://www.php.net/manual/en/pdostatement.bindparam.php
             */
            //execute statement
            $statement->bindParam(':id',  $id, PDO::PARAM_INT) ;
            $statement->execute();
            
            //if statement executes successfully returns true, else returns false
            if($statement->rowCount() > 0){
                
                Log::info("Exit SecurityDAO.deleteUser with true");
                return true;
                
            }else{
                Log::info("Exit SecurityDAO.deleteUser with false");
                return false;
            }
        }catch(PDOException $e)
        {
            // catch exception and throw DatabaseException
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * findbyFirstName method finds for user with entered firstname
     * @param User $user
     * @throws DatabaseException
     * @return array
     */
    function findByFirstName(User $user){
        Log::info("Entering SecurityDAO::findByFirstName()");
        
        try{
            $firstname = $user->getFirstname();
            $statement = $this->connection->prepare("SELECT ID, USERNAME, PASSWORD, FIRSTNAME, LASTNAME, EMAIL, PHONENUMBER, CITY, ROLE, STATUS FROM USER WHERE FIRSTNAME LIKE CONCAT('%', :firstname, '%') ");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            //bindParam firstname and executes statement
            $statement->bindParam(':firstname', $firstname);
            $statement->execute();
            
            //if statement executes successfully
            if($statement->rowCount() > 0){
                Log::info("Exit SecurityDAO.findByFirstName() ");
                
                //fetching users from database
                $users = $statement->fetchAll();
                return $users;
            }
            
        }catch(PDOException $e)
        {
            // catch exception and throw DatabaseException
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * findbyLastName method finds for user with entered lastname
     * @param User $user
     * @throws DatabaseException
     * @return array
     */
    function findByLastName(User $user){
        Log::info("Entering SecurityDAO::findByLastName()");
        
        try{
            $lastname = $user->getLastname();
            $statement = $this->connection->prepare("SELECT ID, USERNAME, PASSWORD, FIRSTNAME, LASTNAME, EMAIL, PHONENUMBER, CITY, ROLE , STATUS FROM USER WHERE LASTNAME LIKE CONCAT('%', :lastname, '%') ");
            
            if(!$statement){
                echo "Something wrong in the binding process.sql error?";
                exit;
            }
            
            //bindParam lastname and executes statement
            $statement->bindParam(':lastname', $lastname);
            $statement->execute();
            
            //if statement executes successfully
            if($statement->rowCount() > 0){
                Log::info("Exit SecurityDAO.findByFirstName() ");
                
                //fetching users from database
                $users = $statement->fetchAll();
                return $users;
            }
            
        }catch(PDOException $e)
        {
            // catch exception and throw DatabaseException
            Log::error("Exception: ", array("message " => $e->getMessage()));
            throw new DatabaseException("Database Exception: ". $e->getMessage(), 0, $e);
        }
    }    
}