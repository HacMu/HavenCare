const showMenu = (toggleId, navbarId, bodyId) => {
  const toggle = document.getElementById(toggleId),
    navbar = document.getElementById(navbarId);
  body = document.getElementById(bodyId);

  if (toggle && navbar) {
    toggle.addEventListener("click", () => {
      navbar.classList.toggle("expander");
      body.classList.toggle("body-pd");
    });
  }
};
showMenu("nav-toggle", "navbar", "body");

/* == Active attribute == */
const linkColor = document.querySelectorAll(".nav_link");
function colorLink() {
  linkColor.forEach((item) => item.classList.remove("active"));
  this.classList.add("active");
}
linkColor.forEach((item) => item.addEventListener("click", colorLink));

/* == Collapse Menu == */
const linkCollapse = document.getElementsByClassName("collapse_link");
for (let i = 0; i < linkCollapse.length; i++) {
  linkCollapse[i].addEventListener("click", function () {
    const collapseMenu = this.nextElementSibling;
    collapseMenu.classList.toggle("showCollapse");

    const rotate = collapseMenu.previousElemntSibling;
    rotate.classList.toggle("rotate");
  });
}
