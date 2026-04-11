// ================= VARIABLES =================
let welcomeMessage = "Welcome to Blood Donation Camp ❤️";
let donorCount = 50;

// ================= OBJECT =================
const bloodCamp = {
    name: "Blood Donation Camp",
    location: "India",
    donors: donorCount,

    // METHOD
    showDetails: function () {
        alert(`🏥 ${this.name}\n📍 Location: ${this.location}\n🧑 Donors: ${this.donors}`);
    },

    addDonor: function () {
        this.donors++;
        updateDonorDisplay();
    }
};

// ================= FUNCTION =================
function updateDonorDisplay() {
    document.getElementById("donorCount").innerText =
        "Total Donors: " + bloodCamp.donors;
}

// ================= POPUP FUNCTIONS =================
function confirmDonation() {
    let result = confirm("Do you want to become a donor?");

    if (result) {
        bloodCamp.addDonor();
        alert("Thank you for donating blood ❤️");
    } else {
        alert("Maybe next time 😊");
    }
}

function showDetails() {
    bloodCamp.showDetails();
}

// ================= EVENTS =================
document.addEventListener("DOMContentLoaded", function () {

    // Welcome popup
    alert(welcomeMessage);

    // Show donor count
    updateDonorDisplay();

    // DOUBLE CLICK EVENT
    document.querySelector(".hero").addEventListener("dblclick", function () {
        bloodCamp.addDonor();
        alert("New donor added 🩸");
    });

    // HOVER EVENT
    let cards = document.querySelectorAll(".card");

    cards.forEach(function (card) {
        card.addEventListener("mouseover", function () {
            card.style.background = "rgba(255,0,0,0.3)";
        });

        card.addEventListener("mouseout", function () {
            card.style.background = "rgba(255,255,255,0.1)";
        });
    });

    // KEYBOARD EVENT
    document.addEventListener("keydown", function (event) {
        if (event.key === "b") {
            alert("Pressed B → Showing Camp Details");
            bloodCamp.showDetails();
        }
    });

});