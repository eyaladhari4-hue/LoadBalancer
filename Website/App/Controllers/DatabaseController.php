<?php
// Show Error
error_reporting(E_ALL);
// Start Class to manage methods for the website
class DatabaseController
{
    private $link;
    // Create constructor for connection to the database
    public function __construct()
    {
        // Check whether the connection $link is established
        if (!$this->link) {
            // Set connection parameters
            $server = 'localhost';
            $Login = 'root';
            $Password = '';
            $database = 'axia';
            // Establish connection
            try {
                $this->link = new mysqli($server, $Login, $Password, $database);
                // Check for a successful connection
                if ($this->link->connect_error) {
                    die('Connection failed: ' . $this->link->connect_error);
                }
                $this->link->set_charset("utf8");
            } catch (mysqli_sql_exception $e) {
                die('Problem de connexion --> ' . $e->getMessage());
            }
        }
    }
    // Connection
    public function getConnectionDB()
    {
        // Connect to the database
        return $this->link;
    }
}