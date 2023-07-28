<div class="account_reference">
<nav class="account__nav">
    <ul class="account__nav_ul">
        <li class="account__nav_ul_li"><a href="front.php?action=index" class="account__nav_ul_li_link"><i class="fa-solid fa-globe account__nav_ul_li_link_icon"></i>Retour</a> <i class="fa-solid fa-chevron-right"></i></li>
        <li class="account__nav_ul_li"><a href="front.php?action=account&case=index" class="account__nav_ul_li_link"><i class="fa-solid fa-user account__nav_ul_li_link_icon"></i>Mes Informations</a> <i class="fa-solid fa-chevron-right"></i></li>
        <li class="account__nav_ul_li"><a href="front.php?action=account&case=accountSchedules" class="account__nav_ul_li_link"><i class="fa-solid fa-dumbbell account__nav_ul_li_link_icon"></i>Mes Séances</a> <i class="fa-solid fa-chevron-right"></i></li>
        <li class="account__nav_ul_li"><a href="front.php?action=account&case=settings" class="account__nav_ul_li_link"><i class="fa-solid fa-gear account__nav_ul_li_link_icon"></i>Paramètres</a> <i class="fa-solid fa-chevron-right"></i></li>
        <li class="account__nav_ul_li"><a href="front.php?action=logout" class="account__nav_ul_li_link"><i class="fa-solid fa-sign-out account__nav_ul_li_link_icon"></i>Deconnexion</a> <i class="fa-solid fa-chevron-right"></i></li>
    </ul>
</nav>
<section class='accountSchedule'>
    <h1 class="accountSchedule__title">Mes Séances</h1>
    <div class='accountSchedule__container'>
    <h2 class="accountSchedule__container_title"><i class="fa-solid fa-calendar accountSchedule__container_title_icon"></i> Mes prochaines séances <i class="fa-solid fa-arrow-up-right"></i></h2>
    <?php
    if (isset($result)){
while($rows=mysqli_fetch_object($result)) {
    echo "<div class='accountSchedule__container_items'>";
    echo "<p class='accountSchedule__container_items_date'>Le " . strftime("%A %d %B %Y", strtotime($rows->date_schedules)) . " </p>";
    echo "<p class='accountSchedule__container_items_hours'>&nbsp;à " . $rows->hours_schedules . "</p>";
    echo "</div>";
}
} ?>
    </div>
        <div class='accountSchedule__container'>
        <h2 class="accountSchedule__container_title"><i class="fa-solid fa-calendar accountSchedule__container_title_icon"></i> Mes séances Passées <i class="fa-solid fa-arrow-down-right"></i></h2>

  <?php
  if (isset($result2)) {
      while ($rows2 = mysqli_fetch_object($result2)) {
          echo "<div class='accountSchedule__container_items'>";
          echo "<p class='accountSchedule__container_items_date'>Le " . strftime("%A %d %B %Y", strtotime($rows2->date_schedules)) . " </p>";
          echo "<p class='accountSchedule__container_items_hours'>&nbsp;à " . $rows2->hours_schedules . "</p>";
          echo "</div>";
      }

      if (mysqli_num_rows($result2) == 0) {
          echo "<div class='accountSchedule__container_items'>";
          echo "<p class='accountSchedule__container_items_date'>Aucunes séances à afficher</p>";
          echo "</div>";
      }
  } ?>

        </div>
    <a href="front.php?action=calendar" class="accountSchedule__cta"><i class="fa-solid fa-dumbbell"></i> Réserver une nouvelle Séance !</a>
</section>
</div>
