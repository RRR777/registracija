<?php
    function createClient($conn)
    {
        if(! $conn ) {
            die('Could not connect: ' . mysql_error());
        }
        $firstName = mysqli_real_escape_string($conn, readline("Įveskite vardą: "));
        $lastName = mysqli_real_escape_string($conn, readline("Įveskite pavardę: "));
        $email = mysqli_real_escape_string($conn, readline("Įveskite el.pašto adresą: "));
        $phoneNumber1 = mysqli_real_escape_string($conn, readline("Įveskite telefono numerį: "));
        $phoneNumber2 = mysqli_real_escape_string($conn, readline("Įveskite mobilaus telefono numerį: "));
        $comment = mysqli_real_escape_string($conn, readline("Komentaras: "));

        $sql = "INSERT INTO clients (firstName, lastName, email, phoneNumber1, phoneNumber2, comment)
            VALUES ('$firstName',
                 '$lastName',
                 '$email',
                 '$phoneNumber1',
                 '$phoneNumber2',
                 '$comment'
                 )";

        if ($conn->query($sql) === true) {
            echo "Naujas klientas įvestas sėkmingai.\n";
        } else {
            echo "Klaida: " . $sql . "\n" . $conn->error;
        }
    }

    function updateClient($conn, $id, $fieldName, $newValue)
    {
        $sql = "UPDATE clients SET $fieldName ='$newValue' WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            echo "Įrašas pakeistas\n";
        } else {
            echo "Klaida: " . $conn->error;
        }
    }

    function deleteClient($conn, $id)
    {
        $sql = "DELETE FROM clients WHERE id = $id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(); 

        echo "Ištrintas klientas, kurio nr.: " . $id . "\n\n";
    }

    function allClients($conn)
    {
        $sql = "SELECT * FROM clients";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "ID Vardas Pavardė El.paštas Telefonas Mobilus Komentaras\n";
            while($row = $result->fetch_assoc()) {
                foreach ($row as $column) {
                    echo $column . " ";
                }
                echo "\n";
            }
        } else {
            echo "0 results";
        }
    }

    function showClient($conn, $id)
    {
        $sql = "SELECT * FROM clients WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "ID Vardas Pavardė El.paštas Telefonas Mobilus Komentaras\n";
            while($row = $result->fetch_assoc()) {
                foreach ($row as $column) {
                    echo $column . " ";
                }
                echo "\n";
            }
        } else {
            echo "0 results";
        }
    }

    function insertFromFile($conn)
    {
        $stmt = $conn->prepare("INSERT INTO `clients` (`firstName`, `lastName`, `email`, `phoneNumber1`, `phoneNumber2`, `comment`) VALUES(?, ?, ?, ?, ?, ?)");
   
        $file = fopen("data.csv", "r");
            $row = 0;
            while (($getData = fgetcsv($file, 10000, ",")) !== false) {
                $row++;
                if ($row == 1) continue;

                $firstName = mysqli_real_escape_string($conn, $getData[1]);
                $lastName = mysqli_real_escape_string($conn,  $getData[2]);
                $email = mysqli_real_escape_string($conn, $getData[3]);
                $phoneNumber1 = mysqli_real_escape_string($conn, $getData[4]);
                $phoneNumber2 = mysqli_real_escape_string($conn, $getData[5]);
                $comment = mysqli_real_escape_string($conn, $getData[6]);
                $stmt->bind_param("sssiis", $firstName, $lastName, $email, $phoneNumber1, $phoneNumber2, $comment);
                $stmt->execute();
            }
        fclose($file);
    }
?>
