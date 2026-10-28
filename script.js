/* =====================================
   1. HTML элементтерін табу
===================================== */

const searchForm = document.getElementById("searchForm");
const searchInput = document.getElementById("searchInput");
const cityFilter = document.getElementById("cityFilter");
const typeFilter = document.getElementById("typeFilter");

const jobsGrid = document.getElementById("jobsGrid");
const resultsCount = document.getElementById("resultsCount");
const emptyMessage = document.getElementById("emptyMessage");
const resetButton = document.getElementById("resetButton");

const menuToggle = document.getElementById("menuToggle");
const navLinks = document.getElementById("navLinks");

const loginDialog = document.getElementById("loginDialog");
const registerDialog = document.getElementById("registerDialog");


/* =====================================
   2. Вакансияларды іздеу және сүзу
===================================== */

function filterJobs() {
    const searchText = searchInput.value.trim().toLowerCase();
    const selectedCity = cityFilter.value;
    const selectedType = typeFilter.value;

    const jobCards = document.querySelectorAll(".job-card");
    let visibleCount = 0;

    jobCards.forEach(function (card) {
        const title = card.dataset.title.toLowerCase();
        const company = card.dataset.company.toLowerCase();
        const city = card.dataset.city;
        const type = card.dataset.type;

        const matchesText =
            title.includes(searchText) ||
            company.toLowerCase().includes(searchText);

        const matchesCity =
            selectedCity === "" || city === selectedCity;

        const matchesType =
            selectedType === "" || type === selectedType;

        const isVisible =
            matchesText && matchesCity && matchesType;

        card.hidden = !isVisible;

        if (isVisible) {
            visibleCount++;
        }
    });

    resultsCount.textContent =
        "Вакансиялар саны: " + visibleCount;

    emptyMessage.hidden = visibleCount !== 0;
}


/* Іздеу батырмасын басқанда */

searchForm.addEventListener("submit", function (event) {
    event.preventDefault();
    filterJobs();
});


/* Қала немесе жұмыс форматы өзгергенде */

cityFilter.addEventListener("change", filterJobs);
typeFilter.addEventListener("change", filterJobs);


/* Сүзгілерді тазарту */

resetButton.addEventListener("click", function () {
    searchInput.value = "";
    cityFilter.value = "";
    typeFilter.value = "";

    filterJobs();
});


/* =====================================
   3. Телефондағы мәзір
===================================== */

menuToggle.addEventListener("click", function () {
    const isOpen = navLinks.classList.toggle("open");

    menuToggle.setAttribute("aria-expanded", String(isOpen));

    menuToggle.setAttribute(
        "aria-label",
        isOpen ? "Мәзірді жабу" : "Мәзірді ашу"
    );
});


/* Мәзірдегі сілтемені басқанда оны жабу */

navLinks.querySelectorAll("a").forEach(function (link) {
    link.addEventListener("click", function () {
        navLinks.classList.remove("open");
        menuToggle.setAttribute("aria-expanded", "false");
        menuToggle.setAttribute("aria-label", "Мәзірді ашу");
    });
});


/* =====================================
   4. Кіру және тіркелу терезелері
===================================== */

document.getElementById("loginButton").addEventListener(
    "click",
    function () {
        loginDialog.showModal();
    }
);

document.getElementById("registerButton").addEventListener(
    "click",
    function () {
        registerDialog.showModal();
    }
);


/* =====================================
   5. Демонстрациялық кіру формасы
===================================== */

document.getElementById("loginForm").addEventListener(
    "submit",
    function (event) {
        event.preventDefault();

        alert(
            "Бұл — демонстрациялық нұсқа. " +
            "Нақты аккаунтқа кіру әзірге қосылмаған."
        );

        loginDialog.close();
        this.reset();
    }
);


/* =====================================
   6. Демонстрациялық тіркелу формасы
===================================== */

document.getElementById("registerForm").addEventListener(
    "submit",
    function (event) {
        event.preventDefault();

        alert(
            "Форма тексерілді! Нақты тіркелу мен " +
            "деректерді сақтау жүйесі әлі қосылмаған."
        );

        registerDialog.close();
        this.reset();
    }
);


/* =====================================
   7. Вакансияға өтінім беру
===================================== */

document.querySelectorAll(".apply-button").forEach(
    function (button) {
        button.addEventListener("click", function () {
            const jobCard = button.closest(".job-card");
            const jobTitle = jobCard.dataset.title;

            alert(
                '"' + jobTitle + '" вакансиясына өтінім беру ' +
                "функциясы әзірге демонстрациялық режимде."
            );
        });
    }
);


/* =====================================
   8. Жұмыс берушілерге арналған батырма
===================================== */

document.getElementById("employerButton").addEventListener(
    "click",
    function () {
        alert(
            "Жұмыс берушілерге арналған толық байланыс " +
            "жүйесі кейін қосылады."
        );
    }
);


/* =====================================
   9. Ағымдағы жылды көрсету
===================================== */

document.getElementById("currentYear").textContent =
    new Date().getFullYear();


/* =====================================
   10. Сайт ашылғанда бастапқы сүзгі
===================================== */

filterJobs();
