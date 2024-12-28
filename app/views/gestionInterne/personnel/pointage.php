<?php

    $selectedEmploye = $_POST['contact1'] ?? ''; 

    $selectedPeriod = $_POST['periode1'] ?? 'today'; 

    $getParams = $_POST; 

    $dates = getPeriodDates($selectedPeriod, $getParams);
    $startDate = $dates['startDate'];
    $endDate = $dates['endDate'];
    $previousStartDate = $dates['previousStartDate'];
    $previousEndDate = $dates['previousEndDate'];

    $user = $_SESSION["connectedUser"];
    $role = $user->idRole;

    $pointageListe = $role ==1 || $role ==2 ? $pointages : $pointagesById;
    $contactListe = $role ==1 || $role ==2 ? $contacts : (array) $contactById;

$idRole = $_SESSION["connectedUser"]->role;
$viewAdmin = (($idRole == "1" || $idRole == "2" || $idRole == "8" || $idRole == "9" ||  $_SESSION["connectedUser"]->isAccessAllOP == "1")) ? "" : "hidden";
$viewAdmin2 = (($idRole == "1" || $idRole == "2" || $idRole == "8" || $idRole == "9" || $idRole == 25 ||  $_SESSION["connectedUser"]->isAccessAllOP == "1")) ? "" : "hidden";

?>




<div class="section-title mb-0">
    <h2 class="mb-0">
        <button onclick="clearLocalStorageAndGoBack()">
            <i class="fas fa-fw fa-arrow-left" style="color: #c00000"></i>
        </button>
        <span>
            &nbsp;&nbsp;
            <i class="fas fa-fw fa-calendar-alt" style="color: #c00000"></i>
            Gestion de Présence
        </span>
        <!-- <button id="notificationButton" style="background: none; border: none; margin-left: 700px;" data-toggle="modal" data-target="#notificationModal">
            <i class="fas fa-fw fa-bell" style="color: #c00000;"></i>
        </button> -->
    </h2>
</div>
<div class="mt-3" id="accordionFiltrea">
    <div class="table-responsive">
        <div class="card accordion-item" style="border-radius: none !important; box-shadow: none !important;">
            <!-- <h2 class="accordion-header" id="headingTwo">
                <button
                    type="button"
                    class="accordion-button collapsed"
                    data-bs-toggle="collapse"
                    data-bs-target="#bloc1"
                    aria-expanded="false"
                    aria-controls="bloc1"
                    style="padding-top: 35px; padding-bottom: 35px; border-radius: 0px !important; box-shadow: none !important;"
                >
                    <strong>Filtres:</strong>
                </button>
            </h2> -->
            <div
                id="bloc1"
                class="accordion-collapse collapse show"
                data-bs-parent="#accordionFiltrea"
                style="box-shadow: none !important;"
            >
                <div class="accordion-body" style="box-shadow: none !important;">
                    <form method="GET" action="<?= linkTo('GestionInterne', 'gerepresence') ?>" style="border: none; margin: 0 !important; padding: 0 !important;margin: auto;" >
                        <div class="row" style="width: 100%;  margin: auto;">

                        <div class="<?= $viewAdmin!="" ? "hidden": "col-md-3 col-xs-12" ?> ">
                            <fieldset>
                            <legend class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                            &nbsp;L'employé</legend>                           
                                    <select name="idUtilisateur" class="form-control" id="contactSelect">
                                        <option value="">Tout</option>
                                        <?php if (!empty($contacts)): ?>
                                            <?php foreach ($contacts as $contact): ?>
                                                <option <?= $idUtilisateur==$contact->idContact ? 'selected' : '' ?> value="<?php echo htmlspecialchars($contact->idContact); ?>">
                                                    <?php echo htmlspecialchars($contact->fullName); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value="aucun">Aucun employé disponible</option>
                                        <?php endif; ?>
                                    </select>
                                </fieldset>
                            </div>
                        
                            <div class="<?= $viewAdmin!="" ? $viewAdmin: "col-md-3 col-xs-12" ?> ">
                            <fieldset>
                            <legend class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                            &nbsp;Site</legend>
                                <select id="site" name="site" class="form-control">
                                    <option <?= $site==='' ? 'selected' : '' ?> value="">Tout</option> 
                                    <option <?= $site==='Paris' ? 'selected' : '' ?> value="Paris">Paris</option>
                                    <option <?= $site==='Tunis' ? 'selected' : '' ?> value="Tunis">Tunis</option>
                                    <option <?= $site==='Dakar' ? 'selected' : '' ?> value="Dakar">Dakar</option>
                                    <option <?= $site==='Cotonou' ? 'selected' : '' ?> value="Cotonou">Cotonou</option>
                                </select>
                            </fieldset>
                        </div>
                        
                        <div class="col-md-3 col-xs-12 mb-3">
                            <fieldset>
                                <legend class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                                    Statut d'arrivée
                                </legend>
                                <div class="card ">
                                    <select id="etat" name="etat" class="form-control">
                                        <option <?= $etat==='' ? 'selected' : ''?> value="">Tout</option>
                                        <option <?= $etat==='Present' ? 'selected' : ''?> value="Present">À l'heure</option>
                                        <option <?= $etat==='Retard' ? 'selected' : ''?> value="Retard">Retard</option>
                                        <option <?= $etat==='Absent' ? 'selected' : ''?> value="Absent">Absent</option>
                                    </select>
                                </div>
                            </fieldset>
                        </div>
                        <!-- <div class="col-md-3 col-xs-12 mb-3">
                                <fieldset>
                                <legend class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                                    Statut de départ
                                        </legend>
                                    <div class="card ">
                                        <select id="etat" name="etat" class="form-control">
                                            <option value="">Tout</option>
                                            <option value="Present">À l'heure</option>
                                            <option value="Retard">Après l'heure</option>
                                            <option value="Absent">Avant l'heure</option>
                                        </select>
                                    </div>
                                </fieldset>
                        </div> -->

                        <div class="col-md-3 col-xs-12 mb-3">
                                <fieldset>
                                    <legend class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                                    État d'arrivée
                                </legend>
                                <div class="card ">
                                    <select id="Motifjustification" name="Motifjustification" class="form-control">
                                        <option <?= $Motifjustification==='' ? 'selected' : ''?> value="">Tout</option>
                                        <option <?= $Motifjustification==='justifie' ? 'selected' : ''?> value="justifie">Justifié</option>
                                        <option <?= $Motifjustification==='injustifie' ? 'selected' : ''?> value="injustifie">Injustifié</option>
                                        <option <?= $Motifjustification==='non-traite' ? 'selected' : ''?> value="non-traite">Non traité</option>
                                    </select>
                                </div>
                                </fieldset>
                            </div>

                        <!-- <div class="col-md-3 col-xs-12 mb-3">
                                <fieldset>
                                <legend class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                                État de départ</legend>
                                <div class="card ">
                                    <select id="Motifjustification" name="Motifjustification" class="form-control">
                                        <option value="">Tout</option>
                                        <option value="justifie">Justifié</option>
                                        <option value="injustifie">Injustifié</option>
                                        <option value="nonTraité">Non traité</option>
                                    </select>
                                </div>
                                </fieldset>
                            </div> -->
       
                            <div class="col-md-3 col-xs-12 mb-3">
                                <fieldset>
                                <legend class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                                &nbsp;Periode</legend>
                                        <div class="card ">
                                            <select name="periode" id="periode" class="form-control" onchange="dateCreationSelect(this.value)">
                                                <option <?= $periode===''?'selected':''; ?> value="">Tout</option>
                                                <option <?= $periode==='today'?'selected':''; ?> value="today">Aujourd'hui</option>
                                                <option <?= $periode==='1'?'selected':''; ?> value="1">A la date du</option>
                                                <option <?= $periode==='2'?'selected':''; ?> value="2">Personnaliser</option>
                                                <option <?= $periode==='semaine'?'selected':''; ?> value="semaine">cette semaine</option>
                                                <option <?= $periode==='mois'?'selected':''; ?> value="mois">ce mois</option>
                                                <option <?= $periode==='trimestre'?'selected':''; ?> value="trimestre">Ce trimestre</option>
                                                <option <?= $periode==='semestre'?'selected':''; ?> value="semestre">Ce semestre</option>
                                                <option <?= $periode==='annuel'?'selected':''; ?> value="annuel">Cette année</option>
                                            </select>
                                        </div>
                                    <p id="datepairOne" style="display: none;">
                                        <label for="defaultFormControlInput" class="form-label">Date:</label>
                                        <br>
                                        <input name="dateOne" id="dateOne" readonly style="border: 1px solid black;" type="text" class="this-form-control col-xs-12 col-md-12 date start " value="<?= (isset($_GET['dateOne']))?$_GET['dateOne']:''; ?>" placeholder="Choisir..."/> 
                                    </p>
                                    <p id="datepair" style="display: none;">
                                        <label for="defaultFormControlInput" class="form-label">Début:</label>
                                        <br>
                                        <input name="dateDebut" id="dateDebut" readonly style="border: 1px solid black;" type="text" class="this-form-control col-xs-12 col-md-12 date start " value="<?= (isset($_GET['dateDebut']))?$_GET['dateDebut']:''; ?>" placeholder="Choisir..."/>
                                        <input name="heureDebut" id="heureDebut" style="border: 1px solid black; display: none;" type="text" class="this-form-control col-md-offset-1 col-md-4 col-xs-offset-1 col-xs-5  time start " value="<?= (isset($_GET['heureDebut']))?$_GET['heureDebut']:''; ?>" placeholder="Choisir..."/>
                                        <br><br>
                                        <label  for="defaultFormControlInput" class="form-label">Fin:</label>
                                        <br>
                                        <input name="dateFin" id="dateFin" readonly style="border: 1px solid black;" type="text" class="this-form-control col-xs-12 col-md-12 date end " value="<?= (isset($_GET['dateFin']))?$_GET['dateFin']:''; ?>" placeholder="Choisir..."/>
                                        <input name="heureFin" id="heureFin" style="border: 1px solid black; display: none;" type="text" class="this-form-control col-md-offset-1 col-md-4 col-xs-offset-1 col-xs-5 time end " value="<?= (isset($_GET['heureFin']))?$_GET['heureFin']:''; ?>" placeholder="Choisir..."/>
                                    </p>
                                </fieldset>
                                
                            </div>
                      
                            <!-- <div class="col-md-12 col-xs-12">
                                <button type="submit" id="filterButton" class="btn btn-primary form-control" style="background: #c00000; border-radius: 0px; color: white;">FILTRER</button>
                            </div> -->

                        </div>
                        <div class="col-md-4 offset-4 col-xs-12">
