<?php
         require('connexionbd.php');
         $ids=$_SESSION['identifiant'];
     ?>
<header id="header" class="header fixed-top d-flex align-items-center bg-dar">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/logo.PNG" alt="">
        <span class="d-none d-lg-block">ELISH-TECH</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown">

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">

           
            <li>
              <hr class="dropdown-divider">
            </li>

          </ul><!-- End Messages Dropdown Items -->

        </li><!-- End Messages Nav -->

        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php
            $sqlcon="SELECT * FROM `utilisateurs` WHERE `id_user`='$ids'";
            $querycon=$con->query($sqlcon);
             while($row=mysqli_fetch_assoc($querycon)){
              $nom=$row['nom'];
            echo "$nom" ;}?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php
              $sqlcon="SELECT * FROM `utilisateurs` WHERE `id_user`='$ids'";
              $querycon=$con->query($sqlcon);
             while($row=mysqli_fetch_assoc($querycon)){
              $nom=$row['nom'];
              echo "$nom" ;}?></h6>
              <span><?php
              $sqlcon="SELECT * FROM `utilisateurs` WHERE `id_user`='$ids'";
              $querycon=$con->query($sqlcon);
             while($row=mysqli_fetch_assoc($querycon)){
              $poste=$row['poste'];
             echo "$poste" ;}?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="profile.php">
                <i class="bi bi-person"></i>
                <span>Mon profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="profile.php">
                <i class="bi bi-gear"></i>
                <span>Parametre</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="../index.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Deconnexion</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

       <li class="nav-item">
         <a class="nav-link " href="dashord.php">
         <i class="bi bi-grid"></i>
         <span>Dashboard</span>
         </a>
        </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Ventes/maintances</span><i class="bi bi-chevron-down ms-auto text-primary"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="NewVente.php">
              <i class="bi bi-circle"></i><span>Nouvelle commande</span>
            </a>
          </li>
          <li>
            <a href="BilanVente.php">
              <i class="bi bi-circle"></i><span>Bilan des ventes</span>
            </a>
          </li>
          <li>
            <a href="maintenance.php">
              <i class="bi bi-circle"></i><span>Maintance</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Achats/Fournisseurs</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="NewAchat.php">
              <i class="bi bi-circle"></i><span>Nouvelle Achats</span>
            </a>
          </li>
          <li>
            <a href="fournisseurs.php">
              <i class="bi bi-circle"></i><span>Fournisseurs</span>
            </a>
          </li>
          <li>
            <a href="BilanAchat.php">
              <i class="bi bi-circle"></i><span>Bilan d'achats</span>
            </a>
          </li>
        </ul>
      </li><!-- End Forms Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Stocks</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="createProduit.php">
              <i class="bi bi-circle"></i><span>Ajouter un produit</span>
            </a>
          </li>
          <li>
            <a href="produits.php">
              <i class="bi bi-circle"></i><span>Listes des produits</span>
            </a>
          </li>
          <li>
            <a href="categorie.php">
              <i class="bi bi-circle"></i><span>Categories</span>
            </a>
          </li>
        </ul>
      </li><!-- End Tables Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bar-chart"></i><span>Depenses</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="depense.php">
              <i class="bi bi-circle"></i><span>Depenses</span>
            </a>
          </li>
        </ul>
      </li><!-- End Charts Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gem"></i><span>Utilisateurs/Clients</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="gererutilisateur.php">
              <i class="bi bi-circle"></i><span>Utilisateurs</span>
            </a>
          </li>
          <li>
            <a href="Clients.php">
              <i class="bi bi-circle"></i><span>Clients</span>
            </a>
          </li>
        </ul>
      </li><!-- End Icons Nav -->

      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="profile.php">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="../index.php">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Deconnexion</span>
        </a>
      </li><!-- End Login Page Nav -->
    </ul>

  </aside>