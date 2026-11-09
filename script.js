document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById("btnSaudacao");
    if (btn) {
        btn.addEventListener("click", () => {
            alert("Obrigado por visitar!");
        });
    }
});