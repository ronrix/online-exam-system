const light = document.querySelector("#light");
const dark = document.querySelector("#dark");

// turning to dark mode
light?.addEventListener("click", () => {
    dark.style.display = "block";
    light.style.display = "none";

    localStorage.setItem("dark", "true");
    document.querySelectorAll(".btn").forEach((el) => el.classList.add("dark"));
    document
        .querySelectorAll(".nav-link")
        .forEach((el) => el.classList.add("dark"));

    document.body.classList.add("dark");
    document?.querySelector("h2")?.classList.add("dark");

    window.location.reload();
});

// turning to light mode
dark?.addEventListener("click", () => {
    light.style.display = "block";
    dark.style.display = "none";

    localStorage.removeItem("dark");

    document
        .querySelectorAll(".nav-link")
        .forEach((el) => el.classList.remove("dark"));
    document.body.classList.remove("dark");
    document
        .querySelectorAll(".btn")
        .forEach((el) => el.classList.remove("dark"));

    document?.querySelector("h2")?.classList.remove("dark");

    window.location.reload();
});

// if dark is true, stay the style
if (localStorage.getItem("dark")) {
    dark.style.display = "block";
    light.style.display = "none";
}
