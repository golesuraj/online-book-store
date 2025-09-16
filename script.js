document.addEventListener("DOMContentLoaded", function() {
    const links = document.querySelectorAll(".sidebar ul li a");
    const sections = document.querySelectorAll(".content .section");

    links.forEach(link => {
        link.addEventListener("click", function(e) {
            e.preventDefault();

            // Remove active class from all links and sections
            links.forEach(l => l.classList.remove("active"));
            sections.forEach(section => section.classList.remove("active"));

            // Add active class to the clicked link and corresponding section
            this.classList.add("active");
            const sectionId = this.getAttribute("data-section");
            document.getElementById(sectionId).classList.add("active");

            // Update the navbar title
            document.querySelector(".navbar h1").textContent = this.textContent;
        });
    });
});