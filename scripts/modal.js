let modals = document.querySelectorAll(".modal");
let triggers = document.querySelectorAll(".trigger");
let closeButtons = document.querySelectorAll(".modal-btn");

function toggleModal(modal) {
  modal.classList.toggle("show-modal");
}

function windowOnClick(event) {
  modals.forEach(modal => {
    if (event.target === modal) {
      toggleModal(modal);
    }
  })
}

triggers.forEach(function(trigger) {
  trigger.addEventListener("click", function() {
    let modalId = trigger.getAttribute("data-target");
    let modal = document.getElementById(modalId);
    toggleModal(modal);
  });
});

closeButtons.forEach(function(button) {
  button.addEventListener("click", function() {
    let modal = button.closest(".modal");
    toggleModal(modal);
  });
});

window.addEventListener("click", windowOnClick);