<button type="submit" class="btn btn-primary form-control">FILTRER</button>
</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 

<div class="card">
    <div class="modal-content mt-3">
     <div class="card-header bg-light text-white">
        <div class="row">
            <div <?= sizeof($pointageListe) != 0 ? "" : "hidden"  ?>
                     class="row  <?= $viewAdmin != "" ? "" : "col-md-2" ?> " <?= $viewAdmin ?>>
                    <div class="col-md-4 text-left float-left">
                        <input onclick="onCheckAll()" type="checkbox" class="form-control float-left" name="allChecked"
                            id="allChecked" value="all">
                    </div>
                    <div id="divBtnExporter" class="mt-1" hidden>
                        <button type="button" rel="tooltip"
                                    title="Faire la déclaration de compagnie pour les  selectionnées"
                                    onclick="onClickExporter()" class="btn btn-sm btn-info btn-simple" id="btnExporter">
                            <i class="fas fa-download" style="color: #ffffff"></i> Exporter
                        </button>
                    </div>
                </div>



                <h2
                    class="<?= $viewAdmin != "" || sizeof($pointageListe) == 0  ? " col-md-12" : " col-md-10 " ?> font-weight-bold text-danger text-center h4">
                    Liste de pointages des salariés <br>
                    <?= $viewAdmin == '' ? "$totalMinuteRetard minutes de retard" : "$totalMinuteRetardById minutes de retard "?>
                </h2>
 </div>
    </div>
    <div class="table-responsive">
          <table id="dataTable16" class="table table-bordered"width="100%" cellspacing="0">
                <thead class="thead">
                    <tr>
                        <th></th>
                        <th>#</th>
                        <th>Actions</th>
                        <th>Date</th>
                        <th class="<?=  $viewAdmin?> ">Employé</th>
                        <th class="<?= $viewAdmin?>">Matricule</th>
                        <th>Heure d'arrivée</th>
                        <th>Heure pointage d'arrivée</th>
                        <th>Statut d'arrivée</th>
                        <th>Détails pointage d'arrivée</th>        
                        <th>Justificatif d'arrivée</th>                  
                        <th>État d'arrivée</th>
                        <th>Heure du départ</th> 
                        <th>Heure pointage du départ</th> 
                        <th>Statut du départ</th>
                        <th>Détails pointage du départ</th>
                        <th>Justificatif du départ</th>
                        <th>État du départ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pointageListe as $index => $pointage) : ?>
                    <?php
                        $dateFormatee =  date("d/m/Y", strtotime($pointage->datePointage));
                        if ($pointage->absent == 1) {
                            $etat = '<span class="badge badge-danger">Absent</span>';
                        } elseif ($pointage->retard == 1) {
                            $etat = '<span class="badge badge-warning">Retard</span>'; 
                        } else {
                            $etat = '<span class="badge badge-success">À l\'heure</span>';     
                        }
                        
                        if ($pointage->absent == 1) {
                            $etatdepart = '<span class="badge badge-danger">Absent</span>';
                        } else {
                            $difference = calculerDifferenceHeures($pointage->heureFinJour, $pointage->heureFinPointage);
                        
                            if ($difference === "-") {
                                $etatdepart = '<span class="badge badge-success">À l\'heure</span>';
                            } elseif (strpos($difference, '-') === 0) {
                                $etatdepart = '<span class="badge badge-warning">Avant l\'heure</span>';
                            } elseif (strpos($difference, '+') === 0) {
                                $etatdepart = '<span class="badge badge-primary">Après l\'heure</span>';
                            } else {
                                $etatdepart = '-';
                            }
                        }
                        
                    ?>
                    <tr data-id="<?= isset($pointage->idPointage) ? $pointage->idPointage : '' ?>" onclick="selectRow(this)">
                        <td style="text-align : center" <?= $viewAdmin ?>>
                <input onclick="onCheckOne()" type="checkbox" class="oneselection" name="check"
                    value="<?= 1 ?>">
            </td>

                    <td><?= $index + 1; ?></td>

                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-icon ml-2" onclick="showPointageDetails(<?= isset($pointage->idPointage) ? $pointage->idPointage : 'null' ?>)"  style="background: #e74c3c; color:white">
                            <i class="fas fa-eye"></i>
                        </button>   
                    </td>

                    <td><?= $dateFormatee  ?></td>
                    
                    <td class="<?= $viewAdmin?>"><?= $pointage->fullName ?? '-'; ?></td>

                    <td class="<?=  $viewAdmin?>"><?= $pointage->matricule ?? '-'; ?></td>

                    <td><?= $pointage->heureDebutJour !== null ? $pointage->heureDebutJour : '-' ?></td>

                    <td><?= $pointage->heureDebutPointage ?? '-'; ?></td> 

                    <td><?= $etat ?></td> 

                    <td><?= convertMinutesToHours($pointage->nbMinuteRetard) === "0 minutes" ? "-" : convertMinutesToHours($pointage->nbMinuteRetard) ?></td>

                   <td>
                        <?php 
                            if ($pointage->absent === 0 && $pointage->retard === 0){
                                '-';
                            } elseif ($pointage->motifRetard ) {
                                echo "oui";
                            }else{
                                echo "non";
                            }
                        ?>
                    </td>

   

                    <td>
                        <?php
                                    
                        if ($pointage->absent === 0 && $pointage->retard === 0) {
                            echo '-';
                        } elseif ($pointage->resultatTraite ==  'Accepté') {
                            echo '<span class="badge badge-success">Justifié</span>';
                        } elseif ($pointage->resultatTraite == "Refusé") {
                            echo '<span class="badge badge-danger">Injustifié</span>';
                        } else {
                            echo '<span class="badge badge-error">Injustifié</span>';
                        }
                                    
                        ?>
                    </td>

                    <td><?= $pointage->heureFinJour !== null ? $pointage->heureFinJour : '-' ?></td> 


                    <td><?= $pointage->heureFinPointage !== null ? $pointage->heureFinPointage : '-' ?></td>


                    <td><?= $etatdepart ?></td> 


                    <td><?= $pointage->heureFinPointage == null ? '-' : calculerDifferenceHeures($pointage->heureFinJour,$pointage->heureFinPointage) ?></td>


                    <td><?php 
                        if ($pointage->absent === 1 ||calculerDifferenceHeures($pointage->heureFinJour,$pointage->heureFinPointage)=== "-"|| $pointage->heureFinPointage == null ) {
                            echo '-';
                        }elseif ($pointage->motifRetardDepart ) {
                            echo "oui";
                        }else{
                            echo "non";
                        }
                        ?>
                    </td>

                        <td>
                            <?php
                                if ($pointage->absent === 1 || calculerDifferenceHeures($pointage->heureFinJour, $pointage->heureFinPointage) === "-" || $pointage->heureFinPointage == null) {
                                    echo '-';
                                } elseif ($pointage->resultatTraiteDepart == 'Accepté') {
                                    echo '<span class="badge badge-success">Justifié</span>';
                                } elseif ($pointage->resultatTraiteDepart == 'Refusé') {
                                    echo '<span class="badge badge-danger">Injustifié</span>';
                                } else {
                                    echo '<span class="badge badge-error">Injustifié</span>';
                                }
                            ?>
                        </td>
                    </tr>
                     <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3" id="accordionFiltrea1">
    <div class="table-responsive">
        <div class="card accordion-item" style="border-radius: none !important; box-shadow: none !important;">
            <!-- <h2 class="accordion-header" id="headingTwo">
                <button
                    type="button"
                    class="accordion-button collapsed"
                    data-bs-toggle="collapse"
                    data-bs-target="#bloc2"
                    aria-expanded="false"
                    aria-controls="bloc2"
                    style="padding-top: 35px; padding-bottom: 35px; border-radius: 0px !important; box-shadow: none !important;"
                >
                    <strong>Filtres:</strong>
                </button>
            </h2> -->
            <div
                id="bloc2"
                class="accordion-collapse collapse show"
                data-bs-parent="#accordionFiltrea1"
                style="box-shadow: none !important;"
            >
                <div class="accordion-body" style="box-shadow: none !important;">
                    <form method="POST" id="filterForm" action="" style="border: none; margin: 0 !important; padding: 0 !important;margin: auto;">
                        <div class="row" style="width: 100%; margin: auto;">
                        <div class="<?=  $viewAdmin!= "" ? $viewAdmin : 'col-md-6 col-xs-12 mb-3'?>">
                                <fieldset>
                                    <legend class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                                    &nbsp;L'employé</legend>
                                    <div class="card ">
                                        <select name="contact1" class="form-control" id="contact1Select">
                                            <option value="">Tout</option>

                                            <?php if (!empty($contacts)): ?>
                                                <?php foreach ($contacts as $contact): ?>
                                                    <option value="<?= htmlspecialchars($contact->fullName); ?>" <?= (isset($_POST['contact1']) && $_POST['contact1'] == $contact->fullName) ? 'selected' : ''; ?>>
                                                        <?= htmlspecialchars($contact->fullName); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <option value="aucun">Aucun employé disponible</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </fieldset>
                            </div>
                            <!-- Période -->
                            <div class="col-md-6 col-xs-12 mb-3">
                                <fieldset>
                                    <legend class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                                    Période</legend>
                                    <div class="card ">
                                        <select name="periode1" class="form-control">
                                            <option <?= (isset($_POST['periode1']) && $_POST['periode1'] === 'today') ? 'selected' : ''; ?> value="today">Aujourd'hui</option>
                                            <option <?= (isset($_POST['periode1']) && $_POST['periode1'] === 'semaine') ? 'selected' : ''; ?> value="semaine">Cette semaine</option>
                                            <option <?= (isset($_POST['periode1']) && $_POST['periode1'] === 'mois') ? 'selected' : ''; ?> value="mois">Ce mois</option>
                                            <option <?= (isset($_POST['periode1']) && $_POST['periode1'] === 'trimestre') ? 'selected' : ''; ?> value="trimestre">Ce trimestre</option>
                                            <option <?= (isset($_POST['periode1']) && $_POST['periode1'] === 'semestre') ? 'selected' : ''; ?> value="semestre">Ce semestre</option>
                                            <option <?= (isset($_POST['periode1']) && $_POST['periode1'] === 'annuel') ? 'selected' : ''; ?> value="annuel">Cette année</option>
                                            <option <?= (isset($_POST['periode1']) && $_POST['periode1'] === 'custom') ? 'selected' : ''; ?> value="custom">Personnaliser</option>
                                        </select>
                                    </div>
                                    <p id="datepair1" style="<?= (isset($_POST['periode1']) && $_POST['periode1'] === 'custom') ? 'display: block;' : 'display: none;'; ?>">
                                        <label for="defaultFormControlInput" class="form-label">Début période 1:</label>
                                        <br>
                                        <input name="dateDebut1" id="dateDebut1" readonly style="border: 1px solid black;" type="text" class="this-form-control col-xs-12 col-md-12 date start" value="<?= isset($_POST['dateDebut1']) ? $_POST['dateDebut1'] : ''; ?>" placeholder="Choisir..."/>
                                        
                                        <label for="defaultFormControlInput" class="form-label">Fin période 1:</label>
                                        <input name="dateFin1" id="dateFin1" style="border: 1px solid black;" type="text" class="this-form-control col-xs-12 col-md-12 date end" value="<?= isset($_POST['dateFin1']) ? $_POST['dateFin1'] : ''; ?>" placeholder="Choisir..."/>
                                        
                                        <br><br>
                                        <label for="defaultFormControlInput" class="form-label">Début période 2:</label>
                                        <br>
                                        <input name="dateDebut2" id="dateDebut2" readonly style="border: 1px solid black;" type="text" class="this-form-control col-xs-12 col-md-12 date start" value="<?= isset($_POST['dateDebut2']) ? $_POST['dateDebut2'] : ''; ?>" placeholder="Choisir..."/>
                                        
                                        <label for="defaultFormControlInput" class="form-label">Fin période 2:</label>
                                        <input name="dateFin2" id="dateFin2" style="border: 1px solid black;" type="text" class="this-form-control col-xs-12 col-md-12 date end" value="<?= isset($_POST['dateFin2']) ? $_POST['dateFin2'] : ''; ?>" placeholder="Choisir..."/>
                                    </p>
                                </fieldset>
                                </div>
                            <div class="col-md-12 col-xs-12">
                                <button type="submit" class="btn btn-primary form-control" style="background: #c00000; border-radius: 0px; color: white;">FILTRER</button>
                            </div>
                        
                
                    </form>
                </div>
            </div>
