const closeSidebarButton = document.getElementById("close-sidebar-button");
const openSidebarButton = document.getElementById("sidebar-button");
const sidebar = document.getElementById("sidebar");

function closeSidebarButtonClicked() {
    sidebar.style.transform = "translateX(-100%)";
    openSidebarButton.style.display = "block";
} 

function openSidebarButtonClicked () {
    sidebar.style.transform = "translateX(0%)";
    openSidebarButton.style.display = "none";
}


closeSidebarButton.addEventListener('click', closeSidebarButtonClicked);
openSidebarButton.addEventListener('click', openSidebarButtonClicked);