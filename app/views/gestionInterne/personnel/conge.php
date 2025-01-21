<?php
$idRole = $_SESSION["connectedUser"]->role;
$viewAdmin = (($idRole == "1" || $idRole == "2" || $idRole == "8" || $idRole == "9" || $_SESSION["connectedUser"]->isAccessAllOP == "1")) ? "" : "hidden";
$viewAdmin2 = (($idRole == "1" || $idRole == "2" || $idRole == "8" || $idRole == "9" || $idRole == 25 || $_SESSION["connectedUser"]->isAccessAllOP == "1")) ? "" : "hidden";
// $pointageListe = $idRole == 1 || $idRole == 2 || $idRole == 25 ? $pointages : $pointagesById;

function formatDate($date)
{
    if (!empty($date)) {
        $dateObj = new DateTime($date);
        return $dateObj->format('d/m/Y');
    }
    return '-'; // Retourne un tiret si la date est vide ou nulle
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" type="text/css"
    href="<?= URLROOT ?>/assets/ticket/vendor/libs/datepicker/jquery.timepicker.css" />
<link rel="stylesheet" type="text/css"
    href="<?= URLROOT ?>/assets/ticket/vendor/libs/datepicker/documentation-assets/bootstrap-datepicker.css" />
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?= URLROOT ?>/assets/ticket/css/tenue-reunion.css" />

<div class="section-title mb-0">
    <h2 class="mb-0">
        <button onclick="history.back()">
            <i class="fas fa-fw fa-arrow-left" style="color: #c00000">
            </i>
        </button>
        <span>
            &nbsp;&nbsp;
            <i class="fas fa-fw fa-file" style="color: #c00000"></i>
            mes congés
        </span>
    </h2>
</div>

<div class=" mt-3" id="accordionFiltrea">
    <div class="table-responsive">
        <div class="card accordion-item" style="broder-radius: none !important; box-shadow: none !important;">
            <div id="bloc1" class="accordion-collapse collapse show" data-bs-parent="#accordionFiltrea"
                style="box-shadow: none !important;">
                <div class="accordion-body" style="box-shadow: none !important;">
                    <form method="GET" id="filterForm" action="<?= linkTo('GestionInterne', 'gererConges') ?>"
                        style="border: none; margin: 0px !important; padding: 0px !important; margin: auto;">
                        <div class="row" style="width: 100%;  margin: auto;">
                            <div class="<?= $viewAdmin2 != "" ? $viewAdmin2 : "col-md-2 col-xs-12 mb-3" ?>">
                                <fieldset class="py-4">
                                    <legend
                                        class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                                        &nbsp;Employé
                                    </legend>
                                    <div class="card ">
                                        <select id="idUtilisateur" name="idUtilisateur" class="form-control">
                                            <option value="">Tout</option>
                                            <?php
                                            foreach ($contacts as $contact) {
                                                ?>
                                                <option value="<?= $contact->idContact ?>">
                                                    <?= $contact->fullName ?>
                                                </option>
                                                <?php
                                            } ?>
                                        </select>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="<?= $viewAdmin2 != "" ? $viewAdmin2 : "col-md-2 col-xs-12" ?>">
                                <fieldset class="py-4">
                                    <legend
                                        class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                                        &nbsp;Site
                                    </legend>
                                    <select id="site" name="idSite" class="form-control">
                                        <option value="">Tout</option>
                                        <?php
                                        foreach ($sites as $sit) {
                                            if ((($idRole == "1" || $idRole == "2" || $idRole == "9" || $idRole == "8" || $_SESSION["connectedUser"]->isAccessAllOP == "1") || (($idRole == "3" || $idRole == "25") && $_SESSION["connectedUser"]->nomSite == $sit->nomSite))) {
                                                ?>
                                                <option value="<?= $sit->idSite ?>">
                                                    <?= $sit->nomSite ?>
                                                </option>
                                                <?php
                                            }
                                        } ?>
                                    </select>
                                </fieldset>
                            </div>

                            <div
                                class="<?= $viewAdmin2 != "" ? "col-md-4 col-xs-12 mb-3" : "col-md-2 col-xs-12 mb-3" ?>">
                                <fieldset class="py-4">
                                    <legend
                                        class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                                        &nbsp;Type de congé
                                    </legend>
                                    <div class="card ">
                                        <select id="typeConge" name="typeConge" class="form-control">
                                            <option value="">Tout</option>
                                            <?php
                                            foreach ($typesConge as $type) {
                                                ?>
                                                <option value="<?= $type->idTypeConge ?>">
                                                    <?= $type->type ?>
                                                </option>
                                                <?php
                                            } ?>
                                        </select>
                                    </div>
                                </fieldset>
                            </div>

                            <div
                                class="<?= $viewAdmin2 != "" ? "col-md-4 col-xs-12 mb-3" : "col-md-2 col-xs-12 mb-3" ?>">
                                <fieldset class="py-4">
                                    <legend
                                        class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                                        Statut
                                    </legend>
                                    <div class="card ">
                                        <select id="statut" name="statut" class="form-control">
                                            <option <?= $statut == "" ? 'selected' : '' ?> value="">Tout</option>
                                            <option <?= $statut == "1" ? 'selected' : '' ?> value="1">Approuvé</option>
                                            <option <?= $statut == "2" ? 'selected' : '' ?> value="2">Rejeté</option>
                                            <option <?= $statut == "0" ? 'selected' : '' ?> value="0">En attente</option>
                                        </select>
                                    </div>
                                </fieldset>
                            </div>

                            <div
                                class="<?= $viewAdmin2 != "" ? "col-md-4 col-xs-12 mb-3" : "col-md-2 col-xs-12 mb-3" ?>">
                                <fieldset class="py-4">
                                    <legend
                                        class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                                        &nbsp;Date de demande
                                    </legend>
                                    <div class="card ">
                                        <Select name="periode" id="dateDemande" class="form-control"
                                            onchange="dateCreationSelect(this.value)">
                                            <option value="">Tout</option>
                                            <option value="today">Aujourd'hui</option>
                                            <option value="1">A la date du</option>
                                            <option value="2">Personnaliser</option>
                                            <!-- <option <?= (isset($_GET['periode']) && $_GET['periode'] == '') ? 'Selected' : ''; ?> value="">Tout</option>
                                            <option <?= (isset($_GET['periode']) && $_GET['periode'] == '0') ? 'Selected' : ''; ?> value="today">Aujourd'hui</option>
                                            <option <?= (isset($_GET['periode']) && $_GET['periode'] == '1') ? 'Selected' : ''; ?> value="1">A la date du</option>
                                            <option <?= (isset($_GET['periode']) && $_GET['periode'] == '2') ? 'Selected' : ''; ?> value="2">Personnaliser</option> -->
                                        </Select>
                                    </div>
                                    <p id="datepairOne" style="display: none;">
                                        <label for="defaultFormControlInput" class="form-label">Date:</label>
                                        <br>
                                        <input name="dateOne" id="dateOne" readonly style="border: 1px solid black;"
                                            type="text" class="this-form-control col-xs-12 col-md-12 date start "
                                            value="<?= (isset($_GET['dateOne'])) ? $_GET['dateOne'] : ''; ?>"
                                            placeholder="Choisir..." />
                                    </p>
                                    <p id="datepair" style="display: none;">
                                        <label for="defaultFormControlInput" class="form-label">Début:</label>
                                        <br>
                                        <input name="dateDebut" id="dateDebut" readonly style="border: 1px solid black;"
                                            type="text" class="this-form-control col-xs-12 col-md-12 date start "
                                            value="<?= (isset($_GET['dateDebut'])) ? $_GET['dateDebut'] : ''; ?>"
                                            placeholder="Choisir..." />
                                        <br><br>
                                        <label for="defaultFormControlInput" class="form-label">Fin:</label>
                                        <br>
                                        <input name="dateFin" id="dateFin" readonly style="border: 1px solid black;"
                                            type="text" class="this-form-control col-xs-12 col-md-12 date end "
                                            value="<?= (isset($_GET['dateFin'])) ? $_GET['dateFin'] : ''; ?>"
                                            placeholder="Choisir..." />
                                    </p>
                                </fieldset>
                            </div>
                            <div class="col-md-4 offset-4 col-xs-12">
                                <br>
                                <button type="submit" id="filterButton" class="btn btn-primary form-control"
                                    style="margin-top: 20px; border-radius: 0px; background: #c00000; ">FILTRER</button>
                                <br><br>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailCongeModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content shadow-lg rounded">

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title font-weight-bold text-uppercase" id="modalLabel">Détails du Congé</h5>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body px-4 py-4">
                    <div class="row">

                        <div class="col-md-6">
                            <p><i class="fas fa-user"></i> <strong>L'employé:</strong> <span id="modalemploye"></span>
                            </p>
                            <p><i class="fas fa-id-badge"></i> <strong>Matricule:</strong> <span
                                    id="modalmatricule"></span></p>
                            <p><i class="fas fa-building"></i> <strong>Site:</strong> <span id="modalsite"></span></p>
                            <p><i class="fas fa-exclamation-circle"></i> <strong>Type:</strong> <span id="modaltype"></span></p>

                            <p><i class="fas fa-calendar-alt"></i><strong>Nombre de jours:</strong> <span
                                    id="modaljours"></span></p>
                            <p><i class="fas fa-exclamation-circle"></i> <strong>Statut:</strong> <span
                                    id="modalEtat"></span></p>
                        </div>

                        <div class="col-md-6">
                            <p><i class="fas fa-calendar-alt"></i> <strong>Date de début souhaitée:</strong> <span
                                    id="modalDebutSouhaite"></span></p>
                            <p><i class="fas fa-calendar-alt"></i> <strong>Date de fin souhaitée:</strong> <span
                                    id="modalFinSouhaite"></span></p>
                            <p><i class="fas fa-calendar-alt"></i> <strong>Date de début proposée:</strong> <span
                                    id="modalDebutPropose"></span></p>
                            <p><i class="fas fa-calendar-alt"></i> <strong>Date de fin proposée:</strong> <span
                                    id="modalFinPropose"></span></p>
                            <p><i class="fas fa-calendar-alt"></i> <strong>Date de début du congé:</strong> <span
                                    id="modalDebut"></span></p>
                            <p><i class="fas fa-calendar-alt"></i> <strong>Date de fin du congé:</strong> <span
                                    id="modalFin"></span></p>
                        </div>
                    </div>
                    <hr>

                    <span class="justif-arrivee-text"></span>
                    <div class="arrivee-section">
                        <p>
                            <i class="fas fa-comment"></i>
                            <strong>Proposer une date:</strong> 
                            <span id="modalMotifRetard"></span>
                        </p>


                        <div class="scrollable-container mb-3">
                            <span id="modalurlJustification"></span>
                        </div>
                        <p><i class="fas fa-comment"></i> <strong>Motif d'arrivée:</strong></p>
                        <input class=" <?= $viewAdmin2 == "" ? "d-none" : "" ?>" type="text" name="motif"
                            id="motif-arrivee" required placeholder="Ajouter un motif">
                        <span id="motifArriveeErreur" class="text-danger">Veuillez entrer le motif</span>
                        <div id="modalJustification" class="motif-container"></div>

                        <div class="mt-0">
                            <div class="<?= $viewAdmin != '' ? $viewAdmin : 'form-group confirm-justif-arrivee' ?>">
                                <label for="confirmation" class="font-weight-bold">Êtes-vous sûr de vouloir valider la
                                    justification d'arrivée ?</label><br>

                                <div class="row">
                                    <div class="form-check d-inline-block  ml-3">
                                        <input type="radio" class="form-check-input" id="confirmOui" name="confirmation"
                                            value="oui">
                                        <label class="form-check-label font-weight-bold" for="confirmOui">Oui</label>
                                    </div>

                                    <div class="form-check d-inline-block ml-3">
                                        <input type="radio" class="form-check-input" id="confirmNon" name="confirmation"
                                            value="non">
                                        <label class="form-check-label font-weight-bold" for="confirmNon">Non</label>
                                    </div>


                                </div>
                                <input type="hidden" id="modalpointage_id">
                                <input type="hidden" id="modalidUserF">
                                <input type="hidden" id="modalemailuser">

                                <div class="modal-footer">
                                    <button class="btn btn-success" type="button"
                                        id="confirmJustificationArriveeSubmit">Confirmer</button>
                                    <button class="btn btn-danger" type="button" data-dismiss="modal">Annuler</button>
                                </div>
                            </div>
                            <div class="hidden confirm-justif-arrivee-msg"></div>
                        </div>
                    </div>



                    <hr id="justif-depart-hr">
                    <span class="justif-depart-text"></span>

                    <div class="depart-section">
                        <p><i class="fas fa-comment"></i> <strong>État du départ:</strong> <span
                                id="modalMotifRetarddepart"></span></p>
                        <p> <i class="fas fa-link"></i>
                            <strong id="modalpiecsejustification">Pièces justificatives du départ:</strong>
                        <div id="piece-depart-form" class="<?= $viewAdmin2 == "" ? "d-none" : "" ?>">
                            <p>
                                <strong>Ajouter une pièce justificative</strong>
                            </p>

                            <form method="post" action="" id="justificationFormDepart" enctype="multipart/form-data">
                                <div class="d-flex flex-column">
                                    <input type="hidden" id="pointage_id" name="pointage_id">
                                    <div class="d-flex flex-column w-50">
                                        <label for="nomDocument">Nom du document</label>
                                        <input type="text" id="nomDocumentDepart" name="nomDocument"
                                            placeholder="nom document">
                                    </div>
                                    <div class="d-flex flex-column w-50">
                                        <label for="commentaire">Commentaire</label>
                                        <input type="text" id="commentaireDepart" name="commentaire"
                                            placeholder="commentaire">
                                    </div>
                                    <div class="d-flex flex-column w-50">
                                        <label for="commentaire">Selectionner un fichier</label>
                                        <input type="file" name="attachments[]" id="attachments" multiple>
                                    </div>
                                    <button class="emp-btn btn btn-red btn-round mt-2 w-25" type="submit"
                                        name="submit">Ajouter</button>
                                </div>
                            </form>

                        </div>
                        </p>
                        <div class="scrollable-container mb-3">

                            <span id="modalurlJustificationDepart"></span>
                        </div>
                        <p><i class="fas fa-comment"></i> <strong>Motif du départ:</strong></p>
                        <input class="<?= $viewAdmin2 == "" ? "d-none" : "" ?>" type="text" name="motif" id="motif-depart"
                            required placeholder="Ajouter un motif">
                        <span id="motifDepartErreur" class="text-danger">Veuillez entrer le motif</span>
                        <div id="modalJustificationDepart" class="motif-container"></div>
                        <div class="mt-0">
                            <div class="<?= $viewAdmin != '' ? $viewAdmin : 'form-group confirm-justif-depart' ?>">
                                <label for="confirmationDepart" class="font-weight-bold">Êtes-vous sûr de vouloir
                                    valider la justification du départ?</label><br>

                                <div class="row">
                                    <div class="form-check d-inline-block ml-3">
                                        <input type="radio" class="form-check-input" id="confirmDepartOui"
                                            name="confirmationDepart" value="oui">
                                        <label class="form-check-label font-weight-bold"
                                            for="confirmDepartOui">Oui</label>
                                    </div>

                                    <div class="form-check d-inline-block ml-3">
                                        <input type="radio" class="form-check-input" id="confirmDepartNon"
                                            name="confirmationDepart" value="non">
                                        <label class="form-check-label font-weight-bold"
                                            for="confirmDepartNon">Non</label>
                                    </div>

                                </div>
                                <input type="hidden" id="modalpointage_id">
                                <input type="hidden" id="modalidUserF">
                                <input type="hidden" id="modalemailuser">

                                <div class="modal-footer">
                                    <button class="btn btn-success" type="button"
                                        id="confirmJustificationDepartSubmit">Confirmer</button>
                                    <button class="btn btn-danger" type="button" data-dismiss="modal">Annuler</button>
                                </div>
                            </div>
                            <div class="hidden confirm-justif-depart-msg"></div>
                        </div>
                    </div>


                    <div class="absent-section hidden">
                        <p><i class="fas fa-comment"></i> <strong>État d'absence:</strong> <span
                                id="modalMotifAbsence"></span></p>

                        <p> <i class="fas fa-link"></i>
                            <strong id="modalpiecsejustification">Pièces justificatives d'absence:</strong>
                        <div id="piece-absence-form" class="<?= $viewAdmin2 == "" ? "d-none" : "" ?>">
                            <p>
                                <strong>Ajouter une pièce justificative</strong>
                            </p>
                            <form method="post" action="" id="justificationFormAbsence" enctype="multipart/form-data">
                                <div class="d-flex flex-column">
                                    <input type="hidden" id="pointage_id" name="pointage_id">
                                    <div class="d-flex flex-column w-50">
                                        <label for="nomDocument">Nom du document</label>
                                        <input class="mb-2" type="text" id="nomDocumentAbsence" name="nomDocument"
                                            placeholder="ajouter le nom du document">
                                    </div>
                                    <div class="d-flex flex-column w-50">
                                        <label for="commentaire">Commentaire</label>
                                        <input class="mb-2" type="text" id="commentaireAbsence" name="commentaire"
                                            placeholder="commentaire">
                                    </div>
                                    <div class="d-flex flex-column w-50">
                                        <label for="commentaire">Selectionner un fichier</label>
                                        <input class="mb-2" type="file" name="attachments[]" id="attachments" multiple>
                                    </div>
                                    <button class="emp-btn btn btn-red btn-round mt-2 w-25" type="submit"
                                        name="submit">Ajouter</button>
                                </div>
                            </form>
                        </div>
                        </p>
                        <div class="scrollable-container mb-3">

                            <span id="modalurlJustificationAbsence"></span>
                        </div>
                        <p><i class="fas fa-comment"></i> <strong>Motif d'absence:</strong></p>
                        <input class="<?= $viewAdmin2 == "" ? "d-none" : "" ?>" type="text" name="motif" id="motif-absence"
                            required placeholder="Ajouter un motif">
                        <span id="motifAbsenceErreur" class="text-danger">Veuillez entrer le motif</span>
                        <div id="modalJustificationAbsence" class="motif-container"></div>
                        <div class="mt-0">
                            <div class="<?= $viewAdmin != '' ? $viewAdmin : 'form-group confirm-justif-absence' ?>">
                                <label for="confirmationDepart" class="font-weight-bold">Êtes-vous sûr de vouloir
                                    valider la justification d'absence'?</label><br>

                                <div class="row">
                                    <div class="form-check d-inline-block ml-3">
                                        <input type="radio" class="form-check-input" id="confirmDepartOui"
                                            name="confirmationDepart" value="oui">
                                        <label class="form-check-label font-weight-bold"
                                            for="confirmDepartOui">Oui</label>
                                    </div>

                                    <div class="form-check d-inline-block ml-3">
                                        <input type="radio" class="form-check-input" id="confirmDepartNon"
                                            name="confirmationDepart" value="non">
                                        <label class="form-check-label font-weight-bold"
                                            for="confirmDepartNon">Non</label>
                                    </div>

                                </div>
                                <input type="hidden" id="modalpointage_id">
                                <input type="hidden" id="modalidUserF">
                                <input type="hidden" id="modalemailuser">

                                <div class="modal-footer">
                                    <button class="btn btn-success" type="button"
                                        id="confirmJustificationAbsenceSubmit">Confirmer</button>
                                    <button class="btn btn-danger" type="button" data-dismiss="modal">Annuler</button>
                                </div>
                            </div>
                            <div class="hidden confirm-justif-absence-msg"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

        <div class="modal fade" id="leaveRequestModal" tabindex="-1" role="dialog"
            aria-labelledby="leaveRequestModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">

                    <div class="modal-header" style="background-color: #c00000;">
                        <h5 class="modal-title font-weight-bold text-uppercase text-white" id="leaveRequestModalLabel">
                            Demande de Congé
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="" id="leaveRequestForm">
                        <div class="modal-body mt-0">
                            <div class="row mt-0">
                                <div class="col-md-12 text-left">
                                    <div class="col-md-12 mx-3">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="leaveType">Type de congé <small
                                                        class="text-danger">*</small></label>
                                                <select id="leaveType" name="leaveType" class="form-control" required>
                                                    <option value="" disabled selected>Sélectionnez un type de congé
                                                    </option>
                                                        <?php
                                                            foreach ($typesConge as $type) {
                                                                ?>
                                                                <option value="<?= $type->idTypeConge ?>">
                                                                    <?= $type->type ?>
                                                                </option>
                                                                <?php
                                                            } 
                                                        ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="attachments">Pièces jointes</label>
                                                <input type="file" id="attachments" name="attachments[]"
                                                    class="form-control">
                                            </div>
                                        </div>


                                        <div class="row">

                                            <div class="col-md-6 mb-3">
                                                <label for="startDate">Date de début <small
                                                        class="text-danger">*</small></label>
                                                <input type="date" id="startDate" name="startDate" class="form-control"
                                                    required>
                                            </div>


                                            <div class="col-md-6 mb-3">
                                                <label for="endDate">Date de fin <small
                                                        class="text-danger">*</small></label>
                                                <input type="date" id="endDate" name="endDate" class="form-control"
                                                    required>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-12 text-left">
                                                <label for="justificationEditor">Motif <small
                                                        class="text-danger">*</small></label>

                                                <div id="justificationEditor" style="height: 200px;"></div>

                                                <textarea id="justification" class="form-control"
                                                    style="display: none;"></textarea>

                                                <small class="text-danger" id="justificationError"
                                                    style="display: none;">Ce champ est requis.</small>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" type="submit">Envoyer</button>
                                                    <button class="btn btn-danger" type="button"
                                                        data-dismiss="modal">Annuler</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <button type="button" class="<?=$viewAdmin2 == '' ? 'hidden' : 'btn btn-sm btn-red ml-1'?>" data-toggle="modal"
                    data-target="#leaveRequestModal" rel="tooltip" title="Ajouter">
                    DEMANDER UN CONGÉ
                </button>
                <a href="<?= linkTo('GestionInterne', 'ajouterTypeConge') ?>" type="button"
                    class="<?= $viewAdmin2 != "" ? $viewAdmin2 : "btn btn-sm btn-red ml-1" ?>" rel="tooltip"
                    title="Ajouter">
                    <i class="fas fa-plus" style="color: #ffffff"></i>
                    AJOUTER UN TYPE DE CONGÉ
                </a>
                <h2 class="text-center" style="color: grey;">Liste des congés</h2>
                <div class="table-responsive">
                    <table id="dataTable16" class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Actions</th>
                                <th class="<?= $viewAdmin2 ?>">Employé</th>
                                <th>Type de congé</th>
                                <th>Nombre de jours</th>
                                <th>Date début souhaitée</th>
                                <th>Date fin souhaitée</th>
                                <th>Date début réelle</th>
                                <th>Date fin réelle</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($conges as $index => $demande) { ?>
                                <!-- DEBUT calcul de nombre de jours -->
                                <?=
                                    $nbrJours = "-";
                                if (!empty($demande->dateDebutDeCongeReelle) && !empty($demande->dateFinDeCongeReelle)) {
                                    $datetimeDebut = new DateTime($demande->dateDebutDeCongeReelle);
                                    $datetimeFin = new DateTime($demande->dateFinDeCongeReelle);
                                    $nbrJours = $datetimeFin->diff($datetimeDebut)->format('%d');
                                } elseif (!empty($demande->dateDebutDeCongeSouhaite) && !empty($demande->dateFinDeCongeSouhaite)) {
                                    $datetimeDebut = new DateTime($demande->dateDebutDeCongeSouhaite);
                                    $datetimeFin = new DateTime($demande->dateFinDeCongeSouhaite);
                                    $nbrJours = $datetimeFin->diff($datetimeDebut)->format('%d');
                                }
                                ?>
                                <!-- FIN calcul de nombre de jours -->

                                <tr data-id="<?php echo htmlspecialchars($demande->idDemande); ?>">
                                    <td><?php echo $index + 1; ?></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-icon ml-2"
                                            onclick="showCongeDetails(<?= isset($demande->idDemande) ? $demande->idDemande : 'null' ?>)"
                                            style="background: #e74c3c; color:white">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                    <td class="<?= $viewAdmin2 ?>"><?php echo htmlspecialchars($demande->fullName); ?></td>
                                    <td><?php echo htmlspecialchars($demande->type); ?></td>
                                    <td> <?= $nbrJours ?></td>
                                    <td><?php echo htmlspecialchars(formatDate($demande->dateDebutDeCongeSouhaite)); ?></td>
                                    <td><?php echo htmlspecialchars(formatDate($demande->dateFinDeCongeSouhaite)); ?></td>
                                    <td><?php echo htmlspecialchars(formatDate($demande->dateDebutDeCongeReelle)); ?></td>
                                    <td><?php echo htmlspecialchars(formatDate($demande->dateFinDeCongeReelle)); ?></td>
                                    <td>
                                        <?php
                                        if ($demande->statut == 0) {
                                            echo '<span class="badge badge-primary">En attente</span>';
                                        } elseif ($demande->statut == 1) {
                                            echo '<span class="badge badge-success">Approuvé</span>';
                                        } elseif ($demande->statut == 2) {
                                            echo '<span class="badge badge-danger">Rejeté</span>';
                                        } else {
                                            echo '<span class="badge badge-warning">Annulé</span>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>


        <script src="<?= URLROOT ?>/assets/ticket/vendor/libs/jquery/jquery.js"></script>
        <script type="text/javascript" src="<?= URLROOT ?>/assets/ticket/vendor/libs/jquery/jquery.js"></script>
        <script type="text/javascript"
            src="<?= URLROOT ?>/assets/ticket/vendor/libs/datepicker/jquery-3.5.1.min.js"></script>

        <!-- <script type="text/javascript" src="<?= URLROOT ?>/assets/ticket/vendor/libs/bootstrap/js/bootstrap.js"></script> -->

        <script type="text/javascript"
            src="<?= URLROOT ?>/assets/ticket/vendor/libs/datepicker/jquery.timepicker.js"></script>
        <script type="text/javascript"
            src="<?= URLROOT ?>/assets/ticket/vendor/libs/datepicker/documentation-assets/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="<?= URLROOT ?>/assets/ticket/js/datepair.js"></script>
        <script type="text/javascript" src="<?= URLROOT ?>/assets/ticket/js/jquery.datepair.js"></script>
        <script src="<?= URLROOT ?>/assets/ticket/vendor/js/bootstrap.js"></script>
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

        <script>
            const URLROOT = '<?php echo URLROOT; ?>';
            // Initialize Quill when the DOM is fully loaded
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

            function showCongeDetails(id) {
                    if (id === null) {
                        $('#errorOperation').modal('show');
                        return;
                    }
                    $('#pointage_id').val(id);

                    $.ajax({
                        url: `${URLROOT}/public/json/conge.php?action=getCongeById`,
                        method: 'POST',
                        data: {
                            idDemande: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            console.log(response);




                            // let arriveeSection = document.querySelector('.arrivee-section')
                            // let justifArriveeText = document.querySelector('.justif-arrivee-text')

                            // let departSection = document.querySelector('.depart-section')
                            // let justifDepartText = document.querySelector('.justif-depart-text')

                            // let absentSection = document.querySelector('.absent-section')

                            // let justifDepartHr = document.querySelector('#justif-depart-hr')

                            // //si absent afficher confirmation absence et cacher confirmation depart/arrivee
                            // if (response.absent == 1) {
                            //     absentSection.classList.remove('hidden')
                            //     departSection.classList.add('hidden')
                            //     arriveeSection.classList.add('hidden')
                            //     justifArriveeText.classList.add('hidden')
                            //     justifDepartText.classList.add('hidden')
                            //     justifDepartHr.classList.add('hidden')



                            // } else {
                            //     //si present cacher confirmation absence
                            //     absentSection.classList.add('hidden')
                            //     justifDepartHr.classList.remove('hidden')
                            //     justifArriveeText.classList.remove('hidden')
                            //     justifDepartText.classList.remove('hidden')
                            //     //si depart à l'heure/apres l'heure ou pas de pointage depart, cacher confirmation depart
                            //     if (calculerDifferenceHeures(response.heureFinJour, response.heureFinPointage).startsWith("+") ||
                            //         calculerDifferenceHeures(response.heureFinJour, response.heureFinPointage).startsWith("0") ||
                            //         response.heureFinPointage === null
                            //     ) {
                            //         //si depart avant l'heure, afficher confirmation depart
                            //         departSection.classList.add("hidden")
                            //         justifDepartText.innerHTML = "Pas besoin de justificatif de depart"
                            //     } else {
                            //         //si retard afficher confirmation depart
                            //         departSection.classList.remove("hidden")
                            //         justifDepartText.innerHTML = ""
                            //     }
                            //     //si à l'heure cacher confirmation arrivee
                            //     if (calculerDifferenceHeures(response.heureDebutJour, response.heureDebutPointage).startsWith("-")) {
                            //         arriveeSection.classList.add("hidden")
                            //         justifArriveeText.innerHTML = "Pas besoin de justificatif d'arrivée"
                            //     } else {
                            //         //si retard afficher confirmation arrivee
                            //         arriveeSection.classList.remove('hidden')
                            //         justifArriveeText.innerHTML = ""
                            //     }
                            // }

                            // let resultatTraiteAbsentText
                            // let badgeAbsentClass

                            // if (response.resultatTraiteAbsent === 'Refusé') {
                            //     resultatTraiteAbsentText = 'Injustifié';
                            //     badgeAbsentClass = 'badge-danger'; // Classe pour le badge 'Injustifié'
                            // } else if (response.resultatTraiteAbsent === 'Accepté') {
                            //     resultatTraiteAbsentText = 'Justifié';
                            //     badgeAbsentClass = 'badge-success'; // Classe pour le badge 'Justifié'
                            // } else {
                            //     resultatTraiteAbsentText = 'Injustifié';
                            //     badgeAbsentClass = 'badge-error'; // Classe par défaut si aucune des conditions n'est remplie
                            // }

                            // // Affichage dans l'élément HTML avec le badge
                            // document.getElementById('modalMotifAbsence').innerHTML = `<span class="badge ${badgeAbsentClass}">${resultatTraiteAbsentText}</span>`;

                            // let confirmJustifAbsence = document.querySelector(".confirm-justif-absence")
                            // let confirmJustifAbsenceMsg = document.querySelector(".confirm-justif-absence-msg")

                            // let confirmJustifDepart = document.querySelector(".confirm-justif-depart")
                            // let confirmJustifDepartMsg = document.querySelector(".confirm-justif-depart-msg")

                            // let confirmJustifArrivee = document.querySelector(".confirm-justif-arrivee")
                            // let confirmJustifArriveeMsg = document.querySelector(".confirm-justif-arrivee-msg")

                            // let pieceDepartForm = document.querySelector("#piece-depart-form")
                            // let pieceArriveeForm = document.querySelector("#piece-arrivee-form")
                            // let pieceAbsenceForm = document.querySelector("#piece-absence-form")

                            // let motifDepart = document.querySelector("#motif-depart")
                            // let motifArrivee = document.querySelector("#motif-arrivee")
                            // let motifAbsence = document.querySelector("#motif-absence")

                            // if (pieceDepartForm && pieceArriveeForm && pieceAbsenceForm) {
                            //     if (response.resultatTraiteAbsent === 'Accepté' || response.resultatTraiteAbsent === 'Refusé') {
                            //         pieceAbsenceForm.classList.add("hidden")
                            //         motifAbsence.classList.add("hidden")
                            //     } else {
                            //         pieceAbsenceForm.classList.remove("hidden")
                            //         motifAbsence.classList.remove("hidden")
                            //     }
                            //     if (response.resultatTraite === 'Accepté' || response.resultatTraite === 'Refusé') {
                            //         pieceArriveeForm.classList.add("hidden")
                            //         motifArrivee.classList.add("hidden")
                            //     } else {
                            //         pieceArriveeForm.classList.remove("hidden")
                            //         motifArrivee.classList.remove("hidden")
                            //     }
                            //     if (response.resultatTraiteDepart === 'Accepté' || response.resultatTraiteDepart === 'Refusé') {
                            //         pieceDepartForm.classList.add("hidden")
                            //         motifDepart.classList.add("hidden")
                            //     } else {
                            //         pieceDepartForm.classList.remove("hidden")
                            //         motifDepart.classList.remove("hidden")
                            //     }
                            // }

                            // if (motifAbsence) {
                            //     if (response.resultatTraiteAbsent === 'Accepté' || response.resultatTraiteAbsent === 'Refusé') {
                            //         motifAbsence.classList.add("hidden")
                            //     } else {
                            //         motifAbsence.classList.remove("hidden")
                            //     }
                            // }
                            // if (motifArrivee) {
                            //     if (response.resultatTraite === 'Accepté' || response.resultatTraite === 'Refusé') {
                            //         motifArrivee.classList.add("hidden")
                            //     } else {
                            //         motifArrivee.classList.remove("hidden")
                            //     }
                            // }
                            // if (motifDepart) {
                            //     if (response.resultatTraiteDepart === 'Accepté' || response.resultatTraiteDepart === 'Refusé') {
                            //         motifDepart.classList.add("hidden")
                            //     } else {
                            //         motifDepart.classList.remove("hidden")
                            //     }
                            // }

                            // if (confirmJustifAbsence) {
                            //     if (response.resultatTraiteAbsent === 'Accepté') {
                            //         confirmJustifAbsence.classList.add('hidden')
                            //         confirmJustifAbsenceMsg.classList.remove("hidden")
                            //         confirmJustifAbsenceMsg.innerHTML = `Absence a été validé par ${response.auteurTraiteAbsent}`
                            //     } else if (response.resultatTraiteAbsent === 'Refusé') {
                            //         confirmJustifAbsence.classList.add('hidden')
                            //         confirmJustifAbsenceMsg.classList.remove("hidden")
                            //         confirmJustifAbsenceMsg.innerHTML = `Absence n'a pas été validé par ${response.auteurTraiteAbsent}`
                            //     } else {
                            //         confirmJustifAbsence.classList.remove('hidden')
                            //         confirmJustifAbsenceMsg.classList.add("hidden")
                            //         confirmJustifAbsenceMsg.innerHTML = ``
                            //     }
                            // } else {
                            //     if (response.resultatTraiteAbsent === 'Accepté') {
                            //         confirmJustifAbsenceMsg.classList.remove("hidden")
                            //         confirmJustifAbsenceMsg.innerHTML = `Absence a été validé par ${response.auteurTraiteAbsent}`
                            //     } else if (response.resultatTraiteAbsent === 'Refusé') {
                            //         confirmJustifAbsenceMsg.classList.remove("hidden")
                            //         confirmJustifAbsenceMsg.innerHTML = `Absence n'a pas été validé par ${response.auteurTraiteAbsent}`
                            //     } else {
                            //         confirmJustifAbsenceMsg.classList.add("hidden")
                            //         confirmJustifAbsenceMsg.innerHTML = ``
                            //     }
                            // }

                            // if (confirmJustifArrivee) {
                            //     if (response.resultatTraite === 'Accepté') {
                            //         confirmJustifArrivee.classList.add('hidden')
                            //         confirmJustifArriveeMsg.classList.remove("hidden")
                            //         confirmJustifArriveeMsg.innerHTML = `Retard d'arrivée a été validé par ${response.auteurTraite}`
                            //     } else if (response.resultatTraite === 'Refusé') {
                            //         confirmJustifArrivee.classList.add('hidden')
                            //         confirmJustifArriveeMsg.classList.remove("hidden")
                            //         confirmJustifArriveeMsg.innerHTML = `Retard d'arrivée n'a pas été validé par ${response.auteurTraite}`
                            //     } else {
                            //         confirmJustifArrivee.classList.remove('hidden')
                            //         confirmJustifArriveeMsg.classList.add("hidden")
                            //         confirmJustifArriveeMsg.innerHTML = ``
                            //     }
                            // } else {
                            //     if (response.resultatTraite === 'Accepté') {
                            //         confirmJustifArriveeMsg.classList.remove("hidden")
                            //         confirmJustifArriveeMsg.innerHTML = `Retard d'arrivée a été validé par ${response.auteurTraite}`
                            //     } else if (response.resultatTraite === 'Refusé') {
                            //         confirmJustifArriveeMsg.classList.remove("hidden")
                            //         confirmJustifArriveeMsg.innerHTML = `Retard d'arrivée n'a pas été validé par ${response.auteurTraite}`
                            //     } else {
                            //         confirmJustifArriveeMsg.classList.add("hidden")
                            //         confirmJustifArriveeMsg.innerHTML = ``
                            //     }
                            // }

                            // if (confirmJustifDepart) {
                            //     if (response.resultatTraiteDepart === 'Accepté') {
                            //         confirmJustifDepart.classList.add('hidden')
                            //         confirmJustifDepartMsg.classList.remove("hidden")
                            //         confirmJustifDepartMsg.innerHTML = `Retard de depart a été validé par ${response.auteurTraiteDepart}`
                            //     } else if (response.resultatTraiteDepart === 'Refusé') {
                            //         confirmJustifDepart.classList.add('hidden')
                            //         confirmJustifDepartMsg.classList.remove("hidden")
                            //         confirmJustifDepartMsg.innerHTML = `Retard de depart n'a pas été validé par ${response.auteurTraiteDepart}`
                            //     } else {
                            //         confirmJustifDepart.classList.remove('hidden')
                            //         confirmJustifDepartMsg.classList.add("hidden")
                            //         confirmJustifDepartMsg.innerHTML = ``
                            //     }
                            // } else {
                            //     if (response.resultatTraiteDepart === 'Accepté') {
                            //         confirmJustifDepartMsg.classList.remove("hidden")
                            //         confirmJustifDepartMsg.innerHTML = `Retard de depart a été validé par ${response.auteurTraiteDepart}`
                            //     } else if (response.resultatTraiteDepart === 'Refusé') {
                            //         confirmJustifDepartMsg.classList.remove("hidden")
                            //         confirmJustifDepartMsg.innerHTML = `Retard de depart n'a pas été validé par ${response.auteurTraiteDepart}`
                            //     } else {
                            //         confirmJustifDepartMsg.classList.add("hidden")
                            //         confirmJustifDepartMsg.innerHTML = ``
                            //     }
                            // }

                            // let justificationAbsenceElement = document.getElementById('modalJustificationAbsence');
                            // if (justificationAbsenceElement) {
                            //     justificationAbsenceElement.innerHTML = response.motifAbsent ? `<p style="margin-left:20px; font-size:16px;">${response.motifAbsent}</p>` : `<p style="font-size:16px;">Aucun motif trouvé</p>`;
                            // }

                            // let pointage_id = document.getElementById('modalpointage_id');
                            // pointage_id.value = response.idPointage;
                            // let idUserF = document.getElementById('modalidUserF');
                            // idUserF.value = response.idUserF;
                            // let emailuser = document.getElementById('modalemailuser');
                            // emailuser.value = response.email;

                            let employeElement = document.getElementById('modalemploye');
                            if (employeElement) {
                                employeElement.innerText = response.fullName || '-';
                            }

                            let matriculeElement = document.getElementById('modalmatricule');
                            if (matriculeElement) {
                                matriculeElement.innerText = response.matricule || '-';
                            }

                            let typeElement = document.getElementById('modaltype');
                            if (typeElement) {
                                typeElement.innerText = response.type || '-';
                            }

                            let siteElement = document.getElementById('modalsite');
                            if (siteElement) {
                                siteElement.innerText = response.nomSite || '-';
                            }

                            function daysDifference(date1, date2) {
                                const diffInMs = Math.abs(date2.getTime() - date1.getTime());
                                const diffInDays = Math.ceil(diffInMs / (1000 * 60 * 60 * 24));
                                return diffInDays;
                            }

                            let nbrJoursElement = document.getElementById('modaljours');
                            if (nbrJoursElement) {
                                let nbrJours = "-";

                                if (response && response.dateDebutDeCongeReelle && response.dateFinDeCongeReelle) {
                                    const dateDebut = new Date(response.dateDebutDeCongeReelle);
                                    const dateFin = new Date(response.dateFinDeCongeReelle);
                                    nbrJours = daysDifference(dateDebut, dateFin);
                                } else if (response && response.dateDebutDeCongeSouhaite && response.dateFinDeCongeSouhaite) {
                                    const dateDebut = new Date(response.dateDebutDeCongeSouhaite);
                                    const dateFin = new Date(response.dateFinDeCongeSouhaite);
                                    nbrJours = daysDifference(dateDebut, dateFin);
                                }
                                nbrJoursElement.innerText = nbrJours;
                            }

                            let etatElement = document.getElementById('modalEtat');
                            if (etatElement) {
                                let etat = '<span class="badge badge-success">À l\'heure</span>';
                                if (response.statut == 0) {
                                    etat = '<span class="badge badge-secondary">En attente</span>';
                                } else if (response.statut == 1) {
                                    etat = '<span class="badge badge-success">Approuvé</span>';
                                } else if(response.statut == 2) {
                                    etat = '<span class="badge badge-danger">Rejeté</span>';
                                }
                                etatElement.innerHTML = etat;
                            }

                            let debutSouhaiteElement = document.getElementById('modalDebutSouhaite');
                            if (debutSouhaiteElement) {
                                debutSouhaiteElement.innerText = formatDate(response.dateDebutDeCongeSouhaite) || '-';
                            }
                            let finSouhaiteElement = document.getElementById('modalFinSouhaite');
                            if (finSouhaiteElement) {
                                finSouhaiteElement.innerText = formatDate(response.dateFinDeCongeSouhaite) || '-';
                            }

                            let debutProposeElement = document.getElementById('modalDebutPropose');
                            if (debutProposeElement) {
                                debutProposeElement.innerText = formatDate(response.dateDebutDeCongePropose) || '-';
                            }
                            let finProposeElement = document.getElementById('modalFinPropose');
                            if (finProposeElement) {
                                finProposeElement.innerText = formatDate(response.dateFinDeCongePropose) || '-';
                            }

                            let debutCongeElement = document.getElementById('modalDebut');
                            if (debutCongeElement) {
                                debutCongeElement.innerText = formatDate(response.dateDebutDeCongeReelle) || '-';
                            }
                            let finCongeElement = document.getElementById('modalFin');
                            if (finCongeElement) {
                                finCongeElement.innerText = formatDate(response.dateFinDeCongeReelle) || '-';
                            }

                            // let resultatTraiteText = '';
                            // let badgeClass = '';

                            // if (response.resultatTraite === 'Refusé') {
                            //     resultatTraiteText = 'Injustifié';
                            //     badgeClass = 'badge-danger'; // Classe pour le badge 'Injustifié'
                            // } else if (response.resultatTraite === 'Accepté') {
                            //     resultatTraiteText = 'Justifié';
                            //     badgeClass = 'badge-success'; // Classe pour le badge 'Justifié'
                            // } else {
                            //     resultatTraiteText = 'Injustifié';
                            //     badgeClass = 'badge-error'; // Classe par défaut si aucune des conditions n'est remplie
                            // }

                            // // Affichage dans l'élément HTML avec le badge
                            // document.getElementById('modalMotifRetard').innerHTML = `<span class="badge ${badgeClass}">${resultatTraiteText}</span>`;

                            // let difference = calculerDifferenceHeures(response.heureDebutJour, response.heureDebutPointage);
                            // if (response.heureDebutPointage === null) {
                            //     etat = '<span class="badge badge-danger">Absent</span>';
                            // } else if (difference.startsWith("-")) {
                            //     etat = '<span class="badge badge-success">À l\'heure</span>';
                            // }
                            // else if (difference.startsWith("+")) {
                            //     etat = '<span class="badge badge-warning">Retard</span>';
                            // }

                            // etatElement.innerHTML = etat;

                            // let etatdepart;
                            // if (response.absent == 1) {
                            //     etatdepart = '<span class="badge badge-danger">Absent</span>';
                            // } else {
                            //     let difference = calculerDifferenceHeures(response.heureFinJour, response.heureFinPointage);

                            //     if (difference === "-") {
                            //         etatdepart = '<span class="badge badge-success">À l\'heure</span>';
                            //     } else if (difference.startsWith("-")) {
                            //         etatdepart = '<span class="badge badge-warning">Avant l\'heure</span>';
                            //     } else if (difference.startsWith("+")) {
                            //         etatdepart = '<span class="badge badge-primary">Après l\'heure</span>';
                            //     } else {
                            //         etatdepart = '-';
                            //     }
                            // }

                            // document.getElementById('modalEtatDepart').innerHTML = etatdepart;
                            // // Gestion de resultatTraiteDepart
                            // let resultatTraiteDepartText = '';
                            // let badgeClassDepart = '';

                            // if (response.resultatTraiteDepart === 'Refusé') {
                            //     resultatTraiteDepartText = 'Injustifié';
                            //     badgeClassDepart = 'badge-danger';

                            // } else if (response.resultatTraiteDepart === 'Accepté') {
                            //     resultatTraiteDepartText = 'Justifié';
                            //     badgeClassDepart = 'badge-success';
                            // } else {
                            //     resultatTraiteDepartText = 'Injustifié';
                            //     badgeClassDepart = 'badge-error';
                            // }

                            // document.getElementById('modalMotifRetarddepart').innerHTML =
                            //     `<span class="badge ${badgeClassDepart}">${resultatTraiteDepartText}</span>`;

                            // justificationAbsenceLinkElement = document.getElementById('modalurlJustificationAbsence');
                            // let justificationAbsenceLinks = '-'; // Default value
                            // if (response.documents && response.documents.length > 0) {
                            //     // Filter documents where isArrive is equal to 1 (for Arrivé)
                            //     const filteredDocs = response.documents.filter(doc => doc.isArrive === null);

                            //     if (filteredDocs.length > 0) {
                            //         // Map the filtered documents to create HTML links
                            //         justificationAbsenceLinks = filteredDocs
                            //             .map(doc =>
                            //                 `<a style="color:#13058f; text-decoration: none; font-size:16px; font-weight:bold; margin-left:20px;" href="${URLROOT}/public/documents/pointage/justification/${doc.urlDocument}" target="_blank">${doc.nomDocument}</a>`
                            //             )
                            //             .join('<br>'); // Add an HTML line break between the links
                            //     } else {
                            //         // No documents found for isArrive === 1
                            //         justificationAbsenceLinks = 'Aucun document associé.';
                            //     }
                            // } else {
                            //     // No documents available in the response
                            //     justificationAbsenceLinks = 'Aucun document trouvé.';
                            // }

                            // // Update the HTML content of the element
                            // if (justificationAbsenceLinkElement) {
                            //     justificationAbsenceLinkElement.innerHTML = justificationAbsenceLinks;
                            // }



                            // justificationLinkElement = document.getElementById('modalurlJustification');
                            // let justificationLinks = '-'; // Default value

                            // if (response.documents && response.documents.length > 0) {
                            //     // Filter documents where isArrive is equal to 1 (for Arrivé)
                            //     const filteredDocs = response.documents.filter(doc => doc.isArrive === 1);

                            //     if (filteredDocs.length > 0) {
                            //         // Map the filtered documents to create HTML links
                            //         justificationLinks = filteredDocs
                            //             .map(doc =>
                            //                 `<a style="color:#13058f; text-decoration: none; font-size:16px; font-weight:bold; margin-left:20px;" href="${URLROOT}/public/documents/pointage/justification/${doc.urlDocument}" target="_blank">${doc.nomDocument}</a>`
                            //             )
                            //             .join('<br>'); // Add an HTML line break between the links
                            //     } else {
                            //         // No documents found for isArrive === 1
                            //         justificationLinks = 'Aucun document associé.';
                            //     }
                            // } else {
                            //     // No documents available in the response
                            //     justificationLinks = 'Aucun document trouvé.';
                            // }

                            // // Update the HTML content of the element
                            // if (justificationLinkElement) {
                            //     justificationLinkElement.innerHTML = justificationLinks;
                            // }

                            // let justificationDepartLinkElement = document.getElementById('modalurlJustificationDepart');
                            // let justificationDepartLinks = '-'; // Default value

                            // if (justificationDepartLinkElement) {
                            //     if (response.documents && response.documents.length > 0) {
                            //         // Filter documents where isArrive is equal to 0 (for Départs)
                            //         const filteredDocsDepart = response.documents.filter(doc => doc.isArrive === 0);

                            //         if (filteredDocsDepart.length > 0) {
                            //             // Map the filtered documents to create HTML links
                            //             justificationDepartLinks = filteredDocsDepart
                            //                 .map(doc =>
                            //                     `<a style="color:#13058f; text-decoration: none;  font-size:16px; font-weight:bold; margin-left:20px;" href="${URLROOT}/public/documents/pointage/justification/${doc.urlDocument}" target="_blank">${doc.nomDocument}</a>`
                            //                 )
                            //                 .join('<br>'); // Add an HTML line break between the links
                            //         } else {
                            //             // No documents found for isArrive === 0
                            //             justificationDepartLinks = 'Aucun document associé.';
                            //         }
                            //     } else {
                            //         // No documents available in the response
                            //         justificationDepartLinks = 'Aucun document trouvé.';
                            //     }

                            //     // Update the HTML content of the element
                            //     justificationDepartLinkElement.innerHTML = justificationDepartLinks;
                            // }


                            $('#detailCongeModal').modal('show');
                        },

                        error: function (xhr, status, error) {
                            console.error('Erreur lors de la récupération des détails du pointage:', error);
                            // alert('Une erreur s\'est produite lors de la récupération des détails.');
                        }
                    });
                }

            document.addEventListener('DOMContentLoaded', function () {
                // Initialize the Quill editor
                var quill = new Quill('#justificationEditor', {
                    theme: 'snow',
                    placeholder: 'Entrez votre justification...',
                    modules: {
                        toolbar: [
                            [{ 'header': [1, 2, 3, false] }],
                            ['bold', 'italic', 'underline'],
                            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                            ['link']
                        ]
                    }
                });

                $(document).ready(function () {
                    $('#leaveRequestForm').on('submit', function (event) {
                        event.preventDefault(); // Empêche l'envoi du formulaire par défaut
                        $('#justificationError').hide(); // Cache les messages d'erreur précédents

                        var formData = new FormData(this); // Crée un objet FormData basé sur le formulaire
                        var motif = quill.getText().trim(); // Récupère et nettoie le texte de la justification
                        var typeConge = $("#leaveType").val()
                        var startDate = $("#startDate").val()
                        var endDate = $("#endDate").val()

                        // Vérifie si la justification est vide
                        // if (justification === '') {
                        //     $('#justificationError').show(); // Affiche un message d'erreur
                        //     $('#justificationError').text('La justification est obligatoire.');
                        //     return; // Arrête l'exécution si la justification est vide
                        // }

                        console.log(typeConge, startDate, endDate, motif, userId)

                        formData.append('motif', motif); // Ajoute la justification à FormData
                        formData.append('userId', userId); // Ajoute l'ID de l'utilisateur (userId doit être défini globalement)
                        formData.append('typeConge', typeConge); // Ajoute l'ID de l'utilisateur (userId doit être défini globalement)
                        formData.append('endDate', endDate); // Ajoute l'ID de l'utilisateur (userId doit être défini globalement)
                        formData.append('startDate', startDate); // Ajoute l'ID de l'utilisateur (userId doit être défini globalement)

                        // Soumission AJAX
                        $.ajax({
                            url: `${URLROOT}/public/json/conge.php?action=saveConge`, // URL d'envoi (variable URLROOT doit être définie)
                            type: 'POST',
                            data: formData,
                            contentType: false, // Empêche jQuery de définir un content-type par défaut
                            processData: false, // Empêche jQuery de traiter les données envoyées (nécessaire pour FormData)
                            success: function (response) {
                                // Redirection après succès de la soumission
                                console.log(response)
                                window.location.href = `${URLROOT}/GestionInterne/gererConges`;
                            },
                            error: function (xhr, status, error) {
                                console.log(xhr.responseText); // Affiche la réponse en cas d'erreur
                                alert('Une erreur est survenue lors de la soumission.');
                            }
                        });
                    });
                });

            });


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

            $(document).ready(function () {
                var dateCreation = $('#dateDemande').val();
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
                //  $('.select3').select2();
            });

            $("#dateDemande").on("change", function () {
                if ($("#dateDemande option:selected").val() == "perso" || $("#dateDemande option:selected").val() == "jour") {
                    $("#changeperso").removeAttr("hidden");
                    if ($("#dateDemande option:selected").val() == "perso") {
                        $("#date2").removeAttr("hidden");

                        $("#date1").removeClass("col-md-12");
                        $("#date1").addClass("col-md-6");
                    } else {
                        $("#date2").attr("hidden", "hidden");
                        $("#date1").removeClass("col-md-6");
                        $("#date1").addClass("col-md-12");
                    }
                } else {
                    $("#changeperso").attr("hidden", "hidden");
                }
            })
            const userId = '<?php echo $_SESSION['connectedUser']->idUtilisateur; ?>'
            document.addEventListener('DOMContentLoaded', function () {
                const filterForm = document.getElementById('filterForm');
                const filterButton = document.getElementById('filterButton');

                // Récupérer les filtres sauvegardés dans le localStorage et pré-remplir le formulaire
                const savedFilters = JSON.parse(localStorage.getItem('filterCriteriaConges'));
                if (savedFilters) {
                    for (const key in savedFilters) {
                        const element = document.querySelector(`[name=${key}]`);
                        if (element) {
                            element.value = savedFilters[key];
                        }
                    }
                    // Appliquer les filtres automatiquement si des filtres existent
                    // applyFilters(savedFilters);
                }

                // Gérer l'événement du bouton de filtre
                // filterButton.addEventListener('click', function (e) {
                //     e.preventDefault(); // Empêcher la soumission par défaut du formulaire

                //     const formData = new FormData(filterForm);
                //     formData.append('userid', userId); // Supposons que userId est défini globalement

                //     // Récupérer les critères de filtre et les stocker dans localStorage
                //     const filterCriteria = {};
                //     for (const [key, value] of formData.entries()) {
                //         if (key !== 'userid') { // On ne stocke pas userid dans le localStorage
                //             filterCriteria[key] = value;
                //         }
                //     }

                //     // Sauvegarder les critères de filtre dans le localStorage
                //     localStorage.setItem('filterCriteriaConges', JSON.stringify(filterCriteria));

                //     // Mettre à jour l'URL avec les critères de filtre (sans userId)
                //     const queryParams = new URLSearchParams(filterCriteria).toString();
                //     const newUrl = `${window.location.pathname}?${queryParams}`;
                //     window.history.pushState(null, '', newUrl); // Mettre à jour l'URL sans recharger la page

                //     // Appliquer les filtres avec les critères de filtre récupérés
                //     // applyFilters(filterCriteria);
                // });

                // Fonction pour appliquer les filtres et mettre à jour les données dans la table
                function applyFilters(filterCriteria) {
                    const formData = new FormData();
                    for (const key in filterCriteria) {
                        formData.append(key, filterCriteria[key]);
                    }
                    formData.append('userid', userId); // Inclure l'userId dans la requête POST

                    fetch(`${URLROOT}/public/json/conge.php?action=filterConges`, {
                        method: 'POST',
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (Array.isArray(data)) {
                                updateTable(data); // Mettre à jour la table avec les données filtrées
                            } else {
                                console.error('Format de données invalide:', data);
                            }
                        })
                        .catch(error => {
                            console.error('Erreur:', error);
                        });
                }

                // Gérer la navigation par historique (boutons précédent/suivant)
                window.addEventListener('popstate', function () {
                    const queryParams = new URLSearchParams(window.location.search);
                    const filterCriteria = Object.fromEntries(queryParams.entries());
                    localStorage.setItem('filterCriteriaConges', JSON.stringify(filterCriteria)); // Synchroniser avec localStorage
                    // applyFilters(filterCriteria); // Réappliquer les filtres en fonction de l'URL
                });

                // Fonction pour mettre à jour la table avec les données filtrées
                function updateTable(data) {
                    const tableBody = document.querySelector('#dataTable16 tbody');
                    tableBody.innerHTML = ''; // Vider les lignes existantes

                    // Fonction pour formater la date au format dd/mm/yy
                    function formatDate(dateString) {
                        const dateObj = new Date(dateString);
                        const day = String(dateObj.getDate()).padStart(2, '0'); // Jour
                        const month = String(dateObj.getMonth() + 1).padStart(2, '0'); // Mois
                        const year = String(dateObj.getFullYear()).slice(2); // Année (2 derniers chiffres)
                        return `${day}/${month}/${year}`;
                    }

                    data.forEach((item, index) => {
                        let statutBadge;

                        // Déterminer le badge correspondant au statut
                        if (item.statut === "0") {
                            statutBadge = '<span class="badge badge-secondary">En attente</span>';
                        } else if (item.statut === "1") {
                            statutBadge = '<span class="badge badge-success">Approuvé</span>';
                        } else if (item.statut === "2") {
                            statutBadge = '<span class="badge badge-danger">Rejeté</span>';
                        } else {
                            statutBadge = '<span class="badge badge-warning">Statut inconnu</span>';
                        }

                        // Créer une nouvelle ligne dans la table
                        const newRow = document.createElement('tr');
                        newRow.setAttribute('data-id', item.idDemande); // Ajouter l'ID de la demande comme attribut
                        newRow.innerHTML = `
                <td>${index + 1}</td>
                <td>${item.typeConge}</td>
                <td>${formatDate(item.dateDebutDeCongeSouhaite)}</td>
                <td>${formatDate(item.dateFinDeCongeSouhaite)}</td>
                <td>${item.motif}</td>
                <td>${statutBadge}</td>
            `;
                        tableBody.appendChild(newRow);
                    });
                }
            });



        </script>