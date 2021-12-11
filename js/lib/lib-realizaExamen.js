window.addEventListener("load",function(){
    fetch("../../php/ajax/ajaxDameExamen")
    .then(response => response.json())
    .then(data => {
        console.log(data);
    });
})