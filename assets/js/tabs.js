function openTab(tabName, linkName) {
    let i;
    let tabContent;
    let linkContent;
    
    tabContent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabContent.length; i++) {
        tabContent[i].style.display = "none";
    }

    linkContent = document.getElementsByClassName("tab-link");
    for (i = 0; i < tabContent.length; i++) {
        linkContent[i].classList.remove("link-active");
    }
    
    document.getElementById(linkName).classList.add("link-active");
    document.getElementById(tabName).style.display = "block";
}

let subtaskLink = document.getElementById("SubtasksLink");
let editTaskLink = document.getElementById("EditTaskLink");

subtaskLink.addEventListener("click", function(){openTab("Subtasks", "SubtasksLink")}, false);
editTaskLink.addEventListener("click", function(){openTab("EditTask", "EditTaskLink")}, false);
