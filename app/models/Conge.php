<?php

class Conge extends Model
{
    public function save($id, $idUtilisateur,$idTypeConge, $motif, $statut, $dateDebutSouhaite, $dateFinSouhaite, $dateDebutPropose, $dateFinPropose, $dateDebutConge, $dateFinConge, $commentaire )
    {
        // Determine if this is an insert or update
        if (empty($id)) {
            // Insert new record
            $this->db->query("INSERT INTO wbcc_demandesconge 
                            (idUtilisateurF, idTypeCongeF, motif, dateDebutDeCongeSouhaite, dateFinDeCongeSouhaite, commentaire,
                            dateDebutDeCongeReelle, dateFinDeCongeReelle, statut, dateDebutDeCongePropose, dateFinDeCongePropose,
                            dateCreation, dateModification) 
                            VALUES (:id_contact, :type_de_conge, :motif, :date_debut_souhaite, :date_fin_souhaite, 
                                    :commentaire, :date_debut_reelle, :date_fin_reelle, :statut, :date_debut_propose, 
                                    :date_fin_propose, :date_creation, :date_modification)");
    
            $this->db->bind(":date_creation", date("Y-m-d H:i:s"));
            $this->db->bind(":date_modification", date("Y-m-d H:i:s"));
        } else {
            // Update existing record
            $this->db->query("UPDATE wbcc_demandesconge 
                            SET idUtilisateurF = :id_contact, 
                                dateDebutDeCongeSouhaite = :date_debut_souhaite, 
                                dateFinDeCongeSouhaite = :date_fin_souhaite, 
                                idTypeCongeF = :type_de_conge, 
                                motif = :motif, 
                                dateDebutDeCongePropose = :date_debut_propose, 
                                dateFinDeCongePropose = :date_fin_propose, 
                                commentaire = :commentaire, 
                                dateDebutDeCongeReelle = :date_debut_reelle, 
                                dateFinDeCongeReelle = :date_fin_reelle, 
                                statut = :statut, 
                                dateModification = :date_modification 
                            WHERE idDemande = :id");
    
            $this->db->bind(":id", $id);
            $this->db->bind(":date_modification", date("Y-m-d H:i:s"));
        }
    
        // Binding object properties and handling nulls
        $this->db->bind(":id_contact", $idUtilisateur ?? null);
        $this->db->bind(":type_de_conge", $idTypeConge ?? null);
        $this->db->bind(":motif", $motif ?? null);
        $this->db->bind(":date_debut_souhaite", $dateDebutSouhaite ?? null);
        $this->db->bind(":date_fin_souhaite", $dateFinSouhaite ?? null);
        $this->db->bind(":date_debut_propose", $dateDebutPropose ?? null);
        $this->db->bind(":date_fin_propose", $dateFinPropose ?? null);
        $this->db->bind(":date_debut_reelle", $dateDebutConge ?? null);
        $this->db->bind(":date_fin_reelle", $dateFinConge ?? null);
        $this->db->bind(":commentaire", $commentaire ?? null);
        $this->db->bind(":statut", $statut ?? null);
    
        if ($this->db->execute()) {
            return $id ? $id : $this->db->lastInsertId();
        } else {
            return false;
        }
    }
    

    public function proposeNewDates($id,$date_debut_propose, $date_fin_propose, $commentaire,$statut)
    {
        $proposeDateDebut = date('Y-m-d', strtotime($date_debut_propose));
        $proposeDateFin = date('Y-m-d', strtotime($date_fin_propose));

        
        $this->db->query("UPDATE wbcc_DemandesConge 
                          SET dateDebutDeCongePropose = :proposeDateDebut, 
                              dateFinDeCongePropose = :proposeDateFin, 
                              commentaire = :commentaire, 
                              dateModification = :dateModification,
                              statut = :statut
                          WHERE idDemande = :id");


        $this->db->bind(':proposeDateDebut', $proposeDateDebut);
        $this->db->bind(':proposeDateFin', $proposeDateFin);
        $this->db->bind(':commentaire', $commentaire);
        $this->db->bind(':statut',$statut);
        $this->db->bind(':dateModification', date('Y-m-d H:i:s'));
        $this->db->bind(':id', $id);

        
        return $this->db->execute();
    }

    public function getAll($orderBy = 'dateCreation DESC')
    {
        $this->db->query("SELECT * FROM wbcc_DemandesConge ORDER BY $orderBy");
        return $this->db->resultSet();
    }

    public function findById($id)
    {
        // Requête pour récupérer les détails d'une demande de congé avec les informations de l'employé
        $this->db->query("SELECT dc.*, c.fullName, u.matricule
                          FROM wbcc_DemandesConge dc
                          JOIN wbcc_contact c ON dc.idContact = c.idContact
                          LEFT JOIN wbcc_utilisateur u ON u.idContactF = c.idContact
                          WHERE dc.idDemande = :id");
    
        // Liaison de l'ID de la demande
        $this->db->bind(":id", $id);
    
        // Récupération des données
        $result = $this->db->single();
    
        // Vérifier si la demande de congé existe
        if ($result) {
            return $result;
        } else {
            // Retourner un message d'erreur ou une valeur nulle si aucun enregistrement n'est trouvé
            return ['error' => 'Aucune demande de congé trouvée avec cet ID.'];
        }
    }
    

    public function getAllWithFullName($orderBy = 'idDemande') 
    {
        $this->db->query("SELECT *
                        FROM wbcc_demandesconge");
        return $this->db->resultSet();
    }
    public function getAllWithContactId($idContact = null) 
    {
        // Base query
        $query = "SELECT dc.*, c.fullName, u.matricule
                FROM wbcc_DemandesConge dc
                JOIN wbcc_contact c ON dc.idContact = c.idContact
                LEFT JOIN wbcc_utilisateur u ON u.idContactF = c.idContact";

        // If an idContact is provided, add a WHERE clause to filter
        if ($idContact) {
            $query .= " WHERE dc.idContact = :idContact";
        }

        // Order the results by idDemande
        $query .= " ORDER BY idDemande";

        // Prepare the query
        $this->db->query($query);

        // Bind the idContact if it's set
        if ($idContact) {
            $this->db->bind(":idContact", $idContact);
        }

        // Execute and return the result set
        return $this->db->resultSet();
    }
    
    //*************************************************************************************************** */

public function createConge($type, $quota, $politique) {
    $this->db->query("INSERT INTO wbcc_type_conge (type, quotas, politique) VALUES (:type, :quota, :politique)") ;
    $this->db->bind(":type", $type);
    $this->db->bind(":quota", $quota);
    $this->db->bind(":politique", $politique);
    
    $this->db->execute();
}

    public function getAllTypesConge() {
        $sql = "SELECT * from wbcc_type_conge";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getCongeById($idDemande) {
        $this->db->query("
            SELECT 
                dc.*, 
                tc.*, 
                c.fullName, 
                u.matricule, 
                u.email, 
                s.nomSite 
            FROM wbcc_demandesconge dc
            JOIN wbcc_utilisateur u ON dc.idUtilisateurF = u.idUtilisateur
            LEFT JOIN wbcc_contact c ON c.idContact = u.idContactF
            LEFT JOIN wbcc_site s ON s.idSite = u.idSiteF
            LEFT JOIN wbcc_type_conge tc ON dc.idTypeCongeF = tc.idTypeConge 
            WHERE dc.idDemande = :idDemande
        ");

        // Liaison du paramètre
        $this->db->bind(":idDemande", $idDemande);

        // Récupération des données
        return $this->db->single();
    }


    public function getFilteredConge($typeConge,$statut, $idSite, $periode, $dateOne, $dateDebut, $dateFin, $idUtilisateur) {
        $sql = "SELECT dc.*, tc.*, c.fullName, u.matricule, u.jourTravail , u.horaireTravail 
        FROM wbcc_demandesconge dc
        JOIN wbcc_utilisateur u ON dc.idUtilisateurF = u.idUtilisateur
        JOIN wbcc_type_conge tc ON dc.idTypeCongeF =tc.idTypeConge
        LEFT JOIN wbcc_contact c ON c.idContact = u.idContactF
        WHERE 1=1";

        $bindParams = [];

        // Apply 'statut' filter
        if ($statut == '0') {
            $sql .= " AND dc.statut = '0'";
        } elseif ($statut == '1') {
            $sql .= " AND dc.statut = '1'";
        } elseif ($statut == '2') {
            $sql .= " AND dc.statut = '2'";
        }

        // Apply 'type congé' filter
        if(!empty($typeConge)) {
            $sql .= " AND dc.idTypeCongeF = $typeConge";
        }

        // Apply 'utilisateur' filter
        if (!empty($idUtilisateur)) {
            $sql .= " AND c.idContact = :idUtilisateur";
            $bindParams[':idUtilisateur'] = $idUtilisateur;
        }

        // Apply 'site' filter
        if (!empty($idSite)) {
            $sql .= " AND u.idSiteF = :idSite";
            $bindParams[':idSite'] = $idSite;
        }

        // Apply 'periode' filter
        switch ($periode) {
            case 'today':
                $sql .= " AND dc.dateDebutDeCongeReelle = :today";
                $bindParams[':today'] = date('Y-m-d');
            case '1': // 'A la date du'
                if ($dateOne) {
                    // Convert the date format if needed (DD-MM-YYYY to YYYY-MM-DD)
                    $dateOneFormatted = DateTime::createFromFormat('d-m-Y', $dateOne);
                    if ($dateOneFormatted) {
                        $sql .= " AND dc.dateDebutDeCongeReelle = :dateOne";
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
                        $sql .= " AND dc.dateDebutDeCongeReelle BETWEEN :dateDebut AND :dateFin";
                        $bindParams[':dateDebut'] = $dateDebutFormatted->format('Y-m-d');
                        $bindParams[':dateFin'] = $dateFinFormatted->format('Y-m-d');
                    } else {
                        // Handle invalid date format
                        echo json_encode(['error' => 'Invalid date format for dateDebut or dateFin']);
                        exit;
                    }
                }
                break;
            default:
                // No period filter applied
                break;
        }

        $this->db->query($sql);

        foreach ($bindParams as $param => $value) {
            $this->db->bind($param, $value);
        }

        return $this->db->resultSet();
    }

  
}
