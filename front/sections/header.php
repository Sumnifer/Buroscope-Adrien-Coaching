<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta
    name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
  />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <link rel="stylesheet" href="../assets/css/styles.css" />
  <link rel="stylesheet" href="../assets/css/FontAwesome.css" />
    <script src="../../javaScript/jquery.min.js"></script>
    <script src="../../javaScript/jquery-3.2.1.min.js"></script>
    <script src="../../javaScript/sss.js"></script>
    <script src="../../javaScript/sss.min.js"></script>

  <title>Adrien | Coaching</title>
</head>
<body>
<header class="header">
  <a href="front.php?action=index" class="header__logo"
  ><img src="../assets/img/logo.png" alt="logo" class="header__logo_img" />
    <h1 class="header__logo_title">Adrien Coaching</h1></a
  >
  <nav class="header__nav">
    <menu class="header__nav_menu">
      <li class="header__nav_menu_items">
        <a href="front.php?action=index" class="header__nav_menu_items_link">Accueil</a>
      </li>
      <li class="header__nav_menu_items">
        <a href="front.php?action=presentation" class="header__nav_menu_items_link">A propos</a>
      </li>
      <li class="header__nav_menu_items">
        <a href="front.php?action=prestation" class="header__nav_menu_items_link">Prestation</a>
      </li>
      <li class="header__nav_menu_items">
        <a href="front.php?action=contact" class="header__nav_menu_items_link">Contact</a>
      </li>
    </menu>
  </nav>
  <div class="header__controls">
    <details class="header__controls_detail">
      <summary class="header__controls_detail_summary">
            <span class="header__controls_detail_summary_span">
              Mon Compte</span
            >
        <i
          class="fa-solid fa-caret-down header__controls_detail_summary_icon"
        ></i>
      </summary>
      <div class="header__controls_detail_bloc">
          <?php
        if(isset($_SESSION['statut_users'])) {
            if (($_SESSION['statut_users'] == "root") || ($_SESSION['statut_users'] == "admin")) {
                echo "<a href='../back/back.php' class='header__controls_detail_bloc_link'><i class='fa-regular fa-table header__controls_detail_bloc_link_icon'></i>Tableau de Bord</a>";
                echo "<a href='front.php?action=account&case=index' class='header__controls_detail_bloc_link'><i class='fa-regular fa-user header__controls_detail_bloc_link_icon'></i>Mon Compte</a>";
            } else {
                echo "<a href='front.php?action=account&case=index' class='header__controls_detail_bloc_link'><i class='fa-regular fa-user header__controls_detail_bloc_link_icon'></i>Mon Compte</a>";
            }
        }
         ?>
        <?php
        if(isset($_SESSION['id_users'])){
          echo "<a href='front.php?action=logout' class='header__controls_detail_bloc_link'>
        <i class='fa-regular fa-sign-out header__controls_detail_bloc_link_icon'></i>Déconnexion</a>";
        } else {
          echo "<a href='front.php?action=logging' class='header__controls_detail_bloc_link'>
        <i class='fa-regular fa-sign-in header__controls_detail_bloc_link_icon'></i>Connexion</a>";}
        ?>
      </div>
    </details>
      <?php
      $connexion=connexion();
      if (isset($_SESSION['id_users']) && $_SESSION['id_users'] != "") {
          $request = "SELECT COUNT(*) AS nb_cart FROM temporary_schedules WHERE id_users = " . $_SESSION['id_users'];
          $result = mysqli_query($connexion, $request);
          $row = mysqli_fetch_assoc($result);
          $nb_cart = $row['nb_cart'];
          if ($nb_cart > 0) {
              echo '<a href="front.php?action=cart&case=show" class="header__controls_cart"><i class="fa-solid fa-cart-shopping header__controls_cart_icon"></i></a>';
          } else {
              echo '<a href="front.php?action=cart&case=show" class="header__controls_cart"><i class="fa-light fa-cart-shopping header__controls_cart_icon"></i></a>';
          }
      }
?>
  </div>
</header>