</div>

<div class="card-body">
    <h2 class="text-center" style="color: grey;">Bilan comparatif</h2>
    <br>
    
    <div class="table-responsive">
        <table  class="simple-table" cellspacing="0">
            <thead>
                <tr>
                    <th>#</th>
                    <th class=<?=$viewAdmin?>>L'employé</th>
                    <th>Période</th>
                    <th>Retard Total</th>
                    <th>Écart Retard</th>
                    <th>Absence Total</th>            
                    <th>Écart Absence</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $index = 1;

                $labels = [];
                $retards = [];
                $absences = [];
   
                if (!empty($selectedEmploye)) {
                    
                    $retardTotal = 0;
                    $absenceTotal = 0;
                    $retardTotalPrev = 0;
                    $absenceTotalPrev = 0;
                    $filteredPointages = filterPointagesByEmployeAndPeriod($selectedEmploye, $startDate, $endDate, $pointages, $retardTotal, $absenceTotal);
                    $filteredPointagesPrev = filterPointagesByEmployeAndPeriod($selectedEmploye, $previousStartDate, $previousEndDate, $pointages, $retardTotalPrev, $absenceTotalPrev);    
                    $ecartRetard = $retardTotal - $retardTotalPrev;
                    $ecartAbsence = $absenceTotal - $absenceTotalPrev;
                    ?>
                    <tr>
                        <th rowspan="2"><?= $index ?></th>
                        <td rowspan="2"><?= htmlspecialchars($selectedEmploye) ?></td>
                        <td><?= formatPeriod($startDate, $endDate, $selectedPeriod) ?></td>
                        <td><?= convertMinutesToHours($retardTotal) ?></td>
                        <td rowspan="2"><?= ($ecartRetard > 0 ? '+' : '') . convertMinutesToHours($ecartRetard) ?></td>
                        <td><?= $absenceTotal ?> jours</td>
                        <td rowspan="2"><?= ($ecartAbsence > 0 ? '+' : '') . $ecartAbsence ?> jours</td>
                    </tr>
                    <tr>
                        <td><?= formatPeriod($previousStartDate, $previousEndDate, $selectedPeriod, true) ?></td>
                        <td><?= convertMinutesToHours($retardTotalPrev) ?></td>
                        <td><?= $absenceTotalPrev ?> jours</td>
                    </tr>
                    <?php
                    $index++;
                    $labels[] = htmlspecialchars($selectedEmploye);
                    $retards[] = $retardTotal; 
                    $absences[] = $absenceTotal;
                    $retardsPrev[] = $retardTotalPrev;
                    $absencesPrev[] = $absenceTotalPrev;
                } else {
                   
                    if (!empty($contactListe) && is_array($contactListe)) {
                        foreach ($contactListe as $employe) {
                           
                            $retardTotalEmploye = 0;
                            $absenceTotalEmploye = 0;
                            $retardTotalPrevEmploye = 0;
                            $absenceTotalPrevEmploye = 0;
                
                            filterPointagesByEmployeAndPeriod(
                               $viewAdmin=="" ? $employe->fullName : $user->fullName,
                                $startDate,
                                $endDate,
                                $pointages,
                                $retardTotalEmploye,
                                $absenceTotalEmploye
                            );
                    
                            filterPointagesByEmployeAndPeriod(
                                $viewAdmin=="" ? $employe->fullName : $user->fullName,
                                $previousStartDate,
                                $previousEndDate,
                                $pointages,
                                $retardTotalPrevEmploye,
                                $absenceTotalPrevEmploye
                            );
                    
                            $ecartRetardEmploye = $retardTotalEmploye - $retardTotalPrevEmploye;
                            $ecartAbsenceEmploye = $absenceTotalEmploye - $absenceTotalPrevEmploye;
                    
                            ?>
                            <tr>
                                <th rowspan="2"><?= $index ?></th>
                                <td rowspan="2" class="<?=$viewAdmin?>"><?= htmlspecialchars($viewAdmin=="" ? $employe->fullName : $user->fullName) ?></td>
                                <td><?= formatPeriod($startDate, $endDate, $selectedPeriod) ?></td>
                                <td><?= convertMinutesToHours($retardTotalEmploye) ?></td>
                                <td rowspan="2"><?= ($ecartRetardEmploye > 0 ? '+' : '') . convertMinutesToHours($ecartRetardEmploye) ?></td>

                                <td><?= $absenceTotalEmploye ?> jours</td>
                                <td rowspan="2"><?= ($ecartAbsenceEmploye > 0 ? '+' : '') . $ecartAbsenceEmploye ?> jours</td>
                            </tr>
                            <tr>
                                <td><?= formatPeriod($previousStartDate, $previousEndDate, $selectedPeriod, true) ?></td>
                                <td><?= convertMinutesToHours($retardTotalPrevEmploye) ?></td>
                                <td><?= $absenceTotalPrevEmploye ?> jours</td>
                            </tr>
                            <?php
                            $index++;
                            
                            // Stocker les données pour le graphique
                            $labels[] = htmlspecialchars($viewAdmin=="" ? $employe->fullName : $user->fullName);
                            $retards[] = $retardTotalEmploye;
                            $absences[] = $absenceTotalEmploye;
                            $retardsPrev[] = $retardTotalPrevEmploye;
                            $absencesPrev[] = $absenceTotalPrevEmploye;
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center'>Aucun employé trouvé.</td></tr>";
                    }
                }
                ?>
                
            </tbody>
        </table>
    </div>
   
</div>
<?php

    $totalRetardCurrent = array_sum($retards);  
    $totalAbsenceCurrent = array_sum($absences);
    $totalRetardPrevious = array_sum($retardsPrev);  
    $totalAbsencePrevious = array_sum($absencesPrev);  


?>

<div class="container">
    <div class="row mt-8 justify-content-center">
        <div class="col-md-6 d-flex justify-content-center">
            <canvas id="retardPieChart" style="max-width: 450px; width: 100%;"></canvas>
        </div>
        <div class="col-md-6 d-flex justify-content-center">
            <canvas id="absencePieChart" style="max-width: 450px; width: 100%;"></canvas>
        </div>
    </div>
</div>

<!-- modal Confirmation TRANSFERT -->
<div class="modal fade" id="modalConfirmExport" data-backdrop="static">
    <div class="modal-dialog modal-lg bg-white">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h3 class="text-black font-weight-bold">Voulez-vous exporter les pointages selectionnés
                    ?</h3>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-6">
                        <button class="btn btn-danger" data-dismiss="modal">Non</button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-success" onclick="exporterFacture()">Oui</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detaillePointageModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content shadow-lg rounded">
        
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title font-weight-bold text-uppercase" id="modalLabel">Détails du Pointage</h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
          
            <div class="modal-body px-4 py-4">
                <div class="row">
           
                    <div class="col-md-6">
                        <p><i class="fas fa-user"></i> <strong>L'employé:</strong> <span id="modalemploye"></span></p>
                        <p><i class="fas fa-id-badge"></i> <strong>Matricule:</strong> <span id="modalmatricule"></span></p>
                        <p><i class="fas fa-building"></i> <strong>Site:</strong> <span id="modalsite"></span></p>

                        <p><i class="fas fa-calendar-alt"></i> <strong>Date Pointage:</strong> <span id="modalDatePointage"></span></p>
                        <p><i class="fas fa-exclamation-circle"></i> <strong>Statut d'arrivée:</strong> <span id="modalEtat"></span></p>
                        <p><i class="fas fa-exclamation-circle"></i> <strong>Statut du départ:</strong> <span id="modalEtatDepart"></span></p>
                    </div>
                   
                      <div class="col-md-6">
                        <p><i class="fas fa-clock"></i> <strong>Heure d'arrivée:</strong> <span id="modalHeureDebutJour"></span></p>
                        <p><i class="fas fa-clock"></i> <strong>Heure du départ:</strong> <span id="modalHeurefinJour"></span></p>
                        <p><i class="fas fa-clock"></i> <strong>Heure pointage d'arrivée:</strong> <span id="modalHeureDebutPointage"></span></p>
                        <p><i class="fas fa-clock"></i> <strong>Heure pointage du départ:</strong> <span id="modalHeurefinPointage"></span></p>
                        <p><i class="fas fa-hourglass-half"></i> <strong>Détails pointage d'arrivée:</strong> <span id="modalMinutesRetard"></span></p>
                        <p><i class="fas fa-hourglass-half"></i> <strong>Détails pointage du départ:</strong> <span id="modalminutesDepart"></span></p>
                    </div>
                </div>
                <hr>
                <p><i class="fas fa-comment"></i> <strong>État d'arrivée:</strong> <span id="modalMotifRetard"></span></p>

                        <p>  
                            <i class="fas fa-link"></i> 
                            <strong id="modalpiecsejustification">Pièces justificatives d'arrivée:</strong>
                        </p>
                        <div class="scrollable-container mb-3"> 
                            <span id="modalurlJustification"></span> 
                        </div>
                        <p><i class="fas fa-comment"></i> <strong>Motif d'arrivée:</strong></p>
                        <div id="modalJustification" class="motif-container"></div>

                <div class="mt-0">
                    <div class="<?= $viewAdmin != '' ? $viewAdmin : 'form-group' ?>">
                        <label for="confirmation" class="font-weight-bold">Êtes-vous sûr de vouloir valider la justification d'arrivée ?</label><br>
                       
                        <div class="row">
                            <div class="form-check d-inline-block  ml-3">
                                <input type="radio" class="form-check-input" id="confirmOui" name="confirmation" value="oui">
                                <label class="form-check-label font-weight-bold" for="confirmOui">Oui</label>
                            </div>

                            <div class="form-check d-inline-block ml-3">
                                <input type="radio" class="form-check-input" id="confirmNon" name="confirmation" value="non">
                                <label class="form-check-label font-weight-bold" for="confirmNon">Non</label>
                            </div>

                        
                        </div>
                        <input type="hidden" id="modalpointage_id">
                        <input type="hidden" id="modalidUserF">
                        <input type="hidden" id="modalemailuser">
                    
                        <div class="modal-footer">
                        <button class="btn btn-success" type="button" id="confirmJustificationArriveeSubmit">Confirmer</button>
                        <button class="btn btn-danger" type="button" data-dismiss="modal">Annuler</button>
                    </div>
                </div>
                <hr>
                <p><i class="fas fa-comment"></i> <strong>État du départ:</strong> <span id="modalMotifRetarddepart"></span></p>
                <p>  <i class="fas fa-link"></i> 
                            <strong id="modalpiecsejustification">Pièces justificatives du départ:</strong>
                        </p><div class="scrollable-container mb-3"> 

                        <span id="modalurlJustificationDepart"></span> 
                        </div>
                        <p><i class="fas fa-comment"></i> <strong>Motif du départ:</strong></p>
                        <div id="modalJustificationDepart" class="motif-container"></div>
                        <div class="mt-0">
                    <div class="<?= $viewAdmin != '' ? $viewAdmin : 'form-group' ?>">
                        <label for="confirmationDepart" class="font-weight-bold">Êtes-vous sûr de vouloir valider la justification du départ?</label><br>
                        
                        <div class="row">
                            <div class="form-check d-inline-block ml-3">
                                <input type="radio" class="form-check-input" id="confirmDepartOui" name="confirmationDepart" value="oui">
                                <label class="form-check-label font-weight-bold" for="confirmDepartOui">Oui</label>
                            </div>

                            <div class="form-check d-inline-block ml-3">
                                <input type="radio" class="form-check-input" id="confirmDepartNon" name="confirmationDepart" value="non">
                                <label class="form-check-label font-weight-bold" for="confirmDepartNon">Non</label>
                            </div>

                        </div>
                        <input type="hidden" id="modalpointage_id">
                        <input type="hidden" id="modalidUserF">
                        <input type="hidden" id="modalemailuser">
                    
                    <div class="modal-footer">
                        <button class="btn btn-success" type="button" id="confirmJustificationDepartSubmit">Confirmer</button>
                        <button class="btn btn-danger" type="button" data-dismiss="modal">Annuler</button>
                    </div>
                </div>

            </div>
            
           
        </div>
    </div>
</div>

<!-- 
<div class="modal fade" id="confirmJustificationModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            
            <div class="modal-header" style="background-color: #c00000;">
                <h5 class="modal-title font-weight-bold text-uppercase text-white" id="modalLabel">Confirmation de la Justification</h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">&times;</span>
                </button>
            </div>

            
            <div class="modal-body">
                
                <div class="form-group">
                    <label for="confirmation">Êtes-vous sûr de vouloir valider cette justification ?</label><br>
                    
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="confirmOui" name="confirmation" value="oui">
                        <label class="form-check-label" for="confirmOui">Oui</label>
                    </div>
                    
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="confirmNon" name="confirmation" value="non">
                        <label class="form-check-label" for="confirmNon">Non</label>
                    </div>
                </div>
            
                
                <input type="hidden" id="pointage_id">
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" type="button" id="confirmJustificationSubmit">Confirmer</button>
                <button class="btn btn-danger" type="button" data-dismiss="modal">Annuler</button>
            </div>
        </div>
    </div>
</div> -->
<div class="modal fade modal-center" id="errorOperation" data-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg bg-white">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h3 id="msgError" style="color:red">Veuillez sélectionner une ligne !</h3>
                    <button onclick="closeModal()" class="btn btn-danger">OK</button>
                </div>
            </div>
        </div>
</div>


<div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content shadow-lg rounded">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title font-weight-bold text-uppercase" id="notificationModalLabel">Notifications</h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-4 py-3">
                <!-- Notification List Container with scrollable area -->
                <div class="notification-list" style="max-height: 400px; overflow-y: auto;">
                    <!-- Notification items will be populated here dynamically -->
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>


<script  src="<?= URLROOT ?>/assets/ticket/vendor/libs/jquery/jquery.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->

<script>
    // const URLROOT = '<?= URLROOT; ?>';
   
    let selectedPointageId = null; 

    function selectRow(row) {
   
        $('#dataTable16 tbody tr').removeClass('selected');
  
        $(row).addClass('selected');

       
        selectedPointageId = $(row).data('id');
    }

    function onCheckOne() {
        let postMail = {};
        var one = document.getElementsByName('check');
        let isChecked = false;
        let checkAll = true;
        let i = 0;
        for (let index = 0; index < one.length; index++) {
            const element = one[index];
            if (element.checked) {
                i++;
                isChecked = true;
            } else {
                checkAll = false;
            }
        }

        if (isChecked) {
            $("#divBtnExporter").removeAttr("hidden");
        } else {
            $("#divBtnExporter").attr("hidden", "hidden")
        }
        var all = document.getElementsByName('allChecked');
        let btnExporter = document.getElementById("btnExporter");
        btnExporter.innerHTML = "<i class='fas fa-download' style='color: #ffffff'></i> Exporter (" + i + ")"
        if (checkAll) {
            all[0].checked = true;
        } else {
            all[0].checked = false;
        }
    }

    function onClickExporter() {
        $("#modalConfirmExport").modal("show");
    }

    function onCheckAll() {
        var all = document.getElementsByName('allChecked');
        let checked = all[0].checked;
        var one = document.getElementsByName('check');
        one.forEach(element => {
            element.checked = false;
        });
        let btnExporter = document.getElementById("btnExporter");
        btnExporter.innerHTML = "<i class='fas fa-download' style='color: #ffffff'></i> Exporter (" + one.length + ")"
        if (checked) {
            //Check ALL
            one.forEach(element => {
                element.checked = true;
            });
            $("#divBtnExporter").removeAttr("hidden");

        } else {
            $("#divBtnExporter").attr("hidden", "hidden")
            one.forEach(element => {
                element.checked = false;
            });
        }
    }
     
     $(document).ready(function () {
        $('.select3').select2();
      
        $('#dataTable16 tbody').on('click', 'tr', function () {
            
            selectRow(this);
        });
    });
    function showtraiter(pointageId){
      if (pointageId) {
       
        $('#pointage_id').val(pointageId);

     
        $('#confirmJustificationModal').modal('show');
        } else {
        
            $('#errorOperation').modal('show');
            return;
        }
   }
   // Function to create notification
    function createNotification(idUtilisateur, title, message) {
        $.ajax({
            url: `${URLROOT}/public/json/pointage.php?action=createNotification`,
            type: 'POST',
            data: {
                idUtilisateur: idUtilisateur,
                title: title,
                message: message
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    console.log('Notification created successfully:', response.message);
                } else {
                    console.error('Failed to create notification:', response.error);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error creating notification:', error);
            }
        });
    }
    function sendEmail(to, subject, body) {
    $.ajax({
        url: `${URLROOT}/public/json/pointage.php?action=sendEmail`, // URL de la fonction PHP
        type: 'POST',
        data: {
            to: to,
            subject: subject,
            body: body
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                console.log('Email sent successfully:', response.message);
            } else {
                console.error('Failed to send email:', response.error);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error sending email:', error);
        }
    });
    }

//    const userId = '<?php echo $_SESSION['connectedUser']->idUtilisateur ?? 'undefined'; ?>';

   $('#confirmJustificationArriveeSubmit').on('click', function () {
    // Récupération des ID nécessaires
    var selectid = $('#modalpointage_id').val();
    var userid_pointage = $('#modalidUserF').val();
    var email = $('#modalemailuser').val(); 

    const confirmOui = document.getElementById("confirmOui").checked;
    const confirmNon = document.getElementById("confirmNon").checked;
    // const confirmDepartOui = document.getElementById("confirmDepartOui").checked;
    // const confirmDepartNon = document.getElementById("confirmDepartNon").checked;

    const datePointageElement = document.getElementById("modalDatePointage");
    const datePointage = datePointageElement ? datePointageElement.innerText : "-";

    let titleNotificationToSend = "";
    let notificationTosend = "";
    let emailSubject = "";
    let emailBody = "";

    // Déterminer le choix pour "arrivée"
    if (confirmOui || confirmNon) {
        const confirmation = confirmOui ? "oui" : "non";
        titleNotificationToSend = `Justificatif ${confirmation === "oui" ? "accepté" : "refusé"}`;
        notificationTosend = `Votre justificatif d'arrivée pour le ${datePointage} a été ${confirmation === "oui" ? "approuvé" : "rejeté"} par votre manager.`;
        emailSubject = `Justification ${confirmation === "oui" ? "Acceptée" : "Rejetée"}`;
        emailBody = `
        Bonjour,<br /><br />
        Votre manager a ${confirmation === "oui" ? "accepté" : "rejeté"} le justificatif que vous avez soumis pour le ${datePointage}.<br /><br />
        ${confirmation === "oui" ? 
            "Votre justificatif a été approuvé et enregistré avec succès. L'état d'arrivée est maintenant 'justifié'." : 
            "Malheureusement, votre justificatif a été refusé. L'état d'arrivée reste 'injustifié'."}<br /><br />
        Si vous avez des questions ou souhaitez obtenir plus d'informations, n'hésitez pas à contacter votre manager.<br /><br />
        Cordialement,<br />
        Votre équipe RH<br />
        `;
    }

    // Déterminer le choix pour "départ"
    // if (confirmDepartOui || confirmDepartNon) {
    //     const confirmationDepart = confirmDepartOui ? "oui" : "non";
    //     titleNotificationToSend = `Justificatif ${confirmationDepart === "oui" ? "accepté" : "refusé"}`;
    //     notificationTosend = `Votre justificatif de départ pour le ${datePointage} a été ${confirmationDepart === "oui" ? "approuvé" : "rejeté"} par votre manager.`;
    //     emailSubject = `Justification ${confirmationDepart === "oui" ? "Acceptée" : "Rejetée"}`;
    //     emailBody = `
    //     Bonjour,<br /><br />
    //     Votre manager a ${confirmationDepart === "oui" ? "accepté" : "rejeté"} le justificatif que vous avez soumis pour le ${datePointage}.<br /><br />
    //     ${confirmationDepart === "oui" ? 
    //         "Votre justificatif a été approuvé et enregistré avec succès. L'état du départ est maintenant 'justifié'." : 
    //         "Malheureusement, votre justificatif a été refusé. L'état du départ reste 'injustifié'."}<br /><br />
    //     Si vous avez des questions ou souhaitez obtenir plus d'informations, n'hésitez pas à contacter votre manager.<br /><br />
    //     Cordialement,<br />
    //     Votre équipe RH<br />
    //     `;
    // }

    if (!selectid) {
        alert('ID de pointage introuvable.');
        return;
    }

    // Obtenir les sélections pour les justifications d'arrivée et de départ
    var arriveeStatus = getSelectedStatus('confirmation'); // Radio group "confirmation"
    // var departStatus = getSelectedStatus('confirmationDepart'); // Radio group "confirmationDepart"

    if (arriveeStatus === null) {
        alert('Veuillez sélectionner une justification d\'arrivée');
        return;
    }

    // Fonction AJAX générique pour mettre à jour les justifications
    function updateJustification(endpoint, data, successMessage) {
        return $.ajax({
            url: `${URLROOT}/public/json/pointage.php?action=${endpoint}`,
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    console.log(successMessage, response);

                    // Appel de createNotification
                    createNotification(userid_pointage, titleNotificationToSend, notificationTosend);

                    // Appel de sendEmail avec l'email dynamique
                    sendEmail(
                        email, // Utilisation de l'email dynamique
                        emailSubject,
                        emailBody
                    );
                } else {
                    console.error('Erreur lors de la mise à jour :', response.error);
                    alert('Erreur: ' + response.error);
                }
            },
            error: function (xhr, status, error) {
                console.error('Erreur AJAX :', error);
                alert('Une erreur est survenue lors de la mise à jour.');
            }
        });
    }

    // Mise à jour de la justification d'arrivée si nécessaire
    if (arriveeStatus !== null) {
        updateJustification(
            'updateJustification',
            { idPointage: selectid, idTraiteF: userId, resultatTraite: arriveeStatus },
            `Le résultat de la justification d'arrivée est : ${arriveeStatus}`
        );
    }

    // Mise à jour de la justification de départ si nécessaire
    // if (departStatus !== null) {
    //     updateJustification(
    //         'updateJustificationsDepart',
    //         { idPointage: selectid, idTraiteDepartF: userId, resultatTraiteDepart: departStatus },
    //         `Le résultat de la justification de départ est : ${departStatus}`
    //     );
    // }

    // Fermer le modal après l'update
    $('#confirmJustificationModal').modal('hide');

    // Optionnel : Rafraîchir la page après un délai pour attendre la fin des requêtes AJAX
    setTimeout(function () {
        window.location.reload();
    }, 500);
});

   $('#confirmJustificationDepartSubmit').on('click', function () {
    // Récupération des ID nécessaires
    var selectid = $('#modalpointage_id').val();
    var userid_pointage = $('#modalidUserF').val();
    var email = $('#modalemailuser').val(); 

    // const confirmOui = document.getElementById("confirmOui").checked;
    // const confirmNon = document.getElementById("confirmNon").checked;
    const confirmDepartOui = document.getElementById("confirmDepartOui").checked;
    const confirmDepartNon = document.getElementById("confirmDepartNon").checked;

    const datePointageElement = document.getElementById("modalDatePointage");
    const datePointage = datePointageElement ? datePointageElement.innerText : "-";

    let titleNotificationToSend = "";
    let notificationTosend = "";
    let emailSubject = "";
    let emailBody = "";

    // Déterminer le choix pour "arrivée"
    // if (confirmOui || confirmNon) {
    //     const confirmation = confirmOui ? "oui" : "non";
    //     titleNotificationToSend = `Justificatif ${confirmation === "oui" ? "accepté" : "refusé"}`;
    //     notificationTosend = `Votre justificatif d'arrivée pour le ${datePointage} a été ${confirmation === "oui" ? "approuvé" : "rejeté"} par votre manager.`;
    //     emailSubject = `Justification ${confirmation === "oui" ? "Acceptée" : "Rejetée"}`;
    //     emailBody = `
    //     Bonjour,<br /><br />
    //     Votre manager a ${confirmation === "oui" ? "accepté" : "rejeté"} le justificatif que vous avez soumis pour le ${datePointage}.<br /><br />
    //     ${confirmation === "oui" ? 
    //         "Votre justificatif a été approuvé et enregistré avec succès. L'état d'arrivée est maintenant 'justifié'." : 
    //         "Malheureusement, votre justificatif a été refusé. L'état d'arrivée reste 'injustifié'."}<br /><br />
    //     Si vous avez des questions ou souhaitez obtenir plus d'informations, n'hésitez pas à contacter votre manager.<br /><br />
    //     Cordialement,<br />
    //     Votre équipe RH<br />
    //     `;
    // }

    // Déterminer le choix pour "départ"
    if (confirmDepartOui || confirmDepartNon) {
        const confirmationDepart = confirmDepartOui ? "oui" : "non";
        titleNotificationToSend = `Justificatif ${confirmationDepart === "oui" ? "accepté" : "refusé"}`;
        notificationTosend = `Votre justificatif de départ pour le ${datePointage} a été ${confirmationDepart === "oui" ? "approuvé" : "rejeté"} par votre manager.`;
        emailSubject = `Justification ${confirmationDepart === "oui" ? "Acceptée" : "Rejetée"}`;
        emailBody = `
        Bonjour,<br /><br />
        Votre manager a ${confirmationDepart === "oui" ? "accepté" : "rejeté"} le justificatif que vous avez soumis pour le ${datePointage}.<br /><br />
        ${confirmationDepart === "oui" ? 
            "Votre justificatif a été approuvé et enregistré avec succès. L'état du départ est maintenant 'justifié'." : 
            "Malheureusement, votre justificatif a été refusé. L'état du départ reste 'injustifié'."}<br /><br />
        Si vous avez des questions ou souhaitez obtenir plus d'informations, n'hésitez pas à contacter votre manager.<br /><br />
        Cordialement,<br />
        Votre équipe RH<br />
        `;
    }

    if (!selectid) {
        alert('ID de pointage introuvable.');
        return;
    }

    // Obtenir les sélections pour les justifications d'arrivée et de départ
    // var arriveeStatus = getSelectedStatus('confirmation'); // Radio group "confirmation"
    var departStatus = getSelectedStatus('confirmationDepart'); // Radio group "confirmationDepart"

    if (departStatus === null) {
        alert('Veuillez sélectionner une justification de depart');
        return;
    }

    // Fonction AJAX générique pour mettre à jour les justifications
    function updateJustification(endpoint, data, successMessage) {
        return $.ajax({
            url: `${URLROOT}/public/json/pointage.php?action=${endpoint}`,
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    console.log(successMessage, response);

                    // Appel de createNotification
                    createNotification(userid_pointage, titleNotificationToSend, notificationTosend);

                    // Appel de sendEmail avec l'email dynamique
                    sendEmail(
                        email, // Utilisation de l'email dynamique
                        emailSubject,
                        emailBody
                    );
                } else {
                    console.error('Erreur lors de la mise à jour :', response.error);
                    alert('Erreur: ' + response.error);
                }
            },
            error: function (xhr, status, error) {
                console.error('Erreur AJAX :', error);
                alert('Une erreur est survenue lors de la mise à jour.');
            }
        });
    }

    // Mise à jour de la justification d'arrivée si nécessaire
    // if (arriveeStatus !== null) {
    //     updateJustification(
    //         'updateJustification',
    //         { idPointage: selectid, idTraiteF: userId, resultatTraite: arriveeStatus },
    //         `Le résultat de la justification d'arrivée est : ${arriveeStatus}`
    //     );
    // }

    // Mise à jour de la justification de départ si nécessaire
    if (departStatus !== null) {
        updateJustification(
            'updateJustificationsDepart',
            { idPointage: selectid, idTraiteDepartF: userId, resultatTraiteDepart: departStatus },
            `Le résultat de la justification de départ est : ${departStatus}`
        );
    }

    // Fermer le modal après l'update
    $('#confirmJustificationModal').modal('hide');

    // Optionnel : Rafraîchir la page après un délai pour attendre la fin des requêtes AJAX
    setTimeout(function () {
        window.location.reload();
    }, 500);
});


