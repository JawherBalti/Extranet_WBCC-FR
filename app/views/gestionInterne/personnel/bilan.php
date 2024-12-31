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

$contactListe = $role == 1 || $role == 2 ? $contacts : (array) $contactById;

$idRole = $_SESSION["connectedUser"]->role;
$viewAdmin = (($idRole == "1" || $idRole == "2" || $idRole == "8" || $idRole == "9" ||  $_SESSION["connectedUser"]->isAccessAllOP == "1")) ? "" : "hidden";
$viewAdmin2 = (($idRole == "1" || $idRole == "2" || $idRole == "8" || $idRole == "9" || $idRole == 25 ||  $_SESSION["connectedUser"]->isAccessAllOP == "1")) ? "" : "hidden";

?>




<div class="section-title mb-0 d-flex justify-content-between align-items-center">
    <h2 class="mb-0">
        <button
            onclick="clearLocalStorageAndGoBack()">
            <i class="fas fa-fw fa-arrow-left" style="color: #c00000"></i>
        </button>
        <span>
            &nbsp;&nbsp;
            <i class="fas fa-fw fa-calendar-alt" style="color: #c00000"></i>
            Bilan Comparatif
        </span>
        <!-- <button id="notificationButton" style="background: none; border: none; margin-left: 700px;" data-toggle="modal" data-target="#notificationModal">
            <i class="fas fa-fw fa-bell" style="color: #c00000;"></i>
        </button> -->
    </h2>
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
                style="box-shadow: none !important;">
                <div class="accordion-body" style="box-shadow: none !important;">
                    <form method="POST" id="filterForm" action="" style="border: none; margin: 0 !important; padding: 0 !important;margin: auto;">
                        <div class="row" style="width: 100%; margin: auto;">
                            <div class="<?= $viewAdmin != "" ? $viewAdmin : 'col-md-6 col-xs-12 mb-3' ?>">
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
                                        <input name="dateDebut1" id="dateDebut1" readonly style="border: 1px solid black;" type="text" class="this-form-control col-xs-12 col-md-12 date start" value="<?= isset($_POST['dateDebut1']) ? $_POST['dateDebut1'] : ''; ?>" placeholder="Choisir..." />

                                        <label for="defaultFormControlInput" class="form-label">Fin période 1:</label>
                                        <input name="dateFin1" id="dateFin1" style="border: 1px solid black;" type="text" class="this-form-control col-xs-12 col-md-12 date end" value="<?= isset($_POST['dateFin1']) ? $_POST['dateFin1'] : ''; ?>" placeholder="Choisir..." />

                                        <br><br>
                                        <label for="defaultFormControlInput" class="form-label">Début période 2:</label>
                                        <br>
                                        <input name="dateDebut2" id="dateDebut2" readonly style="border: 1px solid black;" type="text" class="this-form-control col-xs-12 col-md-12 date start" value="<?= isset($_POST['dateDebut2']) ? $_POST['dateDebut2'] : ''; ?>" placeholder="Choisir..." />

                                        <label for="defaultFormControlInput" class="form-label">Fin période 2:</label>
                                        <input name="dateFin2" id="dateFin2" style="border: 1px solid black;" type="text" class="this-form-control col-xs-12 col-md-12 date end" value="<?= isset($_POST['dateFin2']) ? $_POST['dateFin2'] : ''; ?>" placeholder="Choisir..." />
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
                <table id="dataTable18" class="simple-table" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class=<?= $viewAdmin ?>>L'employé</th>
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
                                        $viewAdmin == "" ? $employe->fullName : $user->fullName,
                                        $startDate,
                                        $endDate,
                                        $pointages,
                                        $retardTotalEmploye,
                                        $absenceTotalEmploye
                                    );

                                    filterPointagesByEmployeAndPeriod(
                                        $viewAdmin == "" ? $employe->fullName : $user->fullName,
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
                                        <td rowspan="2" class="<?= $viewAdmin ?>"><?= htmlspecialchars($viewAdmin == "" ? $employe->fullName : $user->fullName) ?></td>
                                        <td><?= formatPeriod($startDate, $endDate, $selectedPeriod) ?></td>
                                        <td><?= convertMinutesToHours($retardTotalEmploye) ?></td>
                                        <td rowspan="2"><?= ($ecartRetardEmploye > 0 ? '+' : '') . convertMinutesToHours($ecartRetardEmploye) ?></td>

                                        <td><?= $absenceTotalEmploye ?> jours</td>
                                        <td rowspan="2"><?= ($ecartAbsenceEmploye > 0 ? '+' : '') . $ecartAbsenceEmploye ?> jours</td>
                                    </tr>
                                    <tr>
                                    <th class="hidden" rowspan="2"><?= $index ?></th>
                                        <td class="hidden" rowspan="2" class="<?= $viewAdmin ?>"><?= htmlspecialchars($viewAdmin == "" ? $employe->fullName : $user->fullName) ?></td>
                                        <td><?= formatPeriod($previousStartDate, $previousEndDate, $selectedPeriod, true) ?></td>
                                        <td><?= convertMinutesToHours($retardTotalPrevEmploye) ?></td>
                                        <td class="hidden" rowspan="2"><?= ($ecartRetardEmploye > 0 ? '+' : '') . convertMinutesToHours($ecartRetardEmploye) ?></td>
                                        <td><?= $absenceTotalPrevEmploye ?> jours</td>
                                        <td class="hidden" rowspan="2"><?= ($ecartAbsenceEmploye > 0 ? '+' : '') . $ecartAbsenceEmploye ?> jours</td>
                                    </tr>

                                    <!-- <tr>
                                        <td rowspan="2"><?= $index ?></td>
                                        <td rowspan="2" class="<?= $viewAdmin ?>"><?= htmlspecialchars($viewAdmin == "" ? $employe->fullName : $user->fullName) ?></td>
                                        <td><?= formatPeriod($startDate, $endDate, $selectedPeriod) ?></td>
                                        <td><?= convertMinutesToHours($retardTotalEmploye) ?></td>
                                        <td rowspan="2"><?= ($ecartRetardEmploye > 0 ? '+' : '') . convertMinutesToHours($ecartRetardEmploye) ?></td>
                                        <td><?= $absenceTotalEmploye ?> jours</td>
                                        <td rowspan="2"><?= ($ecartAbsenceEmploye > 0 ? '+' : '') . $ecartAbsenceEmploye ?> jours</td>
                                    </tr>
                                    <tr>
                                        <td><?= ($index - 3) % 5 === 0 ? '-' : $index ?></td>
                                        <td><?= ($index - 3) % 5 === 0 ? '-' : htmlspecialchars($viewAdmin == "" ? $employe->fullName : $user->fullName) ?></td>
                                        <td><?= formatPeriod($previousStartDate, $previousEndDate, $selectedPeriod, true) ?></td>
                                        <td><?= convertMinutesToHours($retardTotalPrevEmploye) ?></td>
                                        <td><?= ($index - 3) % 5 === 0 ? '-' : ($ecartRetardEmploye > 0 ? '+' : '') . convertMinutesToHours($ecartRetardEmploye) ?></td>
                                        <td><?= $absenceTotalPrevEmploye ?> jours</td>
                                        <td><?= ($index - 3) % 5 === 0 ? '-' : ($ecartAbsenceEmploye > 0 ? '+' : '') . $ecartAbsenceEmploye ?> jours</td>
                                    </tr> -->


                                     <!-- <tr>
                                        <td rowspan=<?=($index - 3) % 5 === 0 ? "1" : "2"?>><?= $index ?></td>
                                        <td rowspan=<?=($index - 3) % 5 === 0 ? "1" : "2"?> class="<?= $viewAdmin ?>"><?= htmlspecialchars($viewAdmin == "" ? $employe->fullName : $user->fullName) ?></td>
                                        <td><?= formatPeriod($startDate, $endDate, $selectedPeriod) ?></td>
                                        <td><?= convertMinutesToHours($retardTotalEmploye) ?></td>
                                        <td rowspan=<?=($index - 3) % 5 === 0 ? "1" : "2"?>><?= ($ecartRetardEmploye > 0 ? '+' : '') . convertMinutesToHours($ecartRetardEmploye) ?></td>
                                        <td><?= $absenceTotalEmploye ?> jours</td>
                                        <td rowspan=<?=($index - 3) % 5 === 0 ? "1" : "2"?>><?= ($ecartAbsenceEmploye > 0 ? '+' : '') . $ecartAbsenceEmploye ?> jours</td>
                                    </tr>
                                    <tr>
                                        <td class="<?=($index - 3)%5=== 0 ? '' : 'hidden'?>"><?= $index ?></td>
                                        <td class="<?=($index - 3)%5=== 0 ? '' : 'hidden'?>"><?= ($index - 3)%5=== 0 ? '-' : htmlspecialchars($viewAdmin == "" ? $employe->fullName : $user->fullName) ?></td>
                                        <td><?= formatPeriod($previousStartDate, $previousEndDate, $selectedPeriod, true) ?></td>
                                        <td><?= convertMinutesToHours($retardTotalPrevEmploye) ?></td>
                                        <td class="<?=($index - 3)%5=== 0 ? '' : 'hidden'?>"><?= ($index - 3)%5=== 0 ? '-' : ($ecartRetardEmploye > 0 ? '+' : '') . convertMinutesToHours($ecartRetardEmploye) ?></td>
                                        <td><?= $absenceTotalPrevEmploye ?> jours</td>
                                        <td class="<?=($index - 3)%5=== 0 ? '' : 'hidden'?>"><?= ($index - 3)%5=== 0 ? '-' : ($ecartAbsenceEmploye > 0 ? '+' : '') . $ecartAbsenceEmploye ?> jours</td>
                                    </tr> -->
                        <?php
                                    $index++;

                                    // Stocker les données pour le graphique
                                    $labels[] = htmlspecialchars($viewAdmin == "" ? $employe->fullName : $user->fullName);
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

        <script src="<?= URLROOT ?>/assets/ticket/vendor/libs/jquery/jquery.js"></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->

        <script>
            // const URLROOT = '<?= URLROOT; ?>';

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

            function dateCreationSelect(val) {
                if (val == 2) {
                    $('#datepair').show();
                    $('#datepairOne').hide();
                } else if (val == 1) {
                    $('#datepairOne').show();
                    $('#datepair').hide();
                } else {
                    $('#datepair').hide();
                    $('#datepairOne').hide();
                }
            }

            $(document).ready(function() {
                var dateCreation = $('#periode').val();
                dateCreationSelect(dateCreation);

                $('.date').datepicker({
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                    endDate: '<?= date('d-m-Y') ?>',
                    weekStart: 1
                });

                $('.time').timepicker({
                    showDuration: true,
                    timeFormat: 'H:i',
                    step: 1
                });

            });


            document.addEventListener('DOMContentLoaded', function() {
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

                // filterButton.addEventListener('click', function (e) {
                //     e.preventDefault(); 

                //     const formData = new FormData(filterForm);
                //     formData.append('userid', userId); 

                //     const filterCriteria = {};
                //     for (const [key, value] of formData.entries()) {
                //         if (key !== 'userid') {
                //             filterCriteria[key] = value;
                //         }
                //     }

                //     localStorage.setItem('filterCriteria', JSON.stringify(filterCriteria));

                //     applyFilters(filterCriteria);
                // });

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


            document.addEventListener('DOMContentLoaded', function() {
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

            document.addEventListener('DOMContentLoaded', function() {

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
        </script>