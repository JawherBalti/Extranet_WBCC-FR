<?php
header('Access-Control-Allow-Origin: *');

require_once "../../app/config/config.php";
require_once "../../app/libraries/Database.php";
require_once "../../app/libraries/Model.php"; // Correct path to Model.php
require_once "../../app/models/Conge.php";
$db = new Database();
$conge = new Conge();


if (isset($_GET['action'])) {
    $action = $_GET['action'];

   

    // Fetch a leave request by ID
    if ($action == 'findById') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Query to get leave request details along with employee information
            $db->query("SELECT dc.*, c.fullName, u.matricule
                        FROM wbcc_demandesConge dc
                        JOIN wbcc_contact c ON dc.idContact = c.idContact
                        LEFT JOIN wbcc_utilisateur u ON u.idContactF = c.idContact
                        WHERE dc.idDemande = :id");

            // Bind the leave request ID
            $db->bind(":id", $id);

            // Fetch the data
            $result = $db->single();

            // Check if the leave request exists
            if ($result) {
                echo json_encode($result);
            } else {
                // Return an error message if no record is found
                echo json_encode(['error' => 'Aucune demande de congé trouvée avec cet ID.']);
            }
        } else {
            echo json_encode("Missing ID parameter");
        }
    }
    if ($action == 'updateDate') {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $updateField = ''; // This will hold which field to update (dateDebutReelle or dateFinReelle)
    
            // Check which date we are updating
            if (isset($_POST['dateDebutReelle'])) {
                $updateField = 'dateDebutDeCongeReelle';
                $dateToUpdate = $_POST['dateDebutReelle'];
            } elseif (isset($_POST['dateFinReelle'])) {
                $updateField = 'dateFinDeCongeReelle';
                $dateToUpdate = $_POST['dateFinReelle'];
            } else {
                echo json_encode("Missing date parameter");
                exit;
            }
    
            // Update query with dynamic field
            $query = "UPDATE wbcc_demandesConge SET $updateField = :dateToUpdate WHERE idDemande = :id";
            $db->query($query);
            $db->bind(':dateToUpdate', $dateToUpdate);
            $db->bind(':id', $id);
            $updateResult = $db->execute();
    
            // Return the appropriate JSON response
            if ($updateResult) {
                echo json_encode("Date updated successfully");
            } else {
                echo json_encode("Error updating date");
            }
        } else {
            echo json_encode("Missing parameters");
        }
    }
    
    if ($action == 'getAllCongeByIdContact') {
        if (isset($_GET['idContact'])) {
            $idContact = $_GET['idContact'];

            // Query to get all leave requests for a specific contact
            $db->query("SELECT dc.*, c.fullName, u.matricule
                        FROM wbcc_demandesConge dc
                        JOIN wbcc_contact c ON dc.idContact = c.idContact
                        LEFT JOIN wbcc_utilisateur u ON u.idContactF = c.idContact
                        WHERE dc.idContact = :idContact");

            // Bind the contact ID
            $db->bind(":idContact", $idContact);

            // Fetch the data
            $result = $db->resultSet();

            // Check if any leave requests exist
            if ($result) {
                echo json_encode($result);
            } else {
                // Return an error message if no record is found
                echo json_encode(['error' => 'Aucune demande de congé trouvée pour cet ID de contact.']);
            }
        } else {
            echo json_encode("Missing idContact parameter");
        }
    }

   {
     // Update the status of a leave request
     if ($action == 'updateStatus') {
        if (isset($_POST['idDemande']) && isset($_POST['statut']) && isset($_POST['commentaire'])) {
            $idDemande = $_POST['idDemande'];
            $statut = $_POST['statut'];
            $commentaire = $_POST['commentaire'];
    
            // Prepare the SQL statement to update both statut and commentaire
            $query = "UPDATE wbcc_demandesConge 
                    SET statut = :statut, 
                        commentaire = :commentaire, 
                        dateModification = :dateModification 
                    WHERE idDemande = :idDemande";
    
            $db->query($query);
            $db->bind(':statut', $statut);
            $db->bind(':commentaire', $commentaire);
            $db->bind(':dateModification', date('Y-m-d H:i:s')); // Current timestamp
            $db->bind(':idDemande', $idDemande);
            
            // Use execute() for an UPDATE query
            $updateResult = $db->execute();
    
            if ($updateResult) {
                echo json_encode(['success' => true, 'message' => 'Status and note updated successfully']);
            } else {
                echo json_encode(['success' => false, 'error' => 'Error updating status and note']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Missing parameters']);
        }
    }
    
        
    if ($action == 'filterConges') {

        $typeConge = isset($_POST['typeConge']) ? $_POST['typeConge'] : '';
        $statut = isset($_POST['statut']) ? $_POST['statut'] : '';
        $dateDemande = isset($_POST['dateDemande']) ? $_POST['dateDemande'] : '';
        $dateOne = isset($_POST['dateOne']) ? $_POST['dateOne'] : ''; // Pour "A la date du"
        $dateDebut = isset($_POST['dateDebut']) ? $_POST['dateDebut'] : ''; // Pour "Personnaliser"
        $dateFin = isset($_POST['dateFin']) ? $_POST['dateFin'] : ''; // Pour "Personnaliser"
        $userid = isset($_POST['userid']) ? $_POST['userid'] : '';
    
        // Requête SQL de base
        $sql = "SELECT d.*
                FROM wbcc_demandesConge d
                WHERE d.idContact = :userid";
    
        // Tableau pour stocker les paramètres à lier
        $bindParams = [':userid' => $userid];
    
        // Ajouter des filtres en fonction des entrées utilisateur
        if (!empty($typeConge)) {
            $sql .= " AND d.typeConge = :typeConge";
            $bindParams[':typeConge'] = $typeConge;
        }
    
        if ($statut !== '') {
            // Assurez-vous que le statut est soit '0', '1', soit '2'
          
                $sql .= " AND d.statut = :statut";
                $bindParams[':statut'] = $statut;
        
        }
    
        // Appliquer le filtre "période"
        switch ($dateDemande) {
            case 'today':
                $sql .= " AND d.dateDebutDeCongeSouhaite = :today";
                $bindParams[':today'] = date('Y-m-d');
                break;
    
            case '1': // "A la date du"
                if ($dateOne) {
                    $dateOneFormatted = DateTime::createFromFormat('d-m-Y', $dateOne);
                    if ($dateOneFormatted) {
                        $sql .= " AND d.dateDebutDeCongeSouhaite = :dateOne";
                        $bindParams[':dateOne'] = $dateOneFormatted->format('Y-m-d');
                    } else {
                        echo json_encode(['error' => 'Invalid date format for dateOne']);
                        exit;
                    }
                }
                break;
    
            case '2': // "Personnaliser"
                if ($dateDebut && $dateFin) {
                    $dateDebutFormatted = DateTime::createFromFormat('d-m-Y', $dateDebut);
                    $dateFinFormatted = DateTime::createFromFormat('d-m-Y', $dateFin);
                    if ($dateDebutFormatted && $dateFinFormatted) {
                        $sql .= " AND d.dateDebutDeCongeSouhaite BETWEEN :dateDebut AND :dateFin";
                        $bindParams[':dateDebut'] = $dateDebutFormatted->format('Y-m-d');
                        $bindParams[':dateFin'] = $dateFinFormatted->format('Y-m-d');
                    } else {
                        echo json_encode(['error' => 'Invalid date format for dateDebut or dateFin']);
                        exit;
                    }
                }
                break;
    
            default:
                // Aucun filtre de période appliqué
                break;
        }
    
        // Préparer et exécuter la requête
        $db->query($sql);
    
        // Lier dynamiquement les paramètres
        foreach ($bindParams as $param => $value) {
            $db->bind($param, $value);
        }
    
        // Récupérer les données filtrées
        $results = $db->resultset();
    
        // Sortir les résultats au format JSON
        echo json_encode($results);
    }
    if ($action == 'filterCongesAdmin') {
        $typeConge = isset($_POST['typeConge']) ? $_POST['typeConge'] : '';
        $statut = isset($_POST['statut']) ? $_POST['statut'] : '';
       
        $dateDemande = isset($_POST['dateDemande']) ? $_POST['dateDemande'] : '';
        $dateOne = isset($_POST['dateOne']) ? $_POST['dateOne'] : ''; // Pour "A la date du"
        $dateDebut = isset($_POST['dateDebut']) ? $_POST['dateDebut'] : ''; // Pour "Personnaliser"
        $dateFin = isset($_POST['dateFin']) ? $_POST['dateFin'] : ''; // Pour "Personnaliser"
        $idUtilisateur = isset($_POST['contact']) ? $_POST['contact'] : ''; // For filtering by user
          $sql = "SELECT d.* , c.fullName, u.matricule
                FROM wbcc_demandesConge d
                JOIN wbcc_contact c ON c.idContact = d.idContact
               LEFT   JOIN wbcc_utilisateur u ON c.idContact = u.idContactF

             WHERE 1=1";
     
     $bindParams = [];
             // Ajouter des filtres en fonction des entrées utilisateur
             if (!empty($typeConge)) {
                $sql .= " AND d.typeConge = :typeConge";
                $bindParams[':typeConge'] = $typeConge;
            }
        
            if ($statut !== '') {
                // Assurez-vous que le statut est soit '0', '1', soit '2'
              
                    $sql .= " AND d.statut = :statut";
                    $bindParams[':statut'] = $statut;
            
            }
            if (!empty($idUtilisateur)) {
                $sql .= " AND c.idContact = :idUtilisateur";
                $bindParams[':idUtilisateur'] = $idUtilisateur;
            }
            // Appliquer le filtre "période"
            switch ($dateDemande) {
                case 'today':
                    $sql .= " AND d.dateDebutDeCongeSouhaite = :today";
                    $bindParams[':today'] = date('Y-m-d');
                    break;
        
                case '1': // "A la date du"
                    if ($dateOne) {
                        $dateOneFormatted = DateTime::createFromFormat('d-m-Y', $dateOne);
                        if ($dateOneFormatted) {
                            $sql .= " AND d.dateDebutDeCongeSouhaite = :dateOne";
                            $bindParams[':dateOne'] = $dateOneFormatted->format('Y-m-d');
                        } else {
                            echo json_encode(['error' => 'Invalid date format for dateOne']);
                            exit;
                        }
                    }
                    break;
        
                case '2': // "Personnaliser"
                    if ($dateDebut && $dateFin) {
                        $dateDebutFormatted = DateTime::createFromFormat('d-m-Y', $dateDebut);
                        $dateFinFormatted = DateTime::createFromFormat('d-m-Y', $dateFin);
                        if ($dateDebutFormatted && $dateFinFormatted) {
                            $sql .= " AND d.dateDebutDeCongeSouhaite BETWEEN :dateDebut AND :dateFin";
                            $bindParams[':dateDebut'] = $dateDebutFormatted->format('Y-m-d');
                            $bindParams[':dateFin'] = $dateFinFormatted->format('Y-m-d');
                        } else {
                            echo json_encode(['error' => 'Invalid date format for dateDebut or dateFin']);
                            exit;
                        }
                    }
                    break;
        
                default:
                    // Aucun filtre de période appliqué
                    break;
            }
        
            // Préparer et exécuter la requête
            $db->query($sql);
        
            // Lier dynamiquement les paramètres
            foreach ($bindParams as $param => $value) {
                $db->bind($param, $value);
            }
        
            // Récupérer les données filtrées
            $results = $db->resultset();
        
            // Sortir les résultats au format JSON
            echo json_encode($results);
    }


    if ($action == 'saveConge') {
        $idTypeConge = isset($_POST['typeConge']) ? $_POST['typeConge'] : '';
        $userId = isset($_POST['userId']) ? $_POST['userId'] : '';
        $motif = isset($_POST['motif']) ? $_POST['motif'] : '';
        $startDate = isset($_POST['startDate']) ? $_POST['startDate'] : '';
        $endDate = isset($_POST['endDate']) ? $_POST['endDate'] : '';
        $statutConge = '0';
        $conge->save($id='', $userId, $idTypeConge, $motif, $statutConge, $startDate, $endDate, null, null, null, null, null);
    }

    if ($action == 'saveTypeConge') {
        // Retrieve form data sent via AJAX
        $typeConge = isset($_POST['typeConge']) ? $_POST['typeConge'] : '';
        $quotaConge = isset($_POST['quotaConge']) ? $_POST['quotaConge'] : '';
        $politique = isset($_POST['politique']) ? $_POST['politique'] : '';
    
        // Validate required fields
        if (!empty($typeConge) && !empty($quotaConge)) {
            // Prepare SQL to insert the new leave request
            // $sql = "INSERT INTO wbcc_type_conge (type, quotas, politique) VALUES (:type, :quotas, :politique)";
            $conge->createConge($typeConge, $quotaConge, $politique);

            // Bind parameters
            // $bindParams = [
            //     ':type' => $typeConge,
            //     ':quotas' => $quotaConge,
            //     ':politique' => $politique
            // ];
    
            // // Execute the query
            // try {
            //     $db->query($sql);
            //     foreach ($bindParams as $param => $value) {
            //         $db->bind($param, $value);
            //     }
            //     if ($db->execute()) {
            //         echo json_encode(['success' => true, 'message' => 'Congé enregistrée avec succès.']);
            //     } else {
            //         echo json_encode(['success' => false, 'message' => 'Erreur lors de la création du congé.']);
            //     }
            // } catch (Exception $e) {
            //     echo json_encode(['success' => false, 'message' => 'Erreur SQL: ' . $e->getMessage()]);
            // }
        } else {
            echo json_encode(['success' => false, 'message' => 'Veuillez remplir tous les champs requis.']);
        }
    }

    if ($action == 'getCongeById') {
        if (isset($_POST['idDemande'])) {
            $idDemande = $_POST['idDemande'];
            $congesListe = $conge->getCongeById($idDemande);
            echo json_encode($congesListe);
    
        } else {
            echo json_encode(["success" => false, "message" => "ID de demande non fourni"]);
        }
    }

    if ($action == 'getAllWithidUser') {
        // Retrieve $idUser from POST or GET data
        $idUser = $_POST['idUser'] ?? $_GET['idUser'] ?? null;

        // Check if $idUser is set
        if ($idUser) {
            $db->query("
            SELECT dc.*, tc.type
            FROM wbcc_demandesConge dc
            JOIN wbcc_utilisateur u ON dc.idUtilisateurF = u.idUtilisateur
            JOIN wbcc_type_conge tc ON dc.idTypeCongeF = tc.idTypeConge
            WHERE dc.idUtilisateurF = :idUser
            ORDER BY dc.dateCreation DESC
           ");
            // Bind the user ID
            $db->bind(':idUser', $idUser);

            // Execute the query and get results
            $results = $db->resultSet();

          
            // Return results as JSON or an error message if no results
            if ($results) {
                echo json_encode($results);
            } else {
                echo json_encode("0");
            }
        } else {
            // Return error if $idUser is not provided
            echo json_encode(['error' => 'idUser is required.']);
        }
    }
    if ($action == 'getTypeConge') {
       
        $db->query("
            SELECT tc.*
            FROM wbcc_type_conge tc
        ");
    
        $results = $db->resultSet();
        if ($results) {
            echo json_encode($results);
        } else {
            echo json_encode("0");
        }
    }

  }


}

































if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    if ($action == 'filter') {
        error_log(print_r($_POST, true));
        // Gather filter parameters
        $contact = isset($_POST['contact']) ? $_POST['contact'] : '';
        $matricule = isset($_POST['matricule']) ? $_POST['matricule'] : '';
        $typeConge = isset($_POST['typeConge']) ? $_POST['typeConge'] : '';
        // $dateCreation = isset($_POST['dateCreation']) ? $_POST['dateCreation'] : '';
        // $dateCreationOne = isset($_POST['dateCreationOne']) ? $_POST['dateCreationOne'] : '';
        // $dateDebutCreation = isset($_POST['dateDebutCreation']) ? $_POST['dateDebutCreation'] : '';
        // $heureDebutCreation = isset($_POST['heureDebutCreation']) ? $_POST['heureDebutCreation'] : '';
        // $dateFinCreation = isset($_POST['dateFinCreation']) ? $_POST['dateFinCreation'] : '';
        // $heureFinCreation = isset($_POST['heureFinCreation']) ? $_POST['heureFinCreation'] : '';
        $periode = isset($_POST['periode']) ? $_POST['periode'] : '';
        $dateOne = isset($_POST['dateOne']) ? $_POST['dateOne'] : ''; // For single date 'A la date du'
        $dateDebut = isset($_POST['dateDebut']) ? $_POST['dateDebut'] : ''; // For 'Personnaliser'
        $dateFin = isset($_POST['dateFin']) ? $_POST['dateFin'] : ''; // For 'Personnaliser'

        // Start building the query
        $query = "SELECT d.*, c.fullName ,u.matricule
                          FROM wbcc_demandesConge d
                          JOIN wbcc_contact c ON d.idContact = c.idContact
                          LEFT JOIN wbcc_utilisateur u ON u.idContactF = c.idContact
                  WHERE 1=1";

        // Append filters to the query
        if (!empty($contact)) {
            $query .= " AND d.idContact = :contact";
        }
        if (!empty($matricule)) {
            $query .= " AND u.matricule = :matricule";
        }
        if (!empty($typeConge)) {
            $query .= " AND d.typeConge = :typeConge";
        }
      

        // Prepare and execute the query
        $db->query($query);

        if (!empty($contact)) {
            $db->bind(':contact', $contact);
        }
        if (!empty($matricule)) {
            $db->bind(':matricule', $matricule);
        }
        if (!empty($typeConge)) {
            $db->bind(':typeConge', $typeConge);
        }
        // Apply 'periode' filter
        switch ($periode) {
            case 'today':
                $sql .= " AND d.dateDebutDeCongeSouhaite = :today";
                $bindParams[':today'] = date('Y-m-d');
                break;
    
            case '1': // 'A la date du'
                if ($dateOne) {
                    // Convert the date format if needed (DD-MM-YYYY to YYYY-MM-DD)
                    $dateOneFormatted = DateTime::createFromFormat('d-m-Y', $dateOne);
                    if ($dateOneFormatted) {
                        $sql .= " AND d.dateDebutDeCongeSouhaite = :dateOne";
                        $bindParams[':dateOne'] = $dateOneFormatted->format('Y-m-d');
                    } else {
                        // Handle invalid date format
                        echo json_encode(['error' => 'Invalid date format for dateOne']);
                        exit;
                    }
                }
                break;
    
            case '2': // 'Personnaliser'
                if ($dateDebut && $dateFin) {
                    $dateDebutFormatted = DateTime::createFromFormat('d-m-Y', $dateDebut);
                    $dateFinFormatted = DateTime::createFromFormat('d-m-Y', $dateFin);
                    if ($dateDebutFormatted && $dateFinFormatted) {
                        $sql .= " AND d.dateDebutDeCongeSouhaite BETWEEN :dateDebut AND :dateFin";
                        $bindParams[':dateDebut'] = $dateDebutFormatted->format('Y-m-d');
                        $bindParams[':dateFin'] = $dateFinFormatted->format('Y-m-d');
                    } else {
                        // Handle invalid date format
                        echo json_encode(['error' => 'Invalid date format for dateDebut or dateFin']);
                        exit;
                    }
                }
                break;
    
            case 'semaine':
            case 'mois':
            case 'trimestre':
            case 'semestre':
            case 'annuel':
                $dateRange = getPeriodDateRange($periode);
                $sql .= " AND p.datePointaged.dateDebutDeCongeSouhaite BETWEEN :startDate AND :endDate";
                $bindParams[':startDate'] = $dateRange['start'];
                $bindParams[':endDate'] = $dateRange['end'];
                break;
    
            default:
                // No period filter applied
                break;
        }

        $results = $db->resultSet();

        // Return results in JSON format
        echo json_encode($results);
    }

}
?>
