
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<style>
    .main-content {
        margin-top: 50px;
        margin-left: 5px;
        padding: 10px;
    }

    .emp-btn {
        display: flex;
        align-items: center;
        justify-content:center;
        font-size:20px;
        height: 100px;
    }
</style>
<!-- <style>
    /* Style du contenu principal */
    .main-content {
        margin-top: 50px;
        margin-left: 5px;
        padding: 10px;
    }

    .main-content h2 {
        margin-bottom: 20px;
        color: #000000;
        font-weight: bold;
        font-size: 18px;
    }

    .card-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* 3 colonnes */
        gap: 20px;
        justify-items: center; /* Centrer les cartes */
    }

    .card {
        background-color: #f8d7da;
        border: 1px solid #c00000;
        padding: 20px;
        text-align: center;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        height: 50px;
        width: 200px; /* Fixe une largeur uniforme */

        justify-content: center; /* Centrage horizontal */
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card a {
        text-decoration: none;
        color: black;
        font-weight: bold;
        font-size: 18px;
    }

    /* Positionnement des cartes sur la deuxième ligne */
    .card-container .card:nth-child(4) {
        grid-column: 1 / 3; /* Positionne la 4ème carte entre la 1ère et la 2ème cartes */
        grid-row: 2; /* Places card 5 on the second row */
    }
 

    .card-container .card:nth-child(5) {
        grid-column: 2 / 4; /* Moves card 5 to the second column, between cards 2 and 3 */
        grid-row: 2; /* Places card 5 on the second row */
    }

    /* Styles responsives */
    @media (max-width: 768px) {
        .card-container {
            grid-template-columns: repeat(2, 1fr); /* 2 colonnes pour les écrans plus petits */
        }

        .card-container .card:nth-child(4),
        .card-container .card:nth-child(5) {
            grid-column: span 2; /* Sur 2 colonnes pour être centrées */
        }
    }

    @media (max-width: 480px) {
        .card-container {
            grid-template-columns: 1fr; /* 1 colonne pour les petits écrans */
        }

        .card-container .card:nth-child(4),
        .card-container .card:nth-child(5) {
            grid-column: span 1; /* Prend toute la ligne sur petit écran */
        }
    }
</style> -->

<?php
// HtmlProvider::start_page();
// addPrivateRoute();
// echo HtmlProvider::viewTitleBarWithRole("GESTION DES UTILISATEURS", '', '', 'success', linkTo('', ''), getRouteAccess());

// inputHiddenForUrlRoot();
$logo = (true) ? 'LOGO_SOS_SINISTRE.jpg' : "logo_WBCC.png";
$user = $_SESSION["connectedUser"];
$role = $user->idRole;
?>

<div class="section-title">
    <div class="col-md-6">
        <h2>
            <span>      
                <i class="fa fa-solid fa-user" style="color: #c00000"></i>
            </span> GESTION PERSONNEL
        </h2>
    </div>
    <div class="<?= $role!= 1 && $role!= 2 ? "main-content " : "main-content hidden" ?>">
    <div class="container-fluid">
    <div class="row justify-content-center text-center flex-wrap">
        <div class="col-6 col-md-3 mb-3 mb-md-2">
            <a href="<?= $data['dashbord'] ?>" type="button" class="emp-btn btn btn-primary btn-round waves-effect btn-block">
                1- Tableau de bord
            </a>
        </div>
        <div class="col-6 col-md-3 mb-3 mb-md-2">
            <a href="<?= $data['gerepresence'] ?>" type="button" class="emp-btn btn btn-primary btn-round waves-effect btn-block">
                2- Présences
            </a>
        </div>
        <div class="col-6 col-md-3 mb-3 mb-md-2">
            <a href="<?= $data['DemanderConge'] ?>" type="button" class="emp-btn btn btn-primary btn-round waves-effect btn-block">
                3- Congés
            </a>
        </div>
        <div class="col-6 col-md-3 mb-3 mb-md-2">
            <a href="<?= $data['avertir'] ?>" type="button" class="emp-btn btn btn-primary btn-round waves-effect btn-block">
                4- Avertissements
            </a>
        </div>
    </div>
</div>

    </div>

    <div class="<?= $role== 1 || $role== 2 ? "main-content" : "main-content hidden" ?>">
        <div class="d-flex justify-content-between">
            <span class="col-md-2 ml-2 "><a href="<?= $data['tbdPresence'] ?>" type="button" class="w-100 btn btn-primary btn-round waves-effect btn-sm">1- Tableau de bord</a></span>
            <span class="col-md-2 ml-2 "><a href="<?= $data['gerepresence']  ?>" type="button" class="w-100 btn btn-primary btn-round waves-effect btn-sm">2- Présences</a></span>
            <span class="col-md-2 ml-2 "><a href="<?= $data['gererConges'] ?>" type="button" class="w-100 btn btn-primary btn-round waves-effect btn-sm">3- Congés</a></span>
            <span class="col-md-2 ml-2 "><a href="<?= $data['genererAvertissement'] ?>" type="button" class="w-100 btn btn-primary btn-round waves-effect btn-sm">4- Avertissements</a></span>
            <span class="col-md-2 ml-2 "><a href="<?= $data['gererPaie'] ?>" type="button" class="w-100 btn btn-primary btn-round waves-effect btn-sm">5- Exportation de Paie</a></span>
        </div>
    </div>
</div>

<div class=" <?= $role== 1 || $role== 2 ? "page-body" : "page-body hidden" ?>">

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <!-- <div class="form-group col-md-6">
                            <input type="text" id="mySearchText" placeholder="Recherche ..." style="width:100%; padding:3px; border-radius:5px">
                        </div> -->
                    </div>
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h3 class="m-0 mt-2 font-weight-bold text-primary text-center flex-grow-1">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;"><?= $titre ?></font>
                            </font>
                        </h3>
                        <span class="ml-auto">
                            <button type="button" class="btn btn-red btn-round waves-effect btn-sm" data-toggle="modal" data-target="#newRole">
                                <i class="fas fa-user-plus" style="color: #ffffff"></i>
                                Ajouter un utilisateur
                            </button>
                        </span>
                    </div>

                    <div class="page-body">
                        <div class="row">
                            <div class="col-sm-12">

                                <div class="card">
                                    <div class="card-block">
                                        <div class="dt-responsive table-responsive">
                                            <table id="dataTable16" class="display table table-bordered">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th>Prénom</th>
                                                        <th>Nom</th>
                                                        <th>Login</th>
                                                        <th>Téléphone</th>
                                                        <th>Email</th>
                                                        <th>Role</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($users as $user) {
                                                        $idUser = $user->idUtilisateur;
                                                        $idEmp = $user->idContact;
                                                        $trHidden = '';
                                                        $changeLink = $idUser . '/' . $user->etatUser;
                                                        if ($user->etatUser == 1) {
                                                            $btn = 'Bloquer';
                                                            $css = 'danger';
                                                        } else {
                                                            $btn = 'Activer &nbsp;';
                                                            $css = 'success';
                                                        }
                                                        $disable = '';
                                                        if (strtolower($user->libelleRole) == 'administrateur') {
                                                            $disable = 'disabled';
                                                        }
                                                        if ($idUser == $_SESSION['connectedUser']->idUtilisateur) {
                                                            $trHidden = 'hidden';
                                                        }
                                                        // echo "<tr $trHidden class='hovered-tr' dateDep='q' idDep='q' onclick=trClicked(this)>";
                                                        echo HtmlProvider::td_printer(['prenomContact', 'nomContact', 'login', 'telContact', 'email', 'libelleRole'], $user);
                                                        echo "<td class='text-right'>
                                                                <a href='" . linkTo('Personnel', 'edit', $idEmp, 0) . "' class='btn btn-sm btn-warning'>Editer</a>
                                                                <a href='" . linkTo('Utilisateur', 'changeUserState', $changeLink) . "' class='btn btn-sm btn-$css $disable'>$btn</a>
                                                            </td>";
                                                        echo "</tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="newRole" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h4 class=" mt-0 text-primary font-weight-bold">Nouvel Utilisateur</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?= linkTo('Personnel', 'save') ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="" class="active">Civilité</label>
                            <select name="civilite" class="form-control form-control-primary" required>
                            <option value="" selected disabled>-- Choisir la civilité</option>
                                <option value="Mr">Monsieur</option>
                                <option value="Mme">Madame</option>
                                <option value="Mlle">Mademoiselle</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="role" class="active">Groupe</label>
                            <select name="groupe" id="role" class="form-control" required>
                                <option value="" selected disabled>-- Choisir un groupe --</option>
                                <?php
                                foreach ($roles as $role) { $hidden = $role->etatRole == 1 ? '' : 'hidden';
                                ?>
                                    <option <?= $hidden ?> value="<?= $role->idRole ?>"><?= $role->libelleRole ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="role" class="active">Prénom</label>
                            <input name="prenom" required type="text" id="role" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="role" class="active">Nom</label>
                            <input name="nom" required type="text" id="role" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="role" class="active">Téléphone</label>
                            <input name="tel" required type="text" id="role" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="role" class="active">Email</label>
                            <input name="email" required type="text" id="role" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="role" class="active">Nom d'utilisateur</label>
                            <input name="login" required type="text" id="role" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="role" class="active">Mot de passe <small>(Par défaut : passer)</small></label>
                            <input type="password" disabled value="passer" id="role" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect " data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light ">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- <div class="<?= $role== 1 || $role== 2 ? "main-content" : "main-content hidden" ?>">
    <h2>Gestion personnel</h2>
    <div class="card-container">
        <div class="card">
            <a href="<?= $data['tbdPresence'] ?>">1- Tableau de bord</a>
        </div>
        <div class="card">
            <a href="<?= $data['gerepresence'] ?>">2- Présences</a>
        </div>
        <div class="card">
            <a href="<?= $data['gererConges'] ?>">3- Congés</a>
        </div>
        <div class="card">
            <a href="<?= $data['genererAvertissement'] ?>">4- Avertissements</a>
        </div>
        <div class="card">
            <a href="<?= $data['gererPaie'] ?>">5- Exportation de Paie</a>
        </div>
    </div>
</div>

<div class="<?= $role!= 1 && $role!= 2 ? "main-content" : "main-content hidden" ?>">
    <h2>Gestion personnel</h2>
    <div class="card-container">
        <div class="card">
            <a href="<?= $data['dashbord'] ?>">1- Tableau de bord</a>
        </div>
        <div class="card">
            <a href="<?= $data['Pointer'] ?>">2- Présences</a>
        </div>
        <div class="card">
            <a href="<?= $data['DemanderConge'] ?>">3- Congés</a>
        </div>
        <div class="card">
            <a href="<?= $data['avertir'] ?>">4- Avertissements</a>
        </div>
       
    </div>
</div> -->
