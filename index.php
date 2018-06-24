<?php
require 'connectdb.php';
require 'functions.php';

//Jungiames prie duomenu bazes:
$conn = connect();

//pasirinkite veiksmą
$stdin = fopen('php://stdin', 'r');
        $yes   = false;

        while (!$yes)
        {
            echo "Pasirinkite veiksmą:\n
                Kurti Naują klientą: spauskite 1\n
                Redaguoti klientą: spauskite 2\n
                Ištrinti klientą: spauskite 3:";
            $input = readline();
            if ($input == '1') {
                createClient($conn);
                allClients($conn);
                break;
            }
            if ($input == '2') {
                allClients($conn);
                $id = readline("Kurį įrašą norite pakeisti?: ");
                showClient($conn, $id);
                echo "Pasirinkite lauką, kurį norite redaguoti:\n
                    vardas: 1\n
                    pavardė: 2\n
                    el.paštas: 3\n
                    telefonas: 4\n
                    mobilus: 5\n
                    komentaras: 6\n";
                $column = readline();
                switch ($column) {
                    case 1:
                        $fieldName = 'firstName';
                        break;
                    case 2:
                        $fieldName = 'lastName';
                        break;
                    case 3:
                        $fieldName = 'email';
                        break;
                    case 4:
                        $fieldName = 'phoneNumber1';
                        break;
                    case 5:
                        $fieldName = 'phoneNumber2';
                        break;
                    case 6:
                        $fieldName = 'comment';
                        break;
                }
                $newValue = readline('Įveskite naują reikšmę: ');
                updateClient($conn, $id, $fieldName, $newValue);
                allClients($conn);
                break;
            }
            if ($input == '3') {
                allClients($conn);
                $id = readline('Kurį įrašą norite ištrinti?: ');
                deleteClient($conn, $id);
                allClients($conn);
                break;
            }
        }
$conn->close();
?>
