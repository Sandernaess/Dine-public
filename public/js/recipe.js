var stepArray = Array(); 

function edit() {
    var editBtn, btn, add, 
    editBtn = document.getElementById("edit");
    btn = document.getElementsByClassName("delete");
    add = document.getElementById("add");
    
    if (add.style.display == "block") {
        add.style.display = "none"; 
        editBtn.innerHTML = "EDIT"
    } else {
        add.style.display = "block";
        editBtn.innerHTML ="Cancel"
    }

    for(i = 0; i < btn.length; i++) {
        if (btn[i].style.display == "block") {
            btn[i].style.display = "none";
        } else {
            btn[i].style.display = "block";
        }
    } 
    
}

