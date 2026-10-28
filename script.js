const searchForm = document.getElementById("searchForm");

if (searchForm) {
    const searchInput = document.getElementById("searchInput");
    const jobCards = document.querySelectorAll(".job-card");
    const jobCount = document.getElementById("jobCount");
    const emptyMessage = document.getElementById("emptyMessage");

    searchForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const query = searchInput.value.trim().toLowerCase();
        let count = 0;

        jobCards.forEach(function (card) {
            const text = card.textContent.toLowerCase();
            const data = card.dataset.search.toLowerCase();
            const matches = text.includes(query) || data.includes(query);

            card.hidden = !matches;

            if (matches) {
                count++;
            }
        });

        jobCount.textContent = count + " jobs found";
        emptyMessage.hidden = count !== 0;
    });
}

// Login form: visual prototype only
const loginForm = document.getElementById("loginForm");

if (loginForm) {
    loginForm.addEventListener("submit", function (event) {
        event.preventDefault();

        document.getElementById("loginMessage").textContent =
            "Demo only. Connect PHP authentication to log in.";
    });
}

// Registration form: visual prototype only
const registerForm = document.getElementById("registerForm");

if (registerForm) {
    registerForm.addEventListener("submit", function (event) {
        event.preventDefault();

        document.getElementById("registerMessage").textContent =
            "Demo only. Connect PHP and MySQL to create an account.";
    });
}
