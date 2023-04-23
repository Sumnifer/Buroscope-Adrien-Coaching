  <div class="inscription_body">
    <section class="info">
      <form action="inscription.php" method="post" class="info__form">
        <div class="info__form">
          <label for="poids" class="info__form_label">Poids en Kg</label>
          <input
            type="text"
            name="poids"
            id="poids"
            placeholder="Poids en Kg"
            class="info__form_input"
          />
        </div>
        <div class="info__form">
          <label for="taille" class="info__form_label">Taille en cm</label>
          <input
            type="text"
            name="taille"
            id="taille"
            placeholder="Taille en cm"
            class="info__form_input"
          />
        </div>
      </form>
    </section>

    <section class="sante">
      <h2 class="sante_title">Durant les 12 derniers mois</h2>
        <div class="sante__oui">
          <p>Oui</p>
          <p>Non</p>
        </div>
        <div class="sante__text">
          <div class="sante__text_global">
            <i class="fa-solid fa-play" style="color: #ffe13f;"></i>

            <p>Un membre de votre famille est-il décédé subitement d’une cause cardiaque ou inexpliquée ?</p>
            <input type="checkbox">
            <input type="checkbox">
          </div>
          <div class="sante__text_global">
            <i class="fa-solid fa-play" style="color: #ffe13f;"></i>
            <p>Avez-vous ressenti une douleur dans la poitrine, des palpitations, un essoufflement inhabituel ou un malaise ?</p>
            <input type="checkbox">
            <input type="checkbox">
          </div>
          <div class="sante__text_global">
            <i class="fa-solid fa-play" style="color: #ffe13f;"></i>
            <p>Avez-vous eu un épisode de respiration sifflante (asthme) ?</p>
            <input type="checkbox">
            <input type="checkbox">
          </div>
          <div class="sante__text_global">
            <i class="fa-solid fa-play" style="color: #ffe13f;"></i>
            <p>Avez-vous eu une perte de connaissance ?</p>
            <input type="checkbox">
            <input type="checkbox">
          </div>
          <div class="sante__text_global">
            <i class="fa-solid fa-play" style="color: #ffe13f;"></i>
            <p>Si vous avez arrêté le sport pendant 30 jours ou plus pour des raisons de santé, avez-vous repris sans l’accord d’un médecin ?</p>
            <input type="checkbox">
            <input type="checkbox">
          </div>
          <div class="sante__text_global">
            <i class="fa-solid fa-play" style="color: #ffe13f;"></i>
            <p>Avez-vous débuté un traitement médical de longue durée (hors contraception et désensibilisation aux allergies) ?</p>
            <input type="checkbox">
            <input type="checkbox">
          </div>
        </div>

      <h2 class="sante-title">A ce jour</h2>
        <div class="sante__oui">
          <p>Oui</p>
          <p>Non</p>
        </div>
        <div class="sante_text">
          <div class="sante__text_global">
            <i class="fa-solid fa-play" style="color: #ffe13f;"></i>
            <p>Ressentez-vous une douleur, un manque de force ou une raideur suite à un problème osseux, articulaire ou musculaire (fracture, entorse, luxation, déchirure, tendinite, etc…) survenu durant les 12 derniers mois ?</p>
            <input type="checkbox">
            <input type="checkbox">

          </div>
          <div class="sante__text_global">
            <i class="fa-solid fa-play" style="color: #ffe13f;"></i>
            <p>Votre pratique sportive est-elle interrompue pour des raisons de santé ?</p>

            <input type="checkbox" class="sante__text_global_input">
            <input type="checkbox" class="sante__text_global_input">

          </div>
          <div class="sante__text_global">
            <i class="fa-solid fa-play" style="color: #ffe13f;"></i>
            <p>Pensez-vous avoir besoin d’un avis médical pour poursuivre votre pratique sportive ?</p>

            <input type="checkbox" class="sante__text_global_input">
            <input type="checkbox" class="sante__text_global_input">
          </div>
        </div>
        <div class="sante__button">
          <a href="#" class="sante__button_text">Envoyer le formulaire</a>

        </div>
    </section>
  </div>
