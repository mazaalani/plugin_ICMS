window.addEventListener("load", () => {
  let icmsForm = document.querySelectorAll("[data-js-icmsform]");

  //instanciation de chaque form presente dans le DOM
  icmsForm.forEach((element) => {
    new IcmsForm(element).init();
  });
});
