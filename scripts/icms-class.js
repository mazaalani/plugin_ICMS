class IcmsForm {
  constructor(element) {
    this._el = element;
    this._form = this._el.querySelector("form");
    this._firstname = this._form.prenom;
    this._name = this._form.nom;
    this._email = this._form.courriel;
    this._text = this._form.textarea;
    this._Btn = this._form.querySelector("button");
    this._inputs = this._form.querySelectorAll("input");
  }

  //initialisation
  init = () => {
    //traitement au click sur soumettre
    this._Btn.addEventListener("click", (e) => {
      e.preventDefault();
      this.validerFormulaire();
    });
  };

  //Methodes
  validerFormulaire = () => {
    //collection des champs a valider dans un même tableau
    let data = Array.from(this._inputs);
    data.push(this._text);
    //valide que chaque champ est renseigné si non change couleur bordure
    let test = [];
    data.forEach((element) => {
      if (element.value !== "") {
        element.style = "border-color: var(--icms-form-main) !important;";
        test.push(element.value);
      } else {
        element.style = "border-color: red !important;";
        if (test.indexOf(element.value))
          test.splice(test.indexOf(element.value), 1);
      }
    });
    //message d'envoi réussi
    if (test.length == data.length) {
      this._form.reset();
      let msg = document.createElement("h3");
      this._el.appendChild(msg);
      msg.innerHTML = "Formulaire envoyé, merci!";
    }
    console.log(this._el.style);
  };
}