// Fonction utilitaire pour récupérer le statut sélectionné dans un groupe de boutons radio
function getSelectedStatus(groupName) {
    var selectedOption = $(`input[name="${groupName}"]:checked`).val();
    if (selectedOption === 'oui') {
        return 'Accepté';
    } else if (selectedOption === 'non') {
        return 'Refusé';
    }
    return null; // Aucun choix sélectionné
}


    function showPointageDetails(id) {
        if (id === null) {
            $('#errorOperation').modal('show');
            return;
        }
            $.ajax({
                url: `${URLROOT}/public/json/pointage.php?action=getPointageById`,  
                method: 'POST',
                data: {
                    idPointage: id
                },
            dataType: 'json',
            success: function(response) {
                console.log(response);
                
                
                let pointage_id = document.getElementById('modalpointage_id');
                    pointage_id.value = response.idPointage;
                let idUserF = document.getElementById('modalidUserF');
                    idUserF.value = response.idUserF;
                let emailuser = document.getElementById('modalemailuser');
                    emailuser.value = response.email;
                
                    let employeElement = document.getElementById('modalemploye');
                    if (employeElement) {
                        employeElement.innerText = response.fullName || '-';
                    }

                    let matriculeElement = document.getElementById('modalmatricule');
                    if (matriculeElement) {
                        matriculeElement.innerText = response.matricule || '-';
                    }

                    let siteElement = document.getElementById('modalsite');
                    if (siteElement) {
                        siteElement.innerText = response.nomSite || '-';
                    }

                let datePointageElement = document.getElementById('modalDatePointage');
                if (datePointageElement) {
                    datePointageElement.innerText = formatDate(response.datePointage) || '-';
                }

                let heureDebutJourElement = document.getElementById('modalHeureDebutJour');
                if (heureDebutJourElement) {
                    heureDebutJourElement.innerText = response.heureDebutJour || '-';
                }

                let heureDebutPointageElement = document.getElementById('modalHeureDebutPointage');
                if (heureDebutPointageElement) {
                    heureDebutPointageElement.innerText = response.heureDebutPointage || '-';
                }
                let heureFinJourElement = document.getElementById('modalHeurefinJour');
                if (heureFinJourElement) {
                    heureFinJourElement.innerText = response.heureFinJour || '-';
                }

                let heureFinPointageElement = document.getElementById('modalHeurefinPointage');
                if (heureFinPointageElement) {
                    heureFinPointageElement.innerText = response.heureFinPointage || '-';
                }
          

                let minutesRetardElement = document.getElementById('modalMinutesRetard');
                if (minutesRetardElement) {
                    minutesRetardElement.innerText =  convertMinutesToHours(response.nbMinuteRetard )|| '0';
                }
                let minutesDepartElement = document.getElementById('modalminutesDepart');
                if (minutesDepartElement) {
                    minutesDepartElement.innerText =calculerDifferenceHeures(response.heureFinJour, response.heureFinPointage);
                }
                let justificationElement = document.getElementById('modalJustification');
                if (justificationElement) {
                    justificationElement.innerHTML = response.motifRetard ? `<p style="margin-left:20px; font-size:16px;">${response.motifRetard}</p>` :  `<p style=" font-size:16px;">Aucun motif trouvé</p>`;
                }
                let justificationDepartElement = document.getElementById('modalJustificationDepart');
                if (justificationDepartElement) {
                    justificationDepartElement.innerHTML = response.motifRetardDepart ? `<p style="margin-left:20px; font-size:16px;">${response.motifRetardDepart}</p>` :  `<p style="font-size:16px;">Aucun motif trouvé</p>`;
                }

                let resultatTraiteText = '';
            let badgeClass = '';

            if ( response.resultatTraite === 'Refusé') {
                resultatTraiteText = 'Injustifié';
                badgeClass = 'badge-danger'; // Classe pour le badge 'Injustifié'
            } else if (response.resultatTraite === 'Accepté') {
                resultatTraiteText = 'Justifié';
                badgeClass = 'badge-success'; // Classe pour le badge 'Justifié'
            } else {
                resultatTraiteText = 'Injustifié';
                badgeClass = 'badge-error'; // Classe par défaut si aucune des conditions n'est remplie
            }

            // Affichage dans l'élément HTML avec le badge
            document.getElementById('modalMotifRetard').innerHTML = `<span class="badge ${badgeClass}">${resultatTraiteText}</span>`;
        
                let etatElement = document.getElementById('modalEtat');
                if (etatElement) {
                    let etat = '<span class="badge badge-success">À l\'heure</span>';
                    if (response.absent == 1) {
                        etat = '<span class="badge badge-danger">Absent</span>';
                    } else if (response.retard == 1) {
                        etat = '<span class="badge badge-warning">Retard</span>';
                    }
                    etatElement.innerHTML = etat;
                }
                let etatdepart;
                if (response.absent == 1) {
                    etatdepart = '<span class="badge badge-danger">Absent</span>';
                } else {
                    let difference = calculerDifferenceHeures(response.heureFinJour, response.heureFinPointage);
                    
                    if (difference === "-") {
                        etatdepart = '<span class="badge badge-success">À l\'heure</span>';
                    } else if (difference.startsWith("-")) {
                        etatdepart = '<span class="badge badge-warning">Avant l\'heure</span>';
                    } else if (difference.startsWith("+")) {
                        etatdepart = '<span class="badge badge-primary">Après l\'heure</span>';
                    } else {
                        etatdepart = '-';
                    }
                }
           
                document.getElementById('modalEtatDepart').innerHTML = etatdepart;
                 // Gestion de resultatTraiteDepart
            let resultatTraiteDepartText = '';
            let badgeClassDepart = '';

           if (response.resultatTraiteDepart === 'Refusé'  ){
                resultatTraiteDepartText = 'Injustifié';
                badgeClassDepart = 'badge-danger'; 
            
            } else if (response.resultatTraiteDepart === 'Accepté') {
                resultatTraiteDepartText = 'Justifié';
                badgeClassDepart = 'badge-success';
            } else {
                resultatTraiteDepartText = 'Injustifié';
                badgeClassDepart = 'badge-error';
            }

            document.getElementById('modalMotifRetarddepart').innerHTML = 
                `<span class="badge ${badgeClassDepart}">${resultatTraiteDepartText}</span>`;

            justificationLinkElement = document.getElementById('modalurlJustification');
        let justificationLinks = '-'; // Default value

        if (response.documents && response.documents.length > 0) {
            // Filter documents where isArrive is equal to 1 (for Arrivé)
            const filteredDocs = response.documents.filter(doc => doc.isArrive === 1);

            if (filteredDocs.length > 0) {
                // Map the filtered documents to create HTML links
                justificationLinks = filteredDocs
                    .map(doc => 
                        `<a style="color:#13058f; text-decoration: none; font-size:16px; font-weight:bold; margin-left:20px;" href="${URLROOT}/public/documents/justification/${doc.urlDocument}" target="_blank">${doc.nomDocument}</a>`
                    )
                    .join('<br>'); // Add an HTML line break between the links
            } else {
                // No documents found for isArrive === 1
                justificationLinks = 'Aucun document associé.';
            }
        } else {
            // No documents available in the response
            justificationLinks = 'Aucun document trouvé.';
        }

        // Update the HTML content of the element
        if (justificationLinkElement) {
                        justificationLinkElement.innerHTML = justificationLinks;
            }

            let justificationDepartLinkElement = document.getElementById('modalurlJustificationDepart');
            let justificationDepartLinks = '-'; // Default value

            if (justificationDepartLinkElement) {
                if (response.documents && response.documents.length > 0) {
                    // Filter documents where isArrive is equal to 0 (for Départs)
                    const filteredDocsDepart = response.documents.filter(doc => doc.isArrive === 0);

                    if (filteredDocsDepart.length > 0) {
                        // Map the filtered documents to create HTML links
                        justificationDepartLinks = filteredDocsDepart
                            .map(doc => 
                                `<a style="color:#13058f; text-decoration: none;  font-size:16px; font-weight:bold; margin-left:20px;" href="${URLROOT}/public/documents/justification/${doc.urlDocument}" target="_blank">${doc.nomDocument}</a>`
                            )
                            .join('<br>'); // Add an HTML line break between the links
                    } else {
                        // No documents found for isArrive === 0
                        justificationDepartLinks = 'Aucun document associé.';
                    }
                } else {
                    // No documents available in the response
                    justificationDepartLinks = 'Aucun document trouvé.';
                }

                // Update the HTML content of the element
                justificationDepartLinkElement.innerHTML = justificationDepartLinks;
            }


                $('#detaillePointageModal').modal('show');
            },

            error: function(xhr, status, error) {
                console.error('Erreur lors de la récupération des détails du pointage:', error);
                alert('Une erreur s\'est produite lors de la récupération des détails.');
            }
        });
    }
        
    function convertMinutesToHours(minutes) {
            const sign = minutes < 0 ? '-' : '';
            minutes = Math.abs(minutes);

            const hours = Math.floor(minutes / 60);
            const remainingMinutes = minutes % 60;

            if (hours > 0) {
                return `${sign}${hours} heures ${remainingMinutes} minutes`;
            } else {
                return `${sign}${remainingMinutes} minutes`;
            }
    }
    function calculerDifferenceHeures(heure1, heure2) {
            if (!heure1 || !heure2) return "0 minutes"; // Si l'une des heures est manquante

            // Extraire heures, minutes et secondes pour heure1
            const [heures1, minutes1, secondes1 = 0] = heure1.split(":").map(Number);
            // Extraire heures, minutes et secondes pour heure2
            const [heures2, minutes2, secondes2 = 0] = heure2.split(":").map(Number);

            // Convertir en secondes totales
            const totalSecondes1 = heures1 * 3600 + minutes1 * 60 + secondes1;
            const totalSecondes2 = heures2 * 3600 + minutes2 * 60 + secondes2;

            // Calculer la différence en secondes
            const differenceEnSecondes = totalSecondes1 - totalSecondes2;

            // Si aucune différence
            if (differenceEnSecondes === 0) return "-";

            // Calculer le signe
            const signe = differenceEnSecondes < 0 ? "+" : "-";

            // Obtenir la différence absolue
            const differenceAbsolue = Math.abs(differenceEnSecondes);

            // Convertir en heures et minutes
            const heures = Math.floor(differenceAbsolue / 3600);
            const minutes = Math.floor((differenceAbsolue % 3600) / 60);

            // Retourner la différence formatée avec le signe
            return `${signe}${heures} heures ${minutes} minutes`;
    }

    function convertToWebUrl(filePath) {
            
            return filePath.replace('C:/xampp1/htdocs', URLROOT)
                        .replace(/\\/g, '/')  
                        .replace(/\s+/g, '%20'); 
    }
        function formatDate(dateString) {
            if (!dateString) return '-';
            
            const date = new Date(dateString);

            if (isNaN(date.getTime())) {
                return '-'; 
            }

            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = String(date.getFullYear()).slice(2); 
            return `${day}/${month}/${year}`;
        }

        function closeModal() {
        $('#errorOperation').modal('hide');
    }
  
    function dateCreationSelect(val){
        if(val == 2){
            $('#datepair').show();
            $('#datepairOne').hide();
        } else if(val == 1){
            $('#datepairOne').show();
            $('#datepair').hide();
        } else {
            $('#datepair').hide();
            $('#datepairOne').hide();
        }
    }

    $(document).ready(function () {
        var dateCreation = $('#periode').val();
        dateCreationSelect(dateCreation);
    
        $('.date').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            endDate: '<?= date('d-m-Y')?>',
            weekStart: 1
        });

        $('.time').timepicker({
            showDuration: true,
            timeFormat: 'H:i',
            step: 1
        });
     
    });
    
    $(document).ready(function() {
        $('#detaillePointageModal').on('hidden.bs.modal', function () {
          
            $(this).find('span').html(''); 
        });

        $('.btn-secondary').click(function() {
            $('#detaillePointageModal').modal('hide');
        });
    }); 
    $('.btn-danger').on('click', function() {
     $('#detaillePointageModal').modal('hide');
    });
   
   
    $('.close').on('click', function() {
        $('#detaillePointageModal').modal('hide');
    });
    
    document.addEventListener('DOMContentLoaded', function () {
        const filterForm = document.getElementById('filterForm');
        const filterButton = document.getElementById('filterButton');

        const savedFilters = JSON.parse(localStorage.getItem('filterCriteria'));
        if (savedFilters) {
            for (const key in savedFilters) {
                const element = document.querySelector(`[name=${key}]`);
                if (element) {
                    element.value = savedFilters[key];
                }
            }
            applyFilters(savedFilters); 
        }

        filterButton.addEventListener('click', function (e) {
            e.preventDefault(); 

            const formData = new FormData(filterForm);
            formData.append('userid', userId); 

            const filterCriteria = {};
            for (const [key, value] of formData.entries()) {
                if (key !== 'userid') {
                    filterCriteria[key] = value;
                }
            }

            localStorage.setItem('filterCriteria', JSON.stringify(filterCriteria));

            applyFilters(filterCriteria);
        });

        function applyFilters(filterCriteria) {
            const formData = new FormData();
            for (const key in filterCriteria) {
                formData.append(key, filterCriteria[key]);
            }
            formData.append('userid', userId);
            const tableBody = document.querySelector('#dataTable16 tbody');
            fetch(`${URLROOT}/public/json/pointage.php?action=filterPointagesAdmin`, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (Array.isArray(data)) {
                    updateTable(data);
                } else {
                    console.error('Invalid data format:', data);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function updateTable(data) {
            const table = $('#dataTable16').DataTable();
            table.clear().destroy();

            const tableBody = document.querySelector('#dataTable16 tbody');
            tableBody.innerHTML = '';

            data.forEach((item, index) => {
                let etat;
                if (item.absent == 1) {
                    etat = '<span class="badge badge-danger">Absent</span>';
                } else if (item.retard == 1) {
                    etat = '<span class="badge badge-warning">Retard</span>';
                } else {
                    etat = '<span class="badge badge-success">À l\'heure</span>';
                }
                let etatdepart;
                if (item.absent == 1) {
                    etatdepart = '<span class="badge badge-danger">Absent</span>';
                } else {
                    let difference = calculerDifferenceHeures(item.heureFinJour, item.heureFinPointage);
                    
                    if (difference === "-") {
                        etatdepart = '<span class="badge badge-success">À l\'heure</span>';
                    } else if (difference.startsWith("-")) {
                        etatdepart = '<span class="badge badge-warning">Avant l\'heure</span>';
                    } else if (difference.startsWith("+")) {
                        etatdepart = '<span class="badge badge-primary">Après l\'heure</span>';
                    } else {
                        etatdepart = '-';
                    }
                }
                const newRow = document.createElement('tr');
                newRow.setAttribute('data-id', item.idPointage);

                newRow.innerHTML = `
                    <td>${index + 1}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-icon" onclick="showPointageDetails(${item.idPointage})" style="background: #e74c3c; color:white">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                    <td>${formatDate(item.datePointage)}</td>
                    <td>${item.fullName || '-'}</td>
                    <td>${item.matricule || '-'}</td>
                    <td>${item.heureDebutJour ? item.heureDebutJour : '-'}</td>
                    <td>${item.heureFinJour ? item.heureFinJour : '-'}</td>
                    <td>${item.heureDebutPointage || '-'}</td>
                    <td>${item.heureFinPointage? item.heureFinPointage : '-'}</td>
                    <td>${etat}</td>
                    <td>${etatdepart}</td>
                    <td>${convertMinutesToHours(item.nbMinuteRetard) === '0 minutes' ? '-' : convertMinutesToHours(item.nbMinuteRetard)}</td>
                    <td>${calculerDifferenceHeures(item.heureFinJour,item.heureFinPointage) }</td>
                    <td>${item.absent === 0 && item.retard === 0 ? '-' : item.motifRetard ? 'oui' : 'non' }</td>
                    <td>${item.absent === 1 || calculerDifferenceHeures(item.heureFinJour,item.heureFinPointage) === "-" ? '-' : item.motifRetardDepart ? 'oui' : 'non' }</td>
                    <td>${
                        item.absent === 0 && item.retard === 0
                            ? '-' // Aucun retard ou absence
                            : item.resultatTraite === 'Accepté'
                                ? '<span class="badge badge-success">Justifié</span>'
                                : item.resultatTraite === 'Refusé'
                                    ? '<span class="badge badge-danger">Injustifié</span>'
                                    : '<span class="badge badge-error">Injustifié</span>'
                    }</td>
                    <td>${
                        item.absent === 1 || calculerDifferenceHeures(item.heureFinJour, item.heureFinPointage) === '-'
                            ? '-' // Absent ou à l'heure
                            : item.resultatTraiteDepart === 'Accepté'
                                ? '<span class="badge badge-success">Justifié</span>'
                                : item.resultatTraiteDepart === 'Refusé'
                                    ? '<span class="badge badge-danger">Injustifié</span>'
                                    : '<span class="badge badge-error">Injustifié</span>'
                    }</td>
                `;

                tableBody.appendChild(newRow);
            });

            $('#dataTable16').DataTable({
                colReorder: true,
                oLanguage: {
                    sZeroRecords: "Aucune donnée !",
                    sProcessing: "En cours...",
                    sLengthMenu: "Nombre d'éléments _MENU_ ",
                    sInfo: "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
                    sInfoEmpty: "Affichage de 0 à 0 sur 0 entrée",
                    sInfoFiltered: "(filtré à partir de _MAX_ total entrées)",
                    sSearch: "Recherche:",
                },
                language: {
                    paginate: {
                        previous: "<<",
                        next: ">>"
                    }
                },
                pageLength: 10
            });
        }
    });


    document.addEventListener('DOMContentLoaded', function () {
        const periodeSelect = document.querySelector('select[name="periode1"]');
        const datepair = document.getElementById('datepair1');

      
        function handleDateDisplay() {
            if (periodeSelect.value === 'custom') {
                datepair.style.display = 'block'; 
            } else {
                datepair.style.display = 'none'; 
            }
        }

        handleDateDisplay();

        
        periodeSelect.addEventListener('change', handleDateDisplay);
    });
    document.addEventListener('DOMContentLoaded', function () {

        const totalRetardCurrentHours = <?= $totalRetardCurrent ?> / 60;
        const totalRetardPreviousHours = <?= $totalRetardPrevious ?> / 60;
        const totalAbsenceCurrentHours = <?= $totalAbsenceCurrent ?> * 24; 
        const totalAbsencePreviousHours = <?= $totalAbsencePrevious ?> * 24;

        console.log("Total absence : ", totalAbsenceCurrentHours);

        const retardData = {
            labels: ['Retards Période Actuelle', 'Retards Période Précédente'],
            datasets: [{
                data: [totalRetardCurrentHours, totalRetardPreviousHours],
                backgroundColor: ['#c00000', '#D3D3D3']
            }]
        };

        const absenceData = {
            labels: ['Absences Période Actuelle', 'Absences Période Précédente'],
            datasets: [{
                data: [totalAbsenceCurrentHours, totalAbsencePreviousHours],
                backgroundColor: ['#c00000', '#D3D3D3']
            }]
        };

        const displayRetardChart = totalRetardCurrentHours !== 0 || totalRetardPreviousHours !== 0;
        const displayAbsenceChart = totalAbsenceCurrentHours !== 0 || totalAbsencePreviousHours !== 0;

        if (displayRetardChart) {
            const retardCtx = document.getElementById('retardPieChart').getContext('2d');
            new Chart(retardCtx, {
                type: 'pie',
                data: retardData,
                options: {
                    responsive: true,
                    title: { // Configuration pour le titre dans Chart.js 2.9.4
                        display: true,
                        text: 'Comparaison des Retards (heures)', // Titre du graphique
                        fontSize: 16, // Taille de la police
                        fontColor: '#333' // Couleur de la police
                    },
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                }
            });
        }

        if (displayAbsenceChart) {
            const absenceCtx = document.getElementById('absencePieChart').getContext('2d');
            new Chart(absenceCtx, {
                type: 'pie',
                data: absenceData,
                options: {
                    responsive: true,
                    title: { // Configuration pour le titre dans Chart.js 2.9.4
                        display: true,
                        text: 'Comparaison des Absences (heures)', // Titre du graphique
                        fontSize: 16, // Taille de la police
                        fontColor: '#333' // Couleur de la police
                    },
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                }
            });
        }
    });

 
    function clearLocalStorageAndGoBack() {
    
        localStorage.clear();
        
    history.back(); 
    }
    function fetchNotifications(idUtilisateur, is_read = null) {
        // Build the URL dynamically based on `is_read` filter
        let url = `${URLROOT}/public/json/pointage.php?action=getNotifications&idUtilisateur=${idUtilisateur}`;
        if (is_read !== null) {
            url += `&is_read=${is_read}`;
        }

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    populateNotificationModal(data.notifications);
                } else {
                    console.error(data.message || "Error fetching notifications.");
                }
            })
            .catch(error => console.error('Error:', error));
    }
    
   
    function populateNotificationModal(notifications) {
        const notificationList = document.querySelector('.notification-list');
        notificationList.innerHTML = ''; // Clear existing content

        if (notifications.length === 0) {
            notificationList.innerHTML = '<p class="text-center">No notifications available.</p>';
            return;
        }

        notifications.forEach(notification => {
            const notificationItem = document.createElement('div');
            notificationItem.classList.add('notification-item', 'mb-3', 'p-3', 'border', 'rounded');
            
            notificationItem.innerHTML = `
                <p><i class="fas fa-info-circle"></i> <strong>Title:</strong> ${notification.title}</p>
                <p><i class="fas fa-calendar-alt"></i> <strong>Date:</strong> ${new Date(notification.created_at).toLocaleDateString()}</p>
                <p><i class="fas fa-comment"></i> <strong>Description:</strong> ${notification.message}</p>
            `;
            notificationList.appendChild(notificationItem);
        });
    }

 
    document.getElementById('notificationButton').addEventListener('click', () => {
      
        fetchNotifications(userId);
    });

</script>
