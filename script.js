const searchForm = document.getElementById("searchForm");
const searchInput = document.getElementById("searchInput");
const jobCards = document.querySelectorAll(".job-card");
const jobCount = document.getElementById("jobCount");
const emptyMessage = document.getElementById("emptyMessage");

searchForm.addEventListener("submit", function (event) {
    event.preventDefault();

    const searchText = searchInput.value.trim().toLowerCase();
    let visibleJobs = 0;

    jobCards.forEach(function (card) {
        const searchableText = card.dataset.search.toLowerCase();
        const title = card.querySelector("h3").textContent.toLowerCase();
        const company = card.querySelector(".job-info p").textContent.toLowerCase();

        const matches =
            searchableText.includes(searchText) ||
            title.includes(searchText) ||
            company.includes(searchText);

        card.hidden = !matches;

        if (matches) {
            visibleJobs++;
        }
    });

    jobCount.textContent = visibleJobs + " jobs found";
    emptyMessage.hidden = visibleJobs !== 0;
});
